	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/nprogress.css');
		echo link_tag('assets/css/green.css');
		echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
		echo link_tag('assets/css/bootstrap-datepicker.min.css');
		echo link_tag('assets/css/jqvmap.min.css');
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
								<a href="<?php echo base_url('supervisor/list-staff'); ?>">
								<div class="tile-stats">
                  <div class="icon dashboard_big_icon"><i class="fa fa-users text-primary"></i></div>
                  <div class="count text-primary"><?php echo count($staff) ?></div>
                  <h3 class="text-primary">Mitarbeiter</h3>
                </div>
							</a>
              </div>
			   			<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url('supervisor/checklisten/open');?>"><div class="tile-stats">
                  <div class="icon dashboard_big_icon"><i class="far fa-calendar-check text-primary"></i></div>
                  <div class="count text-primary">
                  	<?php
                  		$uid = get_userId();

                  		$dashboard_cl_open    = $this->model->getData('cl_lists','count_array',$args=['where'=>['checked'=>'0','locked'=>'0', 'sv_id'=>$uid]]);
                  		$dashboard_cl_checked = $this->model->getData('cl_lists','count_array',$args=['where'=>['checked'=>'1', 'sv_id'=>$uid]]);
                  		$dashboard_cl_locked  = $this->model->getData('cl_lists','count_array',$args=['where'=>['checked'=>'0','locked'=>'1', 'sv_id'=>$uid]]);

											echo "<div><span class=\"text-open\">" . $dashboard_cl_open . "</span> / <span class=\"text-approved\">" . $dashboard_cl_checked . "</span> / <span class=\"text-rejected\">" . $dashboard_cl_locked . "</span></div>";
                  	?>
                  </div>
                  <h3 class="text-primary">Checklisten</h3>
                </div></a>
              </div>
			   			<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url('supervisor/antrag-auf-mehrarbeit/pending');?>"><div class="tile-stats">
                  <div class="icon dashboard_big_icon"><i class="fa fa-user-clock text-primary"></i></div>
                  <div class="count text-primary">
                  	<?php
                  		$uid = get_userId();

                  		$dashboard_pending  = $this->model->getData('application_overtime','count_array',$args=['where'=>['approved'=>'0', 'user_id'=>$uid]]);
                  		$dashboard_approved = $this->model->getData('application_overtime','count_array',$args=['where'=>['approved'=>'1', 'user_id'=>$uid]]);
                  		$dashboard_rejected = $this->model->getData('application_overtime','count_array',$args=['where'=>['approved'=>'2', 'user_id'=>$uid]]);
											
											echo "<div><span class=\"text-open\">" . $dashboard_pending . "</span> / <span class=\"text-approved\">" . $dashboard_approved . "</span> / <span class=\"text-rejected\">" . $dashboard_rejected . "</span></div>";
                  	?>
                  </div>
                  <h3 class="text-primary">Anträge auf Mehrarbeit</h3>
                </div></a>
              </div>
            </div>
					<div class="clearfix"></div>
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
		<script>

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
					suggestedMax:<?php echo isset($data_max)?$data_max:0 ?>,
					}
				}]
				}
			}
			});
		}
		</script>
	</body>
</html>
