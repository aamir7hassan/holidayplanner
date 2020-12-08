	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/nprogress.css');
		echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
		echo link_tag('assets/css/sweetalert.css');
		echo link_tag('assets/css/toastr.min.css');
		echo link_tag('assets/css/bootstrap-colorpicker.min.css');
		echo link_tag('assets/css/custom.min.css');
		echo link_tag('assets/css/style.css');

	?>
	<style>
		.box {
			height:20px;width:20px;
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
									<h2>Kategorien*</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a href="" class="btn btn-success" data-toggle="modal" data-target="#addModal" style="color:#fff">+ Kategorie</a></li>
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
															<th>ID</th>
															<th>Bezeichnung</th>
															<th class="text-center">Farbe</th>
															<th class="text-center">Bearbeiten</th>
														</tr>
													</thead>
													<tbody>
														<?php
															foreach($items as $k=>$v) {
																$id = $v['id'];
														?>
														<tr>
															<td><?php echo $v['order']; ?></td>
															<td><?php echo $v['name']; ?></td>
															<td><center><p class="box" style="background-color:<?php echo $v['color'];?>"></p></center></td>

															<td class="text-center">
																<a href="#" data-toggle="tooltip" data-edit="<?php echo $id ?>" title="Kategorie bearbeiten" class="edit" ><span class="far fa-edit iconss"></span></a><?php /*<a href="#" data-toggle="tooltip" data-del="<?php echo $id ?>" title="Kategorie löschen" class="del" ><span class="fa fa-trasha-alt text-danger iconss"></span></a>*/?>
															</td>
														</tr>
														<?php } ?>
													</tbody>
												</table>

												<div style="margin: 40px 0 20px 0;">*Farbe und Kategorien sind unternehmensweit einheitlich</div>
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
		<div id="addModal" class="modal fade animated shake" role="dialog" tabindex="-1">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Kategorie hinzuf&uuml;gen</h4>
		      </div>
		      <div class="modal-body">
		        <form role="form">
							<div class="form-group">
								<label class="control-label">Bezeichnung der Kategorie</label>
								<input type="text" name="name" id="name" class="form-control" required />
								<p class="name error"></p>
							</div>
							<div class="input-group picker colorpicker-element">
                <input type="text" value="rgb(224, 26, 181)" class="form-control" name="color" id="color">
                <span class="input-group-addon"><i style="background-color: rgb(224, 26, 181);"></i></span>
              </div>
							<div class="form-group">
								<label class="control-label">ID</label>
								<input type="number" name="order" id="order" class="form-control" required />
								<p class="order error"></p>
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
		<div id="editModal" class="modal fade" role="dialog" tabindex="-1">
		  <div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Kategorie bearbeiten</h4>
		      </div>
		      <div class="modal-body">
		        <form role="form">
							<input type="hidden" id="cid" value="" />
							<div class="form-group">
								<label class="control-label">Bezeichnung der Kategorie</label>
								<input type="text" name="ename" id="ename" class="form-control" required />
								<p class="ename error"></p>
							</div>
							<div class="input-group picker colorpicker-element">
                <input type="text" value="" class="form-control" name="ecolor" id="ecolor">
                <span class="input-group-addon"><i id="eedit" ></i></span>
              </div>
							<div class="form-group">
								<label class="control-label">ID</label>
								<input type="number" name="eorder" id="eorder" class="form-control" required />
								<p class="eorder error"></p>
							</div>
						</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
						 <button type="button" class="btn btn-primary" id="esave">Speichern</button>
		      </div>
		    </div>
		  </div>
		</div>
		<?php $this->load->view('includes/foot');?>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-colorpicker.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
		<script>

			$(".picker").colorpicker();
			var url = "<?php echo base_url('admin/categories/ajax'); ?>";

			$(document).on('click','#save',function() {
				var name = $('#name').val();
				var color = $('#color').val();
				var order = $('#order').val();

				if(name==""){
					$('.name').html('Please select category name');
					return false;
				}
				if(order=="") {
					$('.order').html('Please enter order number');
					return false;
				}
				$(this).prop('disabled',true);
				$(this).html('Saving...');
				$.ajax({
					url : url,
					type : "POST",
					dataType : "JSON",
					data : {'req':'add_category','name':name,'color':color,'order':order},
					success:function(res){
						if(res=="1"){
							$('#addModal').modal('hide');
							toastr.success('Category added successfully');
							window.location.reload();
						} else {
							toastr.error(res);
						}
					}
				});
			});

			// for edit Modal
			$(document).on('click','.edit',function(){
				var id = $(this).data('edit');
				$.ajax({
					url:url,
					type:"POST",
					dataType:"JSON",
					data:{'req':'get_category','id':id},
					success:function(res) {
						if(res=="0"){
							toastr.error('Invalid category id,try again');
						} else {
							$('#cid').val(res.id);
							$('#ename').val(res.name);
							$('#ecolor').val(res.color);
							$('#eedit').css('background-color',res.color);
							$('#eorder').val(res.order);
							$('#editModal').modal('show');
						}
					}
				});
			});

			// save edited model
			$(document).on('click','#esave',function(){
				var id = $('#cid').val();
				var name = $('#ename').val();
				var color = $('#ecolor').val();
				var order = $('#eorder').val();
				if(name==""){
					$('.ename').html('Please select category name');
					return false;
				}
				if(order=="") {
					$('.eorder').html('Please enter order number');
					return false;
				}
				$(this).prop('disabled',true);
				$(this).html('Updating...');
				$.ajax({
					url:url,
					type:"POST",
					dataType:"JSON",
					data:{'req':'save_edited_cat','name':name,'color':color,'order':order,'id':id},
					success:function(res){
						if(res=="1") {
							$('#editModal').modal('hide');
							toastr.success('Category edited successfully');
							window.location.reload();
						} else {
							toastr.error(res);
						}
					}
				});
			});

			$(document).on('click','.del',function() {
				var id = $(this).data('del');
				swal({
            title:"Sind Sie sicher?",
            text: "Die Kategorie wird unwiederbringlich gelöscht!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ja, lösche die Kategorie!",
            closeOnConfirm: true }, function(){
            $.ajax({
							url:url,
							type:"POST",
							dataType:"JSON",
							data:{'req':'delete_category','id':id},
							success:function(res) {
								if(res=="1"){
									toastr.success('Category deleted successfully');
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
