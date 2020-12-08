<?php

	$config['login_validation']= array(
		array('field'=>'email','label'=>'Email','rules'=>'required|valid_email|trim'),
		array('field'=>'password','label'=>'Password','rules'=>'required|trim')
	);
	

?>
