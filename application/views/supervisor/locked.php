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
   <style>
   .errror {color: red; font-size: 17px;}
   </style>
	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<?php $this->load->view('includes/header');?>
				<div class="right_col" role="main">
					        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12  maxi">

							<div class="x_panel">
									
								<div class="x_title">
									<h2>Checklisten <span class="text-rejected">gesperrt</span></h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a href="#" id="add-checklist" class="btn btn-success" style="color:#fff">+ Checkliste</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">
                <?php if($error = $this->session->flashdata('data')) {
                  $class = $this->session->flashdata('class');
                ?>
                  <div class="alert alert-dismissible <?=$class;?>" id="success-alert">
                    <button  type ="button" class="close" data-dismiss="alert">x</button>
                    <?php echo $error;?>
                  </div>
                <?php } ?>

                <div class="table-responsive">
                  <table class="table table-striped table-bordered tbl">
				  
                    <thead>
                      <tr>
												<th class="text-center">KTR</th>
                        <th class="text-center">Objekt</th>
                        <th class="text-center">Objektmanager</th>
                        <th class="text-center">Niederlassung</th>
                        <th class="text-center">Beginn</th>
                        <th class="text-center">Ende</th>
                        <th class="text-center">Kontrollart</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php  
					 if(isset($object)){
						
						 foreach($object as $objects){?>
					 
                    <tr>
											<td class="text-center"><?php

										    $ktr = $objects['ktr_number'];

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

	                  		echo $ktr_temp;
												
												?>
											</td>
                 			<td class="text-center"><?php echo $objects['object_name'];?></td>
											<td class="text-center">
												<?php 
													$res = $this->model->getData('objects','row_array',$args=['where'=>['ktr_number'=>$objects['ktr_number']]]);
													$res2 = $this->model->getData('users','row_array',$args=['where'=>['id'=>$res['created_by']]]);
													echo $res2['fname'] . " " . $res2['lname'];
												?>
											</td>
											<td class="text-center"><?php echo $objects['object_nl'];?></td>
				 							<td class="text-center"><?= $objects['begin_date'] ?></td>
						 					<td class="text-center"><?=$objects['end_date'] ?></td>
						 					<td class="text-center"><?php

						 						if ($objects['year']>0) {
						 							echo "<div class=\"avg avg_kontrolle quartal\">" .$objects['quarter'] . "Q/" . $objects['year'] . "</div>";
						 						}
						 						else if ($objects['re_check']>0) {
						 							?><div class="avg avg_kontrolle avg_red">ReCheck</div><?php
						 						}
						 						else {
						 							?><div class="avg avg_kontrolle aktiv">Individuell</div><?php
						 						}

						 						?>
						 					</td>
					
											<?php }}?>
                    </tbody>
                  </table>
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
		</div> <!-- / .body -->

<!-------model for add checklist----->
<div class="modal addChecklist" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Checkliste hinzufügen</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
    <label for="exampleFormControlSelect1">Objekt</label>
    <select class="form-control" id="chklist" name="chek">
	<?php
			foreach($objectss as $obj){?>
      <option value="<?=$obj['id']?>"><?=$obj['object_name']?></option>
	<?php }?>
    </select>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn-primary" id="addchk">Checkliste erstellen</button>
      </div>
    </div>
  </div>
</div>

		<?php $this->load->view('includes/foot');?>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
		<script>
		 var url = "<?php echo base_url('supervisor/Checklisten/ajax'); ?>";	

	    $(document).ready(function(){
				$(".tbl").DataTable({
					"order": [[ 0, "asc" ]],
					"fnDrawCallback": function(oSettings){
							var rowCount = this.fnSettings().fnRecordsDisplay();
							if(rowCount<=10){
								$('.dataTables_length').hide();
								$('.dataTables_paginate').hide();
							}
				 }
				});
	    });
 
	    $(document).on('click','#add-checklist',function(){
		   $('.addChecklist').modal('show');	   
	   	});

		   $(document).on('click','#addchk',function(e){
			   var id=$('#chklist').val();
			   $.ajax({
				   url:url,
				   type:"POST",
				   dataType:"JSON",
				   data:{'req':'add_checklist','id':id},
				   success:function(res){
					  if(res=="1") {
		            $('.addChecklist').modal('hide');
		            toastr.success('Checkliste erfolgreich hinzugef?gt.');
		            //window.location.reload();
		        		url='https://zehm-vs.org/supervisor/checklisten/open';
								window.location.href = url;
		          } else {
		            toastr.error('Error in add Checklist, try agian');
		          } 
				   }
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

			$(document).ready(function(){
			    $("#modal-checklist").on('shown.bs.modal', function(){
			        $(this).find('#text').focus();
			    });
			});
		</script>
	</body>
</html>
