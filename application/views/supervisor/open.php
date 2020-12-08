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
		#objektname {color:#515356 !important;display:inline;}
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
									<h2>Checklisten <span class="text-open">offen</span></h2>
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
												<th class="text-center">ID</th>
												<th class="text-center">KTR</th>
                        <th class="text-center">Objekt</th>
                        <th class="text-center">Objektmanager</th>
                        <th class="text-center">Niederlassung</th>
                        <th class="text-center">Beginn</th>
                        <th class="text-center">Ende</th>
                        <th class="text-center">Kontrollart</th>
                        <th class="text-center">Bearbeiten</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php  
					 if(isset($object)){
						
						 foreach($object as $objects){?>
					 
                    <tr>
											<td class="text-center"><?php echo $objects['id']; ?></td>
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
													echo '<a href="./detail-view/' . $objects['re_check'] . '" class="avg avg_kontrolle avg_red" data-toggle="tooltip" title="ReCheck von #' . $objects['re_check'] . '">ReCheck #' . $objects['re_check'] . '</a>';
						 						}
						 						else {
						 							?><div class="avg avg_kontrolle aktiv">Individuell</div><?php
						 						}

						 						?>
                      </td>
					
                <td class="text-center"><a href='#' data-toggle='tooltip'  title='Checkliste ausfüllen' class='text-info edit' data-edit='<?=$objects['id']?>' ><span class='far fa-edit iconss'></span></a>
			<?php if(($objects['created_by']==2)&&($objects['locked']==0)&&($objects['checked']==0)&&($objects['re_check']==0)){
				$id = $objects['id'];
						$fun = "del('".$id."')";
						?>
			
			<a href='#' data-toggle='tooltip' data-placement='top' onClick="<?=$fun?>"  title='Checkliste löschen'  class='tbl_rating_del-button' ><span class='fa fa-trash-alt iconss'></span></a></td>
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

<!-------model for edit/rate checklist----->
  <div class="modal fade editModal" id="modal-checklist" tabindex="-1" role="dialog" aria-hidden="true"  tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myModalLabel">[Checkliste Objektkontrolle CL 04-1] <div id="objektname"></div></h4>
        </div>
        <div class="modal-body">
					<form role="form" id="frm">
            <input type="hidden" name="id" id="id" />
			    		<div class="table-responsive">
                  <table class="table table-striped table-bordered tbl2 table-rating">
                    <tbody>
											<span class="message text_error errror text-center"></span>

							 				<div class="form-group">
		    								<label for="exampleInputEmail1">Mitarbeiter</label>
		    								<input type="text" class="form-control" id="text" name="text"  placeholder="" required />
												<span class="errror text_error " id="txt_req"></span>
		  								</div>

											<?php foreach($des as $data){
					 							//Cat1
					 							if(($data['cat']==1) && ($data['rang']==0)){ ?>
													<tr class="rating_first_tr">
							 							<td><?= $data['description']?></td>
							 							<td class="bg-approved"><div title="sehr gut">1</div></td>
							 							<td class="bg-approved"><div title="gut">2</div></td>
							 							<td class="bg-open"><div title="zufriedenstellend">3</div></td>
							 							<td class="bg-open"><div title="mit leichten Mängeln">4</div></td>
							 							<td class="bg-rejected"><div title="mangelhaft">5</div></td>
		                      	<td><button type="button" class="btn btn-success btnn" data-toggle="collapse" data-target=".collapseme1">+</button></td>
													</tr><?php
												}

												if(($data['cat']==1)&&($data['rang']!=0)){?>
													<tr id="collapseme" class="collapse out collapseme1">
														<td><?=$data['description']?></td>
													  <td class="bg-approved"><label class=""><input type="radio" name="radio[<?=$data["id"]?>]"value="1"></label></td>
													  <td class="bg-approved"><label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="2"></label></td>
														<td class="bg-open"><label class=""><input type="radio"name="radio[<?=$data["id"]?>]" value="3"> </label></td>
													 	<td class="bg-open"><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="4"></label></td>
													 	<td class="bg-rejected"><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="5"></label></td>
													 	<td><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]"></label></td>
													</tr><?php
												}
												
					 							//Cat2
					 							if(($data['cat']==2) && ($data['rang']==0)){ ?>
													<tr class="rating_first_tr">
							 							<td><?= $data['description']?></td>
							 							<td class="bg-approved"><div title="sehr gut">1</div></td>
							 							<td class="bg-approved"><div title="gut">2</div></td>
							 							<td class="bg-open"><div title="zufriedenstellend">3</div></td>
							 							<td class="bg-open"><div title="mit leichten Mängeln">4</div></td>
							 							<td class="bg-rejected"><div title="mangelhaft">5</div></td>
		                      	<td><button type="button" class="btn btn-success btnn" data-toggle="collapse" data-target=".collapseme2">+</button></td>
													</tr><?php
												}

												if(($data['cat']==2)&&($data['rang']!=0)){?>
													<tr id="collapseme" class="collapse out collapseme2">
														<td><?=$data['description']?></td>
													  <td class="bg-approved"><label class=""><input type="radio" name="radio[<?=$data["id"]?>]"value="1"></label></td>
													  <td class="bg-approved"><label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="2"></label></td>
														<td class="bg-open"><label class=""><input type="radio"name="radio[<?=$data["id"]?>]" value="3"> </label></td>
													 	<td class="bg-open"><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="4"></label></td>
													 	<td class="bg-rejected"><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="5"></label></td>
													 	<td><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]"></label></td>
													</tr><?php
												}

					 							//Cat3
					 							if(($data['cat']==3) && ($data['rang']==0)){ ?>
													<tr class="rating_first_tr">
							 							<td><?= $data['description']?></td>
							 							<td class="bg-approved"><div title="sehr gut">1</div></td>
							 							<td class="bg-approved"><div title="gut">2</div></td>
							 							<td class="bg-open"><div title="zufriedenstellend">3</div></td>
							 							<td class="bg-open"><div title="mit leichten Mängeln">4</div></td>
							 							<td class="bg-rejected"><div title="mangelhaft">5</div></td>
		                      	<td><button type="button" class="btn btn-success btnn" data-toggle="collapse" data-target=".collapseme3">+</button></td>
													</tr><?php
												}

												if(($data['cat']==3)&&($data['rang']!=0)){?>
													<tr id="collapseme" class="collapse out collapseme3">
														<td><?=$data['description']?></td>
													  <td class="bg-approved"><label class=""><input type="radio" name="radio[<?=$data["id"]?>]"value="1"></label></td>
													  <td class="bg-approved"><label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="2"></label></td>
														<td class="bg-open"><label class=""><input type="radio"name="radio[<?=$data["id"]?>]" value="3"> </label></td>
													 	<td class="bg-open"><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="4"></label></td>
													 	<td class="bg-rejected"><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="5"></label></td>
													 	<td><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]"></label></td>
													</tr><?php
												}

					 							//Cat4
					 							if(($data['cat']==4) && ($data['rang']==0)){ ?>
													<tr class="rating_first_tr">
							 							<td><?= $data['description']?></td>
							 							<td class="bg-approved"><div title="sehr gut">1</div></td>
							 							<td class="bg-approved"><div title="gut">2</div></td>
							 							<td class="bg-open"><div title="zufriedenstellend">3</div></td>
							 							<td class="bg-open"><div title="mit leichten Mängeln">4</div></td>
							 							<td class="bg-rejected"><div title="mangelhaft">5</div></td>
		                      	<td><button type="button" class="btn btn-success btnn" data-toggle="collapse" data-target=".collapseme4">+</button></td>
													</tr><?php
												}

												if(($data['cat']==4)&&($data['rang']!=0)){?>
													<tr id="collapseme" class="collapse out collapseme4">
														<td><?=$data['description']?></td>
													  <td class="bg-approved"><label class=""><input type="radio" name="radio[<?=$data["id"]?>]"value="1"></label></td>
													  <td class="bg-approved"><label class=""><input type="radio" name="radio[<?=$data["id"]?>]" value="2"></label></td>
														<td class="bg-open"><label class=""><input type="radio"name="radio[<?=$data["id"]?>]" value="3"> </label></td>
													 	<td class="bg-open"><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="4"></label></td>
													 	<td class="bg-rejected"><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]" value="5"></label></td>
													 	<td><label class=""> <input type="radio" name="radio[<?=$data["id"]?>]"></label></td>
													</tr><?php
												}
          						}?>
                    </tbody>
                  </table>
                </div>		
             <div class="form-group">
    					<label for="exampleFormControlTextarea1"></label>
    					<textarea class="form-control" name="note" id="note" rows="4" placeholder="Notizen"></textarea>
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
<!---end edit/rate model--->

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
		 	$(document).on('click','#clear',function(e) {
	    var label = $('#clear');
			var n=$('input').attr('mon');
			console.log(n);
			var v=label.attr('month');
			 //$('input').attr('checked', false);
			});

    $(document).ready(function(){
			$(".tbl").DataTable({
				'columnDefs': [ {
					'targets': [8],
					'orderable': false,
				}],
				"order": [[ 1, "asc" ]],
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
            toastr.success('Checkliste erfolgreich hinzugefügt.');
            window.location.reload();
          } else {
            toastr.error('Error in add Checklist, try agian');
          }
		   }
	   });
	   
   });

		$('.btnn').click(function(){
			$(this).text(function(i,old){
				return old=='+' ?  '-' : '+';
			});
		});

	  $(document).on('click','.edit',function(e) {
      console.log('Modal Window Rating gestartet.');
			$('#txt_req').html('');	//prev. fehlende Mitarbeiter-Eingabe Error erforderlich löschen
	   	$('.collapseme1').collapse('hide');
	   	$('.collapseme2').collapse('hide');
	   	$('.collapseme3').collapse('hide');
	   	$('.collapseme4').collapse('hide');
		  $('.btnn').text('+');

      var id = $(this).data('edit');
			$('#id').val(id);
	    $.ajax({
			url:url,
        type:"POST",
        dataType:"JSON",
        data:{'req':'checked_data','id':id},
        success:function(res){
        	
				 	var length=res.data.length;
				 	var tmp1 ='';
				 	for(i=0; i<length; i++) {   
				   	
				   	if (id == res.data[i]['id']) {
				   		tmp1= res.data[i]['object_name'];
				   		$('#objektname').html(tmp1);	//Objektname im Titel vom Modal Window
				   	}
				 	}

					if(res=='0') {
						$('.editModal').modal('show');
						$('input').prop('checked', false);
						$('#text').val('');
						console.log("res==0");
					}
         	else {
						console.log("res==0 else");
					 	var length=res.data.length;
					 	for(i=0; i<length; i++) {   
					   	if(res.data[i]['object_id']==id) {
					 			$('.editModal').modal('show');
							  $('input').prop('checked', false);
							  $('#text').val('');s
							}
							else {
								$('.message').html(''); 
					   		$('.editModal').modal('show');
						   	$('input').prop('checked', false);
						   	$('#text').val('');
							}
					 	}            
         	} //else
        }
      });
    });

	  var check5=false;
	  var count1=0;
	  var count2=0;
	  var count3=0;
	  var count4=0;
	  var count5=0;
	  var count6=0;

	  var arr = [];
    var i = 0;
		var val;
		var fff;
	 	$(document).on('click','#update',function(e) {
				val=$('#text').val();
				if(val=="") {$('#txt_req').html('Eingabe erforderlich!'); $('#modal-checklist').find('#text').focus(); return false;}
				else{$('#txt_req').html('');}

		    var fff=$('input[type=radio]').is(':checked');

				if(!fff){
					empty();
					return false;
				}
		
				var data = $("#frm").serialize()+ '&req=' + 'checkdata';			
				$.ajax({
				url:url,  
				type:"POST",
				dataType:"JSON",
				data:data,
				success:function(res){
					if(res=="0") {

					}
					else {
						var count=res.arr.length
						count1=0;
						count2=0;
						count3=0;
						count4=0;
						count5=0;
						count6=0;

						for(i=0; i<count; i++) {
							console.log(res.arr[i])
	            if(res.arr[i]=="on"){
		         		//if we use this they will call on every radiobutton if they are in 6
		          	count6++;
		         		//norating();
		      		}
							else if(res.arr[i]==5) {
								check5=true;
								count5++;	
							}
							else if(res.arr[i]==4) {
								count4++;
							}
							else if(res.arr[i]==3) {	
								count3++;
							}
							else if(res.arr[i]==2) {		
								count2++;
							}
							else if(res.arr[i]==1) {
							 count1++;
							}			  
						}

						//var str_tmp = "[after success] count1: " + count1 + " | count2: " + count2 + " | count3: " + count3 + " | count4: " + count4 + " | count5:" + count5 + " | count6:" + count6 + " | check5: " + check5; 
						//console.log(str_tmp)

						//if(count1==0&&count2==0&&count3==0&&count4==0&&count5==0&&count6!=0) {
						if(count1==0&&count2==0&&count3==0&&count4==0&&count5==0) {	//count6 checks unnecessary
							empty();
							return false;	
						}

						if(fff=true && val!="") {go();}
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

			function create_recheck() {	//quarr
				var id=$('#id').val();	 
				  $.ajax({
					
					url:url,
					type:"POST",
					dataType:"JSON",
					data:{'req':'recheck_list','id':id},
					success:function(res){
					  if(res=="1") {
					   //go()
					  }
					}
				  });				
			}

			function empty() {
				swal({
					title: "Hinweis",
					text:  "Es muss mindestens eine Bewertung erfolgen!",
					type:  "warning",
					showCancelButton: false,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Ok, verstanden.",
					closeOnConfirm: true }, function(){
				});
			}

			function go() {
				tmp = "";
				if (count5>0) {tmp = "<div class=\"btn-danger\" style=\"margin-top:.5em\">Die Bewertung mit der Note 5 bewirkt die Erstellung einer Nachkontrolle!</div>";}

				swal({
					title: "Sind Sie sicher?",
					html: true,
					text: "Wurden alle Bewertungen wahrheitsgemäß vorgenommen?" + tmp,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Ja, reiche die Checkliste ein!",
					closeOnConfirm: true }, function(){

					var data = $("#frm").serialize()+ '&req=' + 'checklist';			
				  $.ajax({
						url:url,
						type:"POST",
						dataType:"JSON",
						data:data,
						success:function(res){
						  if(res=="1") {
						  	$('#editModal').modal('hide');
								if (count5>0) {create_recheck();}
								toastr.success('Checkliste erfolgreich eingereicht.');
								window.location.reload();
						  }
						  else {
								toastr.error('Error in uploading the checklist, try agian');
						  }
						}
					});
				});	
			}

		function del(id) {
			swal({
				title: "Sind Sie sicher?",
				text:  "Die Checkliste wird endgültig gelöscht!",
				type:  "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ja, lösche die Checkliste!",
        customClass: "se_del",
				closeOnConfirm: true }, function(){
				  $.ajax({
						url:url,
						type:"POST",
						dataType:"JSON",
						data:{'req':'delete_obj','id':id},
						success:function(res){
						  if(res=="1") {
								toastr.success('Checkliste erfolgreich gelöscht.');
								window.location.reload();
						  }
						  else {
								toastr.error('Error: Checkliste löschen');
						  }
						}
				  });
				});	
		}

			$('[data-toggle="tooltip"]').tooltip({
			    trigger : 'hover'
			})

			$(document).ready(function(){
		    $("#modal-checklist").on('shown.bs.modal', function(){
					$(this).find('#text').focus();
		    });
			});
		</script>
	</body>
</html>