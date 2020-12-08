<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	class Login extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function db() {
			$this->load->dbutil();
			$prefs = array(     
				'format'      => 'zip',             
				'filename'    => 'my_db_backup.sql'
				);
			$backup =$this->dbutil->backup($prefs); 
			$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
			$save = $db_name;
			$this->load->helper('file');
			write_file($save, $backup); 
			$this->load->helper('download');
			force_download($db_name, $backup);
		}

		public function me1()
		{
			//ini_set('max_input_time','200');
			$this->load->library('zip');
			$path = 'application';
			$time = time();
			$this->zip->read_dir($path);
			$result = $this->zip->download('holiday_application '.date("d-m-Y").'.zip');
			return $result;
		}

		public function index()
		{
			$data['title'] = "Login";
			$this->load->view("login",$data);
		}

		public function processLogin()
		{
		
			$this->validation->set_error_delimiters('<span class="text text-danger"><i class="fa fa-times-circle animated flash"></i> ','</span>');
			if($this->validation->run('login_validation'))
			{
				$email = test_input($this->input->post('email'));
				$pass = test_input($this->input->post('password'));
				$res = $this->model->getData('users','row_array',$args=['where'=>['email'=>$email,'password'=>sha1($pass)]]);
				
				if($res!=null) {
					if($res['role']=='1') $role="admin";elseif($res['role']=='2') $role="supervisor"; elseif($res['role']=="4") $role="manager";elseif($res["role"]=="5") $role="objektmanager";elseif($res["role"]=="6") $role="kalk"; else $role="invalid role";
					if($res['is_active']=="0") {
						_flashPop(false,'','Ihr Account ist gesperrt. Bitte kontaktieren Sie Ihren Administrator.');
						
						return redirect('login');
					}

					$sessi = array(
						'userId'	=> $res['id'],
						'email'		=> $res['email'],
						'fname'		=> $res['fname'],
						'lname'		=> $res['lname'],
						'role'		=> $role,
					);
					$this->session->set_userdata($sessi);

					if($role=="admin") {
							return redirect('admin/dashboard');
					} else if($role=="supervisor") {
							return redirect('supervisor/dashboard');
					} elseif($role=="manager"){
						return redirect('manager');
					}elseif($role=="objektmanager"){
						return redirect('objektmanager');
					}elseif($role=="kalk"){
						return redirect('kalk');
					} else {
						$this->session->set_flashdata('data','Invalid role');
						$this->session->set_flashdata('class','alert-danger');
						return redirect('login');
					}
				} else {
					_flashPop(false,'','E-Mail Adresse oder Passwort falsch!');
					return redirect('login');
				}
			} else{
				$data['title'] = "login";
				$this->load->view("login",$data);
			}
		}





		public function reset_password() {
			if($this->session->role=='admin') {
				$data['title'] = "Reset Password";
				$this->load->view('admin/reset_password',$data);
			}
			else if($this->session->role=='supervisor') {
				$data['title'] = "Reset Password";
				$this->load->view('reset_password',$data);
			}
		}


		public function processResetPassword() {
			$uid = get_userId();
			$data['title'] = "Reset Password";


			$oldPass = test_input($this->input->post('opass'));

			$newPass = test_input($this->input->post('npass'));

			$user = $this->model->getData('users','row_array',$args=['select'=>['password'],'where'=>['id'=>$uid]]);

			$dbPass = $user['password'];

			if($dbPass===sha1($oldPass)) {

				$res = $this->model->updateData('users',['password'=>sha1($newPass)],$args=['where'=>['id'=>$uid]]);

				_flash($res,'Password updated successfully','Error in updating password,try again');

				return redirect('reset-password');

			} else {

				_flash(FALSE,'host','Old password do not match, please type correct old password');

				return redirect('reset-password');

			}

		}



		public function forgot() {

			$email = test_input($this->input->post('email'));
			
			$chk = $this->model->getData('users','count_array',$args=['where'=>['email'=>$email]]);

			if($chk==0) {

				echo json_encode('<span class="text-danger">Unbekannte E-Mail-Adresse</span>');die;

			}
			else {
				
				/*$str = "";

				$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));

				$max = count($characters) - 1;

				for ($i = 0; $i < 5; $i++) {

					$rand = mt_rand(0, $max);

					$str .= $characters[$rand];

				}

				$newPass = $str;
				*/

				$password_string = '!@#$%*abcdefghijkmnprstuwxyzABCDEFGHKLMNPQRSTUWXYZ2356789';
				$newPass = substr(str_shuffle($password_string), 0, 12);

				$arr = array(

					'password'		=> sha1($newPass),

					'pass'				=> $newPass,

				);

				$res = $this->model->updateData('users',$arr,$args=['where'=>['email'=>$email]]);
				if($res)
				{
					$this->load->library('email');
					$config['protocol'] = 'sendmail';
					$config['mailpath'] = '/usr/sbin/sendmail';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;

					$this->email->initialize($config);
					$this->email->from('no-replay@zehm-vs.org', 'Zehm VS');
					$this->email->to($email);
					//$this->email->cc('another@another-example.com');
					//$this->email->bcc('them@their-example.com');

					$this->email->subject('Neues Passwort');
					$this->email->message('Das neue Passwort lautet: '.$newPass);
					$mails = $this->email->send();
					if($mails)
					{
						echo json_encode('1');die;
					} else {
						echo json_encode('Error in recovering password, try agian');die;
					}

				}else{
						echo json_encode('Error ,try agian');die;
				}

			}

		}



		public function logout() {

			$this->session->sess_destroy();

			return redirect('login');

		}



		public function sessi()

		{

			var_dump($_SESSION);

			echo "<pre>";

			$this->load->library('user_agent');

			$u = $this->input->ip_address();

			var_dump($u);

		}

	}
