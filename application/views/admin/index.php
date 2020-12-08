	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/nprogress.css');
		echo link_tag('assets/css/green.css');
		echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
		echo link_tag('assets/css/bootstrap-datepicker.min.css');
		echo link_tag('assets/css/jqvmap.min.css');
		  echo link_tag('assets/datatables/jquery.dataTables.min.css');
		echo link_tag('assets/css/custom.min.css');
		echo link_tag('assets/css/style.css');
	?>

	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<?php $this->load->view('includes/header');?>
				<div class="right_col" role="main">
					<div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url('admin/supervisors');?>"><div class="tile-stats">
                  <div class="icon dashboard_big_icon"><i class="fa fa-users text-primary"></i></div>
									<?php
										$cnt = $this->model->getData('users','count_array',$args=['where'=>['role'=>'2']]);
									?>
                  <div class="count text-primary"><?php echo $cnt ?></div>
                  <h3 class="text-primary">Bereichsleiter</h3>
                </div></a>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url('admin/staff');?>"><div class="tile-stats">
                  <div class="icon"><i class="fa fa-user text-primary"></i></div>
                  <div class="count text-primary"><?php echo getCount('staff','')?></div>
                  <h3 class="text-primary">Mitarbeiter</h3>
                </div></a>
              </div>
			   			<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url('admin/managers');?>"><div class="tile-stats">
                  <div class="icon"><i class="fa fa-user text-primary"></i></div>
								  <?php 
									$managers = $this->model->getData('users','count_array',$args=['where'=>['role'=>'4']]);
								  ?>
                  <div class="count text-primary"><?php echo $managers;?></div>
                  <h3 class="text-primary">Lohnmanager</h3>
                </div></a>
              </div>
			   			<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url('admin/objektmanagers');?>"><div class="tile-stats">
                  <div class="icon"><i class="fa fa-user text-primary"></i></div>
								  <?php 
										$objektmanagers = $this->model->getData('users','count_array',$args=['where'=>['role'=>'5']]);
								  ?>
                  <div class="count text-primary"><?php echo $objektmanagers;?></div>
                  <h3 class="text-primary">Objektmanager</h3>
                </div></a>
              </div>
			   			<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url('admin/objekte');?>"><div class="tile-stats">
                  <div class="icon"><i class="fa fa-home text-primary"></i></div>
                  <div class="count text-primary"><?php echo getCount('objects','')?></div>
                  <h3 class="text-primary">Objekte</h3>
                </div></a>
              </div>
			   			<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url('admin/checklisten/open');?>"><div class="tile-stats">
                  <div class="icon dashboard_big_icon"><i class="far fa-calendar-check text-primary"></i></div>
                  <div class="count text-primary">
                  	<?php
                  		$dashboard_cl_open    = $this->model->getData('cl_lists','count_array',$args=['where'=>['checked'=>'0','locked'=>'0']]);
                  		$dashboard_cl_checked = $this->model->getData('cl_lists','count_array',$args=['where'=>['checked'=>'1']]);
                  		$dashboard_cl_locked  = $this->model->getData('cl_lists','count_array',$args=['where'=>['checked'=>'0','locked'=>'1']]);

											echo "<div><span class=\"text-open\">" . $dashboard_cl_open . "</span> / <span class=\"text-approved\">" . $dashboard_cl_checked . "</span> / <span class=\"text-rejected\">" . $dashboard_cl_locked . "</span></div>";
                  	?>
                  </div>
                  <h3 class="text-primary">Checklisten</h3>
                </div></a>
              </div>
			   			<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url('admin/antrag-auf-mehrarbeit/pending');?>"><div class="tile-stats">
                  <div class="icon dashboard_big_icon"><i class="fa fa-user-clock text-primary"></i></div>
                  <div class="count text-primary">
                  	<?php
                  		$dashboard_pending = $this->model->getData('application_overtime','count_array',$args=['where'=>['approved'=>'0']]);
                  		$dashboard_approved = $this->model->getData('application_overtime','count_array',$args=['where'=>['approved'=>'1']]);
                  		$dashboard_rejected = $this->model->getData('application_overtime','count_array',$args=['where'=>['approved'=>'2']]);
											
											echo "<div><span class=\"text-open\">" . $dashboard_pending . "</span> / <span class=\"text-approved\">" . $dashboard_approved . "</span> / <span class=\"text-rejected\">" . $dashboard_rejected . "</span></div>";
                  	?>
                  </div>
                  <h3 class="text-primary">Anträge auf Mehrarbeit</h3>
                </div></a>
              </div>
            </div>
		  <div class="panel panel-success" style="margin-top: 1em; display:none;">

						<div class="panel-heading">Übersicht Urlaub</div>

						<div class="panel-body">
							
							<div class="table-responsive">
								<table class="table" id="tbl">
									<thead>
										<tr>
											<th class="text-left" nowrap>Name</th>
											<th class="text-left no-sort">Jahr</th>
											<th class="text-left">Urlaubsanspruch</th>	
											<th class="text-left">Urlaubstage vom Vorjahr</th>
											<th class="text-left">genutzte Urlaubstage vom Vorjahr</th>
											<?php 
												foreach($categories as $cats) {
											?>
											<th class="text-left"><?php echo $cats['name'] ?></th>
											<?php } ?>
											<th class="text-left">Beanspruchter Urlaub</th>
										</tr>
									</thead>
									<tbody id="result">
										<?php
										
										if(!empty($holiday_ent)) {
										foreach($staff as $key=>$val) {
											
											$check_ent=array_search($val["id"],array_column($holiday_ent,"staff_id"));
											$e_key=array_search($val["id"],array_column($holiday_ent,"staff_id"));
											
											$h_key = array_search($val['id'],array_column($staff,"id"));
											$a_key=array_search($val["id"],array_column($attendance,"staff_id"));
											
											$ptrn="";
											if($a_key!==false) {
												$ptrn=$attendance[$a_key]["pattern"];
											}
											$parr=explode(",",$ptrn);
											
											$prevY_k=array_search($val["id"],array_column($prevYearHolidays,"staff_id"));
											$prevHE_k=array_search($val["id"],array_column($prevYEnt,"staff_id"));
											$countF=0;
											if($prevY_k!==false) {
												$prevPat = $prevYearHolidays[$prevY_k]['pattern'];
												$fPrevPat=[];
												if(!empty($prevPat)) {
												$fPrevPat= explode(',',$prevPat);
												}
												
												$countF = count($fPrevPat);
											}
											
											$cnt=0;
											$preYHE=0;
											$ent=0;
											if($prevHE_k !== false) {
												if($prevYEnt[$prevHE_k]['holiday_ent']!==""  && $val['id']==$prevYEnt[$prevHE_k]['staff_id']) {
													$preYHE = $prevYEnt[$prevHE_k]['holiday_ent'];
													
													$cnt = $preYHE - ($countF/2);
													if($cnt<=0) {
														$cnt=0;
													}
												} 
											}
											
											$prevC="0";
											foreach($parr as $pt) {
												if(!empty($pt)) {
													$pattern=explode(" ",$pt);
													if($pattern[2]==$prevY)
													{
														$prevC=$prevC+0.5;
													}
												}
											}
											if($e_key!==false) {									
												if($holiday_ent[$e_key]['holiday_ent']!=="" && $holiday_ent[$e_key]['year']==$curYear && $val['id']==$holiday_ent[$e_key]['staff_id']) {
													$ent= $holiday_ent[$e_key]["holiday_ent"];
												} else {
													$ent = 0;
												}
											}
											if($ent!==0) {
										?>
										<tr>
											<td class="text-left" nowrap><?php echo $val["lname"].", ".$val["fname"]?></td>
											<td class="text-left"><?php echo $holiday_ent[$e_key]["year"];?></td>
											<td class="text-left"><?php echo $ent;?></td>
											<td class="text-left"><?php echo $cnt?></td>
											<td class="text-left"><?php echo $prevC?></td>
											<?php
											
											foreach($categories as $c_key=>$c_val) {
												$count=0;
												foreach($parr as $pt) {
													if(!empty($pt)) {
														$pattern=explode(" ",$pt);
														if($pattern[2]==$curYear && $pattern[3]==$c_val["id"])
														{
															$count=$count+0.5;
														}
													}
												}
											?>
											<td class="text-left"><?php echo $count?></td>
											
											<?php } 
											$coun=0;
											foreach($parr as $pt) {
												if(!empty($pt)){
												$pattern=explode(" ",$pt);
												if($pattern[2]==date("Y"))
												{
													$coun=$coun+0.5;
												}
											}
											}
											?>
											<td class="text-left"><?php echo $coun?></td>
										</tr>
											
											<?php } }
									}else{ ?>
										
									<? } ?>
									</tbody>

								</table>

							</div>

							<!-- / .table-responsive -->

						</div>

					</div>


					</div>
				</div>
				<!-- / .right_col -->
			</div>
			<!-- / .main_container -->
		</div>
		<!-- / .body -->
		<?php $this->load->view('includes/foot');?>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/Chart.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/gauge.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-progressbar.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/skycons.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.flot.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.flot.pie.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/date.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.vmap.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.vmap.world.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/moment.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/daterangepicker.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
		
		  <script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
		<script>
		$("#tbl").DataTable();

			$('#date').datepicker({
				autoclose: true,
		    minViewMode: 1,
		    format: 'mm/yyyy',
			}).on('changeDate', function(selected){
        $('#frm').submit();
    	});

			$(document).on('change','#staff',function(){
				var date = $('#date').val();
				if(date=="") {
					alert('Please select date');
					return false;
				}
				$('#frm').submit();
			});
		if ($('#barChart').length ) {
			var ctx = document.getElementById("barChart");
			var mybarChart = new Chart(ctx, {
			type: 'bar',
			<?php

				$cats = array_column($categories,'name');
				$color = array_column($categories,'color');

			?>
			data: {

				labels: <?php echo json_encode($cats); ?>,
				datasets: [{
				label: '',
				backgroundColor:
         <?php echo json_encode($color); ?>
       ,
				data: <?php echo json_encode($data_set) ?>
			}
			]
			},
			options: {
				scales: {
				yAxes: [{
					ticks: {
					beginAtZero: true,
					stepSize:0.5,
					suggestedMax:<?php echo isset($data_max)?$data_max:0 ?>
					}
				}]
				}
			}
			});
		}
		</script>
	</body>
</html>
