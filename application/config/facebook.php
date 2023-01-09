<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//facebook api information goes here


	$config['api_id']       = '1744282192360923';
	$config['api_secret']   = 'affe84d776d839c77d57f5d72ee148af';
	$config['redirect_url'] = base_url().'home/facebook_login';  //change this if you are not using my fb controller
	$config['logout_url']   = base_url();          //User will be redirected here when he logs out.
	$config['permissions']  = array('email','public_profile');
