
	<?php 
		$url = current_url();
		$exp = explode('/',$url);
	?>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <ul class="nav navbar-nav">
                <?php
                  if($this->session->userdata('role')=='admin') {
                ?>
                  <li <?php echo in_array('dashboard',$exp)?"class='active'":"";?>><a href="<?php echo base_url('admin/dashboard');?>"><i class="fa fa-th-large"></i> Dashboard </a></li>
				  				<li <?php 
												if (in_array('supervisors',$exp) OR  in_array('managers',$exp) OR in_array('objektmanagers',$exp))
													echo "class='dropdown active'";
												else {
													echo"class='dropdown'";
												}
											?>><a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-users"></i> Benutzerkonten <span class="caret"></span></a>
										<ul class="dropdown-menu">
										 	<li><a href="<?=base_url('admin/supervisors');?>">Bereichsleiter</a></li>
										  <li><a href="<?=base_url('admin/managers');?>">Lohnmanager</a></li>
										  <li><a href="<?=base_url('admin/objektmanagers');?>">Objektmanager</a></li>
										</ul>
								  </li>
                  <li <?php echo in_array('staff',$exp)?"class='active'":"";?>><a href="<?php echo base_url('admin/staff');?>"><i class="fa fa-user"></i> Mitarbeiter </a></li>
				   				<li <?php echo in_array('objekte',$exp)?"class='active'":"";?>><a href="<?php echo base_url('admin/objekte');?>"><i class="fa fa-home"></i> Objekte </a></li>
				  				<li <?php echo in_array('checklisten',$exp)?"class=' dropdown active'":"class='dropdown'";?>><a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="far fa-calendar-check"></i> Checklisten <span class="caret"></span></a>
										<ul class="dropdown-menu">
										  <?php /*<li><a href="<?=base_url('admin/checklisten');?>">Übersicht</a></li>*/ ?>
										 	<li><a href="<?=base_url('admin/checklisten/open');?>">Offen</a></li>
										  <li><a href="<?=base_url('admin/checklisten/checked');?>">Abgegeben</a></li>
										  <li style="border-top:1px solid #000;"><a href="<?=base_url('admin/checklisten/locked');?>">Unbearbeitet gesperrt</a></li>
										  <li style="border-top:1px solid #000;"><a href="<?=base_url('admin/checklisten/erstellen');?>">Quartalslisten erstellen</a></li>
										</ul>
								  </li>
								  <li <?php echo in_array('antrag-auf-mehrarbeit',$exp)?"class=' dropdown active'":"class='dropdown'";?>><a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user-clock"></i> Antrag auf Mehrarbeit <span class="caret"></span></a>
										<ul class="dropdown-menu">
										  <li><a href="<?=base_url('admin/antrag-auf-mehrarbeit/pending');?>">Offen</a></li>
										  <li><a href="<?=base_url('admin/antrag-auf-mehrarbeit/approved');?>">Genehmigt</a></li>
										  <li style="border-top:1px solid #000;"><a href="<?=base_url('admin/antrag-auf-mehrarbeit/rejected');?>">Abgelehnt</a></li>
										</ul>
								  </li>
									<li <?php 
												if (in_array('public-holidays',$exp) OR  in_array('settings',$exp) OR in_array('categories',$exp) OR in_array('notification',$exp))
													echo "class='dropdown active'";
												else {
													echo"class='dropdown'";
												}
											?>><a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cogs"></i> Einstellungen <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="<?=base_url('admin/public-holidays');?>">Ferien & Feiertage</a></li>
										  <li><a href="<?=base_url('admin/settings');?>">Farben</a></li>
										  <li><a href="<?=base_url('admin/categories');?>">Kategorien</a></li>
										  <li style="border-top:1px solid #000;"><a href="<?=base_url('admin/notification');?>">Benachrichtigungen</a></li>
										</ul>
									</li>
	                <?php } else if($this->session->userdata('role')=='supervisor') { ?>
	                <?php
										$style_dashboard = "class='dropdown'";
										$style_list_staff = "class='dropdown'";

										if (in_array('dashboard',$exp) AND in_array('list_staff',$exp)) {
											$style_list_staff = "class='dropdown active'";
										}
										else if (in_array('dashboard',$exp)) {
											$style_dashboard = "class='dropdown active'";
										}
	                ?>
                  <li <?php echo $style_dashboard;?>><a href="<?php echo base_url('supervisor/dashboard');?>"><i class="fa fa-home"></i> Dashboard </a></li>
                  <li <?php echo in_array('attendance',$exp)?"class='active'":"";?>><a href="<?php echo base_url('supervisor/attendance');?>"><i class="far fa-calendar-alt"></i> Urlaubsplaner </a></li>
                  <li <?php echo in_array('list-staff',$exp)?"class='active'":"";?>><a href="<?php echo base_url('supervisor/list-staff');?>"><i class="fa fa-users"></i> Mitarbeiter </a></li>
									<li <?php echo in_array('checklisten',$exp)?"class='dropdown active'":"class='dropdown'";?>><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="far fa-calendar-check"></i> Checklisten <span class="caret"></span></a>
										<ul class="dropdown-menu">
										 	<?php /*<li><a href="<?=base_url('supervisor/checklisten/');?>">All</a></li>*/?>
										 	<li><a href="<?=base_url('supervisor/checklisten/open');?>">Offen</a></li>
										  <li><a href="<?=base_url('supervisor/checklisten/checked');?>">Abgegeben</a></li>
										  <li style="border-top:1px solid #000;"><a href="<?=base_url('supervisor/checklisten/locked');?>">Unbearbeitet gesperrt</a></li>
										</ul>
									</li>
				  <li <?php 
							if (in_array('antrag-auf-mehrarbeit',$exp))
								echo "class='dropdown active'";
							else {
								echo"class='dropdown'";
							}
						?>><a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user-clock"></i> Antrag auf Mehrarbeit <span class="caret"></span></a>
					<ul class="dropdown-menu">
					 <li><a href="<?=base_url('supervisor/antrag-auf-mehrarbeit/pending');?>">Offen</a></li>
					  <li><a href="<?=base_url('supervisor/antrag-auf-mehrarbeit/approved');?>">Genehmigt</a></li>
					  <li style="border-top:1px solid #000;"><a href="<?=base_url('supervisor/antrag-auf-mehrarbeit/rejected');?>">Abgelehnt</a></li>
					  <li style="border-top:1px solid #000;"><a href="<?=base_url('supervisor/add-antrag-auf-mehrarbeit');?>">Neuer Antrag</a></li>
					</ul>
				</li>
				  <li <?php 
							if (in_array('public-holidays',$exp) OR in_array('categories',$exp) OR in_array('notification',$exp))
								echo "class='dropdown active'";
							else {
								echo"class='dropdown'";
							}
						?>><a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cogs"></i> Einstellungen <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?=base_url('supervisor/public-holidays');?>">Ferien & Feiertage</a></li>
					</ul>
				</li>
				  <!--<li><a href="<?=base_url('supervisor/add-antrag-auf-mehrarbeit');?>"><i class="fa fa-plus"></i> Antrag auf Mehrarbeit </a></li>-->
				  
				  
                <?php } else if($this->session->userdata('role')=='manager') { ?>
		
					 <li <?php echo in_array('antrag-auf-mehrarbeit',$exp)?"class=' dropdown active'":"class='dropdown'";?>><a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user-clock"></i> Antrag auf Mehrarbeit <span class="caret"></span></a>
					<ul class="dropdown-menu">
					  <li><a href="<?=base_url('manager/antrag-auf-mehrarbeit/unchecked');?>">Ungeprüft</a></li>
					  <li><a href="<?=base_url('manager/antrag-auf-mehrarbeit/checked');?>">Überprüft</a></li>
					</ul>
				  </li>
				  
				<?php } else if($this->session->userdata('role')=='objektmanager') { ?>
		
					 <li <?php echo in_array('objektmanager',$exp)?"class='active'":"";?>><a href="<?php echo base_url('objektmanager');?>"><i class="fa fa-home"></i> Objekte </a></li>
				  
				<?php }
				
				 else if($this->session->userdata('role')=='kalk') { ?>
		
					 <li <?php echo in_array('kalk',$exp)?"class='active'":"";?>><a href="<?php echo base_url('kalk');?>"><i class="fa fa-home"></i> Objekte </a></li>
				  
				<?php } ?>

              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><?php
                	$admin_name = "";
                	if($this->session->userdata('role')=='admin') {$admin_name = ' class="admin_name"';}
                	echo '<div' . $admin_name . '>' . $this->session->userdata('fname')." ".$this->session->userdata('lname') . '</div>'; ?><a href="<?php echo base_url('logout');?>" class="menu_logout"> <i class="fa fa-sign-out-alt"></i></a></li>
              </ul>
            </nav>
          </div>
          <div class="clearfix"></div>
        </div>
        <!-- /top navigation -->
		
