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
	                  <li></li>
	                </ul>
	                <div class="clearfix"></div>
	              </div>

								<div class="x_content">

									<div class="text-right">

										<!--<a href="<?php echo base_url('supervisor/add-antrag-auf-mehrarbeit');?>"><button class="btn btn-primary"><i class="fa fa-plus"></i> Antrag auf Mehrarbeit</button></a>-->

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
									<th class="text-center">Antragsteller</th>
									<!--<th class="text-center">Status</th>-->
									<th class="text-center">
										
										<?php 
											$str = $this->uri->segment(3);
											if($str=="approved") {
												$strr = 'Details';
											} elseif($str=="rejected") {
												$strr = 'Details';
											} elseif($str=="pending") {
												$strr = 'Bearbeiten';
											}
											echo $strr;
										?>

									</th>
									<?php 
										if($str=="approved") {
									?>
									<th class="text-center lohnmanager_th">Lohnmanager</th>
									<th class="text-center">Status</th>
									<?php } ?>
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
									<!--<td class="text-center"><?=$status?></td>-->
									<td>
										<center>
											<a href="<?=base_url('admin/antrag-auf-mehrarbeit/'.$val['id'])?>" data-toggle='tooltip' class="text-success" title="Details"><span class="fa fa-info-circle iconss"></a>
											<?php if($str!='approved' && $str !='rejected'){?>
											<a href="#" data-approve="<?=$val['id']?>" data-toggle='tooltip' class="text-success approve" title="Antrag genehmigen"><span class="fa fa-check-circle iconss "></a>
											<?php } ?>
											<?php 
												if($str !='rejected' && $str!='approved') {
											?>
											<a href="#" data-reject="<?=$val['id']?>" data-toggle='tooltip' class="text-danger reject" title="Antrag ablehnen"><span class="fa fa-times-circle iconss "></a>
											<?php	} ?>
										</center>
									</td>
									<?php 
										if($str=="approved") {
											$selman = $val['id'];
											if($val['manager_check']=="1") {
												$checked = '<div class="status geprueft">geprüft</div>';
											} elseif($val['manager_check']=="0") {
												$checked = '<div class="status ungeprueft">ungeprüft</div>';
											} else {
												$checked = '<div class="">&nbsp;</div>';
											}
									?>
									<th>
										<?php 
											if($val['manager_check']=="1") {
												foreach($managers as $k=>$manager) {
													if($manager['id']==$val['manager_id']){
														echo $manager['fname'].' '.$manager['lname'];
													}
												}
											} else {
										?>
										<select name="manager" class="form-control manager" style="/*width:160px; margin: 0 auto;/*">
										<?php 
											if(count($managers)>0) {
												echo "<option value=''>Zuordnung</option>";
												foreach($managers as $k=>$manager) {
													
													$sel = $manager['id']==$val['manager_id']?"selected":"";
													
										?>
											<option <?=$sel?> value="<?=$manager['id'].'_'.$selman?>"><?=$manager['fname']." ".$manager['lname']?></option>
											<?php } } } ?>
										</select>
									</th>
									<th><?=$checked?></th>
									<?php } ?>
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
					<h4 class="modal-title"><span id="name"></span> Grund der Ablehnung</h4>
				</div>
				<div class="modal-body">
					<form role="form">
					<input type="hidden" id="rejectid" value="" />
						<div class="form-group">
							<textarea class="form-control" name="reason" id="reason" required ></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
					<a href="#" id="rejectN" class="btn btn-danger" >Antrag ablehnen</a>
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

			 "columnDefs": [ {
				"targets": 11,
				"orderable": false
				} ],
			"fnDrawCallback": function(oSettings){
					var rowCount = this.fnSettings().fnRecordsDisplay();
					if(rowCount<=10){
						$('.dataTables_length').hide();
						$('.dataTables_paginate').hide();
					}
		 }
		});

		$(document).on('click','.approve',function(e) {
			e.preventDefault();
			var that = $(this);
			var id = $(this).data('approve');
			swal({
			title: "Sind Sie sicher?",
			text: "Der Antrag wird endgültig genehmigt!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Antrag genehmigen!",
			closeOnConfirm: true }, function(){
				$.ajax({
					url:"<?php echo base_url('admin/dashboard/ajax'); ?>",
					type:"POST",
					dataType:"JSON",
					data:{'req':'approve_formular','id':id},
					success:function(res) {
						if(res=="1") {
							toastr.success('Approved successfully');
							window.location.reload();
						} else {
							toastr.error(res);
							that.removeClass('disabled');
						}
					}
				});
			});
		});
		
		$(document).on('click','.del',function(e) {
			e.preventDefault();
			var id = $(this).data('del');
			swal({
			title: "Sind Sie sicher?",
			text: "Die Daten werden endgültig gelöscht!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Daten löschen!",
			closeOnConfirm: true }, function(){
				$.ajax({
				url:"<?php echo base_url('admin/dashboard/ajax');?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'delete_formular','id':id},
				success:function(res) {
					if(res=="1"){
						toastr.success('Mitarbeiter erfolgreich gelöscht');
						window.location.reload();
					} else {
						toastr.error(res);
					}
				}
				});
			});
		});
		
		$(document).on('click','.reject',function(e){
			e.preventDefault();
			var that = $(this);
			var id = that.data('reject');
			$('#rejectid').val(id);
			$('#rejectModal').modal('show');
		});
		
		$(document).on('click','#rejectN',function(e){
			e.preventDefault();
			var that = $(this);
			var id = $('#rejectid').val();
			var reason = $('#reason').val();
			that.addClass('disabled');
			$.ajax({
				url:"<?php echo base_url('admin/dashboard/ajax'); ?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'reject_formular','id':id,'reason':reason},
				success:function(res) {
					if(res=="1") {
						toastr.success('Rejected successfully');
						window.location.reload();
					} else {
						toastr.error(res);
						that.removeClass('disabled');
					}
				}
			});
		});
		
		$(document).on('change','.manager',function(){
			var mid = $(this).val();
			if(mid=="") {
				toastr.error('Bitte einen Lohnmanager auswählen!');
				return false;
			}
			$.ajax({
				url:"<?php echo base_url('admin/dashboard/ajax'); ?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'assign_manager','mid':mid},
				success:function(res) {
					if(res=="1") {
						
						window.location.reload();
					} else {
						toastr.error(res);
					}
				}
			});
		});
		
		<?php
			if($this->session->has_userdata('data')) {
		?>
			toastr.<?php echo $this->session->flashdata('class') ?>('<?php echo $this->session->flashdata('data') ?>');
		<?php } ?>
	</script>

	</body>

</html>
