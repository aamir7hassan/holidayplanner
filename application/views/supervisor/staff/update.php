	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/nprogress.css');
		echo link_tag('assets/css/green.css');
		echo link_tag('assets/css/bootstrap-progressbar-3.3.4.min.css');
		echo link_tag('assets/css/custom.min.css');
		echo link_tag('assets/css/style.css');
	?>
	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<?php $this->load->view('includes/header');?>
				<div class="right_col" role="main">
					<div class="form-group">
					<form action="<?php echo base_url('supervisor/dashboard/update_staff');?>" method="POST">
						<input type="hidden" name="id" id="id" value="<?php echo $staff['id'];?>"/>
								<div class="form-group">
									<label for="firstname">
										Vorname:
									</label>
									<input type="text" class="form-control" value="<?php echo $staff['fname'];?>" name="firstname" required/>
								</div>
								<div class="form-group">
									<label for="laststname">
										Nachname:
									</label>
									<input type="text" class="form-control" value="<?php echo $staff['lname'];?>" name="lastname" required/>
								</div>
								<div class="form-group">
									<label for="email">
										E-Mail:
									</label>
									<input type="email" class="form-control" id="email" placeholder="optional" value="<?php echo $staff['email'];?>" name="email" />
									<p class="chk hidden text-success bold"><span>Checking availability...</span></p>
								</div>
								<div class="form-group">
									<label for="phone">
										Telefon:
									</label>
									<input type="text" class="form-control" placeholder="optional" value="<?php echo $staff['phone'];?>" name="per_phone" />
								</div>
								<div class="form-group">
									<label for="department">
										Abteilung:
									</label>
									<input type="text" class="form-control" placeholder="optional" name="dept" value="<?php echo $staff['department'];?>" />
								</div>
								<!--<div class="form-group">
									<label for="holidays">
										Holiday Entitlement Per Year:
									</label>
									<input type="number" value="<?php echo $holiday['holiday_ent'] ?>" id="holiday_ent" min="0.0" step="0.5" class="form-control" name="holiday_ent" required/>
								</div>
								<div class="form-group">
									<input type="button" id="plus5" onClick="add_five()" class="btn btn-secondary" value="+0.5"/>
									<input type="button" id="min5"  onclick="sub_five()" class="btn btn-danger" value="-0.5"/>
								</div>
								<div class="form-group">
									<label for="holidays">
										Year:
									</label>
									<input type="number" class="form-control" name="year" id="year" min="0" step="1" value="<?php echo $holiday['year'] ?>" />
								</div>-->
								<div class="form-group">
									<a href="../list-staff/" class="btn btn-info" title="Zur&uuml;ck">Zur&uuml;ck</a>
									<input type="submit" class="btn btn-success" name="submit" value="Speichern"/>
								</div>
							</form>
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
		<script type="text/javascript" src = "<?php echo base_url('assets/js/Chart.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/gauge.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/bootstrap-progressbar.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/icheck.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/skycons.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.flot.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.flot.pie.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.flot.time.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.flot.stack.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.flot.resize.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.flot.orderBars.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.flot.spline.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/curvedLines.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/date.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.vmap.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/jquery.vmap.world.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/moment.min.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/daterangepicker.js');?>"></script>
		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>
		<script>
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
				$('.chk').removeClass('hidden');
				var email = $(this).val();
				var id = $('#id').val();
				$.ajax({
					url:"<?php echo base_url('supervisor/dashboard/ajax') ?>",
					type:"POST",
					dataType:"JSON",
					data:{'req':'chk_email_update','email':email,'id':id},
					success:function(res) {
						$('.chk').html(res);
					}
				});
			});
		</script>
	</body>
</html>
