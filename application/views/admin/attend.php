<?php
  $this->load->view('includes/head');
  echo link_tag('assets/fontawesome/css/all.css');
  echo link_tag('assets/css/nprogress.css');
  echo link_tag('assets/css/green.css');
  echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
  echo link_tag('assets/css/jqvmap.min.css');
  echo link_tag('assets/css/daterangepicker.css');
  echo link_tag('assets/datatables/jquery.dataTables.min.css');
  echo link_tag('assets/css/custom.min.css');
?>
<style>
  .eraser {
    font-weight:bold;
  }
  .parent {
    position:relative;
  }
  .left {
    position: absolute;
    top: 0;
    max-width:18px;
    padding:10px;
    background-color:#ccc;
  }
  .right{
    position:absolute;
    min-width:22px;
    left:20px;
    padding:10px;
    background-color:#ccc
  }
</style>

</head>
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php $this->load->view('includes/header');?>
      <div class="right_col" role="main">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="x_panel">
              <div class="x_content">
                <div class="btn-group" id="buttons">
                  <?php
                    if(count($categories)>0) {
                      echo "<button type='button' class='btn btn-danger' data-erase='0' id='erase'>Erase</button>";
                    }
                    foreach($categories as $key=>$val) {
                      if($val['status']=="1"){
                        $font = "bolder";
                        $class="selected";
                      } else {
                        $font="";$class="";
                      }
                  ?>
                  <button type="button" data-cid="<?php echo $val['id']; ?>" class="btn btnclr <?php echo $class; ?>" data-color="<?php echo $val['color'] ?>" style="background-color:<?php echo $val['color'] ?>;font-weight:<?php echo $font ?>;color:#000"><?php echo ucwords($val['name']) ?></button>
                <?php } ?>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered tbl">
                    <thead>
                      <tr>
                        <th colspan="2" rowspan="2"></th>
                        <?php
                        $date=date("t");
                        $monthyear = date('M Y');
                        $monthYEAR = date('m Y');
                        ?>
                        <th colspan="<?php echo $date;?>" class="text-center"><?php echo $monthyear ?></th>
                      </tr>
                      <tr>
                        <?php
                          $date=date("1");
                          $month_end=date("t");
                          for($i=$date;$i<=$month_end;$i++)
                          {
                        ?>
                        <th><?php echo date("$i");?></th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($staff as $row) { ?>
                      <tr>
                        <td colspan="2"><?php echo $row['fname']." ".$row['lname'];?></td>
                        <?php
                        $date=date("1");
                        $month_end=date("t");
                        $chk_date=date("Y-m-d");
                        $pattern=explode(",",$row['pattern']);
                        $arr = [];
                        for($i=1;$i<=$month_end;$i++)
                        {
                          $color=""; $status="";
                          foreach($pattern as $k) {
                            $chk = explode(" ",$k);
                            if($i==$chk[0]){
                              array_push($arr,$k);
                            }
                          }
                        ?>
                        <td style="padding-left:0px;padding-right:0px;width:50px">
                          <div class="parent">
                            <div class="left half" data-del="0" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div>
                            <div class="right half" data-del="1" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div>
                          <?php  foreach($arr as $k=>$val) {
                              $v = explode(" ",$val);
                              $adate = $v[0];$amonth = $v[1];$ayear=[2];$acat = $v[3];$astatus = $v[4];
                              $color_key  = array_search($acat,array_column($categories,'id'));
                              $color = $categories[$color_key]['color'];
                              if($i==$adate) {
                            ?>

                          <?php if($astatus=="0") { ?>
                          <div style="background-color: <?php echo $color;?>" class="left half" data-del="0" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div>
                          <!-- <div class="right half" data-del="1" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div> -->
                        <?php }else if($astatus=="1") { ?>
                          <!-- <div class="left half" data-del="0" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div> -->
                          <div style="background-color: <?php echo $color;?>"  class="right half" data-del="1" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div>
                        <?php } else { ?>

                      <?php } } else {  ?>

                      <?php } }// end foreach?>

                      </div>
                        </td>
                      <?php  } // end for ?>
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
  <?php $this->load->view('includes/foot');?>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
  <script>
  //$(".tbl").DataTable();
  $(document).on('click','.btnclr',function() {
    var id = $(this).data('cid');
    $('#erase').removeClass('eraser');
      $.ajax({
        url:"<?php echo base_url('admin/dashboard/ajax'); ?>",
        type:"POST",
        dataType:"JSON",
        data:{'req':'setStatus','id':id},
        success:function(res){
          $('#buttons').html(res);
        }
      });
  });

  $(document).on('click','.half',function() {
      if($('#buttons').find('button.selected').length !== 0) {
        var color = $('#buttons >button.selected').data('color');
        var cid = $('#buttons >button.selected').data('cid');
        var erase = $('#erase').data('erase');
        console.log(erase);
        if(erase=='1'){
          erase ='1';
          $(this).css('background-color','#ccc');
        } else {
          erase='0';
          $(this).css('background-color',color);
        }

        var uid = $(this).data('uid');
        var pattrn = $(this).data('id');
        var input = $(this).data('del');
        $.ajax({
          url:"<?php echo base_url('admin/dashboard/ajax');?>",
          type:"POST",
          dataType:"JSON",
          data:{'req':'mark_attendance','uid':uid,'pattern':pattrn,'cid':cid,'input':input,'erase':erase}
        });
      }
    });

    $(document).on('click','#erase',function(e){
      e.preventDefault();
      $(this).addClass('eraser');
      $("#erase").attr('data-erase',"1");
      if($('#buttons').find('button.selected').length !== 0) {
        var cid = $('#buttons >button.selected').css('font-weight','normal');

      }
    });


</script>
</body>
</html>
