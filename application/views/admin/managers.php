	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
		echo link_tag('assets/datatables/jquery.dataTables.min.css');
		echo link_tag('assets/css/toastr.min.css');
		echo link_tag('assets/css/sweetalert.css');
		echo link_tag('assets/css/custom.min.css');
		echo link_tag('assets/css/style.css');
	?>
	<style>
		.dataTables_filter,.dataTables_info {
			/*display:none;*/
		}
		table th,td {
			text-align:center;
		}
	</style>

	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<?php $this->load->view('includes/header');?>
				<div class="right_col" role="main">
					<div class="">
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Lohnmanager</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a href="#" data-toggle="modal" data-target="#addmanager" class="btn btn-success" style="color:#fff">+ Lohnmanager</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<?php if($error = $this->session->flashdata('data')) {
										$class = $this->session->flashdata('class');
									?>
										<div class="alert alert-dismissible <?=$class;?>" id = "success-alert">
											<button  type ="button" class="close" data-dismiss="alert">x</button>
											<?php echo $error;?>
										</div>
									<?php } ?>
									<div class="table-responsive">
										<table class="table table-striped table-bordered tbl">
											<thead>
												<tr>
													<th>Nachname</th>
													<th>Vorname</th>
													<th>E-Mail</th>
													<th class="text-center">Status</th>
													<th class="text-center">Bearbeiten</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													foreach($managers as $key=>$val) {
														$id = $val['id'];
														$fun = "del('".$id."')";
														$active = $val['is_active']=="1"?"<div class='status aktiv'>AKTIV</div>":"<div class='status gesperrt'>GESPERRT</div>";
														if($val['is_active']=='0') {
															$activate = "<a href='#' data-toggle='tooltip' data-placement='top' data-activate='".$id."' title='entsperren' class='text-success activate' ><span class='fa fa-check-circle iconss' style='#73A839 !important;'></span></a>";
															$sperren = "";
														} else {
															//$activate = "<a href='#' title='Activate User CD' class='text-success disabled' ><span class='fa fa-building-o iconss'></span></a>";
															$activate = "";
															$sperren = "<a href='#' data-toggle='tooltip' data-placement='top' title='sperren' onClick=".$fun." class='text-danger' ><span class='fa fa-times-circle iconss'></span></a>";
														}
												
														$action = "<a href='#' title='bearbeiten' class='text-info edit' data-toggle='tooltip' data-placement='top' data-edit='".$id."' ><span class='far fa-edit iconss'></span></a>".$activate.$sperren;
												?>
													<tr>
														<td><?=$val['lname']?></td>
														<td><?=$val['fname']?></td>
														<td><?=$val['email']?></td>
														<td><?=$active?></td>
														<td><?=$action?></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- / .x_panel -->
						</div>
					</div>
					<!-- / div -->
					</div>
				</div>
				<!-- / .right_col -->
			</div>
			<!-- / .main_container -->
		</div>
		<!-- / .body -->
		<div id="addmanager" class="modal" role="dialog" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Lohnmanager hinzuf&uuml;gen</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<input type="hidden" name="id" id="id" />
							<div class="form-group">
								<label class="control-label">Vorname</label>
								<input type="text" name="fname" id="fname" class="form-control" required />
								<span class="error fname"></span>
							</div>
							<div class="form-group">
								<label class="control-label">Nachname</label>
								<input type="text" name="lname" id="lname" class="form-control" required />
								<span class="error lname"></span>
							</div>
							<div class="form-group">
								<label class="control-label">E-Mail</label>
								<input type="email" name="email" id="email" class="form-control" required />
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
						<button type="button" class="btn btn-primary" id="add">Lohnmanager hinzuf&uuml;gen</button>
					</div>
				</div>
			</div>
		</div>
		
		<div id="editmanager" class="modal fade editModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Lohnmanager bearbeiten</h4>
					</div>
					<div class="modal-body">
						<form role="form">
							<input type="hidden" name="id" id="eid" />
							<div class="form-group">
								<label class="control-label">Vorname</label>
								<input type="text" name="fname" id="efname" class="form-control" required />
								<span class="error fname"></span>
							</div>
							<div class="form-group">
								<label class="control-label">Nachname</label>
								<input type="text" name="lname" id="elname" class="form-control" required />
								<span class="error lname"></span>
							</div>
							<div class="form-group">
								<label class="control-label">E-Mail</label>
								<input type="email" name="email" id="eemail" class="form-control" required />
							</div>
							<div class="form-group">
								<label class="control-label">Passwort</label>
								<input type="text" name="pass" id="epass" class="form-control" />
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
						<button type="button" class="btn btn-primary" id="update">Speichern</button>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('includes/foot');?>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>

		<script>

			var url = "<?php echo base_url('admin/dashboard/ajax'); ?>";
			$(document).ready(function(){
				$('.tbl').DataTable({
					"pageLength" : 25,
					'columnDefs': [ {
					  'targets': [4],
					  'orderable': false
					}],
					"fnDrawCallback": function(oSettings) {
						var rowCount = this.fnSettings().fnRecordsDisplay();
						if(rowCount<=25){
							$('.dataTables_length').hide();
							$('.dataTables_paginate').hide();
						}
					}
				}); // datatables
			});
			
			$(document).on('click','#add',function(e) {
				var fname = $('#fname').val();
				var lname = $('#lname').val();
				var email = $('#email').val();
				if(fname=="") {
					toastr.error('Bitte den Vornamen eintragen.');
					return false;
				}
				if(lname=="") {
					toastr.error('Bitte den Nachnamen eintragen.');
					return false;
				}
				if(email=="") {
					toastr.error('Bitte die E-Mail-Adresse eintragen.');
					return false;
				}
				$(this).prop('disabled',true);
				$(this).html('Adding...');
				$.ajax({
					url:url,
					type:"POST",
					dataType:"JSON",
					data:{'req':'add_manager','fname':fname,'lname':lname,'email':email},
					success:function(res) {
						if(res=="1") {
							toastr.success('Lohnmanager erfolgreich hinzugefügt.');
							window.location.reload();
						} else {
							toastr.error(res);
						}
					}
				});
			});

			// edit modal
			$(document).on('click','.edit',function(e){
				var id = $(this).data('edit');
				$.ajax({
					url:url,
					type:"POST",
					dataType:"JSON",
					data:{'req':'get_manager','id':id},
					success:function(res) {
						$('#efname').val(res.fname);
						$('#elname').val(res.lname);
						$('#eemail').val(res.email);
						$('#epass').val(res.pass);
						$('#eid').val(res.id);
						$('.editModal').modal('show');
					}
				});
			});

			$(document).on('click','#update',function(e){
				var fname = $('#efname').val();
				var lname = $('#elname').val();
				var pass = $('#epass').val();
				var email = $('#eemail').val();
				var id = $('#eid').val();
				if(fname==""){
					$('.fname').html('Please enter first name');
					return false;
				}
				if(lname==""){
					$('.lname').html('Please enter last name');
					return false;
				}
				$(this).prop('disabled',true);
				$(this).html('Updating...');
				var frm = {'req':'process_edit_manager','fname':fname,'lname':lname,'pass':pass,'email':email,'id':id};
				$.ajax({
					url:url,
					type:"POST",
					dataType:"JSON",
					data:frm,
					success:function(res){
						if(res=="1") {
							$('#editModal').modal('hide');
							toastr.success('User updated successfully');
							window.location.reload();
						} else {
							toastr.error(res);
						}
					}
				});
			});
			
			$(document).on('click','.activate',function(e){
				var id = $(this).data('activate');
				if(id==""){
					toastr.error('There is some problem,refresh your page');
					return false;
				}
				$(this).prop('disabled',true);
				$(this).html('Activating...');
				var frm = {'req':'activate_manager','id':id};
				$.ajax({
					url:url,
					type:"POST",
					dataType:"JSON",
					data:frm,
					success:function(res){
						if(res=="1") {
							toastr.success('User activated successfully');
							window.location.reload();
						} else {
							toastr.error(res);
						}
					}
				});
			});

			function del(id)
			{
				swal({
				title: "Sind Sie sicher?",
				text: "Der Lohnmanager wird gesperrt!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ja, sperre den Lohnmanager!",
				customClass: "se_del",
				closeOnConfirm: true }, function(){
					$.ajax({
						url:url,
						type:"POST",
						dataType:"JSON",
						data:{'req':'delete_manager','id':id},
						success:function(res) {
							if(res=="1"){
								toastr.success('Lohnmanager erfolgreich gesperrt');
								window.location.reload();
							} else {
								toastr.error(res);
							}
						}
					});
				});
			}

			$(document).ready(function(){
			    $("#addmanager").on('shown.bs.modal', function(){
			        $(this).find('#fname').focus();
			    });
			});
		</script>
	</body>
</html>
