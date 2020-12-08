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
		echo link_tag('assets/css/sweetalert.css');
		echo link_tag('assets/css/toastr.min.css');
		echo link_tag('assets/css/style.css');
	?>
	<style>
		.deactivate{background-image: linear-gradient(135deg,rgba(0,0,0,.02) 25%,transparent 25%,transparent 50%,rgba(0,0,0,.02) 50%,rgba(0,0,0,.02) 75%,transparent 75%,transparent) !important; background-color: #ccc !important; background-size: 1rem 1rem !important;}
		.deactivate-text{color: #BAB8B8 !important;}
		.activate-text{color:#337AB7!important;}
	</style>
	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<?php $this->load->view('includes/header');?>
				<div class="right_col" role="main">

					<div class="row">
          	<div class="col-md-12 col-sm-12 col-xs-12  maxi">
							<div class="x_panel">
									
								<div class="x_title">
									<h2>Quartalslisten erstellen</h2>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">


					<div class="row top_tiles">
					<?php
				    $quartals = array(1 => 1, 2 => 1, 3 => 1, 4 => 2, 5 => 2, 6 => 2, 7 => 3, 8 => 3, 9 => 3, 10 => 4, 11 => 4, 12 => 4 ); 
						$quartals_end = array(1 => 3, 2 => 6, 3 => 9, 4 => 12 );
						$quartals_start = array(1 => 1, 2 => 4, 3 => 7, 4 => 10);

						$curDate = date_create('today'); //'today' || 2020-11-28 15:00
						//$curDate = date_create('2020-01-28 15:00'); //1. Quarter 2020
						$curDate = date_create('2020-04-23 15:00'); //2. Quarter 2020
						//$curDate = date_create('2020-08-23 15:00'); //3. Quarter 2020
						//$curDate = date_create('2020-11-03 15:00'); //4. Quarter 2020
						$month = $curDate->format('n');
						$year = $curDate->format('Y');
						$aktQuartal = $quartals[$month];
											
						$Quartal = 2;	//Quartalzeitraum mit Quartalsangabe
						$Quartal_Start = date("d.m.Y",mktime(0,0,0,$quartals_start[$Quartal],1,$year));
						$Quartal_Ende = date("d.m.Y",mktime(0,0,0,$quartals_end[$Quartal],date("t",mktime(0,0,0,$quartals_end[$Quartal],1,$month)),$year));


						foreach($data as $check) {  
							if ($check['year']==date("Y")) {
								$Quartal = $check['quarter'];	//Quartalzeitraum mit Quartalsangabe
								$Quartal_Start = date("d.m.",mktime(0,0,0,$quartals_start[$Quartal],1,$year));
								$Quartal_Ende = date("d.m.Y",mktime(0,0,0,$quartals_end[$Quartal],date("t",mktime(0,0,0,$quartals_end[$Quartal],1,$month)),$year));

								if($check['status']==0 && $aktQuartal == $check['quarter']) {?>
			             <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 db_cl_active">
											<a href="#" onClick=quar('<?=$check['quarter']?>')>
		                	<div class="tile-stats">
		                  	<div class="icon"><i class="far fa-calendar-check activate-text"></i></div>
												<div class="count activate-text"><?=$check['quarter']?>. Quartal</div>
		                  	<h3 class="text-primary"><?php echo $Quartal_Start . "-" . $Quartal_Ende; ?></h3>
		                		</div>
		                </a>
		              </div>
									<?php
								}
								else {
									if($check['status']==1) {$clr_cl_created = " style=\"background: #d9ecdb !important\"";}
									else {$clr_cl_created = "";}
									?>
	              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12 db_cl">
	                <div href="#">
					
	                	<div class="tile-stats deactivate"<?php echo $clr_cl_created; ?>>
	                  	<div class="icon"><i class="far fa-calendar-check"></i></div>
											<div class="count deactivate-text" ><?=$check['quarter']?>. Quartal</div>
	                  	<h3 class="" style="color: #BAB8B8 !important;"><?php echo $Quartal_Start . "-" . $Quartal_Ende; ?></h3>
	                		</div>
	                </div>
	              </div><?php
	            	}
							}
						}
					?>
            </div>
				</div>
				<!-- / .right_col -->
			</div>
			<!-- / .main_container -->
		</div>


		<?php $this->load->view('includes/foot');?>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/Chart.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/gauge.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-progressbar.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
			<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
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
		var url = "<?php echo base_url('admin/checklists/ajax'); ?>";
		
		function quar(id) {
				var span = document.createElement("span");
				span.innerHTML = "Testno  sporocilo za objekt <b>test</b>";
				
				swal({
				title: "Sind Sie sicher?",
				html: true,
				text: "Es werden für alle Objekte Checklisten für das aktuelle Quartal erstellt!<div class=\"btn-danger\" style=\"margin-top:.5em\">Vorhandene Quartalslisten werden gesperrt!</div>",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ja, erstelle die Checklisten!",
				closeOnConfirm: true }, function(){
					$.ajax({
						url:url,
						type:"POST",
						dataType:"JSON",
						data:{'req':'update_quarter','id':id},
						success:function(res) {
							if(res=="1"){
								toastr.success('Checklisten erfolgreich erstellt.');
								
								window.location.reload();
							} else {
								toastr.error(res);
							}
						}
					});
				});
			}
		</script>
	</body>
</html>
