	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/nprogress.css');
		echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
		echo link_tag('assets/datatables/jquery.dataTables.min.css');
		echo link_tag('assets/css/jqvmap.min.css');
		echo link_tag('assets/css/toastr.min.css');
		echo link_tag('assets/css/sweetalert.css');
		echo link_tag('assets/css/custom.min.css');
		echo link_tag('assets/css/style.css');

	?>

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
									<h2>Antrag auf Mehrarbeit</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a href="#" class="btn btn-success" onClick="window.history.back()" style="color:#fff">Zur&uuml;ck</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="row">
										<div class="col-md-12">
											<div class="tale-responsive">
												<table class="table details">
													<tr>
														<th>Objekt</th>
														<td><?=$item['object']?></td>
													</tr>
													<tr>
														<th>Mitarbeiter</th>
														<td><?=$item['employee_name']?></td>
													</tr>
													<tr>
														<th>vom</th>
														<td><?=$item['time_from']?></td>
													</tr>
													<tr>
														<th>bis</th>
														<td><?=$item['time_untill']?></td>
													</tr>
													<tr>
														<th>Stunden/Tag</th>
														<td><?=$item['no_of_hours']?></td>
													</tr>
													<tr>
														<th>Begr&uuml;ndung</th>
														<td><?=$item['justification']?></td>
													</tr>
													<tr>
														<th>Ausgleich</th>
														<td>
															<?php 
																if($item['check_box']=="0") {
																	echo "Nein";
																} elseif($item['check_box']=="1") {
																	echo "Ja";
																} else {
																	echo "NILL";
																}
															?>
														</td>
													</tr>
													<tr>
														<th>Ort, Datum</th>
														<td><?=$item['place']?>, <?=date('d.m.Y H:i',strtotime($item['date_created']))?></td>
													</tr>
													<tr>
														<th>Antragsteller</th>
														<td><?=$item['applicants_name']?></td>
													</tr>
													<?php 
														if($item['manager_check']=="0") {
													?>
													<tr>
														<th colspan="2"><a href="#" class="btn btn-success mark" data-id="<?=$item['id']?>">Als &uuml;berpr&uuml;ft markieren</a></th>
													</tr>
													<?php } ?>
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
		<!-- / .body -->
		<?php $this->load->view('includes/foot');?>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
		<script>
			$(document).on('click','.mark',function(){
				var id=$(this).data('id');
				swal({
				title: "Sind Sie sicher?",
				text: "Der Antrag wird als überprüft markiert!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Markiere den Antrag als überprüft!",
				closeOnConfirm: true }, function(){
				$.ajax({
						url:'<?=base_url("manager/dashboard/ajax")?>',
						type:"POST",
						dataType:"JSON",
						data:{'req':'mark_checked','id':id},
						success:function(res) {
							if(res=="1"){
								toastr.success('Antrag erfolgreich überprüft!');
								
								//window.location.reload();
								url='https://zehm-vs.org/manager/antrag-auf-mehrarbeit/unchecked';
								window.location.href = url;
							} else {
								toastr.error(res);
							}
						}
					});
				});
			}); 
			
			<?php 
				if($this->session->has_userdata('data')) {
					$msg = $this->session->userdata('data');
					$class= $this->session->userdata('class');
			?>
				toastr.<?=$class?>('<?=$msg?>');
			<?php
				}
			?>
		</script>
	</body>
</html>
