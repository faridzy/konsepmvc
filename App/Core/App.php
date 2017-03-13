<?php
namespace App\Core;

use \App\Core\Pengaturan;
use \App\Controllers\Controller;

/**
 * summary
 */
class App
{
    /**
     * summary
     */
    private static $database;
    private static $twig;
    public function __construct()
    {
    	if(Pengaturan::getKonfigurasi()['debug']){
    		error_reporting(E_ALL);
    		ini_set('display_errors',1);
    	}
    	else {
    		error_reporting(0);
    		ini_set('display_errors',0);
    	}
        
    }
    public static function getDb(){
    	if(self::$database===null){
    		self::$database = new Database(
    			Pengaturan::getKonfigurasi()['database']['name'],
                Pengaturan::getKonfigurasi()['database']['username'],
                Pengaturan::getKonfigurasi()['database']['password'],
                Pengaturan::getKonfigurasi()['database']['host']
    			);
    	}
    	return self::$database;
    }
    public static function getTwig() {
        if(self::$twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/views');

            self::$twig = new \Twig_Environment($loader, [
                'cache' => Pengaturan::getKonfigurasi()['twig']['cache']
            ]);

            $asset = new \Twig_SimpleFunction('asset', function ($path) {
                return Pengaturan::getKonfigurasi()['url'] . 'assets/' . $path;
            });

            $excerpt = new \Twig_SimpleFunction('excerpt', function ($content, $size = 300) {
                return substr($content, 0, $size) . '...';
            });

            $url = new \Twig_SimpleFunction('url', function ($slug, $id = null, $post_type = null) {
                return Pengaturan::getKonfigurasi()['url'] . $slug;
            });

            $pad = new \Twig_SimpleFunction('pad', function ($value, $size = 5) {
                $s = $value . "";
                while (strlen($s) < $size) $s = "0" . $s;
                return $s;
            });

            $title = new \Twig_SimpleFunction('title', function ($title = null) {
                if($title) return $title . ' - ' . Pengaturan::getKonfigurasi()['name'];
                else return Pengaturan::getKonfigurasi()['name'];
            });


            self::$twig->addFunction($asset);
            self::$twig->addFunction($excerpt);
            self::$twig->addFunction($url);
            self::$twig->addFunction($title);
            self::$twig->addFunction($pad);

            isset($_SESSION['auth']) ? self::$twig->addGlobal('auth', $_SESSION['auth']) : self::$twig->addGlobal('auth', '');
        }

        return self::$twig;
    }

    public static function error() {
        header("HTTP/1.0 404 Not Found");
        $controller = new \App\Controllers\Controller();
        $controller->render('pages/404.twig', []);
    }

    public static function redirect($path = '') {
        $location = 'Location: ' . Pengaturan::getKonfigurasi()['url'] . $path;
        header($location);
    }

    public static function secured() {
        if(!isset($_SESSION['auth'])) {
            self::redirect('signin');
            exit;
        }
    }
}
