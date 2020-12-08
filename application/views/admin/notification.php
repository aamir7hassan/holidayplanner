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
					<h2>Benachrichtigungen</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a href="#" class="btn btn-success" style="color:#fff" data-toggle="modal" data-target="#myModal">+ Benachrichtigungen</a></li>
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
					<table class="table">
								<thead class="thead-light">
										<tr>
										  <th scope="col">E-Mail</th>
										  <th class="text-center" scope="col">neuer Antrag</th>
										  <th class="text-center" scope="col">genehmigter Antrag</th>
										  <th class="text-center">Bearbeiten</th>
										</tr>
							  </thead>
							  <tbody>
									<?php 
										foreach($items as $key=>$val){
											$email = $val['admin'];
											$k = array_search($email,array_column($users,'email'));
											$pass = $users[$k]['pass'];
											if($val['new_request']=='1') {
												$new = '<div class="status aktiv">JA</div>';
											} else {
												$new = '<div class="status gesperrt">NEIN</div>';
											}
											if($val['approved_request']=='1'){
												$approved = '<div class="status aktiv">JA</div>';
											} else {
												$approved = '<div class="status gesperrt">NEIN</div>';
											}
									?>
									<tr>
										<td class="tbl_notif_email"><?=$email;?></td>
										<td><?=$new;?></td>
										<td><?=$approved;?></td>
										<td>
											<a href="#" data-toggle='tooltip' title='bearbeiten' class="text-info edit" data-edit="<?=$val['id']?>"><span class="far fa-edit iconss"></span></a>
											<a href="#" data-toggle='tooltip' title='löschen' class="text-danger del" data-del="<?=$val['id']?>"><span class="fa fa-trash-alt iconss"></span></a>
										</td>
									</tr>
									<?php } ?>
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
	 <!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog" tabindex="-1">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<form role="form">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">E-Mail hinzuf&uuml;gen</h4>
		  </div>
		  <div class="modal-body">
				<div class="form-group">
					<!--<label class="control-label">Admin Email</label>-->
					<input type="text" name="email" id="email" class="form-control" required />
				</div>
				<div class="form-group">
					<label class="checkbox-inline">
						<input type="checkbox" value="" id="new" /> Mitteilung &uuml;ber neuen Antrag
					</label>
					<label class="checkbox-inline">
						<input type="checkbox" value="" id="approve" > Mitteilung &uuml;ber genehmigten Antrag
					</label>
				</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
			<button type="button" class="btn btn-primary" id="save">Hinzuf&uuml;gen</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

	<div id="benachrichtigung_bearbeiten" class="modal fade editModal" role="dialog" tabindex="-1">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<form role="form">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Benachrichtigung bearbeiten</h4>
		  </div>
		  <div class="modal-body" id="frms">
							
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
			<button type="button" class="btn btn-primary" id="update">Speichern</button>
		  </div>
		  </form>
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
 

    $(document).on('click','#save',function(e) {
		//e.preventDefault();
		var email = $('#email').val();
		if(email=="") {
			toastr.error('Bitte eine E-Mail-Adresse eintragen!');
			return false;
		}
		
		if($("#new").prop('checked') == true){
			var newn = "1";
		} else {
			var newn = "0";
		}
		if($("#approve").prop('checked') == true){
			var approve = "1";
		} else {
			var approve = "0";
		}
		$.ajax({
			url:url,
			type:"POST",
			dataType:"JSON",
			data:{'req':'add_notification','newn':newn,'approve':approve,'email':email},
			success:function(res) {
				if(res=="1") {
					toastr.success('Eintrag erfolgreich!');
					window.location.reload();
				} else {
					toastr.error(res);
				}
			}
		});
    });
	
	$(document).on('click','.del',function(e) {
      var id = $(this).data('del');
		swal({
			title: "Sind Sie sicher?",
			text: "Der Eintrag wird endgültig gelöscht!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Ja, lösche den Eintrag!",
			closeOnConfirm: true }, function(){
			$.ajax({
				url:url,
				type:"POST",
				dataType:"JSON",
				data:{'req':'delete_notification','id':id},
				success:function(res) {
					if(res=="1") {
						toastr.success('Item deleted successfully');
						window.location.reload();
					} else {
						toastr.error(res);
					}
				}
			});
		});
	});
	
    $(document).on('click','.edit',function(e) {
      var id = $(this).data('edit');
      $.ajax({
        url:url,
        type:"POST",
        dataType:"JSON",
        data:{'req':'get_notifications','id':id},
        success:function(res) {
            $('#frms').html(res);
            $('.editModal').modal('show');
        }
      });
    });

    $(document).on('click','#update',function(e) {
		//e.preventDefault();
		var that = $(this);
		var id = $('#eid').val();
		var email = $('#eemail').val();
		if(email=="") {
			toastr.error('Please enter email');
			return false;
		}
		if($("#enew").prop('checked') == true){
			var newn = "1";
		} else {
			var newn = "0";
		}
		if($("#eapprove").prop('checked') == true){
			var approve = "1";
		} else {
			var approve = "0";
		}
		$(this).prop('disabled','disabled').html('Updating...');
		$.ajax({
			url:url,
			type:"POST",
			dataType:"JSON",
			data:{'req':'update_notification','newn':newn,'approve':approve,'email':email,'id':id},
			success:function(res) {
				if(res=="1") {
					toastr.success('Daten erfolgreich aktualisiert.');
					window.location.reload();
				} else {
					toastr.error(res);
					that.prop('disabled','').html('Update');
				}
			}
		});
    });

		$(document).ready(function(){
		    $("#myModal").on('shown.bs.modal', function(){
		        $(this).find('#email').focus();
		    });

		    $("#benachrichtigung_bearbeiten").on('shown.bs.modal', function(){
		        $(this).find('#eemail').focus();
		    });
		});
  </script>
</body>
</html>
