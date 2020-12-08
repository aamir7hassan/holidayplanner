	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/nprogress.css');
		echo link_tag('assets/css/green.css');
		echo link_tag('assets/css/toastr.min.css');
		echo link_tag('assets/datatables/jquery.dataTables.min.css');
		echo link_tag('assets/css/sweetalert.css');
		echo link_tag('assets/css/custom.min.css');
		echo link_tag('assets/css/style.css');
	?>
	<style>
		.table-responsive {
			min-height: .01%;
			overflow-x: initial !important;
		}
		.x_content {
			/*overflow-x: scroll;*/
			overflow-x: auto !important;
		}
		.navbar-nav .open .dropdown-menu {
			left:0px !important;
		}
	</style>
	</head>

	<body class="nav-md">

		<div class="container body">

			<div class="main_container">

				<?php $this->load->view('includes/header');?>

				<div class="right_col" role="main">

					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 maxi">

							<div class="x_panel">

	              <div class="x_title">
	                <h2>Antrag auf Mehrarbeit <?php 
										$str = $this->uri->segment(3);
										if($str=="checked") {
											$strr = '<span class="text-approved">überprüft</span>';
										} else if($str=="unchecked") {
											$strr = '<span class="text-open">ungeprüft</span>';
										}
										echo $strr;?></h2>
	                <ul class="nav navbar-right panel_toolbox">
	                  <li></li>
	                </ul>
	                <div class="clearfix"></div>
	              </div>

								<div class="x_content">
									<div class="table-responsive">
										<table class="table table-striped table-bordered tbl">
											<thead>
												<tr>
													<th class="text-center">ID</th>
													<th class="text-center">Objekt</th>
													<th class="text-center">Mitarbeiter</th>
													<th class="text-center">vom</th>
													<th class="text-center">bis</th>
													<th class="text-center">Stunden/Tag</th>
													<th class="text-center">Begründung</th>
													<th class="text-center">Ausgleich</th>
													<th class="text-center">Ort</th>
													<th class="text-center">Antrag vom</th>
													<th class="text-center">Antragsteller</th>
													<th class="text-center">Details</th>
												</tr>
											</thead>
							<tbody>
								<?php foreach($items as $key=>$val) {
								$st = $val['approved'];
								$status="";
								if($st=="0") {
									$status = '<span class="text-warning"><b>Pending</b></span>';
								} elseif($st=="2") {
									$status = '<span class="text-danger"><b>Rejected</b></span>';
								} elseif($st=="1") {
									$status = '<span class="text-success"><b>Approved</b></span>';
								}
							  ?>

								<tr>
									<td class="text-center"><?php echo $val['id'];?></td>
									<td class="text-center"><?php echo $val['object'];?></td>
									<td class="text-center"><?php echo $val['employee_name'];?></td>
									<td class="text-center"><?php echo $val['time_from'];?></td>
									<td class="text-center"><?php echo $val['time_untill'];?></td>
									<td class="text-center"><?php echo $val['no_of_hours'];?></td>
									<td class="text-center"><?php echo $val['justification'];?></td>
									<?php $check=$val['check_box'];
									if($check=='1') { ?>
									<td class="text-center text-success"><?php echo "Ja";?></td>
									<?php  } else {?>
									<td class="text-center text-danger"><?php echo "Nein";?></td>
									<?php }?>
									<td class="text-center"><?php echo $val['place'];?></td>
									<td class="text-center"><?php echo date('d.m.Y H:i',strtotime($val['date_created']));?></td>
									<td class="text-center"><?php echo $val['applicants_name'];?></td>
									<td class="text-center"><a href="<?=base_url('manager/antrag-auf-mehrarbeit/'.$val['id'])?>"  data-toggle='tooltip' class="text-success" title="Details"><span class="fa fa-info-circle iconss"></a></td>
								</tr>

								<?php } ?>

							</tbody>

						</table>

					</div>
						

								</div>

							</div>

						</div>

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
		<!-- Modal -->
	
	
	
	<div id="rejectModal" class="modal fade" role="dialog" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><span id="name"></span> Rejection reason</h4>
				</div>
				<div class="modal-body">
					<form role="form">
					<input type="hidden" id="rejectid" value="" />
						<div class="form-group">
							<label for="holidays" class="control-label">Reason:</label>
							<textarea class="form-control" name="reason" id="reason" required ></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
					<a href="#" id="rejectN" class="btn btn-success" >Reject Now</a>
				</div>
			</div>
		</div>
	</div>
		<?php $this->load->view('includes/foot');?>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>

		<script>

		$(".tbl").DataTable({

			"order": [[ 0, "desc" ]],
			 responsive: true,
			 "ordering":true,

			 'columnDefs': [ {
			 'targets': [11],
			 'orderable': false,
			 }],
			 responsive: true,
			"fnDrawCallback": function(oSettings){
					var rowCount = this.fnSettings().fnRecordsDisplay();
					if(rowCount<=10){
						$('.dataTables_length').hide();
						$('.dataTables_paginate').hide();
					}
		 }
		});	

		<?php
			if($this->session->flashdata('data')) {
		?>
			toastr.<?php echo $this->session->flashdata('class') ?>('<?php echo $this->session->flashdata('data') ?>');
		<?php } ?>

	</script>

	</body>

</html>
