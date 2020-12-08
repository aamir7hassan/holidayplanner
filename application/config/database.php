<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$active_group = 'default';
	$query_builder = TRUE;

	$db['default'] = array(
		'dsn'	=> '',
		'hostname' => 'db5000292313.hosting-data.io',
		'username' => 'dbu120941',
		'password' => 'AFKCnR8db%2020',
		'database' => 'dbs285560',
		'dbdriver' => 'mysqli',
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => (ENVIRONMENT !== 'production'),
		'cache_on' => FALSE,
		'cachedir' => '',
		'char_set' => 'utf8',
		'dbcollat' => 'utf8_general_ci',
		'swap_pre' => '',
		'encrypt' => FALSE,
		'compress' => FALSE,
		'stricton' => FALSE,
		'failover' => array(),
		'save_queries' => TRUE
	);
