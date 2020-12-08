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
              <h1>hello</h1>

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
		
	</body>
</html>
