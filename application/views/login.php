	<?php
		$this->load->view('includes/head');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('assets/css/custom.min.css');
		echo link_tag('assets/css/toastr.min.css');
		echo link_tag('assets/css/animate.min.css');
	?>

	</head>

	<body class="login">

		<div class="login_wrapper">

		<div class="animate form login_form">

          <section class="login_content">

            <form action="<?php echo base_url('login/processLogin'); ?>" method="POST">

              <h1>Login</h1>

              <div>

                <input type="text" name="email" class="form-control" placeholder="E-Mail" required="" autofocus/>

              </div>

              <div>

                <input type="password" name="password" class="form-control" placeholder="Passwort" required="" />

              </div>

              <div>
                <input type="submit" value="Login" class="btn btn-default submit" />
								<a class="reset_pass" href="#" data-toggle="modal" data-target="#myModal">Passwort vergessen?</a>
              </div>


              <div class="clearfix"></div>

            </form>

          </section>

        </div>




    </div>

		<!-- Modal -->

		<div id="myModal" class="modal fade" role="dialog">

		  <div class="modal-dialog">

		    <!-- Modal content-->

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal">&times;</button>

		        <h4 class="modal-title">Wenn Sie Ihre E-Mail Adresse eingeben, wird ein neues Passwort erstellt und an Ihre E-Mail Adresse versendet.</h4>

						<h3 id="recovered"></h3>

		      </div>

		      <div class="modal-body">

		        <form role="form" id="frms">

							<div class="form-group">

								<label class="control-label">E-Mail</label>

								<input type="email" name="remail" id="remail" class="form-control" />

								<span class="error remail text-danger"></span>

							</div>

						</form>

		      </div>

		      <div class="modal-footer">

		        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>

						<a href="#" class="btn btn-primary" id="recover">Neues Passwort anfordern</a>

		      </div>

		    </div>

		  </div>

		</div>

		<?php $this->load->view('includes/foot');?>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/toastr.min.js');?>"></script>

		<script type="text/javascript" src = "<?php echo base_url('assets/js/custom.min.js');?>"></script>



		<script>

		$('#recover').on('click',function(e){

			e.preventDefault();

			var email = $('#remail').val();

			if(email=="") {

				$('.remail').html('Bitte geben Sie eine E-Mail ein!');

				return false;

			}

			$(this).html('...')

			$(this).prop('disabled',true);

			$.ajax({

				url:"<?php echo base_url('login/forgot'); ?>",

				type:"POST",

				dataType:"JSON",

				data:{'email':email},

				success:function(res){

					$('#recover').html('Neues Passwort anfordern');

					$('#recover').prop('disabled',true);
					if(res=="1") {
						toastr.success('Das neue Passwort wurde per E-Mail versandt!');
						$('#remail').val('');
						$('#myModal').modal('hide');
					} else {
						$('#recovered').html(res);
					}
				}

			});

		});

		<?php
			if(isset($_SESSION['data'])) { ?>
				toastr.<?php echo $_SESSION['class'] ?>('<?php echo $_SESSION['data']; ?>');
		<?	}
		?>
		</script>
	</body>
</html>
