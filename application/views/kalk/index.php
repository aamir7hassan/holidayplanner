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
                        <th class="text-center">Objektmanager</th>
                        <th class="text-center">Niederlassung</th>
                        <th class="text-center">Bereichsleiter</th>
                        <th class="text-center">Beginn</th>
                        <th class="text-center">Ende</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                    if(isset($objects)){
                    foreach($objects as $object){?>
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
												<td class="text-center">
													<?php 
														$res = $this->model->getData('objects','row_array',$args=['where'=>['ktr_number'=>$object['ktr_number']]]);
														$res2 = $this->model->getData('users','row_array',$args=['where'=>['id'=>$res['created_by']]]);
														echo $res2['fname'] . " " . $res2['lname'];
													?>
												</td>
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

  <?php $this->load->view('includes/foot');?>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/fastclick.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/nprogress.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
  <script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
	<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
  <script>
    var url = "<?php echo base_url('kalk/dashboard/ajax'); ?>";
    $(document).ready(function(){
      $('.tbl').DataTable({
				'columnDefs': [ {
				  'targets': [5],
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
  </script>
</body>
</html>