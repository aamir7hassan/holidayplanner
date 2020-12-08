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
									<h2>Checklisten</h2>
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
                        <th class="text-center">Niederlassung</th>
                        <th class="text-center">Objektleiter </th>
                        <th class="text-center">Beginn</th>
                        <th class="text-center">Ende</th>
                        <th class="text-center">Bearbeiten</th>
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
											<td class="text-center"><?php echo $objects['object_nl'];?></td>
				 							<td class="text-center "><?php echo $objects['object_supervisor'];?></td>

				 <td class="text-center"><?=$objects['begin_date'] ?></td>
						 <td class="text-center"><?= $objects['end_date'] ?></td>
               <?php if($objects['locked']==1 && $objects['checked']==0){?>
                        <td class="text-center text-danger">Locked</td>
					<?php
					}else if($objects['locked']==1 && $objects['checked']==1){?>	
                      <td class="text-center text-success"><a href="<?=base_url('admin/detail-view/'.$objects['id'])?>" data-toggle='tooltip' class="text-success" title="Details"><span class="fa fa-info-circle iconss"></a>checked(but locked)</td>
						
					  <?php
					}else if($objects['locked']==0 && $objects['checked']==1){?>	
                      <td class="text-center text-success"><a href="<?=base_url('admin/detail-view/'.$objects['id'])?>" data-toggle='tooltip' class="text-success" title="Details"><span class="fa fa-info-circle iconss"></a>unlocked(but checked)</td>
					  <?php
					}else if($objects['locked']==0 && $objects['checked']==0){?>	
                      <td class="text-center text-danger">unlocked(but unchecked)</td>
					<?php }}}?>
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
		</div>
		<!-- / .body -->
		  <!-- / .body -->
  <div class="modal fade editModal" tabindex="-1" role="dialog" aria-hidden="true"  tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">Objekt bearbeiten</h4>
        </div>
        <div class="modal-body">
		<form role="form" id="frm">
            <input type="hidden" name="id" id="id" />
			    <div class="table-responsive">
                  <table class="table table-striped table-bordered tbl">
				 
                    <thead>
					
                      <tr>
						<th class=""></th>
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                        
                      </tr>
                    </thead>
                    <tbody>
					<span class="message text_error errror text-center"></span>
					 <div class="form-group">
    <label for="exampleInputEmail1">Mitarbeiter</label>
    <input type="text" class="form-control" id="text" name="text"  placeholder="Enter Text" required>
	<span class="errror text_error"></span>
  </div>
					<?php foreach($des as $data){
					 if(($data['rang']==0) &&($data['cat']==1)){ ?>
					
					<tr>
					 <td style="color:black;"><?= $data['description']?></td>
                      <td colspan="5"></td>
					</tr>
					<?php
					}
					if(($data['cat']==1)&&($data['rang']!=0)){
						?>
						 <tr>
					<td><?=$data['description']?></td>
				  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]"value="1"> </label></td>
	  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="2"></label></td>
	<td> <label class=""><input type="radio"name="radio[<?=$data["id"]?>]" value="3">  </label></td>
	 <td> <label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="4"> </label></td>
	 <td> <label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="5"> </label></td>
					</tr>
					<?php
					}
					 if(($data['rang']==0) &&($data['cat']==2)){ ?>
					
					<tr>
					 <td style="color:black;"><?= $data['description']?></td>
                      <td colspan="5"></td>
					</tr>
					<?php
					}
					if(($data['cat']==2)&&($data['rang']!=0)){
						?>
						 <tr>
					<td><?=$data['description']?></td>
				  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="1"> </label></td>
	  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="2"></label></td>
	<td> <label class=""><input type="radio"name="radio[<?=$data["id"]?>]" value="3">  </label></td>
	 <td> <label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="4"> </label></td>
	 <td> <label class=""> <input type="radio"name="radio[<?=$data["id"]?>]"value="5"> </label></td>
					</tr>
					<?php
					}
					 if(($data['rang']==0) &&($data['cat']==3)){ ?>
					
					<tr>
					 <td style="color:black;"><?= $data['description']?></td>
                      <td colspan="5"></td>
					</tr>
					<?php
					}
					if(($data['cat']==3)&&($data['rang']!=0)){
						?>
						 <tr>
					<td><?=$data['description']?></td>
				  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="1"> </label></td>
	  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="2"></label></td>
	<td> <label class=""><input type="radio"name="radio[<?=$data["id"]?>]" value="3">  </label></td>
	 <td> <label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="4"> </label></td>
	 <td> <label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="5"> </label></td>
					</tr>
					<?php
					}
				 if(($data['rang']==0) &&($data['cat']==4)){ ?>
					
					<tr>
					 <td style="color:black;"><?= $data['description']?></td>
                      <td colspan="5"></td>
					</tr>
					<?php
					}
					if(($data['cat']==4)&&($data['rang']!=0)){
						?>
						 <tr>
					<td><?=$data['description']?></td>
				  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="1"> </label></td>
	  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="2"></label></td>
	<td> <label class=""><input type="radio"name="radio[<?=$data["id"]?>]" value="3">  </label></td>
	 <td> <label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="4"> </label></td>
	 <td> <label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="5"> </label></td>
					</tr>
					<?php
					}
					 if(($data['rang']==0) &&($data['cat']==5)){ ?>
					
					<tr>
					 <td style="color:black;"><?= $data['description']?></td>
                      <td colspan="5"></td>
					</tr>
					<?php
					}
					if(($data['cat']==5)&&($data['rang']!=0)){
						?>
						 <tr>
					<td><?=$data['description']?></td>
				  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="1"> </label></td>
	  <td> <label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="2"></label></td>
	<td> <label class=""><input type="radio"name="radio[<?=$data["id"]?>]" </label></td>
	 <td> <label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="4"> </label></td>
	 <td> <label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="5"> </label></td>
					</tr>
					<?php
					}
					}
					?>
                   
					
                    </tbody>
                  </table>
                </div>		
             <div class="form-group">
    <label for="exampleFormControlTextarea1"></label>
    <textarea class="form-control" name="note" id="note" rows="4" placeholder="Notes"></textarea>
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
<!---end edit model--->
		<?php $this->load->view('includes/foot');?>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
		<script>
		 var url = "<?php echo base_url('admin/checklists/ajax'); ?>";	
    $(document).ready(function(){
			$(".tbl").DataTable({
				'columnDefs': [ {
					'targets': [6],
					'orderable': false,
				}],
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

	  $(document).on('click','.edit',function(e) {
      var id = $(this).data('edit');
	  $('#id').val(id);
	   $.ajax({
        url:url,
        type:"POST",
        dataType:"JSON",
        data:{'req':'checked_data','id':id},
        success:function(res){
			if(res=='0')
			{
				$('.editModal').modal('show');
			}
          else{
			 var length=res.data.length;
			 for(i=0; i<length; i++)
			 {   
		         if(res.data[i]['object_id']==id)
				 {
				   $('.message').html('Tabel is already checked!');
		  $('#update').prop('disabled',true).html('Disabled');
		   $("input[type=radio]").attr('disabled', true);
		  $("input[type=text]").attr('disabled', true);
		  $('.editModal').modal('show');
				 }
				 else
				 {
					  $('.message').html(''); 
		  $("input[type=radio]").attr('disabled', false);
		  $("input[type=text]").attr('disabled', false);
		  $('#update').prop('disabled',false).html('Speichern');
		   $('.editModal').modal('show');
				 }
			 }
            
          }
        }
      });
   
    });
	 $(document).on('click','#update',function(e) {
		var val=$('#text').val();
		if(val=="")
		{
		 $('.text_error').html('required!');	
		}
		else{
		$('.text_error').html('');
		}
		   var data = $("#frm").serialize()+ '&req=' + 'checklist';
      $.ajax({
        url:url,
        type:"POST",
        dataType:"JSON",
        data:data,
        success:function(res){
          if(res=="1") {
            $('#editModal').modal('hide');
            toastr.success('Objekt erfolgreich aktualisiert.');
            window.location.reload();
          } else {
            toastr.error('Error in updating Objekt, try agian');
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
		</script>
	</body>
</html>
