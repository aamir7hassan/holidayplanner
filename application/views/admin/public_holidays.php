	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/nprogress.css');
		echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
		echo link_tag('assets/css/sweetalert.css');
		echo link_tag('assets/css/toastr.min.css');
		echo link_tag('assets/css/bootstrap-datepicker.min.css');
		echo link_tag('assets/css/custom.min.css');
		echo link_tag('assets/css/style.css');

	?>
	<style>
		.box {
			height:20px;width:20px;
		}
		.chks {
			display: inline-block;
			vertical-align: text-bottom;
			padding-right: 13px;
		}
		.input {
			display: inline-block;
		}
	</style>

	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<?php $this->load->view('includes/header');?>
				<div class="right_col" role="main">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Ferien & Feiertage</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a href="" class="btn btn-success" data-toggle="modal" data-target="#addModal" style="color:#fff">+ Ferien/Feiertag</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table class="table table-striped" id="tbl">
													<thead>
														<tr>
															<th class="text-center">Zeitraum</th>
															<th class="text-center">Tage</th>
															<th class="text-center" colspan="<?=count($states)?>">Bundesländer für Ferien- & Feiertagsdarstellung im Urlaubsplaner</th>
															<th class="text-center">Bearbeiten</th>
														</tr>
													</thead>
													<tbody>
														<?php
															foreach($items as $k=>$v) {
																$id = $v['id'];
																$date1 = strtotime($v['start_date']);
																$date2 = strtotime($v['end_date']);
																$datediff = $date2 - $date1;
																$no_of_days =  floor($datediff / (60 * 60 * 24)) + 1;
																$exp = explode(',',$v['state_ids']);
																
														?>
														<tr>
															<td><?=date('d.m.Y',$date1)." - ".date('d.m.Y',$date2)?></td>
															<td class="text-center"><?=$no_of_days?></td>
															<td colspan="<?=count($states)?>">
																<table>
																	<tr>
																	<td>
																		<?php foreach($states as $state) { 
																		$k = array_search($state['id'],$exp);
																		if(is_numeric($k)) $checked = "checked";
																		else  $checked = "";
																	?>
																		<td title="<?=$state['name']?>">
																		<div class="input"><input type="checkbox" disabled <?=$checked;?> /></div>
																		<div class="chks"><?=$state['code']?></div></td>
																		<?php } ?>
																	</td>
																	</tr>
																</table>
															</td>
															<td class="text-center">
																<a href="#" data-toggle="tooltip" data-edit="<?php echo $id ?>" title="Eintrag bearbeiten" class="edit" ><span class="far fa-edit iconss"></span></a>
																<a href="#" data-toggle="tooltip" data-del="<?php echo $id ?>" title="Eintrag löschen" class="del" ><span class="fa fa-trash-alt text-danger iconss"></span></a>
															</td>
														</tr>
														<?php } ?>
													</tbody>
												</td>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / .x_panel -->
						</div>
					</div>
				</div>
				<!-- / .right_col -->
			</div>
			<!-- / .main_container -->
		</div>

		<!-- Modal -->
		<div id="addModal" class="modal fade animated shake" role="dialog" tabindex='-1'>
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Ferien- / Feiertag hinzufügen</h4>
		      </div>
		      <div class="modal-body">
		        <form role="form">
							<div class="form-group">
								<label class="control-label">Startdatum</label>
								<input type="text" name="sdate" id="sdate" class="form-control datepicker start" required />
								<p class="name error"></p>
							</div>
							<div class="form-group">
								<label class="control-label">Enddatum</label>
								<input type="text" name="edate" id="edate" class="form-control datepicker end" required />
								<p class="name error"></p>
							</div>
							<div class="form-group">
								<label class="control-label">Auswahl Bundesland</label>
								<div class="input" style="margin-left:.5em;"><input type="checkbox" name="" id="checkall" /></div>
								<div class="chks">Alle auswählen</div><br>
								<?php 
									foreach($states as $s) {
								?>
								<div class="input"><input type="checkbox" name="chk[]"  class="sel" value="<?=$s['id']?>"/></div>
								<div class="chks"><?=$s['code']?></div>
								<?php } ?>
							</div>
						</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
				<button type="button" class="btn btn-primary" id="save">Speichern</button>
		      </div>
		    </div>
		  </div>
		</div>
		<div id="editModal" class="modal fade" role="dialog" tabindex='-1'>
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Ferien- & Feiertage bearbeiten</h4>
		      </div>
		      <div class="modal-body">
		        <form role="form">
			  				 <input type="hidden" name="id" id="edit_id" />
							<div class="form-group">
								<label class="control-label">Startdatum</label>
								<input type="text" name="sdate" id="edit_sdate" class="form-control datepicker start" required />
								<p class="name error"></p>
							</div>
							<div class="form-group">
								<label class="control-label">Enddatum</label>
								<input type="text" name="edate" id="edit_edate" class="form-control datepicker end" required />
								<p class="name error"></p>
							</div>
							<div class="form-group">
								<label class="control-label">Auswahl Bundesland</label>
								<div class="input" style="margin-left:.5em;"><input type="checkbox" name="" id="checkall_edit" /></div>
								<div class="chks">Alle auswählen</div><br>
								<?php 
									foreach($states as $s) {
								?>
								<div class="input"><input type="checkbox" name="edit_chk[]"  class="sel_edit" value="<?=$s['id']?>"/></div>
								<div class="chks"><?=$s['code']?></div>
								<?php } ?>
							</div>
						</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
						 <button type="button" data-id="" class="btn btn-primary" id="edit_save">Speichern</button>
		      </div>
		    </div>
		  </div>
		</div>
		<?php $this->load->view('includes/foot');?>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
		<script>

			// $(".datepicker").datepicker({
				// weekStart: 1,
				// autoclose:true
			// });
			$('.start').datepicker({
				autoclose:true,
				weekStart: 1,
			}).on('changeDate',function(e){
				$('.end').datepicker('setStartDate',e.date)
			});

			$('.end').datepicker({
				autoclose:true,
				weekStart: 1,
			}).on('changeDate',function(e){
				$('.start').datepicker('setEndDate',e.date)
			});

			var url = "<?php echo base_url('admin/dashboard/ajax'); ?>";
			$('#checkall').on('click',function(){
				$('input:checkbox.sel').not(this).prop('checked', this.checked);
			});
			$('#checkall_edit').on('click',function(){
				$('input:checkbox.sel_edit').not(this).prop('checked', this.checked);
			});
			

			$(document).on('click','#save',function() {
				var start = $('#sdate').val();
				var end = $('#edate').val();
				var arr = $("input[name='chk[]']:checked").map(function() {
					return $(this).val();
				}).get();
				if(start==""){
					toastr.error('Please select start date');
					return false;
				}
				if(end==""){
					toastr.error('Please select end date');
					return false;
				}
				if(arr.length<=0) {
					toastr.error('Please select atleast one state');
					return false;
				}
				$(this).prop('disabled',true);
				$(this).html('Saving...');
				var that = $(this);
				$.ajax({
					url : url,
					type : "POST",
					dataType : "JSON",
					data : {'req':'add_publicholiday','start':start,'end':end,'states':arr},
					success:function(res){
						if(res=="1") {
							$('#addModal').modal('hide');
							that.prop('disabled',false).html('Save');
							toastr.success('Category added successfully');
							window.location.reload();
						} else {
							toastr.error(res);
						}
					}
				});
			});
			function format_date(date){
				const d = new Date(date)
				const dtf = new Intl.DateTimeFormat('en', { year: 'numeric', month: '2-digit', day: '2-digit' }) 
				const [{ value: mo },,{ value: da },,{ value: ye }] = dtf.formatToParts(d);
				return `${mo}/${da}/${ye}`;
			}
			// for edit Modal
			$(document).on('click','.edit',function(){
				var id = $(this).data('edit');
				$.ajax({
					url:url,
					type:"POST",
					dataType:"JSON",
					data:{'req':'get_public_holidays','id':id},
					success:function(res) {
						if(res==0 || res=="0"){
							toastr.error('Invalid category id,try again');
						} else {
							$('#edit_id').val(res.id);
							$('#edit_sdate').val(format_date(res.start_date));
							$('#edit_edate').val(format_date(res.end_date));
							var arr=res.state_ids.split(",");
							$('input:checkbox.sel_edit').each(function(i,v){
								v.checked=false;
							});
							$('input:checkbox.sel_edit').each(function(i,v){
								for(i=0;i<arr.length;i++){
									if(parseInt(v.value)==parseInt(arr[i])){
										v.checked=true;
									}
								}
							});
							$('#editModal').modal('show');
						}
					}
				});
			});

			// save edited model
			$(document).on('click','#edit_save',function(){
				var id=$("#edit_id").val();
				var start = $('#edit_sdate').val();
				var end = $('#edit_edate').val();
				var arr = $("input[name='edit_chk[]']:checked").map(function() {
					return $(this).val();
				}).get();
				if(start==""){
					toastr.error('Please select start date');
					return false;
				}
				if(end==""){
					toastr.error('Please select end date');
					return false;
				}
				
				$(this).prop('disabled',true);
				$(this).html('Saving...');
				var that = $(this);
				$.ajax({
					url : url,
					type : "POST",
					dataType : "JSON",
					data : {'req':'update_publicholiday','start':start,'end':end,'states':arr,'id':id},
					success:function(res){
						if(res=="1") {
							$('#editModal').modal('hide');
							that.prop('disabled',false).html('Save');
							toastr.success('Category updated successfully');
							window.location.reload();
						} else {
							toastr.error(res);
						}
					}
				});
			});

			$(document).on('click','.del',function() {
				var id = $(this).data('del');
				var str = '&Ouml;';
				swal({
					title: "Sind Sie sicher?",
					text: "Der Eintrag wird unwiederbringlich gelöscht!",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Ja, lösche den Eintrag!",
					closeOnConfirm: true }, function(){
					$.ajax({
						url:url,
						type:"POST",
						dataType:"JSON",
						data:{'req':'delete_public_holiday','id':id},
						success:function(res) {
							if(res=="1"){
								toastr.success('Item deleted successfully');
								window.location.reload();
							} else {
								toastr.error(res);
							}
						}
					});
				});
			});
		</script>
	</body>
	<!-- / .body -->
</html>
