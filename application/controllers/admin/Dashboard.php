<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			if(isAdmin()==false){
				return redirect('login');
			}
		}
		
		public function index() {
			$data['title'] = "Dashboard";

			$sess_id = get_userId();
			$date_m=date('m');
			$date_y=date('Y');
			$prev_y = date('Y',strtotime('-1 year'));
			$curYear = $date_y;
			 	$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id'";
			$res = $this->model->query($q,'all_array');

			$data['attendance'] = $res;
			$data["categories"]=$this->model->getData("categories","all_array",$args=["where"=>["is_active"=>"1"]]);
			$data["data_set"]=array();
			$n=count($data["categories"]);
			for($i=1;$i<=$n;$i++)
			{
				array_push($data["data_set"],"0.0");
			}
			if(!empty($_POST["staffid"]))
			{
				$staff_id=$_POST["staffid"];
				$r= $this->model->getData("staff",'row_array',$args=["where"=>["id"=>$staff_id]]);
				$date=explode("/",$_POST["date"]);
				$date_m=$date[0];
				$date_y=$date[1];
				$rid= $this->model->getData("holiday_ent",'row_array',$args=["where"=>["staff_id"=>$staff_id,'year'=>$date_y]]);
				$data["data_max"]=$rid["holiday_ent"];
				$res = $this->model->getData("attendance",'row_array',$args=["where"=>["staff_id"=>$staff_id,'year'=>$date_y]]);
				$data["data_set"]=array();
				foreach($data["categories"] as $cat)
				{
					$pt=$res["pattern"];
					$pt1=explode(",",$pt);
					$i=0;
					if(!empty($pt))
					{
					foreach($pt1 as $pat)
					{
						$pattern=explode(" ",$pat);
						if($pattern[3]==$cat["id"] && $pattern[1]==$date_m && $pattern[2]==$date_y)
						{
							++$i;
						}
					}
					}
					array_push($data["data_set"],$i);
				}
			} else {

				$rid= $this->model->getData("staff",'row_array',$args=["select top 1"=>["*"]]);
				$date_m=date('m');
				$date_y=date('Y');
				$r= $this->model->getData("holiday_ent",'row_array',$args=["where"=>["staff_id"=>$rid['id'],'year'=>$date_y]]);
				$data["data_max"]=$r["holiday_ent"];
				$res = $this->model->getData("attendance",'row_array',$args=["where"=>["staff_id"=>$rid['id'],'year'=>$date_y]]);
				$data["data_set"]=array();
				foreach($data["categories"] as $cat)
				{
					$pt=$res["pattern"];
					$pt1=explode(",",$pt);
					$i=0;
					if(!empty($pt))
					{
					foreach($pt1 as $pat)
					{
						$pattern=explode(" ",$pat);
						if($pattern[3]==$cat["id"] && $pattern[1]==$date_m && $pattern[2]==$date_y)
						{
							++$i;
						}
					}
					}
					array_push($data["data_set"],$i);
				}
			}
			$data['staff'] = $this->model->getData('staff','all_array',$args=['select'=>['id','fname','lname']]);
			$yj = $date_y - 1;
			$prevYearHa =  $this->model->getData("holiday_ent",'all_array',$args=["where"=>['year'=>$yj]]);
			
			$rese = $this->model->getData("attendance",'all_array',$args=["where"=>['year'=>$date_y-1]]);
			$data['prevYearHolidays'] = $rese;
			$data['prevYEnt'] = $prevYearHa;
			
			$data['staff'] = $this->model->getData('staff','all_array',$args=['select'=>['id','fname','lname']]);
			
			if(!empty($_POST["tbDate"])) {
				$curYear=$_POST["tbDate"];
				$q = "select s.*,s.id as sid,a.*,a.id as aid from staff as s inner join attendance as a on a.staff_id=s.id WHERE s.supervisor='$sess_id' and a.year=".$curYear;
				$res = $this->model->query($q,'all_array');
				$data['attendance'] = $res;
				$yj = $curYear - 1;
				$prevYearHa =  $this->model->getData("holiday_ent",'all_array',$args=["where"=>['year'=>$yj]]);
				$rese = $this->model->getData("attendance",'all_array',$args=["where"=>['year'=>$curYear-1]]);
				$data['prevYearHolidays'] = $rese;
				$data['prevYEnt'] = $prevYearHa;
			}
			
			$data['prevY'] = $yj;
			$data["holiday_ent"]=$this->model->getData("holiday_ent","all_array",$args=['where'=>['year'=>$curYear]]);
			$data['curYear'] = $curYear;
			$this->load->view('admin/index',$data);
		}

		public function categories()
		{
			$data['title'] = "Kategorien";
				$items = $this->model->getData('categories','all_array',$args=['where'=>['is_active'=>'1'],'order'=>['col'=>'order','type'=>'ASC']]);
			$data['items'] = $items;
			$this->load->view('admin/categories',$data);
		}
		
		public function antrag_auf_mehrarbeit($type) { 
			$data['title'] = "Antrag auf Mehrarbeit";
			$uid = get_userId();
			
			if($type=="pending") {
				$data['managers'] = [];
				$data['items'] = $this->model->getData('application_overtime','all_array',$args=['where'=>['approved'=>'0']]);
				$this->load->view('admin/list_antrag_auf_mehrarbeit',$data);
			} elseif($type=="rejected") {
				$data['managers']=[];
				$data['items'] = $this->model->getData('application_overtime','all_array',$args=['where'=>['approved'=>'2']]);
				$this->load->view('admin/list_antrag_auf_mehrarbeit',$data);
			} elseif($type=="approved") {
				$data['managers'] = $this->model->getData('users','all_array',$args=['where'=>['role'=>'4','is_active'=>'1']]);
				$data['items'] = $this->model->getData('application_overtime','all_array',$args=['where'=>['approved'=>'1']]);
				$this->load->view('admin/list_antrag_auf_mehrarbeit',$data);
			} else {
				// show detail here
				$chk = $this->model->getData('application_overtime','row_array',$args=['where'=>['id'=>$type]]);
				if($chk==null) {
					_flashPop(false,'','Invalid id , try again');
					return redirct('admin/antrag-auf-mehrarbeit/pending');
				} else {
					$data['title'] = 'Antrag auf Mehrarbeit Details';
					$data['item'] = $chk;
					$this->load->view('admin/antrag_auf_mehrarbeit_detail',$data);
				}
			}
			
			
		}
		
		public function managers() {
			$data['title'] = "Lohnmanager";
			$data['managers'] = $items = $this->model->getData('users','all_array',$args=['where'=>['role'=>'4']]);
			$this->load->view('admin/managers',$data);
		}
		public function objektmanagers() {
			$data['title'] = "Objektmanager";
			$data['managers'] = $items = $this->model->getData('users','all_array',$args=['where'=>['role'=>'5']]);
			$this->load->view('admin/objektmanager',$data);
		}

		public function staff()
		{
			$data['title'] = "Mitarbeiter";
			$this->load->view('admin/staff',$data);
		}

		public function settings()
		{
			$data['title'] = "Farben bearbeiten";
			$items = $this->model->getData('settings','row_array',$args=[]);
			$data['item'] = $items;
			$this->load->view('admin/settings',$data);
		}
		
		public function public_holidays()
		{
			$data['title'] = 'Ferien & Feiertage';
			$data['states'] = $this->model->getData('states','all_array',$args=['']);
			$data['items'] = $this->model->getData('public_holidays','all_array',$args=['']);
			$this->load->view('admin/public_holidays',$data);
		}

		public function notification()
		{
		  $data['title']="Benachrichtigungen";
		  $data['items'] = $this->model->getData('notification','all_array',$args=[]);
		  $data['users'] = $this->model->getData('users','all_array',$args=['where'=>['role'=>'1']]);
		  $this->load->view('admin/notification',$data);
			
		}
		public function ajax()
		{
			if($this->input->post('req')=='add_category')
			{
				$name = $this->input->post('name');
				$color = $this->input->post('color');
				$order = $this->input->post('order');
				$chk = $this->model->getData('categories','count_array',$args=['where'=>['name'=>$name]]);
				if($chk==0) {
					$arr = array(
						'name'		=> $name,
						'color'		=> $color,
						'order'		=> $order,
						'date_created'	=> date('Y-m-d H:i:s'),
					);
					$res = $this->model->insertData('categories',$arr);
					$str = $res==true?"1":'Error in adding category,try again';
					echo json_encode($str);die;
				} else {
					$error = 'Category name "'.$name.'" already exists, try different name';
					echo json_encode($error);die;
				}
			} // end add_category

			if($this->input->post('req')=='delete_category')
			{
				$id = test_input($this->input->post('id'));
				$chk = $this->model->getData('categories','count_array',$args=['where'=>['id'=>$id]]);
				if($chk>0) {
					$res = $this->model->updateData('categories',['is_active'=>'0'],$args=['where'=>['id'=>$id]]);
					echo $res==true?"1":json_encode('Error in deleting categories,try again');die;
				} else {
					echo json_encode('Invalid category id');die;
				}
			}

			if($this->input->post('req')=='get_category')
			{
				$id = $this->input->post('id');
				$chk = $this->model->getData('categories','row_array',$args=['where'=>['id'=>$id]]);
					if($chk!=null) {
						echo json_encode($chk);die;
					} else {
						echo "0";die;
					}
			}// end get_category
			if($this->input->post('req')=='get_public_holidays')
			{
				$id = $this->input->post('id');
				$chk = $this->model->getData('public_holidays','row_array',$args=['where'=>['id'=>$id]]);
					if($chk!=null) {
						echo json_encode($chk);die;
					} else {
						echo "0";die;
					}
			} 
			if($this->input->post('req')=='update_publicholiday')
			{
				
				$post = $this->input->post();
				$ids = implode(',',$post['states']);
				$arr = array(
					'start_date'	=> date('Y-m-d',strtotime(test_input($post['start']))),
					'end_date'		=> date('Y-m-d',strtotime(test_input($post['end']))),
					'state_ids'		=> $ids,
					'admin_checked'	=> '1',
				);
				$res = $this->model->updateData('public_holidays',$arr,$args=["where"=>["id"=>$post["id"]]]);
				echo $res?json_encode('1'):json_encode('Error in saving, try again');die;
			} 
			if($this->input->post('req')=='save_edited_cat')
			{
				$post = $this->input->post();
				$id = test_input($post['id']);
				$name = test_input($post['name']);
				$color = test_input($post['color']);
				$order = test_input($post['order']);
				$chk = $this->model->getData('categories','count_array',$args=['where'=>['id'=>$id]]);
				if($chk>0) {
					$namechk = $this->model->getData('categories','count_array',$args=['where'=>['name'=>$name,'id!='=>$id]]);
					if($namechk==0) {
						$res = $this->model->updateData('categories',['name'=>$name,'color'=>$color,'order'=>$order],$args=['where'=>['id'=>$id]]);
						$str = $res==true?"1":"Error in updating , try again";
						echo json_encode($str);die;
					} else {
						echo json_encode('Category name "'.$name.'" already exists, try different name');die;
					}
				} else {
					echo json_encode('Invalid category id.');die;
				}
			} // save_edited_cat

			if($this->input->post('req')=='get_staff') {
				$id = test_input($this->input->post('id'));
				$res = $this->model->getData('staff','row_array',$args=['where'=>['id'=>$id]]);
				echo json_encode($res);die;
			} // end get_staff

			if($this->input->post('req')=='save_staff') {
				$post = $this->input->post();
				$id = $post['id'];

				$chk = $this->model->getData('staff','count_array',$args=['where'=>['id'=>$id]]);
				if($chk>0) {
				$arr = array(
					'fname'			=> test_input($post['fname']),
					'lname'			=> test_input($post['lname']),
					'email'			=> test_input($post['email']),
					'department'=> test_input($post['dept']),
					'phone'			=> test_input($post['phone']),
				);

				$res = $this->model->updateData('staff',$arr,$args=['where'=>['id'=>$id]]);
				echo $res==true ? "1":json_encode('Error in updating record, try again');die;
			} else {
				echo json_encode('Invalid staff id');die;
			}

			} // end save staff

			if($this->input->post('req')=='delete_staff') {
				$id = test_input($this->input->post('id'));
				$chk = $this->model->getData('staff','count_array',$args=['where'=>['id'=>$id]]);
				if($chk==0) {
					echo json_encode('Invalid staff id');die;
				} else {
					$res = $this->model->deleteData('staff',['id'=>$id]);
					$res1=$this->model->deleteData('holiday_ent',['staff_id'=>$id]);
					echo $res==true?"1":json_encode('error in deleting staff, try again');die;
				}
			}

			if($this->input->post('req')=='get_all_staff_dt')
			{
				// database col names
				$columns = array(
					//0 =>'staff.id',
					
					0 => 'lname',
					1 => 'fname',
					2 => 'email',
					3 => 'phone',
					4 => 'department',
					//5 => 'year',
					5 => 'holiday_ent',
					6 => 'supervisor',
					7 => 'date_created',
				);
				$limit = $this->input->post('length');
				$start = $this->input->post('start');
				$order = $columns[$this->input->post('order')[0]['column']];
				$dir = $this->input->post('order')[0]['dir'];
				$q1 = "select s.*,e.id from staff as s inner join holiday_ent as e on s.id=e.staff_id where s.supervised='1' && e.year=".date('Y');
				$items =  $this->model->query($q1,"all_array");
				$totalData = count($items);
				$totalFiltered = $totalData;
				if(empty($this->input->post('search')['value'])) {
					$q2 = "select staff.*,staff.id as sid,a.*,users.id as uid,users.fname as ufname,e.holiday_ent,users.lname as ulname from staff inner join users ON staff.supervisor=users.id
					 inner join holiday_ent as e on e.staff_id=staff.id inner join attendance as a on a.staff_id=staff.id where staff.supervised='1' && e.year=".date('Y')." && a.year=".date('Y')." order by $order $dir limit $start,$limit";
					$posts = $this->model->query($q2,'all_array');
				} else {
					$search = $this->input->post('search')['value'];
					$q3 = "select staff.*,staff.id as sid,a.*,users.id as uid,e.holiday_ent,users.fname as ufname,users.lname as ulname from staff inner join users ON staff.supervisor=users.id
					inner join holiday_ent as e on e.staff_id=staff.id inner join attendance as a on a.staff_id=staff.id where staff.supervised='1' && e.year=".date('Y')." && a.year=".date('Y')." && ( staff.fname like '%".$search."%' || staff.email like '%".$search."%' || staff.department like '%".$search."%')  order by $order $dir limit $start,$limit";

					$posts = $this->model->query($q3,'all_array');
					$totalFiltered = count($posts);
				}
				$data = array();
				if(!empty($posts)) {
					foreach($posts as $key=>$val) {
						$id = $val['sid'];
						$fun = "del('".$id."')";

						if(!empty($val['pattern'])) {
							$arr = explode(',',$val['pattern']);
							$leaves = count($arr);
						} else {
							$leaves = 0;
						}

//						<a href='#' data-toggle='tooltip' data-placement='top' title='Delete' onClick=".$fun." class='text-danger' ><span class='fa fa-trash-alt iconss'></span></a>
						$action = "<a href='#' title='Mitarbeiter bearbeiten' class='text-info edit' data-toggle='tooltip' data-placement='top' data-edit='".$id."' ><span class='far fa-edit iconss'></span></a>
						<a href='#' data-toggle='tooltip' data-name='".$val['fname'].' '.$val['lname']."' data-placement='top' title='Urlaubstage pro Jahr festlegen' data-holiday='".$id."' class='text-primary holiday' ><span class='far fa-calendar-alt iconss'></span></a>";
						$indata['name']     = $val['fname'];
						$indata['lname']	= $val['lname'];
						$indata['email']    = $val['email'];
						$indata['number']		= $val['phone'];
						$indata['department']= $val['department'];
						$indata['holiday']  = number_format($leaves/2,1)."/".$val['holiday_ent']." - ".$val['year'];

						$indata['supervisor']= $val['ufname']." ".$val['ulname'];
						$indata['action'] = $action;
						$data[] = $indata;
					}
				} // end empty posts
				$json_data = array(
					"draw"            => intval($this->input->post('draw')),
					"recordsTotal"    => intval($totalData),
					"recordsFiltered" => intval($totalFiltered),
					"data"            => $data
				);
				echo json_encode($json_data);
			} // end datatables

			if($this->input->post('req')=='process_reset')
			{
				$uid = get_userId();
				$post = $this->input->post();
				$old = test_input($post['old']);
				$new = test_input($post['new']);
				$cnew = test_input($post['cnew']);
				$res = $this->model->getData('users','row_array',$args=['where'=>['id'=>$uid]]);
				$dbold = $res['password'];
				if($dbold==sha1($old)) {
					if($new==$cnew) {
						$chk = $this->model->updateData('users',['password'=>sha1($new),'pass'=>$new],$args=['where'=>['id'=>$uid]]);
						echo $chk==true? "1":json_encode('Error in updating password, try again');
					} else {
						echo json_encode('New password and confirm password do not match');die;
					}
				}  else  {
					echo json_encode('Old password do not match');die;
				}
			} // process_reset

			if($this->input->post('req')=='get_weekday')
			{
				$res = $this->model->getData('settings','row_array',$args=[]);
				echo json_encode($res);die;
			}

			if($this->input->post('req')=='update_weekday')
			{
				$post = $this->input->post();
				$color = $post['color'];
				$id = $post['id'];
				$res = $this->model->updateData('settings',['weekend_color'=>$color],$args=['where'=>['id'=>$id]]);
				echo $res==true?"1":json_encode('Error in updating , try again');die;
			}
			
			if($this->input->post('req')=='update_holiday_color')
			{ 
				$post = $this->input->post();
				$color = $post['color'];
				$id = $post['id'];
				$res = $this->model->updateData('settings',['public_holiday_color'=>$color],$args=['where'=>['id'=>$id]]);
				echo $res==true?"1":json_encode('Error in updating , try again');die;
			}

			if($this->input->post('req')=='setStatus')
			{
					$id = $this->input->post('id');
					$this->model->updateData('categories',['status'=>'1'],$args=['where'=>['id'=>$id]]);
					$this->model->updateData('categories',['status'=>'0'],$args=['where'=>['id!='=>$id]]);
					$cats = $this->model->getData('categories','all_array');
					$data=[];
					$data[]="<button type='button' class='btn btn-danger' data-cid='0' id='erase'>Erase</button>";
					foreach($cats as $val){
						if($val['status']=="1"){
							$font = "bolder";$class="selected";
						} else {
							$font="";$class="";
						}
						$data[].='<button type="button" data-cid="'.$val['id'].'" class="btn btnclr '.$class.'" data-color="'.$val['color'].'" style="background-color:'.$val['color'].';font-weight:'.$font.';color:#000">'.ucwords($val['name']).'</button>';
					}
					echo json_encode($data);die;
			} // end setStatus

			if($this->input->post('req')=='get_staff_holidays')
			{
				$id = $this->input->post('sid');
				$chk = $this->model->getData('holiday_ent','count_array',$args=['where'=>['staff_id'=>$id]]);
				if($chk==0) {
					echo "0";die;
				} else {
					$res = $this->model->getData('holiday_ent','all_array',$args=['where'=>['staff_id'=>$id],'order'=>['col'=>'year','type'=>'ASC']]);
					$arr=[];
					foreach($res as $key=>$val) {
						$arr[] = '<tr><td>'.$val['holiday_ent'].'</td><td>'.$val['year'].'</td><td><a href="#" data-editi="'.$val['id'].'" class="text-info editi"><span class="far fa-edit iconss"></span></a></td></tr>';
					}
					echo json_encode($arr);die;
				}
			} // end get_staff_holidays

			if($this->input->post('req')=='addHoliday') {
				$post = $this->input->post();
				$year = $post['year'];
				$sid = $post['sid'];
				$holiday = $post['holiday'];
				$checkY = $this->model->getData('holiday_ent','count_array',$args=['where'=>['year'=>$year,'staff_id'=>$sid]]);
				if($checkY==0) {
					$arr = array(
						'staff_id'		=> $sid,
						'holiday_ent'	=> $holiday,
						'year'				=> $year,
					);
					$res = $this->model->insertData('holiday_ent',$arr);
					echo $res==true?"1":"0";die;
				} else {
					$res = $this->model->updateData('holiday_ent',['holiday_ent'=>$holiday],$args=['where'=>['year'=>$year,'staff_id'=>$sid]]);
					echo $res==true?"1":"0";die;
				}
			} // end addHoliday
			
			if($this->input->post('req')=='edit_holiday') {
				$id = $_POST['id'];
				$chk = $this->model->getData('holiday_ent','count_array',$args=['where'=>['id'=>$id]]);
				if($chk==0) {
					echo "0";die;
				} else {
					$res = $this->model->getData('holiday_ent','row_array',$args=['where'=>['id'=>$id]]);
					echo json_encode($res);die;
				}
			}
			
			if($this->input->post('req')=='updateHoliday') {
				$post = $this->input->post();
				$year = $post['year'];
				$sid = $post['sid'];
				$holiday = $post['holiday'];
				$checkY = $this->model->getData('holiday_ent','count_array',$args=['where'=>['year'=>$year,'id'=>$sid]]);
				if($checkY==0) {
					$arr = array(
						'holiday_ent'	=> $holiday,
						'year'			=> $year,
					);
					$res = $this->model->updateData('holiday_ent',$arr,$args=['where'=>['id'=>$sid]]);
					echo $res==true?"1":"0";die;
				} else {
					$res = $this->model->updateData('holiday_ent',['holiday_ent'=>$holiday],$args=['where'=>['id'=>$sid]]);
					echo $res==true?"1":"0";die;
				}
			}
			
			if($this->input->post('req') == 'approve_formular') {
				$id = $this->input->post('id');
				
				$chk = $this->model->getData('application_overtime','row_array',$args=['where'=>['id'=>$id]]);
				if($chk!=null) {
					$arrs = array(
						'approved'	=> '1',
						'approved_at'	=> date('Y-m-d H:i:s'),
					);
					$q = "update application_overtime set approved='1',approved_at='".date('Y-m-d H:i:s')."' where id=$id";
					$res = $this->db->query($q);
					//$res = $this->model->updateData('application_overtime',['approved'=>'1','approved_at'=>date('Y-m-d H:i:s')],$args=['where'=>['id'=>$id]]);
					$das = $this->model->getData('application_overtime','row_array',$args=['where'=>['id'=>$id]]);
					$das['adminS']="approval";
					$mesg = $this->load->view('email_temp',$das,true);
					$sup = $this->model->getData('users','row_array',$args=['where'=>['id'=>$chk['user_id']],'select'=>['email']]);
					$to   = $sup['email'];
					$from = email_sender();
					// send meail to USER
					$subject =  "[Antrag auf Mehrarbeit | genehmigt]";
					if(!empty($to) || !empty($from)) {
						send_mail($to,$from,$subject,$mesg);
					}
					// email sent to admin
					// all admin that have permission to receive email from notification table
					$admins = $this->model->getData('notification','all_array',$args=['where'=>['approved_request'=>'1']]) ;
					$adminEmails = array_column($admins,'admin');
					foreach($adminEmails as $mail=>$mails) {
						if(!empty($mails) || !empty($from)) {
							send_mail($mails,$from,$subject,$mesg);
						}
					}					
					echo $res==true?json_encode("1"):json_encode('Error in approving,try again');die;
				} else {
					echo json_encode('Invalid id, try again');die;
				}
			}
			
			if($this->input->post('req') == 'reject_formular') {
				$id = $this->input->post('id');
				$reason = $this->input->post('reason');
				$chk = $this->model->getData('application_overtime','row_array',$args=['where'=>['id'=>$id]]);
				if( $chk !=null ) {
					$arr = array(
						'approved'	=> '2',
						'not_approved_reason'	=> $reason,
						'rejected_at'	=> date('Y-m-d H:i:s')
					);
					
					$res = $this->model->updateData('application_overtime',$arr,$args=['where'=>['id'=>$id]]);
					
					$chk['adminS']="rejection";
					$chk['reason'] = $reason;
					$mesg = $this->load->view('email_temp',$chk,true);
					$sup = $this->model->getData('users','row_array',$args=['where'=>['id'=>$chk['user_id']],'select'=>['email']]);
					$to   = $sup['email'];
					$from = email_sender();
					$subject = "[Antrag auf Mehrarbeit | abgelehnt]";
					if(!empty($to) || !empty($from)) {
						send_mail($to,$from,$subject,$mesg);
					}			
					
					echo $res==true?json_encode("1"):json_encode('Error in rejecting,try again');die;
				} else {
					echo json_encode('Invalid id, try again');die;
				}
			}
			
			if($this->input->post('req') == 'delete_formular') {
				die;
				$id = $this->input->post('id');
				$chk = $this->model->getData('application_overtime','count_array',$args=['where'=>['id'=>$id]]);
				if( $chk > 0 ) {
					$res = $this->model->deleteData('application_overtime',['id'=>$id]);
					echo $res?json_encode('1'):json_encode('Error in deleting request , try again');die;
				} else {
					echo json_encode('invalid id, try again');die;
				}
			}
			
			if($this->input->post('req') == 'add_notification') {
				$post = $this->input->post();
				$email = test_input($post['email']);
				$arr = array(
					'admin'			=> $email,
					'new_request' 	=> test_input($post['newn']),
					'approved_request'=> test_input($post['approve'])
				);
				//$chk = $this->model->getData('users','count_array',$args=['where'=>['email'=>$email]]);
				//var_dump($chk);die;
				//if($chk==0) {
					/*$str = "";
					$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
					$max = count($characters) - 1;
					for ($i = 0; $i < 5; $i++) {
						$rand = mt_rand(0, $max);
						$str .= $characters[$rand];
					}
					$newPass = $str;
					$arr1 = array(
						'email'		=> $email,
						'password'	=> sha1($newPass),
						'date_created' => date('Y-m-d H:i:s'),
						'role'		=> '1',
						'pass'		=> $newPass
					);
					$this->model->insertData('users',$arr1);*/
					$res = $this->model->insertData('notification',$arr);
					echo $res?json_encode('1'):json_encode('Fehler, bitte noch einmal probieren.');die;
				//} else {
					//echo json_encode('Email already exist, try different email');die;
				//}
			} 
			
			/*if($this->input->post('req') == 'add_notification') {
				$post = $this->input->post();
				$email = test_input($post['email']);
				$arr = array(
					'admin'			=> $email,
					'new_request' 	=> test_input($post['newn']),
					'approved_request'=> test_input($post['approve'])
				);
				$chk = $this->model->getData('notification','count_array',$args=['where'=>['admin'=>$email]]);
				if($chk==0) {
					$res = $this->model->insertData('notification',$arr);
					echo $res?json_encode('1'):json_encode('Error, try again');die;
				} else {
					echo json_encode('Email already exist, try different email');die;
				}
			} */
			
			if($this->input->post('req') == 'delete_notification') {
				$id = $this->input->post('id');
				$chk = $this->model->getData('notification','count_array',$args=['where'=>['id'=>$id]]);
				if( $chk > 0 ) {
					$res = $this->model->deleteData('notification',['id'=>$id]);
					echo $res?json_encode('1'):json_encode('Error in deleting request , try again');die;
				} else {
					echo json_encode('invalid id, try again');die;
				}
			}
				
			if($this->input->post('req') == 'get_notifications') {
				$id = $this->input->post('id');
				$chk = $this->model->getData('notification','row_array',$args=['where'=>['id'=>$id]]);
				if( $chk !=null ) {
					$email = $chk['admin'];
					if($chk['new_request']=="1") {
						$new = "checked";
					} else {
						$new = "";
					}
					if($chk['approved_request']=="1") {
						$approve = "checked";
					} else {
						$approve = "";
					}
					$html = '<input type="hidden" id="eid" value="'.$chk['id'].'" /><div class="form-group">
					<input type="text" name="email" id="eemail" class="form-control" required value="'.$chk['admin'].'" />
						</div>
						<div class="form-group">
							<label class="checkbox-inline">
								<input type="checkbox" value="" '.$new.' id="enew" > Mitteilung &uuml;ber neuen Antrag
							</label>
							<label class="checkbox-inline">
								<input type="checkbox" value="" '.$approve.' id="eapprove" > Mitteilung &uuml;ber genehmigten Antrag
							</label>
						</div>';
						echo json_encode($html);die;
				} else {
					echo json_encode('invalid id, try again');die;
				}
			} 
			
			if($this->input->post('req') == 'update_notification') {
				$id = $this->input->post('id');
				$email = $this->input->post('email');
				$new = $this->input->post('newn');
				$approve = $this->input->post('approve');
				$chk = $this->model->getData('notification','count_array',$args=['where'=>['id'=>$id]]);
				if( $chk > 0 ) {
					$namechk = $this->model->getData('notification','count_array',$args=['where'=>['admin'=>$email,'id!='=>$id]]);
					if($namechk==0) {
						$res = $this->model->updateData('notification',['new_request'=>$new,'approved_request'=>$approve,'admin'=>$email],$args=['where'=>['id'=>$id]]);
						$res==true?"1":"Error in updating , try again";
						echo json_encode($res);die;
					} else {
						echo json_encode('Email "'.$email.'" already exists, try different name');die;
					}
				} else {
					echo json_encode('invalid id, try again');die;
				}
			}

			if($this->input->post('req') == 'add_sv') {
				$email = $this->input->post('email');
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$chk = $this->model->getData('users','count_array',$args=['where'=>['email'=>$email]]);
				if( $chk == 0 ) {
					$password_string = '!@#$%*abcdefghijkmnprstuwxyzABCDEFGHKLMNPQRSTUWXYZ2356789';
					$pass = substr(str_shuffle($password_string), 0, 12);

					$arr = array(
						'fname'		=> $fname,
						'lname'		=> $lname,
						'email'		=> $email,
						'password'	=> sha1($pass),
						'date_created' => date('Y-m-d H:i:s'),
						'role'		=> '2',
						'is_active'	=> '1',
						'pass'		=> $pass
					);

					//$res = $this->model->insertData('users',$arr);
					$res = $this->model->insert_id('users',$arr);
					$idf = $this->db->insert_id();
					$mini = array(
						'sv_id'			=> $idf,
						'state_ids'		=> '',
					);
					$this->model->insertData('sv_holidays',$mini);
					echo $res?json_encode("1"):json_encode('Error in adding sv,try again');die;
				}
				else {
					echo json_encode('E-Mail-Adresse bereits vorhanden, bitte eine andere E-Mail-Adresse verwenden!');die;
				}
			}
			
			if($this->input->post('req') == 'add_manager') {
				$email = $this->input->post('email');
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$chk = $this->model->getData('users','count_array',$args=['where'=>['email'=>$email]]);
				if( $chk == 0 ) {
					$password_string = '!@#$%*abcdefghijkmnprstuwxyzABCDEFGHKLMNPQRSTUWXYZ2356789';
					$pass = substr(str_shuffle($password_string), 0, 12);

					$arr = array(
						'fname'		=> $fname,
						'lname'		=> $lname,
						'email'		=> $email,
						'password'	=> sha1($pass),
						'date_created' => date('Y-m-d H:i:s'),
						'role'		=> '4',
						'is_active'	=> '1',
						'pass'		=> $pass
					);
					$res = $this->model->insertData('users',$arr);
					echo $res?json_encode("1"):json_encode('Error in adding manager, try again');die;
				}
				else {
					echo json_encode('E-Mail-Adresse bereits vorhanden, bitte eine andere E-Mail-Adresse verwenden!');die;
				}
			}

			if($this->input->post('req') == 'add_objekt_manager') {
				$email = $this->input->post('email');
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$chk = $this->model->getData('users','count_array',$args=['where'=>['email'=>$email]]);
				if( $chk == 0 ) {
					$password_string = '!@#$%*abcdefghijkmnprstuwxyzABCDEFGHKLMNPQRSTUWXYZ2356789';
					$pass = substr(str_shuffle($password_string), 0, 12);

					$arr = array(
						'fname'		=> $fname,
						'lname'		=> $lname,
						'email'		=> $email,
						'password'	=> sha1($pass),
						'date_created' => date('Y-m-d H:i:s'),
						'role'		=> '5',
						'is_active'	=> '1',
						'pass'		=> $pass
					);
					$res = $this->model->insertData('users',$arr);
					echo $res?json_encode("1"):json_encode('Error in adding objekt manager, try again');die;
				}
				else {
					echo json_encode('E-Mail-Adresse bereits vorhanden, bitte eine andere E-Mail-Adresse verwenden!');die;
				}
			}  // add_manager
			
			if($this->input->post('req')=='get_manager' || $this->input->post('req')=='get_sv')
			{
				$id = $this->input->post('id');
				$res = $this->model->getData('users','row_array',$args=['where'=>['id'=>$id]]);
				echo json_encode($res);die;
			} // get_manager / get_sv
			
			if($this->input->post('req') == 'process_edit_manager' || $this->input->post('req') == 'process_edit_sv') {
				$id = $this->input->post('id');
				$email = $this->input->post('email');
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$pass = $this->input->post('pass');
				$chk = $this->model->getData('users','count_array',$args=['where'=>['email'=>$email,'role'=>'4','id!='=>$id]]);
				if( $chk == 0 ) {
					$arr = array(
						'fname'		=> $fname,
						'lname'		=> $lname,
						'email'		=> $email,
						'password'	=> sha1($pass),
						'pass'		=> $pass
					);
					$res = $this->model->updateData('users',$arr,$args=['where'=>['id'=>$id]]);
					echo $res?json_encode("1"):json_encode('Fehler beim Hinzufügen, bitte noch einmal probieren.');die;
					
				} else {
					echo json_encode('E-Mail-Adresse bereits vorhanden, bitte eine andere E-Mail-Adresse verwenden!');die;
				}
			}  // add_manager / process_edit_sv
			
			if($this->input->post('req')=='activate_manager' || $this->input->post('req')=='activate_sv') {
				$post = $this->input->post();
				$id = $post['id'];
				$chk = $this->model->getData('users','count_array',$args=['where'=>['id'=>$id]]);
				if($chk==0) {
					echo json_encode('Invalid id,try again');die;
				} else {
					$res = $this->model->updateData('users',['is_active'=>'1'],$args=['where'=>['id'=>$id]]);
					echo $res==true?"1":json_encode('Error in activating, try again');die;
				}
			} // activate_manager / activate_sv
			
			if($this->input->post('req')=='delete_manager' || $this->input->post('req')=='delete_sv') {
				$post = $this->input->post();
				$id = $post['id'];
				$chk = $this->model->getData('users','count_array',$args=['where'=>['id'=>$id]]);
				if($chk==0) {
					echo json_encode('Invalid id');die;
				} else {
					$res = $this->model->updateData('users',['is_active'=>'0'],$args=['where'=>['id'=>$id]]);
					echo $res==true?"1":json_encode('Error in deleting, try again');die;
				}
			} // delete_manager / delete_sv
			
			if($this->input->post('req')=='assign_manager')
			{	
				// if in future is needed for multiple managers, then add comma separated ids of managers.
				$ar = $this->input->post('mid');
				$exp = explode('_',$ar);
				$mid = $exp[0];
				$frm_id = $exp[1];
				$chk = $this->model->getData('application_overtime','row_array',$args=['where'=>['id'=>$frm_id]]);
			
				if($chk==null) {
					echo json_encode('Invalid id,refresh page');die;
				} else {
					$res = $this->model->updateData('application_overtime',['manager_check'=>'0','manager_id'=>$mid],$args=['where'=>['id'=>$frm_id]]);
					$chk['adminS'] = 'approval';
					$chk['manager'] = "manager";
					
					$mesg = $this->load->view('email_temp',$chk,true);
					$mgr = $this->model->getData('users','row_array',$args=['where'=>['id'=>$mid],'select'=>['email']]);
					$to   = $mgr['email'];
					$from = email_sender();
					// send meail to USER
					$subject = "[Antrag auf Mehrarbeit | genehmigt] Manager Mitteilung";
					if(!empty($to) || !empty($from)) {
						send_mail($to,$from,$subject,$mesg);
					}
					echo $res==true?"1":json_encode('Error in assinging, try again');die;
				}
			} // assign_manager
			
			if($this->input->post('req') == 'add_publicholiday') {
				$post = $this->input->post();
				$ids = implode(',',$post['states']);
				$arr = array(
					'start_date'	=> date('Y-m-d',strtotime(test_input($post['start']))),
					'end_date'		=> date('Y-m-d',strtotime(test_input($post['end']))),
					'state_ids'		=> $ids,
					'admin_checked'	=> '1',
				);
				$res = $this->model->insertData('public_holidays',$arr);
				$id = $this->db->insert_id();
				$sv = $this->model->getData('users','all_array',$args=['where'=>['role'=>'2']]);
				foreach($sv as $k) {
					$chk = $this->model->getData('sv_holidays','count_array',$args=['where'=>['sv_id'=>$k['id']]]);
					if($chk==0) {
						$mini = array(
							'sv_id'			=> $k['id'],
							'state_ids'		=> implode(',',$post['states']),
						);
						$this->model->insertData('sv_holidays',$mini);
					}
				}
				echo $res?json_encode('1'):json_encode('Error in saving, try again');die;
			} // add_publicholiday
			
			if($this->input->post('req') == 'delete_public_holiday') {
				$id = test_input($this->input->post('id'));
				$chk = $this->model->getData('public_holidays','count_array',$args=['where'=>['id'=>$id]]);
				if($chk==0) {
					echo json_encode('Invalid holiday id');die;
				} else {
					$res = $this->model->deleteData('public_holidays',['id'=>$id]);
					echo $res==true?"1":json_encode('error in deleting data, try again');die;
				}
			} // delete_public_holiday
			///add _object
			if($this->input->post('req') == 'add_objekt') {
				$post=$this->input->post();
				if($post['begin_date']!=""){
					$begin_date=date('Y-m-d',strtotime($post['begin_date']));
					$post['begin_date']=$begin_date;
				}
				if($post["end_date"]!=""){
					$end_date=date('Y-m-d',strtotime($post['end_date']));
					$post['end_date']=$end_date;
				}
				
				$data=array(
				    "ktr_number"=>$post["ktr_number"],
					"object_name"=>$post["object_name"],
					"object_nl"=>$post["object_nl"],
					"object_supervisor"=>$post["object_supervisor"],
					"begin_date"=>$post["begin_date"],
					"end_date"=>$post["end_date"],
					"created_by"=>$this->session->userdata["userId"]
				);
				
				$res=$this->model->insertData("objects",$data);
				if($res){
					_flashPop($res,'Objekt','Objekt Added Successfully!');
					redirect("objektmanager");
				}else{
					_flashPop($res,'Objekt','Objekt Added Successfully!');
					redirect("objektmanager");
				}
               }
               if($this->input->post('req') == 'edit_objekt') {
				$post=$this->input->post();
				$id=$post['id'];
				$data=array(
				    "ktr_number"=>$post["ktr_number"],
					"object_name"=>$post["object_name"],
					"object_nl"=>$post["object_nl"],
					"object_supervisor"=>$post["object_supervisor"],
					"begin_date"=>$post["begin_date"],
					"end_date"=>$post["end_date"],
				);
				$res = $this->model->updateData('objects',$data,$args=['where'=>['id'=>$id]]);
				if($res)
				{
					echo json_encode('1');die;
				}
				else
				{
					echo json_encode('0');die;
				}
               }
               if($this->input->post('req') == 'delete_objekt') {
				$id = $this->input->post('id');
				$res = $this->model->deleteData('objects',['id'=>$id]);
				if($res)
				{
					echo json_encode('1');die;
				}
				else
				{
					echo json_encode('0');die;
				}
               }
               if($this->input->post('req') == 'get_objekt') {
				$id = $this->input->post('id');
				$res = $this->model->getData('objects','row_array',$args=['where'=>['id'=>$id]]);
				if($res['end_date']=="") {
					$res['begin_date']=date('m/d/Y',strtotime($res['begin_date']));
					$res['end_date']="00-00-0000";
					echo json_encode($res);die;	
				}
				else{
					$res['begin_date']=date('m/d/Y',strtotime($res['begin_date']));
					$res['end_date']=date('m/d/Y',strtotime($res['end_date']));
					echo json_encode($res);die;	
				}		
			}
		} // end ajax
		public function objekte() {
			$data["title"]="Objekte";
		  $data["objects"]=$this->model->getData("objects","all_array");
      $q1='select * from users where role=2 order by lname';
			$data["supervisors"] = $this->model->query($q1,'all_array');

      $q2='select * from users where role=5 order by lname';					//NEU, um den Objektmanagernamen für die Objektseite zur Verfügung zu stellen
			$data["objektmanager"] = $this->model->query($q2,'all_array');

			$q='select * from object_nl order by nl_name';
			$data["object_nl"] = $this->model->query($q,'all_array');
			$this->load->view('admin/object',$data);
	  }

	} // end class Dashboard
?>
