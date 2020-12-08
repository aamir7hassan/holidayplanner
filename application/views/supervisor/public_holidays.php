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
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table class="table table-striped" id="tbl">
													<thead>
														<tr>
															<th class="text-center" colspan="<?=count($states)?>">Bundesländer für Ferien- & Feiertagsdarstellung im Urlaubsplaner</th>
														</tr>
													</thead>
													<tbody>
														<tr>
														<?php
															$stateids = explode(',',$sv_holidays['state_ids']);
															foreach($states as $state) {
																$k = array_search($state['id'],$stateids);
																if(is_numeric($k))  {
																	$checked = "checked";
																	$disabled = "";
																} else {
																	$checked = "";
																	//$disabled = "disabled";
																	$disabled="";
																}
															$hid = $sv_holidays['id'];
														?>
														
															<td title="<?=$state['name']?>">
															<div class="input"><input type="checkbox" <?=$checked." ".$disabled?> value="<?=$state['id']?>" name="ck<?=$hid?>[]" data-hid="<?=$hid?>" class="cb"/></div>
															<div class="chks"><?=$state['code']?></div></td>
															
														<?php } ?>
														</tr>
													</tbody>
												</table>
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

		<?php $this->load->view('includes/foot');?>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
		<script>

			$(".datepicker").datepicker();
			var url = "<?php echo base_url('supervisor/dashboard/ajax'); ?>";
			

			$(document).on('click','.cb',function(){
				var hid = $(this).data('hid');
				if ($(this).is(":checked")) { 
					var checked = "1"; 
				} else { 
					var checked = "0"; 
				}
				var arr = $("input[name='ck"+hid+"[]']:checked").map(function() {
					return $(this).val();
				}).get();
				//toastr.success('Eintrag wird aktualisiert...');
				$.ajax({
					url:url,
					type:"POST", 
					dataType:"JSON",
					data:{'req':'update_holiday','id':hid,'status':checked,'ids':arr},
					success:function(res) {
						if(res=="1"){
							toastr.success('Änderung wurde gespeichert.');
						} else {
							toastr.error(res);
						}
					}
				});
			});

		
		</script>
	</body>
	<!-- / .body -->
</html>
