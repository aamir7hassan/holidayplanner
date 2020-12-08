<?php
  $this->load->view('includes/head');
  echo link_tag('assets/fontawesome/css/all.css');
  echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
  echo link_tag('assets/datatables/jquery.dataTables.min.css');
  echo link_tag('assets/css/toastr.min.css');
  echo link_tag('assets/css/sweetalert.css');
  echo link_tag('assets/css/custom.min.css');
  echo link_tag('assets/css/style.css');
?>
	<style>
		table tbody tr td:last-child {
			padding-top: 10px !important;
			padding-bottom: 6px !important;
		}
  .urlaubsanspruch tbody tr:nth-child(odd) {background-color: #f2f2f2 !important;}
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
                <h2>Mitarbeiter</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li></li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <?php if($error = $this->session->flashdata('data')) {
                  $class = $this->session->flashdata('class');
                ?>
                  <div class="alert alert-dismissible <?=$class;?>" id = "success-alert">
                    <button  type ="button" class="close" data-dismiss="alert">x</button>
                    <?php echo $error;?>
                  </div>
                <?php } ?>
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
                        <th class="text-center">Bereichsleiter</th>
                        <th class="text-center">Bearbeiten</th>
                      </tr>
                    </thead>
                    <tbody>

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
  <!-- / .body -->
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
            <input type="hidden" name="id" id="id" />
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
              <input type="email" name="email" id="email" class="form-control" required />
            </div>
            <div class="form-group">
              <label class="control-label">Telefon</label>
              <input type="text" name="phone" id="phone" class="form-control" required />
            </div>
            <div class="form-group">
              <label class="control-label">Abteilung</label>
              <input type="text" name="dept" id="dept" class="form-control" required />
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

  <!-- Modal -->
<div id="holidaymodal" class="modal fade" role="dialog"  tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span id="name"></span></h4>
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
          <tbody id="tbody">

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
      </div>
    </div>
  </div>
</div>
<div id="editholiday" class="modal fade" role="dialog"  tabindex="-1">
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
							<input type="number" class="form-control" name="year" id="eyear" min="0" step="1" readonly />
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
  <?php $this->load->view('includes/foot');?>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
  	<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>

  <script>

    var url = "<?php echo base_url('admin/dashboard/ajax'); ?>";
    $(document).ready(function(){
      $('.tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
            "url": url,
            "dataType": "JSON",
            "type": "POST",
            "data":{ 'req':'get_all_staff_dt'}
          },
        "columns": [
		  		{ "data": "lname" },
          { "data": "name" },
          { "data": "email" },
          { "data": "number" },
          { "data": "department" },
          { "data": "holiday" },
          { "data": "supervisor" },
          { "data": "action"},
        ],
        'columnDefs': [ {
          'targets': [7],
          'orderable': false,
		  'class'	: 'incenter'
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
            $('#id').val(res.id);
            $('.editModal').modal('show');
        }
      });
    });

    $(document).on('click','#update',function(e) {
      var fname = $('#fname').val();
      var lname = $('#lname').val();
      if(fname==""){
        $('.fname').html('Bitte den Urlaubsanspruch eintragen');
        return false;
      }
      if(lname==""){
        $('.lname').html('Please enter last name');
        return false;
      }
      $(this).prop('disabled',true);
      $(this).html('Saving...');
      var data = $("#frm").serialize()+ '&req=' + 'save_staff';
      $.ajax({
        url:url,
        type:"POST",
        dataType:"JSON",
        data:data,
        success:function(res){
          if(res=="1") {
            $('#editModal').modal('hide');
            toastr.success('staff updated successfully');
            window.location.reload();
          } else {
            toastr.error('Error in updating staff, try agian');
          }
        }
      });
    });


    function del(id)
		{
			swal({
          title: "Sind Sie sicher?",
          text: "Die Daten können nicht wiederhergestellt werden!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ja, lösche den Mitarbeiter!",
          closeOnConfirm: true }, function(){
          $.ajax({
						url:url,
						type:"POST",
						dataType:"JSON",
						data:{'req':'delete_staff','id':id},
						success:function(res) {
							if(res=="1") {
								toastr.success('Staff deleted successfully');
								window.location.reload();
							} else {
								toastr.error(res);
							}
						}
					});
      });
		}

    $(document).on('click','.holiday',function() {
			var sid = $(this).data('holiday');
      var name = $(this).data('name');
      $('#name').html(name);
      $('#id').val(sid);
			$.ajax({
				url:"<?php echo base_url('admin/dashboard/ajax');?>",
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
				alert('Bitte den Urlaubsanspruch eintragen');
				return false;
			}
			if(year=="") {
				alert('Please enter year');
				return false;
			}
			$(this).html('saving...');
			$(this).prop('disabled',true);
			$.ajax({
				url:"<?php echo base_url('admin/dashboard/ajax'); ?>",
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
				url:"<?php echo base_url('admin/dashboard/ajax'); ?>",
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
				alert('Bitte den Urlaubsanspruch eintragen');
				return false;
			}
			if(year=="") {
				alert('Please enter year');
				return false;
			}
			$(this).html('updating...');
			$(this).prop('disabled',true);
			$.ajax({
				url:"<?php echo base_url('admin/dashboard/ajax'); ?>",
				type:"POST",
				dataType:"JSON",
				data:{'req':'updateHoliday','sid':sid,'holiday':holiday,'year':year},
				success:function(res){
					$('#esave').html('Update');
					$('#esave').prop('disabled',false);
					$('#eholiday_ent').val('');
					$('#eyear').val('');
					if(res==1) {
						toastr.success('Updated successfully');
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
    $(document).ready(function(){
         $('[data-toggle="tooltip"]').tooltip();
	
    });


  </script>
</body>
</html>
