
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Antrag auf Mehrarbeit</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php 
		echo link_tag('formular/vendor/bootstrap/css/bootstrap.min.css');
		echo link_tag('assets/fontawesome/css/all.css');
		echo link_tag('formular/fonts/iconic/css/material-design-iconic-font.min.css');
		echo link_tag('formular/vendor/animate/animate.css');
		echo link_tag('assets/css/sweetalert.css');
		echo link_tag('formular/vendor/animsition/css/animsition.min.css');
		echo link_tag('formular/vendor/select2/select2.min.css');
		echo link_tag('formular/css/main.css');
	?>
	


	<style type="text/css">
		.checkbox {display: block; padding-left: 20px; line-height: 1.25em;}
		input[type="checkbox"] {margin-right: 6px; margin-left: -20px;}

		h2 {display: block; width: 100%; font-family: Montserrat-Black; font-size: 1.5em; color: #333333; line-height: 1.2; text-align: center; padding-bottom: 1em; margin-top: 3em;}

		.list-group-item2 {
		    display: list-item;
		}
		
		ol p {
			padding: 1em 0.25em;
	    font-family: inherit;
	    font-size: 16px !important;
	    color: #212529;
		}
		.left {
			float:left !important;
		}
		@media print {
		  .hidden-print {
			display: none !important;
		  }
		}

 	.btn-back {
 			font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif !important;
 			font-size: 14px;
 	}

	</style> 
</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" action="<?=base_url('supervisor/processFormular')?>" method="post" id="frm">
				<span class="contact100-form-title">
					<a href="#" onclick="window.history.back()" class="btn btn-info btn-back left hidden-print">Zurück</a>Antrag auf Mehrarbeit
				</span>

				<div class="wrap-input100 validate-input bg1" data-validate="">
					<span class="label-input100">Objekt</span>
					<input class="input100" type="text" name="objekt" required placeholder="" autofocus>
				</div>

				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Name des Mitarbeiters</span>
					<input class="input100" type="text" name="employee" required placeholder="">
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
					<span class="label-input100">Zeitfenster vom</span>
					<input class="input100" type="text" name="zeitfenster_von" required placeholder="">
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
					<span class="label-input100">Zeitfenster bis</span>
					<input class="input100" type="text" name="zeitfenster_bis" required placeholder="">
				</div>

				<div class="wrap-input100 validate-input bg1">
					<span class="label-input100">Anzahl der Stunden am Tag</span>
					<input class="input100" type="number" name="hours" required placeholder="Stunden pro Tag, NICHT über den gesamten Zeitraum">
				</div>

				<div class="wrap-input100 validate-input bg0 rs1-alert-validate" data-validate = "">
					<span class="label-input100">Kurze Begründung/Anmerkung</span>
					<textarea class="input100" name="message" required placeholder="... nicht noch einmal das Objekt eintragen, das steht bereits oben!"></textarea>
				</div>

				<label class="checkbox" style="margin-bottom: 3em;">
				  <input type="checkbox" name="check_box" value="1" />Die Mehrarbeitsstunden werden in Form von Freizeit bis zum Monatsende ausgeglichen.
				</label>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
					<span class="label-input100">Ort</span>
					<input class="input100" type="text" required name="place" placeholder="nur Ort (KEIN Datum eintragen!)">
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100">
					<span class="label-input100">Name des Antragstellers</span>
					<input class="input100" readonly type="text" name="supervisor" placeholder="" value="<?=$this->session->userdata('fname')." ".$this->session->userdata('lname');?>">
				</div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn" id="submit">
						<span>
							Antrag bei der Geschäftsführung einreichen
							<i class="fas fa-long-arrow-alt-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
				</div>

			</form>

			<h2>Hinweise zur Mehrarbeit gemäß Rahmentarifvertrag des Gebäudereinigerhandwerks vom 31.10.2019</h2>

			<div class="container">
				<ol>
					<li>
						<p>Mehrarbeit mit Belastungszuschlag (25%) darf nur mit vorheriger Anordnung des Arbeitgebers oder dessen Beauftragten (z.B. Betriebsleiter) geleistet werden.</p>
					</li>
					<li>
						<p>Die Genehmigung ist grundsätzlich schriftlich einzuholen.</p>
					</li>
					<li>
						<p><span style="text-decoration: underline;">Nicht genehmigte</span> Mehrarbeitsstunden mit Belastungszuschlag werden bei der Lohnabrechnung <span style="text-decoration: underline;">nicht berücksichtigt.</span></p>
					</li>
					<li>
						<p>Die regelmäßige wöchentliche Arbeitszeit beträgt 39 Stunden.</p>
					</li>
					<li>
						<p><span style="font-weight: bold;">Beispiel:</span> Eine Reinigungskraft, die nur an einem Tag für 10 Stunden arbeitet, erhält für die 9. und 10. Stunde den Zuschlag. Ein Ausgleich durch Verkürzung der Arbeitszeit an anderen Tagen ist <span style="text-decoration: underline;">nicht</span> möglich.</p>
					</li>
				</ol>
			</div>
		</div>
	</div>



<!--===============================================================================================-->
	<script src="<?=base_url('formular/vendor/jquery/jquery-3.2.1.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('formular/vendor/animsition/js/animsition.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('formular/vendor/bootstrap/js/popper.js');?>"></script>
	<script type="text/javascript" src = "<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
	<script src="<?=base_url('formular/vendor/bootstrap/js/bootstrap.min.js');?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url('formular/vendor/select2/select2.min.js')?>"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});


			$(".js-select2").each(function(){
				$(this).on('select2:close', function (e){
					if($(this).val() == "Please chooses") {
						$('.js-show-service').slideUp();
					}
					else {
						$('.js-show-service').slideUp();
						$('.js-show-service').slideDown();
					}
				});
			});
		})
	</script>
	<script>
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 1500, 3900 ],
	        connect: true,
	        range: {
	            'min': 1500,
	            'max': 7500
	        }
	    });

	    var skipValues = [
	    document.getElementById('value-lower'),
	    document.getElementById('value-upper')
	    ];

	    filterBar.noUiSlider.on('update', function( values, handle ) {
	        skipValues[handle].innerHTML = Math.round(values[handle]);
	        $('.contact100-form-range-value input[name="from-value"]').val($('#value-lower').html());
	        $('.contact100-form-range-value input[name="to-value"]').val($('#value-upper').html());
	    });
	</script>
<!--===============================================================================================-->
	<script src="<?=base_url('formular/js/main.js');?>"></script>
	<script>
		$(docmuent).on('click','#submit',function(){
			$('#frm').submit();
		});
		
		<?php
			if($this->session->flashdata('data')) {
		?>
			toastr.<?php echo $this->session->flashdata('class') ?>('<?php echo $this->session->flashdata('data') ?>');
		<?php } ?>
	</script>
</body>
</html>
