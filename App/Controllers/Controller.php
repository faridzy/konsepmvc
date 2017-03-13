<?php
namespace App\Controllers;

use \App\Core\App;
/**
* 
*/
class Controller 
{
	public function render($template,$attributes){
		echo App::getTwig()->render($template,$attributes);
	}
}
