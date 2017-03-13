<?php
namespace App\Models;

use \App\Core\App;
use \App\Models\Model;

class UsersModel extends Model {

    protected $table = "users";

    public function login($username, $password) {
        $user = App::getDb()->prepare('SELECT * FROM users WHERE username = ?', [$username], true);

        if($user) {
            if($user->password === $password) {
                $_SESSION['auth'] = $user->id;

                return true;
            }
        }

        return false;
    }

    public static function logged(){
        if(!isset($_SESSION['auth'])) {
            App::redirect('signin');
            exit;
        }
    }

}
