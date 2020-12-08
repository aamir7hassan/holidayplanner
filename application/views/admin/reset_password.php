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
              <!--<div class="x_title">
                <h2>Add New Supervisor</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a href="" class="btn btn-success" style="color:#fff">Supervisors</a></li>
                </ul>
                <div class="clearfix"></div>
              </div>-->
              <div class="x_content">
                <div class="row">
                  <div class="col-md-12">
                    <form role="form" id="frm" autocomplete="off">
                      <div class="form-group">
                        <label class="control-label">Old Password</label>
                        <input type="password" name="old" autocomplete="off" id="old" class="form-control" />
                        <p class="error eold"></p>
                      </div>
                      <div class="form-group">
                        <label class="control-label">New Password</label>
                        <input type="password" name="new" autocomplete="off" id="new" class="form-control" />
                        <p class="error enew"></p>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Confirm New Password</label>
                        <input type="password" name="cnew" autocomplete="off" id="cnew" class="form-control" />
                        <p class="error ecnew"></p>
                      </div>
                      <div class="form-group">
                        <input type="submit" name="update" id="update" class="btn btn-success" value="Update" />
                      </div>
                    </form>
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
    $(document).on('click','#update',function(e) {
      e.preventDefault();
      var old = $('#old').val();
      var newp = $('#new').val();
      var cnew = $('#cnew').val();
      if(old=="") {
        $('.eold').html('Please enter old password');
        return false;
      }
      if(newp == "") {
        $('.enew').html('Please enter new password');
        return false;
      }
      if(cnew=="") {
        $('.ecnew').html('Please enter confirm new password');
        return false;
      }
      if(newp!=cnew) {
        $('.ecnew').html('New password and confirm new password do not match');
        return false;
      }
      var data = $("#frm").serialize()+ '&req=' + 'process_reset';

      $.ajax({
        url:"<?php echo base_url('admin/dashboard/ajax'); ?>",
        type:"POST",
        dataType:"JSON",
        data:data,
        success:function(res) {
          if(res=="1") {
            toastr.success('Password updated successfully');
						window.location.reload();
          } else {
            toastr.error(res);
          }
        }
      });
    });
  </script>
</body>
</html>
