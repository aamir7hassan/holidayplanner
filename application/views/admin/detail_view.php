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

		if ($item['id']!='') {	//Checkliste vorhanden
			if (get_userId()!=$item['sv_id'] && $this->session->userdata('role')!='admin') {
				header('Location: ../open');	//Checkliste SupervisorId ist nicht identisch UserId => Weiterleitung zu offenen Checklisten, damit Bereichsleiter nicht andere Checklisten Details einsehen können
			}
		}
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
									<h2>Checklisten</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a href="#" class="btn btn-success" onClick="window.history.back()" style="color:#fff">Zur&uuml;ck</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="row">
										<div class="col-md-12">
											<div class="tale-responsive">
												<table class="table details tbl">
													<tr>
														<th>Objekt</th>
														<td><?=$item['object_name']?></td>
													</tr>
													<tr>
														<th>Kostenträger</th>
														<td><?

	                        		$ktr = $item['ktr_number'];
	                        		
	                        		$n=0; $ktr_temp = ""; $space = "";
															for ($i = 0; $i < strlen($ktr); $i++) {
															    if ($n==2) {
															    	$space = " ";
															    	$n=0;
															    }
															    else {$space = "";}
															     $ktr_temp =  $ktr_temp . $space . substr($ktr, $i, 1);
															    $n++;
															}

	                        		echo  $ktr_temp;															
														?></td>
													</tr>
													<tr>
														<th>Niederlassung</th>
														<td><?=$item['object_nl']?></td>
													</tr>
													<tr>
														<th>Bereichsleiter</th>
														<td><?=$item['object_supervisor']?></td>
													</tr>
													<tr>
														<th>Mitarbeiter</th>
														<td><?=$item['staff']?></td>
													</tr>
													<tr>
														<th>Notizen</th>
														<td><?=$item['notes']?></td>
													</tr>
													<tr>
														<th>Kontrollart</th>
														<td>
															<?php
										 						if ($item['year']>0) {
										 							echo "<div class=\"avg avg_kontrolle quartal\">" .$item['quarter'] . "Q/" . $item['year'] . "</div>";
										 						}
										 						else if ($item['re_check']>0) {
										 						 	echo '<a href="' . $item['re_check'] . '" class="avg avg_kontrolle avg_red" data-toggle="tooltip" title="ReCheck von #' . $item['re_check'] . '">ReCheck #' . $item['re_check'] . '</a>';
										 						}
										 						else if ($item['id']<>'') {
										 							?><div class="avg avg_kontrolle aktiv">Individuell</div><?php
										 						}

										 						$res = $this->model->getData('cl_lists','row_array',$args=['where'=>['re_check'=>$item['id']]]);
									 						 	if($res) { //nur bei einem Ergebnis eines ReChecks
										 						 	$tmp_re_check_link = '<a href="' . $res['id'] . '" class="avg avg_kontrolle avg_red" data-toggle="tooltip" title="erzeugter ReCheck" style="margin-left:.5em;"><i class="fas fa-caret-right"></i> ReCheck #' . $res['id'] . '</a>';
										 						 	echo $tmp_re_check_link;
									 						 	}
									 						 ?>
														</td>
													</tr>																										
													<tr style="border-bottom: 2px solid #515356;">
														<th>Kontrolldatum</th>
														<td><? 
															if ($item['check_date']<>'') {
																echo date_format(date_create($item['check_date']), 'd.m.Y');
															}
															?>
														</td>
													</tr>
													<?php 
													$sum=0;
													$c=0;
													foreach($des as $d){
														$rating=$item['rating'];
														$rat=explode(';',$rating);
														$count=count($rat);
														for($i=0; $i<$count; $i++)
														{
														  $rat1=explode((","),$rat[$i]) ;
                              $cat=$d['cat'];
                              $rang=$d['rang'];
														  if($cat==$rat1[0] && $rang==$rat1[1]) {
															  $c++;
															  $rat2=$rat1[2];
															  $sum=$sum+$rat2;

																$res = $this->model->getData('cl_desc','row_array',$args=['where'=>['cat'=>$cat,'rang'=>0]]);
															  ?>
													<tr>
														<th>
															<?
																echo "[" . $res['description'] . "] " . $d['description']
															?></th>
														<td><?php
																$rating_color = "";
                				
				                				if ($rat2>=5) {
				                					$rating_color = " bg-rejected";
				                				}
				                				else if ($rat2>=3) {
				                					$rating_color = " bg-open";
				                				}
				                				else {
				                					$rating_color = " bg-approved";
				                				}

				                				echo "<div class=\"avg avg_kontrolle cl_dv_rating" . $rating_color . "\">". $rat2 . "</div>";
															?>
														</td>
													</tr>
														 <?php }
															
														}
													}

																$durchschnitt="";
																if ($c>0) {
																	$durchschnitt_th = "Durchschnitt";
																	$avg = number_format($sum/$c, 2);

					                				if ($avg>=5) {
					                					$rating_color = " bg-rejected";
					                				}
					                				else if ($avg>=3) {
					                					$rating_color = " bg-open";
					                				}
					                				else {
					                					$rating_color = " bg-approved";
					                				}

																	$durchschnitt = "<div class=\"avg avg_kontrolle" . $rating_color . "\">". $avg . "</div>";;
																}
																else {
																	$durchschnitt_th = "Hinweis";
																	if ($item['id']<>'') {
																		$durchschnitt = "<div class=\"text-danger\">Die Checkliste wurde noch nicht ausgefüllt!</div>";
																	}
																	else {
																		$durchschnitt = "<div class=\"text-danger\">Die Checkliste existiert nicht!</div>";
																	}

																}
														?>
													</tr>
													<tr style="border-top: 2px solid #515356;">
														<th><? echo $durchschnitt_th; ?></th>
														<td><? echo $durchschnitt; ?></td>
													</tr>
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

	</body>
</html>
