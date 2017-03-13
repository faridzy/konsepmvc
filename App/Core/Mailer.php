<?php

namespace App\Core;

use \PHPMailer;
/**
* 
*/
class Mailer extends PHPMailer
{
	

	public function __construct(){
		parent::__construct();
		$this->isSMTP();
		$this->Host =Pengaturan::getKonfigurasi()['mail']['host'];
		$this->Username=Pengaturan::getKonfigurasi()['username']['host'];
		$this->Password = Pengaturan::getKonfigurasi()['password']['host'];
		$this->Port =Pengaturan::getKonfigurasi()['port']['host'];
		$this->SMTPOptions = array(
	            'ssl' => array(
	                'verify_peer'       => false,
	                'verify_peer_name'  => false,
	                'allow_self_signed' => true
	            )
	        );

	}
}
