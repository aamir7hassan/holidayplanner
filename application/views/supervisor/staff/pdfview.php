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
  echo link_tag('assets/css/style.css');
   echo link_tag('assets/css/bootstrap-datepicker.min.css');
?>
<style>
.eraser {
  font-weight:bold;
}
.parent {
  position:relative;
  width:60px;
}
.left {
  position: absolute;
  top: 0;
  width:30px;
  padding:10px;
  background-color:#ccc;
}
.right{
  position:absolute;
  width:30px;
  left:30px;
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
          <div class="col-lg-12 col-md-12 colsm-12">
            <div class="x_panel">
              <div class="x_content">
                <div style="margin-bottom: 5px;" class="btn-group" id="buttons">
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
                <br>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered tbl">
                    <thead>
                      <tr>
                        <th colspan="2" rowspan="2"></th>
                        <?php
                        $date=date("t");
                        $monthyear = date('M Y');
                        $monthYEAR = date('m Y');
                        $day=date("D");
						if(!empty($s_date))
						{
							$monthyear=date("M Y",strtotime($s_date));
                          $monthYEAR=date("m Y",strtotime($s_date));
                          $day=date("D",strtotime($s_date));
						}
						else
						{
                          $monthyear = date('M Y');
                        $monthYEAR = date('m Y');
						}
                        ?>
                        <th colspan="<?php echo $date;?>" class="text-center"><?php echo $monthyear ?></th>
                      </tr>
                      <tr>
                        <?php
                          $date=date("1");
                          $month_end=date("t");
						if(!empty($s_date))
						{
							$date=date("1",strtotime($s_date));
                          $month_end=date("t",strtotime($s_date));
						}
						else
						{
                          $date=date("1");
                          $month_end=date("t");
						}

                          for($i=$date;$i<=$month_end;$i++)
                          {
                            if(!empty($s_date)) {
                              $date_m=date("m",strtotime($s_date));
                              $date_y=date("Y",strtotime($s_date));
                              $weekDay = date('N', strtotime($i."-".$date_m."-".$date_y));
                              if($weekDay == 6 || $weekDay == 7)
                              {
                              $colorr=$settings["weekend_color"];
                              }else {
                                $colorr="";
                              }
                            } else {
                              $date_m=date("m");
                              $date_y=date("Y");
                              $date = $i."-".$date_m."-".$date_y;
                              $weekDay = date('N', strtotime($date));
                              if($weekDay == 6 || $weekDay == 7)
                              {
                              $colorr=$settings["weekend_color"];
                            } else {
                              $colorr="";
                            }
                            }
                        ?>
                        <th style="background-color:<?php echo $colorr; ?>"><?php echo date("$i");?></th>
                        <?php } ?>
                      </tr>
                      <tr>
                        <th colspan="2" rowspan="2"></th>
                        <?php
                          $date=date("1");
                          $month_end=date("t");
            if(!empty($s_date))
            {
              $date=date("1",strtotime($s_date));
                          $month_end=date("t",strtotime($s_date));
            }
            else
            {
                          $date=date("1");
                          $month_end=date("t");
            }


                          for($i=$date;$i<=$month_end;$i++)
                          {
                            $day = date("D",strtotime($i-"1"."-".$monthyear."-".$monthYEAR));
                            if($day=='Sat' || $day=='Sun')
                              $colorr=$settings["weekend_color"];
                            else
                            $colorr="";
                         ?>
                        <th style="background-color: <?php echo $colorr?>" colspan="<?php echo $date;?>" class="text-center"><?php echo "&nbsp;"."&nbsp;".date("D",strtotime($i-"1"."-".$monthyear."-".$monthYEAR))."&nbsp;"."&nbsp;"  ;?></th>
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
						$date_y=date("Y");
						$date_m=date("m");
						if(!empty($s_date))
						{
							$date=date("1",strtotime($s_date));
                          $month_end=date("t",strtotime($s_date));
						  $date_m=date("m",strtotime($s_date));
						  $date_y=date("Y",strtotime($s_date));
						}
						else
						{
                          $date=date("1");
                          $month_end=date("t");
						}
                        $chk_date=date("Y-m-d");
                        $pattern=explode(",",$row['pattern']);
                        $arr = [];
                        for($i=$date;$i<=$month_end;$i++)
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
							 <?php $weekDay = date('N', strtotime($i."-".$date_m."-".$date_y));

							  if($weekDay == 6 || $weekDay == 7)
							  {
							  $color=$settings["weekend_color"];
							  } ?>
                            <div style="background-color: <?php echo $color;?>" class="left half" data-del="0" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div>
                            <div style="background-color: <?php echo $color;?>" class="right half" data-del="1" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div>
                          <?php  foreach($arr as $k=>$val) {
                              $v = explode(" ",$val);
                              $adate = $v[0];$amonth = $v[1];$ayear=$v[2];$acat = $v[3];$astatus = $v[4];
                              $color_key  = array_search($acat,array_column($categories,'id'));
                              $color = $categories[$color_key]['color'];

                              if($i==$adate && $amonth==$date_m && $ayear==$date_y) {
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
  <script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
  <script>
  $("#print").click(function(){
    if ($("input[type=checkbox]:checked").length == 0)
        alert("No Staff Member Selected!");
});
  $("#start_date").datepicker();
  $("#end_date").datepicker();
   $("#s_date").datepicker().on("changeDate", function(e) {
        $("#dateForm").submit();
    });
	$("#dept").on("change",function(){
	$("#deptForm").submit();
	});
  //$(".tbl").DataTable();
  $(document).on('click','.btnclr',function() {
    var id = $(this).data('cid');
    $('#erase').removeClass('eraser');
      $.ajax({
        url:"<?php echo base_url('supervisor/dashboard/ajax'); ?>",
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
        var uid = $(this).data('uid');
        var pattrn = $(this).data('id');
        var input = $(this).data('del');

        if(erase=='1'){
          erase ='1';
          var str = pattrn.substr(0, 2);
          if(str<10) str="0"; else str="";
          var arr = <?php echo json_encode($weekends); ?>;
           if($.inArray(str+pattrn,arr)!==-1) {

           } else {
            $(this).css('background-color','#ccc');
          }
        } else {
          erase='0';
          $(this).css('background-color',color);
        }

        $.ajax({
          url:"<?php echo base_url('supervisor/dashboard/ajax');?>",
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
