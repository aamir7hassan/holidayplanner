<?php
  $this->load->view('includes/head');
  echo link_tag('assets/fontawesome/css/all.css');
  echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
  echo link_tag('assets/datatables/jquery.dataTables.min.css');
  echo link_tag('assets/css/toastr.min.css');
  echo link_tag('assets/css/sweetalert.css');
  echo link_tag('assets/css/custom.min.css');
  echo link_tag('assets/css/style.css');
  echo link_tag('assets/css/bootstrap-datepicker.min.css');
?>
	<style>
		table tbody tr td:last-child {
			padding-top: 10px !important;
			padding-bottom: 6px !important;
		}
		.errror {color: red; font-size: 17px;}
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
          <div class="col-md-12 col-sm-12 col-xs-12  maxi">
            <div class="x_panel">
              <div class="x_title">
                <h2>Objekte</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a href="#" data-toggle="modal" data-target="#add-object" class="btn btn-success" style="color:#fff">+ Objekt</a></li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <?php if($error = $this->session->flashdata('data')) {
                  $class = $this->session->flashdata('class');
                ?>
                  <?php /*<div class="alert alert-dismissible <?=$class;?>" id = "success-alert">
                    <button  type ="button" class="close" data-dismiss="alert">x</button>
                    <?php echo $error;?>
                  </div>*/?>
                <?php } ?>

                <div class="table-responsive">
                  <table class="table table-striped table-bordered tbl">
                    <thead>
                      <tr>
												<th class="text-center">KTR</th>
                        <th class="text-center">Objekt</th>
                        <th class="text-center">Niederlassung</th>
                        <th class="text-center">Bereichsleiter </th>
                        <th class="text-center">Beginn</th>
                        <th class="text-center">Ende</th>
                        <th class="text-center">Bearbeiten</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
					
                    if(isset($objects)){
                    foreach($objects as $object){
						
				
					
                    ?>
                    <tr>
                        <td class="text-center"><?
                        		$ktr = $object['ktr_number'];
                        		
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
                        <td class="text-center"><?=$object['object_name']?></td>
						<?php 
						foreach($object_nl	as $val){
						 if($object['object_nl']==$val['id']){?>
                        <td class="text-center"><?=$val['nl_name']?></td>
						 <?php }}
						foreach($supervisors as $sup){
						if($object['object_supervisor']==$sup['id']){?>
                        <td class="text-center"><?=$sup['fname'].' '.$sup['lname']?> </td>
						<?php }}?>
                        <td class="text-center<?php
                        		//date_diff Anzahl zwischen Beginn- und Enddatum, wenn positiv, dann Enddatum > als Begindatum, wenn negativ Begindatum > Enddatum
                        		$clr_datecheck = "";
                        		if ($object['end_date']!="") {
	                        		if (date_diff(new DateTime($object['begin_date']), new DateTime($object['end_date']))->format('%R%a')<0) {;
	                        			$clr_datecheck = " btn-danger";
	                        		}
                        		}
                        		echo $clr_datecheck;?>"><? echo date_format(new DateTime($object['begin_date']), 'd.m.Y'); ?></td>
						<?php if(($object['end_date'])==""){?>
                        <td class="text-center"><? echo $object['end_date'] ?></td>
						<?php }?>
						<?php if(($object['end_date'])!=""){?>
                        <td class="text-center<?php echo $clr_datecheck;?>"><? echo date_format(new DateTime($object['end_date']), 'd.m.Y') ?></td>
						<?php }?>
                        <td class="text-center">
						<?php
						$id = $object['id'];
						$fun = "del('".$id."')";?>
													<a href='#' data-toggle='tooltip' title='Objekt bearbeiten' class='text-info edit' data-edit='<?=$object['id']?>' ><span class='far fa-edit iconss'></span></a>
                         	<a href='#' data-toggle='tooltip' data-placement='top' onClick="<?=$fun?>"  title='Objekt löschen'  class='text-danger' ><span class='fa fa-trash-alt iconss'></span></a>
                        </td>
                    </tr>
                    <?php }} ?>
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

	<!----Edit--->
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
            <div class="form-group">
              <label class="control-label">KTR</label>
              <input type="number" name="ktr_number" id="ktr_number" class="form-control" required />
              <span class="error ktr"></span>
            </div>
            <div class="form-group">
              <label class="control-label">Objekt</label>
              <input type="text" name="object_name" id="objet_name" class="form-control" required />
              <span class="error object"></span>
            </div>
            <div class="form-group">
              <label class="control-label">Niederlassung</label>
              <select class="form-control" name="object_nl" id="object_nl" required>
              <?php if(isset($object_nl)):?>
              <?php foreach($object_nl as $nl): ?>
              <option value="<?php echo $nl['id']?>"><?php echo $nl['nl_name']?></option>
              <?php endforeach;?>
              <?php endif;?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Bereichsleiter</label>
              <select class="form-control" name="object_supervisor" id="object_supervisor">
              <?php if(isset($supervisors)):?>
              <?php foreach($supervisors as $sup): ?>
              <option value="<?php echo $sup["id"]?>"><?php echo $sup["lname"]?>, <?php echo $sup["fname"]?></option>
              <?php endforeach;?>
              <?php endif;?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Beginn</label>
              <input type="text" name="begin_date" id="begin_date" class="form-control " required />
              <span class="errror begin_date"></span>
            </div>
            <div class="form-group">
              <label class="control-label">Ende</label>
              <input type="text" name="end_date" id="end_date" class="form-control " />
			   			<span class="errror end_date"></span>
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

  <!----ADdd--->
  <div class="modal fade" id="add-object" tabindex="-1" role="dialog" aria-hidden="true"  tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">Objekt hinzufügen</h4>
          <span class="tmp_text"></span>
        </div>
        <div class="modal-body">
          <form role="form" id="new-object" action="<?php echo base_url('objektmanager/dashboard/ajax')?>" method="POST">
          <input type="hidden" name="req" value="add_objekt" required />
            <div class="form-group">
              <label class="control-label">KTR</label>
              <input type="number" name="ktr_number" id="ktr_number" class="form-control" required />
              <span class="error ktr"></span>
            </div>
            <div class="form-group">
              <label class="control-label">Objekt</label>
              <input type="text" name="object_name" class="form-control" required />
              <span class="error object"></span>
            </div>
            <div class="form-group">
              <label class="control-label">Niederlassung</label>
              <select class="form-control" name="object_nl">
              <?php if(isset($object_nl)):?>
              <?php foreach($object_nl as $nl): ?>
              <option value="<?php echo $nl["id"]?>"><?php echo $nl["nl_name"]?></option>
              <?php endforeach;?>
              <?php endif;?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Bereichsleiter</label>
              <select class="form-control" name="object_supervisor">
              <?php if(isset($supervisors)):?>
              <?php foreach($supervisors as $sup): ?>
              <option value="<?php echo $sup["id"]?>"><?php echo $sup["lname"]?>, <?php echo $sup["fname"]?></option>
              <?php endforeach;?>
              <?php endif;?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Beginn</label>
              <input type="text" name="begin_date" id="begin_date_add" class="form-control " required />
              <span class="errror begin_date_add_error"></span>
            </div>
            <div class="form-group">
              <label class="control-label">Ende</label>
              <input type="text" name="end_date" id="end_date_add" class="form-control " />
			  			<span class="errror end_date_add_error"></span>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
          <button type="button" class="btn btn-primary" id="object_add">Objekt hinzufügen</button>
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
	<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
  <script>
    var url = "<?php echo base_url('objektmanager/dashboard/ajax'); ?>";
    $(document).ready(function(){
      $('.tbl').DataTable({
				'columnDefs': [ {
				  'targets': [6],
				  'orderable': false,
				  
				}],
        "fnDrawCallback": function(oSettings) {
            var rowCount = this.fnSettings().fnRecordsDisplay();
            if(rowCount<=10){
              $('.dataTables_length').hide();
              $('.dataTables_paginate').show(); 
            }
       }
      }); // datatables 
    });
    
    //$(".datepicker").datepicker();
//###### add modal ######
    $(document).on("click","#object_add",function(){
			var check=false;
			$('.begin_date_add_error').html('');
      $('.end_date_add_error').html('');
			$("#new-object").each(function(){
				var input=$(this).find(':input');
				$(".error").remove();
				$(input).each(function(){
					if($(this).prop("required") && $(this).val()==""){
						$(this).after("<p class='error'>Eingabe erforderlich!</p>");
						check=true;
					}
				}); //<-- Should return all input elements in that specific form.
			});

		//begin-date
		var txtvalue=$('#begin_date_add').val();
		var chk=txtvalue.length;
		if(chk!=0){
	    if(isDate(txtvalue)) {
				$('.begin_date_add_error').html('');
			}
	    else {
				$('.begin_date_add_error').html('Datumsformat nicht korrekt!');
		   	check=true;
			}
		}


		//end-date
		var txtVal2=$('#end_date_add').val();
		var chk=txtVal2.length
		if(chk!=0){
    	if(isDate(txtVal2)) {
      	$('.end_date_add_error').html('');
			}
      else {
      	$('.end_date_add_error').html('Datumsformat nicht korrekt!');
        check=true;
			}
		}


		if(!check){$("#new-object").submit();}
    })

//###### Edit ######
    $(document).on('click','#update',function(e) {
			var check=false;
			$('.begin_date').html('');
      $('.end_date').html('');
			$("#frm").each(function(){
				var input=$(this).find(':input');
				$(".error").remove();
				$(input).each(function(){
					if($(this).prop("required") && $(this).val()==""){
						$(this).after("<p class='error'>Eingabe erforderlich!</p>");
						check=true;
					}
				}); //<-- Should return all input elements in that specific form.
			});


      var ktr = $('#ktr_number').val();
      var object = $('#objet_name').val();
	
      if(ktr==""){
        $('.ktr').html('Eingabe erforderlich! X');
        check=true;
      }
      if(object==""){
        $('.object').html('Eingabe erforderlich! X');
        check=true;
      }


			//begin-date
	   	var txtvalue=$('#begin_date').val();
			var chk=txtvalue.length;
			if(chk!=0){
		    if(isDate(txtvalue)) {
					$('.begin_date').html('');
				}
		    else {
					$('.begin_date').html('Datumsformat nicht korrekt!');
			   	check=true;
				}
			}

			//end-date
			var txtVal2 =  $('#end_date').val();
		 	var chk=txtVal2.length
		 	if(chk!=0) {
	      if(isDate(txtVal2)) {
	         $('.end_date').html('');
				}
	      else {  
					$('.end_date').html('Datumsformat nicht korrekt!');
					check=true;
				}
		 	}

			if (check) return false;

      $(this).prop('disabled',true);
      $(this).html('Speichere...');
      var data = $("#frm").serialize()+ '&req=' + 'edit_objekt';
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

    $(document).on('click','.edit',function(e) {
      var id = $(this).data('edit');
	   	$(".error").remove();
	  	$('.begin_date').html('');
      $('.end_date').html('');
	  
      $.ajax({
        url:url,
        type:"POST",
        dataType:"JSON",
        data:{'req':'get_objekt','id':id},
        success:function(res) {
			
			//### begin date ###
			var begin_date=new Date(res.begin_date)
			$tmp_begin_d = begin_date.getDate()
			if ($tmp_begin_d<10) $tmp_begin_d = "0" + $tmp_begin_d
			$tmp_begin_m = (begin_date.getMonth() + 1)
			if ($tmp_begin_m<10) $tmp_begin_m = "0" + $tmp_begin_m
			var new_begin = $tmp_begin_d + "." + $tmp_begin_m + "." + begin_date.getFullYear()

			//### end date ###
			var end_date=new Date(res.end_date)
			$tmp_end_d = end_date.getDate()
			if ($tmp_end_d<10) $tmp_end_d = "0" + $tmp_end_d
			$tmp_end_m = (end_date.getMonth() + 1)
			if ($tmp_end_m<10) $tmp_end_m = "0" + $tmp_end_m
			var new_end = $tmp_end_d + "." + $tmp_end_m + "." + end_date.getFullYear()
			$('#id').val(res.id);
            $('#objet_name').val(res.object_name);
            $('#ktr_number').val(res.ktr_number);
            $('#object_nl').val(res.object_nl);
            $('#begin_date').val(new_begin);
			if(res.end_date=='00-00-0000') {
				$('#end_date').val("");
			}
			else {
        $('#end_date').val(new_end);
			}
        $('#object_supervisor').val(res.object_supervisor);
        $('.editModal').modal('show');
        }
      });
    });

		function isDate(txtDate)
		{
		    var currVal = txtDate;
		    if(currVal == '')
		        return false;
		    
		    var rxDatePattern = /^(0?[1-9]|[12][0-9]|3[01])[\.\-](0?[1-9]|1[012])[\.\-]\d{4}$/;; //Declare Regex
		    var dtArray = currVal.match(rxDatePattern); // is format OK?
		    
		    if (dtArray == null) 
		        return false;
		    
		    
		    //Checks for dd/mm/yyyy format.
		    dtMonth = dtArray[3];
		    dtDay   = dtArray[1];
		    dtYear  = dtArray[5];       
		    
		    if (dtMonth < 1 || dtMonth > 12) 
		        return false;
		    else if (dtDay < 1 || dtDay> 31) 
		        return false;
		    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
		        return false;
		    else if (dtMonth == 2) 
		    {
		        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
		        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
		                return false;
		    }
		    return true;
		}

    function del(id) {
			swal({
          title: "Sind Sie sicher?",
          text:  "Die Objekt wird endgültig gelöscht!",
          type:  "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ja, lösche das Objekt!",
          customClass: "se_del",
          closeOnConfirm: true }, function(){
          $.ajax({
						url:url,
						type:"POST",
						dataType:"JSON",
						data:{'req':'delete_objekt','id':id},
						success:function(res) {
							if(res=="1") {
								toastr.success('Objekt erfolgreich gelöscht.');
								window.location.reload();
							} else {
								toastr.error(res);
							}
						}
					});
      });
		}


	$(document).ready(function(){
	    $("#add-object").on('shown.bs.modal', function(){
	        $(this).find('#ktr_number').focus();
	        $(".error").remove();
	        
	        //document.getElementById('begin_date_add').value = '';
	        //document.getElementById('end_date_add').value = '';
	    });
	});
  </script>
</body>
</html>