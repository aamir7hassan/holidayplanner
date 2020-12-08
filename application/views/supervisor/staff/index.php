	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/nprogress.css');
		echo link_tag('assets/css/green.css');
		echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
		echo link_tag('assets/css/jqvmap.min.css');
		echo link_tag('assets/css/toastr.min.css');
		echo link_tag('assets/datatables/jquery.dataTables.min.css');
		echo link_tag('assets/css/sweetalert.css');
		echo link_tag('assets/css/custom.min.css');
		echo link_tag('assets/css/style.css');
	?>
  <style>
 

  .urlaubsanspruch tbody tr:nth-child(odd) {background-color: #f2f2f2 !important;}

  </style>
	</head>

	<body class="nav-md">

		<div class="container body">

			<div class="main_container">

				<?php $this->load->view('includes/header');?>

				<div class="right_col" role="main">

					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 maxi">

							<div class="x_panel">
									
								<div class="x_title">
									<h2>Mitarbeiter</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a href="#" id="add-staff" class="btn btn-success" style="color:#fff">+ Mitarbeiter</a></li>
									</ul>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">
						
									<div class="table-responsive">
										<table class="table table-striped table-bordered tbl">
							<thead>
								<tr>
									<th class="text-center">Nachname</th>
									<th class="text-center">Vorname</th>
									<th class="text-center">E-Mail</th>
									<th class="text-center">Telefon</th>
									<th class="text-center">Abteilung</th>
									<th class="text-center">Urlaub</th>
									<th class="text-center">Bearbeiten</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($staff as $key=>$val) {
									if(!empty($val['pattern'])) {
										$arr = explode(',',$val['pattern']);
										$leaves = count($arr);
									} else {
										$leaves = 0;
									}
							  ?>

								<tr>
									<td class="text-center"><?php echo $val['lname'];?></td>
									<td class="text-center"><?php echo $val['fname'];?></td>
									<td class="text-center"><?php echo $val['email'];?></td>
									<td class="text-center"><?php echo $val['phone'];?></td>
									<td class="text-center"><?php echo $val['department'];?></td>
									<td class="text-center"><?php echo number_format($leaves/2,1)."/".$val['holiday_ent']." - ".$val['year'];?></td>
									<td class="text-center">
										<a data-toggle='tooltip' href="#" data-placement='top' data-edit="<?php echo $val['sid']?>" title='Mitarbeiter bearbeiten' class="text-info edit"><i class="far fa-edit iconss"></i></a>
										<a data-toggle='tooltip' data-id="<?php echo $val['sid'];?>" data-placement='top' title='Mitarbeiter löschen' class="text-danger delete"><i class="fa fa-trash-alt iconss"></i></a>
										<a href='#' data-toggle='tooltip' data-name='<?php echo $val['fname'].' '.$val['lname']?>' data-placement='top' title='Urlaubsanspruch' data-holiday='<?php echo $val['sid'];?>' class='text-primary holiday' ><span class='far fa-calendar-alt iconss'></span></a>
									</td>

								</tr>

								<?php } ?>

							</tbody>

						</table>

					</div>

								</div>

							</div>

						</div>

					</div>

				</div>

					<div class="clearfix"></div>

					</div>

				</div>

				<!-- / .right_col -->

			</div>

			<!-- / .main_container -->

		</div>

		<!-- / .body -->
		<!-- Modal -->
	<div id="holidaymodal" class="modal fade" role="dialog" tabindex="-2">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><span id="name"></span></h4>
					<form>
						<input type="hidden" id="id" name="id" value="" />
					</form>
				</div>
				<div class="modal-body" id="mbody">
					<table class="table urlaubsanspruch">
						<thead>
							<tr>
								<th>Urlaubsanspruch</th>
								<th>Jahr</th>
								<th>Bearbeiten</th>
							</tr>
						</thead>
						<tbody class="tbody"id="tbody">

						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
				</div>
			</div>
		</div>
	</div>
	
	<div id="editholiday" class="modal fade" role="dialog" tabindex="-3">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><span id="ename"></span> Urlaubsanspruch bearbeiten</h4>
				</div>
				<div class="modal-body">
					<form role="form">
						<input type="hidden" id="hid" value="" />
						<div class="form-group">
							<label class="control-label">Urlaubsanspruch</label>
							<input type="number" id="eholiday_ent" min="0.0" step="1" class="form-control" name="holiday_ent" required />
						</div>
						<div class="form-group">
							<label for="holidays" class="control-label">Jahr</label>
							<input type="number" class="form-control" name="year" id="eyear" readonly />
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
					<a href="#" id="esave" class="btn btn-success" >Speichern</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade editModal" tabindex="-1" role="dialog" aria-hidden="true"  tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">Mitarbeiter bearbeiten</h4>
        </div>
        <div class="modal-body">
          <form role="form" id="frm">
            <input type="hidden" name="id" id="sid" value="" />
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
              <input type="email" placeholder="optional" name="email" id="email" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label">Telefon</label>
              <input type="text" placeholder="optional" name="phone" id="phone" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label">Abteilung</label>
              <input type="text" placeholder="optional" name="dept" id="dept" class="form-control" />
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
  <div class="modal fade addStaff" tabindex="-1" role="dialog" aria-hidden="true"  tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">Mitarbeiter hinzufügen</h4>
        </div>
        <div class="modal-body">
	   <form action="<?php echo base_url('supervisor/dashboard/create');?>" id="new-staff" method="POST">
								<div class="form-group">
									<label for="firstname">
										Vorname
									</label>
									<input type="text" class="form-control" name="firstname" id="firstname" required autofocus />
								</div>
								<div class="form-group">
									<label for="laststname">
										Nachname
									</label>
									<input type="text" class="form-control" name="lastname" required  />
								</div>
								<div class="form-group">
									<label for="email">
										E-Mail
									</label>
									<input type="email" placeholder="optional" class="form-control" name="email" id="email" />
								</div>
								<div class="form-group">
									<label for="phone">
										Tel.
									</label>
									<input type="text" placeholder="optional" class="form-control" name="per_phone"  />
								</div>
								<div class="form-group">
									<label for="Departement">
										Abteilung
									</label>
									<input type="text" placeholder="optional" class="form-control" name="dept"  />
								</div>
								<div class="form-group">
									<label for="holidays">
										Urlaubstage pro Jahr
									</label>
									<input type="number" id="holiday_ent" min="0.0" step="0.5" class="form-control" name="holiday_ent" required  />
								</div>
								<div class="form-group">
									<input type="button" id="min5"  onclick="sub_five()" class="btn btn-danger" value="-0.5"/>
									<input type="button" id="plus5" onClick="add_five()" class="btn btn-success" value="+0.5"/>
								</div>
								</form>
								<!-- <div class="form-group">
									<label for="holidays">
										Jahr:
									</label>
									<input type="number" class="form-control" name="year" id="year" min="0" step="1" value="<?php echo date('Y');?>"/>
								</div> -->
								
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal">Abbrechen</a>
          <input id="save-staff" class="btn btn-primary" name="submit" value="Mitarbeiter hinzufügen"/>
        </div>
      </div>
    </div>
  </div>
		<?php $this->load->view('includes/foot');?>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/date.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
		<script>
		
		var url = "<?php echo base_url('supervisor/dashboard/ajax'); ?>";
		$(".tbl").DataTable({
			'columnDefs': [ {
				'targets': [6],
				'orderable': false,
			}],
			"fnDrawCallback": function(oSettings){
					var rowCount = this.fnSettings().fnRecordsDisplay();
					if(rowCount<=10){
						$('.dataTables_length').hide();
						$('.dataTables_paginate').hide();
					}
		 }
		});
		 // edit modal
		$(document).on('click','.edit',function(e) {
			var id = $(this).data('edit');
			$.ajax({
			url:url,
			type:"POST",
			dataType:"JSON",
			data:{'req':'get_staff','id':id},
			success:function(res) {
				$('#fname').val(res.fname);
				$('#lname').val(res.lname);
				$('#email').val(res.email);
				$('#phone').val(res.phone);
				$('#dept').val(res.department);
				$('#pass').val(res.pass);
				$('#sid').val(res.id);
				$('.editModal').modal('show');
			}
			});
		});

		$(document).on('click','#update',function(e) {
			var fname = $('#fname').val();
			var lname = $('#lname').val();
			$('.fname').html('');
			$('.lname').html('');
			if(fname==""){
			$('.fname').html('Bitte den Vornamen eintragen.');
			return false;
			}
			if(lname==""){
			$('.lname').html('Bitte den Nachnamen eintragen.');
			return false;
			}
			$(this).prop('disabled',true);
			$(this).html('speichere ...');
			var data = $("#frm").serialize()+ '&req=' + 'save_staff';
			$.ajax({
			url:url,
			type:"POST",
			dataType:"JSON",
			data:data,
			success:function(res){
				if(res=="1") {
				$('#editModal').modal('hide');
				toastr.success('Mitarbeiter erfolgreich aktualisiert.');
				window.location.reload();
				} else {
				toastr.error('Error in updating staff, try agian');
				}
			}
			});
		});
		$(document).on('click','.delete',function() {
      	var id = $(this).data('id');
        swal({
        title: "Sind Sie sicher?",
        text:  "Der Mitarbeiter wird endgültig gelöscht!",
        type:  "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ja, lösche den Mitarbeiter!",
        customClass: "se_del",
        closeOnConfirm: true }, function(){
        	$.ajax({
            url:"<?php echo base_url('supervisor/dashboard/delete_staff');?>",
            type:"POST",
            dataType:"JSON",
            data:{'id':id},
            success:function(res) {
                if(res=="1"){
									toastr.success('Mitarbeiter erfolgreich gelöscht');
									window.location.reload();
                } else {
                    toastr.error(res);
                }
            }
        	});
   		});
    });

		$(document).on('click','.holiday',function() {
			var sid = $(this).data('holiday');
      var name = $(this).data('name');
      $('#name').html(name);
			$('#id').val(sid);
			$.ajax({
				url:"<?php echo base_url('supervisor/dashboard/ajax');?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'get_staff_holidays','sid':sid},
				success:function(res) {
          if(res==0) {
            toastr.error('Invalid staff id');
          } else {
            $('#tbody').html(res);
            $('#holidaymodal').modal('show');
          }
				}
			});
		});

		$(document).on('click','#assign',function(){
			$('#addholiday').modal('show');
		});

		$(document).on('click','#save',function(){
			var sid = $('#id').val();
			var holiday = $('#holiday_ent').val();
			var year = $('#year').val();
			if(holiday=="") {
				alert('Please enter holidays');
				return false;
			}
			if(year=="") {
				alert('Please enter year');
				return false;
			}
			$(this).html('speichere ...');
			$(this).prop('disabled',true);
			$.ajax({
				url:"<?php echo base_url('supervisor/dashboard/ajax'); ?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'addHoliday','sid':sid,'holiday':holiday,'year':year},
				success:function(res){
					$('#save').html('Save');
					$('#save').prop('disabled',false);
					$('#holiday_ent').val('');
					$('#year').val('');
					if(res==1) {
						toastr.success('Assigned successfully');
						$('#addholiday').modal('hide');
						$('#holidaymodal').modal('hide');
						
					} else {
						toastr.error('Error! try agian');
						$('#addholiday').modal('hide');
						$('#holidaymodal').modal('hide');
					}
				}
			});
		});

		$(document).on('click','.editi',function(){
			var id = $(this).data('editi');
			$.ajax({
				url:"<?php echo base_url('supervisor/dashboard/ajax'); ?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'edit_holiday','id':id},
				success:function(res) {
					console.log(res);
					if(res==0) {
						toastr.error('invalid id');
					} else {
						$('#hid').val(res.id);
						$('#eholiday_ent').val(res.holiday_ent);
						$('#eyear').val(res.year);
						$('#editholiday').modal('show');
					}
				}
			});
		});
		
		$(document).on('click','#esave',function(){
			var sid = $('#hid').val();
			var holiday = $('#eholiday_ent').val();
			var year = $('#eyear').val();
			
			if(holiday=="") {
				alert('Please enter holidays');
				return false;
			}
			if(year=="") {
				alert('Please enter year');
				return false;
			}
			$(this).html('aktualisiere ...');
			$(this).prop('disabled',true);
			$.ajax({
				url:"<?php echo base_url('supervisor/dashboard/ajax'); ?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'updateHoliday','sid':sid,'holiday':holiday,'year':year},
				success:function(res){
					$('#esave').html('Update');
					$('#esave').prop('disabled',false);
					$('#eholiday_ent').val('');
					$('#eyear').val('');
					if(res==1) {
						toastr.success('Aktualisierung erfolgreich');
						$('#editholiday').modal('hide');
						$('#holidaymodal').modal('hide');
						window.location.reload();
						
					} else {
						toastr.error('Error! try agian');
						$('#editholiday').modal('hide');
						$('#holidaymodal').modal('hide');
					}
				}
			});
		});

		<?php
			if($this->session->flashdata('data')) {
		?>
			toastr.<?php echo $this->session->flashdata('class') ?>('<?php echo $this->session->flashdata('data') ?>');
		<?php } ?>
		$(document).on("click","#add-staff",function(){
			$('.addStaff').modal('show');
			 $(this).find('#fname').focus();
		})
		$(document).on("click","#save-staff",function(){
			var check=false;
			$("#new-staff").each(function(){
				$(".error").remove();
				var input=$(this).find(':input');
				$(input).each(function(){
					if($(this).prop("required") && $(this).val()==""){
						$(this).after("<p class='error'>Eingabe erforderlich!</p>");
						check=true;
					}
				}); //<-- Should return all input elements in that specific form.
			});
			if(!check){
				$("#new-staff").submit();
			}
			//$("#new-staff").submit();
		})
			function add_five()
			{
				var value = parseFloat(document.getElementById('holiday_ent').value, 10);
    			value = isNaN(value) ? 0 : value;
    			value=value+0.5;
   				document.getElementById('holiday_ent').value = value;
			}
			function sub_five()
			{
				var value = parseFloat(document.getElementById('holiday_ent').value, 10);
				console.log(value);
				value = isNaN(value) ? 0 : value;
				if(value!=0){
    			value=value-0.5;
   				document.getElementById('holiday_ent').value = value;
				}
			}

			$(document).on('focusout','#email',function() {
				var email = $(this).val();
				if(email=="") {
					return false;
				}
				$('.chk').removeClass('hidden');
				$.ajax({
					url:"<?php echo base_url('supervisor/dashboard/ajax') ?>",
					type:"POST",
					dataType:"JSON",
					data:{'req':'chk_email','email':email},
					success:function(res) {
						$('.chk').html(res);
					}
				});
			});

			<?php
				if($this->session->has_userdata('data')) {
			?>
				toastr.<?php echo $this->sesison->userdata('class') ?>('<?php echo $this->session->userdata('data') ?>');
			<?php } ?>

	$(document).ready(function(){
	    $(".addStaff").on('shown.bs.modal', function(){
			
	        $(this).find('#firstname').focus();
	    });
	});
	</script>

	</body>

</html>
