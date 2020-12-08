<?php
  $this->load->view('includes/head');
  echo link_tag('assets/fontawesome/css/all.css');
  echo link_tag('assets/css/nprogress.css');
  echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
  echo link_tag('assets/datatables/jquery.dataTables.min.css');
  echo link_tag('assets/css/toastr.min.css');
  echo link_tag('assets/css/bootstrap-colorpicker.min.css');
  echo link_tag('assets/css/sweetalert.css');
  echo link_tag('assets/css/custom.min.css');
  echo link_tag('assets/css/style.css');

?>
<style>
  .clr {
    height:20px;width:20px;
  }
  span.week {
    margin-left: 20px;
    margin-top: -4px;
  }
  .weekday {
    display:inline-flex;
  }
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
                <h2>Farben bearbeiten</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <!--<div class="row">
                  <div class="col-md-3 col-sm-3 col-lg-3">
                    <div class="x_panel">
                      <div class="x_content">
                        <h3>Farbe Wochenende</h3>-->
                        <div class="weekday" style="margin-top:10px;">
                          <p class="clr" style="background-color:<?php echo $item['weekend_color']; ?>"></p>
                          <span class="week"><a href="#" id="weekende" class="btn btn-default btn-sm">Wochenende</a></span>
                        </div>
                				<div class="clearfix"></div>
												<div class="weekday" style="margin-top:1em;">
                          <p class="clr" style="background-color:<?php echo $item['public_holiday_color']; ?>"></p>
                          <span class="week"><a href="#" id="holiday" class="btn btn-default btn-sm">Ferien & Feiertage</a></span>
                        </div>
                      <!--</div>
                    </div>
                  </div>-->
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
  <!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="weekendModal" class="modal fade" role="dialog" tabindex='-1'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Farbe Wochenende</h4>
      </div>
      <div class="modal-body">
        <form role="form">
          <input type="hidden" id="cid" value="" />
          <label class="control-label"></label>
          <div class="input-group picker colorpicker-element">
            <input type="text" value="rgb(224, 26, 181)" class="form-control" name="color" id="color">
            <span class="input-group-addon"><i style="background-color: rgb(224, 26, 181);"></i></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn-primary" id="weeksave" data-dismiss="modal">Speichern</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal -->
<div id="holidayModal" class="modal fade" role="dialog" tabindex='-1'>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Farbe Ferien & Feiertage</h4>
      </div>
      <div class="modal-body">
        <form role="form">
          <input type="hidden" id="hid" value="" />
          <label class="control-label"></label>
          <div class="input-group picker colorpicker-element">
            <input type="text" value="rgb(224, 26, 181)" class="form-control" name="color" id="holidayc">
            <span class="input-group-addon"><i style="background-color: rgb(224, 26, 181);"></i></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn-primary" id="holidaysave" data-dismiss="modal">Speichern</button>
      </div>
    </div>

  </div>
</div>
  <?php $this->load->view('includes/foot');?>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-colorpicker.min.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
  <script>
  var url ="<?php echo base_url('admin/dashboard/ajax'); ?>";
 $(".picker").colorpicker();

    $(document).on('click','#weekende',function(){
      $.ajax({
        url : url,
        type : "POST",
        dataType : "JSON",
        data : {'req':'get_weekday'},
        success:function(res) {
            $('#cid').val(res.id);
            $(".picker").colorpicker("destroy");
            $(".picker").colorpicker({
              "color":res.weekend_color,
            });
            $('#ecolor,#eedit').val(res.weekend_color);
            $('#weekendModal').modal('show');
        }
      });
    });
	
	 $(document).on('click','#holiday',function(){
      $.ajax({
        url : url,
        type : "POST",
        dataType : "JSON",
        data : {'req':'get_weekday'},
        success:function(res) {
            $('#hid').val(res.id);
             $(".picker").colorpicker("destroy");
            $(".picker").colorpicker({
              "color":res.public_holiday_color,
            });
            $('#ecolor,#eedit').val(res.public_holiday_color);
            $('#holidayModal').modal('show');
        }
      });
    });
	
	$(document).on('click','#holidaysave',function() {
      var color = $('#holidayc').val();
      var id = $('#hid').val();
      if(color=="") {
        toastr.error('Please select color');
        return false;
      }
      $(this).prop('disabled',true).html('Saving...');
      var that = $(this);
      $.ajax({
        url : url,
        type : "POST",
        dataType : "JSON",
        data : {'req':'update_holiday_color','color':color,'id':id},
        success:function(res){
          if(res=="1"){
            $('#holidayModal').modal('hide');
            toastr.success('Holiday color updated successfully');
						window.location.reload();
          } else {
            toastr.error(res);
          }
        }
      });
    });


    $(document).on('click','#weeksave',function() {
      var color = $('#color').val();
      var id = $('#cid').val();
      if(color=="") {
        $('.name').html('Please select color');
        return false;
      }
      $(this).prop('disabled',true);
      $(this).html('Saving...');
      $.ajax({
        url : url,
        type : "POST",
        dataType : "JSON",
        data : {'req':'update_weekday','color':color,'id':id},
        success:function(res){
          if(res=="1"){
            $('#addModal').modal('hide');
            toastr.success('weekend color updated successfully');
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
