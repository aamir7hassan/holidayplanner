<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
<style>

html,
body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #f1f1f1;
}

/* What it does: Stops email clients resizing small text. */
* {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}

/* What it does: Centers email on Android 4.4 */
div[style*="margin: 16px 0"] {
    margin: 0 !important;
}

/* What it does: Stops Outlook from adding extra spacing to tables. */
table,
td {
    mso-table-lspace: 0pt !important;
    mso-table-rspace: 0pt !important;
}

/* What it does: Fixes webkit padding issue. */
table {
    border-spacing: 0 !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    margin: 0 auto !important;
}

/* What it does: Uses a better rendering method when resizing images in IE. */
img {
    -ms-interpolation-mode:bicubic;
}

/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
a {
    text-decoration: none;
}

/* What it does: A work-around for email clients meddling in triggered links. */
*[x-apple-data-detectors],  /* iOS */
.unstyle-auto-detected-links *,
.aBn {
    border-bottom: 0 !important;
    cursor: default !important;
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
.a6S {
    display: none !important;
    opacity: 0.01 !important;
}

/* What it does: Prevents Gmail from changing the text color in conversation threads. */
.im {
    color: inherit !important;
}

/* If the above doesn't work, add a .g-img class to any image in question. */
img.g-img + div {
    display: none !important;
}

/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
/* Create one of these media queries for each additional viewport size you'd like to fix */

/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
    u ~ div .email-container {
        min-width: 320px !important;
    }
}
/* iPhone 6, 6S, 7, 8, and X */
@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
    u ~ div .email-container {
        min-width: 375px !important;
    }
}
/* iPhone 6+, 7+, and 8+ */
@media only screen and (min-device-width: 414px) {
    u ~ div .email-container {
        min-width: 414px !important;
    }
}

</style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
<style>

.primary{
	background: #f3a333;
}

.bg_white{
	background: #ffffff;
}
.bg_light{
	background: #fafafa;
}
.bg_dark2{
	background: rgba(0,0,0,.8);
}
.email-section{
	padding:2.5em;
}

/*BUTTON*/
.btn{
	padding: 10px 15px;
}
.btn.btn-primary{
	border-radius: 30px;
	background: #f3a333;
	color: #ffffff;
}



h1,h2,h3,h4,h5,h6{
	font-family: 'Playfair Display', serif;
	color: #000000;
	margin-top: 0;
}

body{
	font-family: 'Montserrat', sans-serif;
	font-weight: 400;
	font-size: 15px;
	line-height: 1.8;
	color: rgba(0,0,0,.4);
}

a{
	color: #f3a333;
}

table{
}
/*LOGO*/

.logo h1{
	margin: 0;
}
.logo h1 a{
	color: #000;
	font-size: 20px;
	font-weight: 700;
	text-transform: uppercase;
	font-family: 'Montserrat', sans-serif;
}


/*HEADING SECTION*/
.heading-section{
}
.heading-section h2{
	color: #000000;
	font-size: 28px;
	margin-top: 0;
	line-height: 1.4;
}
.heading-section .subheading{
	margin-bottom: 20px !important;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(0,0,0,.4);
	position: relative;
}
.heading-section .subheading::after{
	position: absolute;
	left: 0;
	right: 0;
	bottom: -10px;
	content: '';
	width: 100%;
	height: 2px;
	background: #f3a333;
	margin: 0 auto;
}

.heading-section-white{
	color: rgba(255,255,255,.8);
}
.heading-section-white h2{
	font-size: 28px;
	font-family: 
	line-height: 1;
	padding-bottom: 0;
}
.heading-section-white h2,.heading-section-white h3{
	color: #ffffff;
}
.heading-section-white .subheading{
	margin-bottom: 0;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(255,255,255,.4);
}
.tbl {
	border:1px solid #000;
	padding:5px;
}
table tr td {
	text-align:left;
	padding-left: 10px;
}


.icon{
	text-align: center;
}
.icon img{
}


/*SERVICES*/
.text-services{
	padding: 10px 10px 0; 
	text-align: center;
}
.text-services h3{
	font-size: 20px;
}





@media screen and (max-width: 500px) {

	.icon{
		text-align: left;
	}

	.text-services{
		padding-left: 0;
		padding-right: 20px;
		text-align: left;
	}

}

</style>


</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #fff;">
	<center style="width: 100%; background-color: #fff;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
      &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
    	<!-- BEGIN BODY -->
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
				<tr>
		      <td class="bg_white">
		        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
		          <tr>
		            <td class="bg_dark email-section" style="text-align:center;">
		            	<div class="heading-section heading-section-white">
						<?php 
							// sending to supervisor
							if(isset($adminS) && $adminS=='approval') {
						?>
							<?php 
								if(isset($manager) && $manager=="manager") {
							?>
							<p style="color:#000; text-align: left; margin-bottom: 1em;">[Mitteilung für Sie als ausgewählten Manager]</p>
								<?php } else { ?>
								<p style="color:#000; text-align: left; margin-bottom: 1em;">[Ihr Antrag wurde genehmigt.]</p>
								<?php } ?>

							<h3 style="color:#000; text-align: left;">Antrag auf Mehrarbeit</h3>
								
							<table class="tbl" role="presentation" cellspacing="1" cellpadding="1" border="1" width="100%">
							<tr>
								<td style="color:#000">Objekt</td>
								<td style="color:#000"><?php echo $object;?></td>
							</tr>
							<tr>
								<td style="color:#000">Mitarbeiter</td>
								<td style="color:#000"><?=$employee_name?></td>
							</tr>
							<tr>
								<td style="color:#000">vom</td>
								<td style="color:#000"><?=$time_from?></td>
							</tr>
							<tr>
								<td style="color:#000">bis</td>
								<td style="color:#000"><?=$time_untill?></td>
							</tr>
							<tr>
								<td style="color:#000">Stunden/Tag</td>
								<td style="color:#000"><?=$no_of_hours?></td>
							</tr>
							<tr>
								<td style="color:#000">Begründung</td>
								<td style="color:#000"><?=$justification?></td>
							</tr>
							<tr>
								<td style="color:#000">Ort, Datum</td>
								<td style="color:#000"><?=$place?>, <?=date('d.m.Y H:i',strtotime($date_created))?></td>
							</tr>
							<tr>
								<td style="color:#000">Antragsteller</td>
								<td style="color:#000"><?php echo $applicants_name;?></td>
							</tr>
							<tr>
								<td>Ausgleich</td>
								<td><?php
									$chk =$check_box;
									if($chk=="1") {
										echo "Ja";
									} else {
										echo "Nein";
									}
								?>
								</td>
							</tr>
							<?php 
								if(isset($manager) && $manager=="manager") {
							?>

							<tr>
								<td style="color:#000">Link</td>
								<td style="color:#000"><a href="<?=base_url('manager/antrag-auf-mehrarbeit/unchecked')?>">Alle ungeprüften Anträge</a></td>
							</tr>

								<?php }  ?>



						</table><br></br>
							
								<?php  } else if(isset($adminS) && $adminS=='rejection') { ?>
							<p style="color:#000">Ihr Antrag wurde abgelehnt.</p>
							<?php 
								if(!empty($reason)) {
									echo '<h2>Begründung:</h2><p>'.$reason.'</p>';
								}
							?>
								<h3 style="color:#000; text-align: left;">Antrag auf Mehrarbeit</h3>
						<table class="tbl" role="presentation" cellspacing="1" cellpadding="1" border="1" width="100%">
							<tr>
								<td style="color:#000">Objekt</td>
								<td style="color:#000"><?php echo $object;?></td>
							</tr>
							<tr>
								<td style="color:#000">Mitarbeiter</td>
								<td style="color:#000"><?=$employee_name?></td>
							</tr>
							<tr>
								<td style="color:#000">vom</td>
								<td style="color:#000"><?=$time_from?></td>
							</tr>
							<tr>
								<td style="color:#000">bis</td>
								<td style="color:#000"><?=$time_untill?></td>
							</tr>
							<tr>
								<td style="color:#000">Stunden/Tag</td>
								<td style="color:#000"><?=$no_of_hours?></td>
							</tr>
							<tr>
								<td style="color:#000">Begründung</td>
								<td style="color:#000"><?=$justification?></td>
							</tr>
							<tr>
								<td style="color:#000">Ort, Datum</td>
								<td style="color:#000"><?=$place?>, <?=date('d.m.Y H:i',strtotime($date_created))?></td>
							</tr>
							<tr>
								<td style="color:#000">Antragsteller</td>
								<td style="color:#000"><?php echo $applicants_name;?></td>
							</tr>
							<tr>
								<td>Ausgleich</td>
								<td><?php
									$chk =$check_box;
									if($chk=="1") {
										echo "Ja";
									} else {
										echo "Nein";
									}
								?>
								</td>
							</tr>
							
						</table> <br><br>			
						<?php } else { ?>
							<p style="color:#000; text-align: left; margin-bottom: 1em;">[Eingangsbestätigung]</p>
							<h3 style="color:#000; text-align: left;">Antrag auf Mehrarbeit</h3>
						<table class="tbl" role="presentation" cellspacing="1" cellpadding="1" border="1" width="100%">
							<tr>
								<td style="color:#000">Objekt</td>
								<td style="color:#000"><?php echo $object;?></td>
							</tr>
							<tr>
								<td style="color:#000">Mitarbeiter</td>
								<td style="color:#000"><?=$employee_name?></td>
							</tr>
							<tr>
								<td style="color:#000">vom</td>
								<td style="color:#000"><?=$time_from?></td>
							</tr>
							<tr>
								<td style="color:#000">bis</td>
								<td style="color:#000"><?=$time_untill?></td>
							</tr>
							<tr>
								<td style="color:#000">Stunden/Tag</td>
								<td style="color:#000"><?=$no_of_hours?></td>
							</tr>
							<tr>
								<td style="color:#000">Begründung</td>
								<td style="color:#000"><?=$justification?></td>
							</tr>
							<tr>
								<td style="color:#000">Ort, Datum</td>
								<td style="color:#000"><?=$place?>, <?=date('d.m.Y H:i',strtotime($date_created))?></td>
							</tr>
							<tr>
								<td style="color:#000">Antragsteller</td>
								<td style="color:#000"><?php echo $applicants_name;?></td>
							</tr>
							<tr>
								<td>Ausgleich</td>
								<td><?php
									$chk =$check_box;
									if($chk=="1") {
										echo "Ja";
									} else {
										echo "Nein";
									}
								?>
								</td>
							</tr>
							<?php 
								if($status=="admin") {
							?>
							<tr>
								<td style="color:#000">Link</td>
								<td style="color:#000"><a href="<?=base_url('admin/antrag-auf-mehrarbeit/pending')?>">Alle offenen Anträge</a></td>
							</tr>
							<?php } ?>
						</table> <br><br>
						<?php } ?>
		            	</div>
		            </td>
		          </tr><!-- end: tr -->
		        </table>

		      </td>
		    </tr><!-- end:tr -->
      <!-- 1 Column Text + Button : END -->
      </table>
    </div>
  </center>
</body>
</html>