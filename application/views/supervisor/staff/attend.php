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
		td {line-height:24px !important;}
	  .eraser {font-weight:bold;}
	  .parent {position:relative;width:60px;top:-9px;}
	  .left {position: absolute;top: 0;width:30px;padding:10px;background-color:#ccc;}
	  .right{position:absolute;width:30px;left:30px;padding:10px;background-color:#ccc;}
	  
	  #buttons .btn {
	    margin-right: .4em;
	    padding: 10px 12px;
	    border-radius: 6px;
	    border-width: 2px;
	    width:100px;
		}

		.selected, .eraser {
	    font-weight:400;
	    border-color: #515356;
		}

		#buttons .btn:hover {
			border-color: #515356;
		}
</style>
</head>
<body class="nav-md">
   <!-- Modal -->
                <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">PDF</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="<?php echo base_url('supervisor/Dashboard/print_report');?>">
                          <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group">
                                <input type="checkbox"  id="allP" > Alle auswählen<br>
                              </div>
                              <?php foreach($staff as $row){?>
                              <div class="form-group">
                                <input type="checkbox" value="<?php echo $row['sid']?>" class="cprint"  name="staff_<?php echo $row['id'];?>"> <?php echo $row["fname"]." ".$row["lname"];?><br>
                              </div>
                              <?php }?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group">
                                Start Datum:<input class="form-control" type="text" name="start_date" id="start_date" autocomplete="off" required/>
                              </div>
                              <div class="form-group">
                                End Datum: <input class="form-control" type="text" name="end_date" id="end_date" autocomplete="off" required/>
                              </div>
                            </div>
                          </div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                      <input type="submit" id="print" class="btn btn-primary" name="submit" value="Drucken"/>
                      </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal fade" id="printModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Druck-Report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form method="post" action="<?php echo base_url('supervisor/Dashboard/print_ctrl');?>">
                          <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group">
                                <input type="checkbox" id="all2"  > Alle auswählen<br>
                              </div>
                              <?php foreach($staff as $row){?>
                              <div class="form-group">
                                <input type="checkbox" value="<?php echo $row['sid']?>" class="all2p" name="staff_<?php echo $row['id'];?>"> <?php echo $row["fname"]." ".$row["lname"];?><br>
                              </div>
                              <?php }?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group">
                                Start Datum:<input class="form-control" type="text" name="start_date" id="start_date2" autocomplete="off" required/>
                              </div>
                              <div class="form-group">
                                End Datum: <input class="form-control" type="text" name="end_date" id="end_date2" autocomplete="off" required/>
                              </div>
                            </div>
                          </div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                      <input type="submit" id="print" class="btn btn-primary" name="submit" value="Drucken"/>
                      </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
  <div class="container body">
    <div class="main_container">
      <?php $this->load->view('includes/header');?>
      <div class="right_col" role="main">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 maxi">
            <div class="x_panel">
              <div class="x_content">
                <div class="row">
                  <div class="col-lg-4">
                    <form id="deptForm" method="post" action="<?php echo base_url('supervisor/attendance');?>">
                      <div class="form-group">
                        <select id="dept" class="form-control" name="dept">
                          <option value="0" <?php if(isset($dept_sel) && $dept_sel=="0"){echo "selected";}?>>--- Auswahl Abteilung ---</option>
                          <option value="1" <?php if(isset($dept_sel) && $dept_sel=="1"){echo "selected";}?>>Alle</option>
   
                          <?php
						  
						
                          $dept_v = array_unique(array_column($dept,'dept'));
						
                          foreach($dept_v as $key=>$val) {?>
                          <option value="<?php echo $val;?>" <?php if(isset($dept_sel) && $dept_sel==$val){echo "selected";}?>><?php echo $val;?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </form>
                  </div>
                  <div class="col-lg-4">
                  </div>
                </div>
                <div class="text-right">
                  <button style="margin-top:32px;margin-bottom: -32px;" class="btn btn-primary" data-toggle="modal" data-target="#printModal2"><i class="fa fa-print"></i> Print</button>
                  <button style="margin-top:32px;margin-bottom: -32px;" class="btn btn-success" data-toggle="modal" data-target="#printModal"><i class="far fa-list-alt"></i> PDF</button>
                </div>

                <div style="margin-bottom: 5px;" class="btn-group" id="buttons">
                  <?php
                    if(count($categories)>0) {

                      echo "<button type='button' class='btn btn-danger' data-erase='0' id='erase'>ENTF</button>";

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
								<pre>&nbsp;</pre>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
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
                        <?php
                          $time=strtotime($s_date);

                          $sendDate=date('d-M-Y', strtotime("-1 month",$time));

                          ?>
                          <th colspan="4"></th>
                        <th>
                          <form id="dateForm" method="POST" action="<?php echo base_url('supervisor/attendance');?>">
                            <input type="hidden" name="s_date" value="<?php echo $sendDate;?>"/>
                            <input type="submit" name="submit" value="<" class="btn btn-default"/>
                          </form>
                        </th>
                        <?php
                        $colspan=31;
                        $datem=31;
                        if(!empty($s_date)) {
                          $datem=date("t",strtotime($s_date));
                        }
                        switch($datem){
                          case 31:
                            $colspan-=2;
                          break;
                          case 30:
                            $colspan-=3;
                          break;
                          case 29:
                            $colspan-=4;
                          break;
                          case 28:
                            $colspan-=5;
                          break;
                        }
                        
                        $checkGermMonth=date("M",strtotime($monthyear));
                        $checkGermYear=date("Y",strtotime($monthyear));
                       switch($checkGermMonth){
                         case "Mar":
                          $checkGermMonth="Mrz";
                         break;
                         case "May":
                          $checkGermMonth="Mai";
                         break;
                         case "Oct":
                          $checkGermMonth="Okt";
                         break;
                         case "Dec":
                          $checkGermMonth="Dez";
                         break;
                         default:
                         $checkGermMonth=$checkGermMonth;
                          break;
                       }
                        ?>
                        <th colspan="<?php echo $colspan;?>" class="text-center"><?php echo $checkGermMonth." ".$checkGermYear ?>
                        </th>
                        <th>
                          <?php
                            $time=strtotime($s_date);
                            $sendDate=date('d-M-Y', strtotime("+1 month",$time));
                            ?>
                          <form id="dateForm" method="POST" action="<?php echo base_url('supervisor/attendance');?>">
                            <input type="hidden" name="s_date" value='<?php echo $sendDate;?>'/>
                            <input type="submit" name="submit" value=">" class="btn btn-default"/>
                          </form>
                        </th>
                      </tr>
                      <tr>
                        <td colspan="4"><strong>Mitarbeiter</strong></td>
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
                          $days="";
                          for($i=$date;$i<=$month_end;$i++)
                          {
                            if(!empty($s_date)) {
                              $date_m=date("m",strtotime($s_date));
                              $date_y=date("Y",strtotime($s_date));
                              $weekDay = date('N', strtotime($i."-".$date_m."-".$date_y));
                              if($weekDay == 6 || $weekDay == 7)
                              {
                                $colorr=$settings["weekend_color"];
                              } else {
                                $colorr="";
                              }


                              $d = $i;
                              $day = date("w",strtotime($d."-".$date_m."-".$date_y));
                              if($day==6) {
                                $days = "SA";
                              } elseif($day==0) {
                                $days = "SO";
                              } elseif($day==1) {
                                $days = "MO";
                              } elseif($day==2) {
                                $days = "DI";
                              } elseif($day==3) {
                                $days = "MI";
                              } elseif($day==4) {
                                $days = "DO";
                              } elseif($day==5) {
                                $days = "FR";
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
                              $d=$i;
                              $day = date("w",strtotime($d."-".$date_m."-".$date_y));
                              if($day=="Sat") {
                                $days = "SA";
                              } elseif($day=="Sun") {
                                $days = "SO";
                              } elseif($day=="Mon") {
                                $days = "MO";
                              } elseif($day=="Tue") {
                                $days = "DI";
                              } elseif($day=="Wed") {
                                $days = "MI";
                              } elseif($day=="Thu") {
                                $days = "DO";
                              } elseif($day=="Fri") {
                                $days = "FR";
                              }

                            }

                          ?>
                        <th class="text-center" style="background-color:<?php echo $colorr; ?>"><?php echo $i."<br>".$days;?></th>
                        <?php } ?>
                      </tr>
                      <tr>
                        <?php
                          $date=date("1");
                          $month_end=date("t");
                          if(!empty($s_date))
                          {
                          $date=date("1",strtotime($s_date));
                          $month_end=date("t",strtotime($s_date));
                          } else {
                          $date=date("1");
                          $month_end=date("t");
                          }
                          ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
						$uniqHolidays=[];
						if(count($public_holidays)>0){
							$holidaysP = [];$stateIds=[];$expForHoliWithStates=[];
							foreach($public_holidays as $p=>$hol) {
								$startdate = date('Y-m-d',strtotime($hol['start_date']));
								$enddate   = date('Y-m-d',strtotime($hol['end_date']));
								$end = new DateTime($enddate);
								$end = $end->modify( '+1 day' ); 
								$period = new DatePeriod(
									 new DateTime($startdate),
									 new DateInterval('P1D'),
									 $end
								);
								foreach ($period as $key => $value) {
									$holidaysP[]=$value->format('Y-m-d');
									$expForHoliWithStates[] = $value->format('Y-m-d')."_".$hol['state_ids'];
								}
								$state_ids = explode(',',$hol['state_ids']);
								foreach($state_ids as $state) {
									$stateIds[] = $state;
								}
							}
						}

						//$uniqStateids = array_unique($stateIds);
						if(!empty($holidaysP)) {
							$uniqHolidays = array_unique($holidaysP);
            }
						$svStates	  = explode(',',$sv_holidays['state_ids']);
						//$svStatesF    = array_intersect($svStates,$uniqStateids);
						
						
					  foreach($staff as $row) { ?>
                      <tr>
                        <td colspan="4" style="white-space:nowrap;"><?php echo $row['lname'].", ".$row['fname'];?></td>
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
                          <?php 
                $fd  = date("Y-m-d",strtotime($date_y.'-'.$date_m.'-'.$i));
								
							
							$weekDay = date('N', strtotime($i."-".$date_m."-".$date_y));
                            $color="";
							if(!empty($uniqHolidays)) {
							if(in_array($fd,$uniqHolidays)) {
								foreach($expForHoliWithStates as $single) {
                  $exp =explode('_',$single);
									if($exp[0]==$fd) {
                    $states = $exp[1];
										$sos = explode(',',$states);
										$fst = array_unique($sos);
										foreach($svStates as $st) {
											if(in_array($st,$fst)) {
												$color = $settings['public_holiday_color'];
											}
										}
										
									}
								}
							}
							}
                            if($weekDay == 6 || $weekDay == 7)
                            {
								$color=$settings["weekend_color"];
                            }

							?>
                        <td style="padding-left:0px;padding-right:0px;width:50px;background-color:<?php echo $color; ?>">
                          <div class="parent">

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
                            <div style="background-color: <?php echo $color;?>" data-c="<?php echo $acat ?>" data-clr="<?php echo $color;?>" class="left half" data-del="0" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div>
                            <?php }else if($astatus=="1") { ?>
                            <div style="background-color: <?php echo $color;?>" data-c="<?php echo $acat ?>" data-clr="<?php echo $color;?>"  class="right half" data-del="1" data-uid="<?php echo $row['sid']?>" data-id="<?php echo $i ." ". $monthYEAR ?>"></div>
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

    $("#start_date").datepicker({autoclose:true});

    $("#end_date").datepicker({autoclose:true});
    $("#start_date2").datepicker({autoclose:true});

    $("#end_date2").datepicker({autoclose:true});

     $("#s_date").datepicker().on("changeDate", function(e) {

          $("#dateForm").submit();

      });

    $("#dept").on("change",function(){

    $("#deptForm").submit();

    });

    $(document).on('click','.btnclr',function() {

      var id = $(this).data('cid');
      $('#erase').removeClass('eraser');
        $.ajax({
          url:"<?php echo base_url('supervisor/dashboard/ajax'); ?>",
          type:"POST",
          dataType:"JSON",
          data:{'req':'setStatus','id':id},
          success:function(res) {
            $('#buttons').html(res);
          }
        });
    });

    $(document).on('click','.half',function() {
        if($('#buttons').find('button.selected').length !== 0) {
          var color = $('#buttons > button.selected').data('color');
          var cid = $('#buttons > button.selected').data('cid');
          var erase = $('#erase').attr('data-erase');
          var uid = $(this).data('uid');
          var pattrn = $(this).data('id');
          var input = $(this).data('del');
          var clr = $(this).attr('data-c');

          if(erase=='1' || erase==1) {
            erase ='1';
            var str = pattrn.substr(0, 2);
            if(str<10) str="0"; else str="";
            var arr = <?php echo json_encode($weekends); ?>;
            <?php
            $p_arr=[]; 
            if(count($uniqHolidays)>0){
              foreach($expForHoliWithStates as $single) {
                  $exp =explode('_',$single);
									$states = $exp[1];
										$sos = explode(',',$states);
										$fst = array_unique($sos);
										foreach($svStates as $st) {
											if(in_array($st,$fst)) {
												$p_arr[]=date("j m Y",strtotime($exp[0]));
											}
										}
								}
            }
            ?>
            var p_arr=<?php echo json_encode($p_arr);?>;
             if($.inArray(str+pattrn,arr)!==-1) {
                $(this).css('background-color','<?php echo $settings["weekend_color"]?>');
             } else {
               if($.inArray(pattrn,p_arr)!==-1){
                 $(this).css('background-color','<?php echo $settings["public_holiday_color"]?>');
               }else{
                 $(this).css('background-color','#ccc');
               }
            }
          } else {
            erase='0';
            $(this).attr('data-c',cid);
            $(this).css('background-color',color);
          }
          $.ajax({
            url:"<?php echo base_url('supervisor/dashboard/ajax');?>",
            type:"POST",
            dataType:"JSON",
            data:{'req':'mark_attendance','uid':uid,'pattern':pattrn,'cid':cid,'input':input,'erase':erase,'clr':clr},
          });
        }
    });

    $(document).on('click','#erase',function(e){
      e.preventDefault();
      $(this).addClass('eraser');
      $("#erase").attr('data-erase',"1");
      if($('#buttons').find('button.selected').length !== 0) {
        var cid = $('#buttons >button.selected').css('font-weight','normal');
        var cid = $('#buttons >button.selected').css('border-color','#fff');
      }
    });

    $("#all2").click(function () {
       $('input:checkbox.all2p').not(this).prop('checked', this.checked);
    });

    $("#allP").click(function () {
       $('input:checkbox.cprint').not(this).prop('checked', this.checked);
    });

  </script>
</body>
</html>
