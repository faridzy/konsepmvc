<?php

namespace App\Core;

use Symfony\Component\Yaml\Yaml;

class Pengaturan{
	public static $config = null;
	private static $environment = null;

	public static function getKonfigurasi(){
		if(self::$config=== null){
			//memasukkan file config.yml
			$config_file = Yaml::parse((
				file_get_contents(dirname(__DIR__).'/config.yml')));
			self::$environment=$config_file['environment'];
			self::$config=$config_file[self::$environment];
			//jika config.yml tidak bisa diload
			if(!self::$config)
				throw new Exception("Configurasi file tidak bisa di load");
		}
		return self::$config;
	} 
}
