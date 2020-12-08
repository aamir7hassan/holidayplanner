	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/nprogress.css');
		echo link_tag('assets/css/green.css');
		echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
		echo link_tag('assets/css/jqvmap.min.css');
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
										if($str=="approved") {
											$strr = '<span class="text-approved">genehmigt</span>';
										} elseif($str=="rejected") {
											$strr = '<span class="text-rejected">abgelehnt</span>';
										} elseif($str=="pending") {
											$strr = '<span class="text-open">offen</span>';
										}
										echo $strr;?></h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a href="../../supervisor/add-antrag-auf-mehrarbeit" class="btn btn-success" style="color:#fff">+ Antrag auf Mehrarbeit</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">

									<div class="text-right">

									</div>
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
									<th class="text-center">Details</th>
									<!--<th class="text-center">Status</th>-->
								</tr>
							</thead>
							<tbody>
								<?php foreach($items as $key=>$val) {
								$st = $val['approved'];
								if($st=="1") {
									$status = '<span class="text-success"><b>Approved</b></span>';
								} elseif($st=="0") {
									$status = '<span class="text-warning"><b>Pending</b></span>';
								} elseif($st=="2") {
									$status = '<span class="text-danger"><b>Rejected</b></span>';
								} else {
									$status="";
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
								if($check=='1'){  ?>
									<td class="text-center text-success"><?php echo "Ja";?></td>
									<?php  } else {?>
									<td class="text-center text-danger"><?php echo "Nein";?></td>
									<?php }?>
									<td class="text-center"><?php echo $val['place'];?></td>
									<td class="text-center"><?php echo date('d.m.Y H:i',strtotime($val['date_created']));?></td>
									<td class="text-center">
									<a href="<?php echo base_url('supervisor/antrag-auf-mehrarbeit/'.$val['id'])?>" data-toggle='tooltip' class="text-success" title="Details"><i class="fa fa-info-circle iconss"></i></a>
									</td>
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
	<div id="holidaymodal" class="modal fade" role="dialog" tabindex="-2">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><span id="name"></span> Urlaubsanspruch</h4>
					<form>
						<input type="hidden" id="id" name="id" value="" />
					</form>
				</div>
				<div class="modal-body" id="mbody">
					<a href="#" class="btn btn-success" id="assign">Urlaubsanspruch hinzufügen</a>
					<table class="table">
						<thead>
							<tr>
								<th>Urlaubsanspruch</th>
								<th>Jahr</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="tbody">

						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
				</div>
			</div>
		</div>
	</div>
	<div id="addholiday" class="modal fade" role="dialog" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><span id="name"></span> Urlaubsanspruch</h4>
				</div>
				<div class="modal-body">
					<form role="form">
						<div class="form-group">
							<label class="control-label">Urlaubsanspruch</label>
							<input type="number" id="holiday_ent" min="0.0" step="0.5" class="form-control" name="holiday_ent" required/>
						</div>
						<div class="form-group">
							<label for="holidays" class="control-label">Jahr:</label>
							<input type="number" class="form-control" name="year" id="year" min="0" step="1" />
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
					<a href="#" id="save" class="btn btn-success" >Save</a>
				</div>
			</div>
		</div>
	</div>
	<div id="editholiday" class="modal fade" role="dialog" tabindex="-3">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><span id="ename"></span> Urlaubsanspruch</h4>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" id="hid" value="" />
						<div class="form-group">
							<label class="control-label">Urlaubsanspruch</label>
							<input type="number" id="eholiday_ent" min="0.0" step="0.5" class="form-control" name="holiday_ent" required/>
						</div>
						<div class="form-group">
							<label for="holidays" class="control-label">Jahr:</label>
							<input type="number" class="form-control" name="year" id="eyear" min="0" step="1" />
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
					<a href="#" id="esave" class="btn btn-success" >Update</a>
				</div>
			</div>
		</div>
	</div>
		<?php $this->load->view('includes/foot');?>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/date.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>

		<script>

		$(".tbl").DataTable({
			'columnDefs': [ {
				'targets': [6],
				'targets': [10],
				'orderable': false,
			}],
			"order": [[ 0, "desc" ]],
			"fnDrawCallback": function(oSettings){
					var rowCount = this.fnSettings().fnRecordsDisplay();
					if(rowCount<=10){
						$('.dataTables_length').hide();
						$('.dataTables_paginate').hide();
					}
		 }
		});

		$(document).on('click','.holiday',function() {
			var sid = $(this).data('holiday');
      var name = $(this).data('name');
      $('#name').html(name);
			$('#id').val(sid);
			$.ajax({
				url:"<?php echo base_url('supervisor/dashboard/ajax');?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'get_staff_holidays','sid':sid},
				success:function(res) {
          if(res==0) {
            toastr.error('Invalid staff id');
          } else {
            $('#tbody').html(res);
            $('#holidaymodal').modal('show');
          }
				}
			});
		});

		$(document).on('click','#assign',function(){
			$('#addholiday').modal('show');
		});

		$(document).on('click','#save',function(){
			var sid = $('#id').val();
			var holiday = $('#holiday_ent').val();
			var year = $('#year').val();
			if(holiday=="") {
				alert('Please enter holidays');
				return false;
			}
			if(year=="") {
				alert('Please enter year');
				return false;
			}
			$(this).html('saving...');
			$(this).prop('disabled',true);
			$.ajax({
				url:"<?php echo base_url('supervisor/dashboard/ajax'); ?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'addHoliday','sid':sid,'holiday':holiday,'year':year},
				success:function(res){
					$('#save').html('Save');
					$('#save').prop('disabled',false);
					$('#holiday_ent').val('');
					$('#year').val('');
					if(res==1) {
						toastr.success('Assigned successfully');
						$('#addholiday').modal('hide');
						$('#holidaymodal').modal('hide');
						
					} else {
						toastr.error('Error! try agian');
						$('#addholiday').modal('hide');
						$('#holidaymodal').modal('hide');
					}
				}
			});
		});

		$(document).on('click','.editi',function(){
			var id = $(this).data('editi');
			$.ajax({
				url:"<?php echo base_url('supervisor/dashboard/ajax'); ?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'edit_holiday','id':id},
				success:function(res) {
					console.log(res);
					if(res==0) {
						toastr.error('invalid id');
					} else {
						$('#hid').val(res.id);
						$('#eholiday_ent').val(res.holiday_ent);
						$('#eyear').val(res.year);
						$('#editholiday').modal('show');
					}
				}
			});
		});
		
		$(document).on('click','#esave',function(){
			var sid = $('#hid').val();
			var holiday = $('#eholiday_ent').val();
			var year = $('#eyear').val();
			
			if(holiday=="") {
				alert('Please enter holidays');
				return false;
			}
			if(year=="") {
				alert('Please enter year');
				return false;
			}
			$(this).html('updating...');
			$(this).prop('disabled',true);
			$.ajax({
				url:"<?php echo base_url('supervisor/dashboard/ajax'); ?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'updateHoliday','sid':sid,'holiday':holiday,'year':year},
				success:function(res){
					$('#esave').html('Update');
					$('#esave').prop('disabled',false);
					$('#eholiday_ent').val('');
					$('#eyear').val('');
					if(res==1) {
						toastr.success('Aktualisierung erfolgreich');
						$('#editholiday').modal('hide');
						$('#holidaymodal').modal('hide');
						
					} else {
						toastr.error('Error! try agian');
						$('#editholiday').modal('hide');
						$('#holidaymodal').modal('hide');
					}
				}
			});
		});

		<?php
			if($this->session->flashdata('data')) {
		?>
			toastr.<?php echo $this->session->flashdata('class') ?>('<?php echo $this->session->flashdata('data') ?>');
		<?php } ?>

	</script>

	</body>

</html>
