<?php
namespace App\Controllers;

use \App\Core\App;
use \App\Core\Pengaturan;
use \App\Core\ValidasiForm;
use \App\Controllers\Controller;
use \App\Models\UsersModel;
use \App\Core\Mailer;

class UsersController extends Controller {

    public function all() {
        $model = new UsersModel();
        $data  = $model->all();

        $this->render('pages/admin/users.twig', [
            'title'       => 'Users',
            'description' => 'Users - Just a simple inventory management system.',
            'page'        => 'users',
            'users'    => $data
        ]);
    }

    public function add() {
        if(!empty($_POST)) {
            $username              = isset($_POST['username']) ? $_POST['username'] : '';
            $email                 = isset($_POST['email']) ? $_POST['email'] : '';
            $password              = isset($_POST['password']) ? $_POST['password'] : '';
            $password_verification = isset($_POST['password_verification']) ? $_POST['password_verification'] : '';

            $validator = new ValidasiForm();
            $validator->validUsername('username', $username, "Your username is not valid (no spaces, uppercase, special character)");
            $validator->availableUsername('username', $username, "Your username is not available");
            $validator->validEmail('email', $email, "Your email is not valid");
            $validator->validPassword('password', $password, $password_verification, "You didn't write the same password twice");

            if($validator->isValid()) {
                $model = new UsersModel();
                $model->create([
                    'username' => $username,
                    'email'    => $email,
                    'password' => hash('sha256', Pengaturan::getKonfigurasi()['salt'] . $password)
                ]);

                $content = App::getTwig()->render('mail_new.twig', [
                    'username'    => $username,
                    'password'    => $password,
                    'title'       => Pengaturan::getKonfigurasi()['name'],
                    'description' => Pengaturan::getKonfigurasi()['description'],
                    'link'        => Pengaturan::getKonfigurasi()['url'] . 'signin'
                ]);

                $mailer = new Mailer();
                $mailer->setFrom(Pengaturan::getKonfigurasi()['mail']['from'], 'Mailer');
                $mailer->addAddress($email);
                $mailer->Subject = 'Hello ' . $username . ', welcome on board!';
                $mailer->msgHTML($content);
                $mailer->send();

                App::redirect('admin/users');
            }

            else {
                $this->render('pages/admin/users_add.twig', [
                    'title'       => 'Add user',
                    'description' => 'Users - Just a simple inventory management system.',
                    'page'        => 'users',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'username' => $username,
                        'email'    => $email
                    ]
                ]);
            }
        }

        else {
            $this->render('pages/admin/users_add.twig', [
                'title'       => 'Add user',
                'description' => 'Users - Just a simple inventory management system.',
                'page'        => 'users'
            ]);
        }
    }

    public function edit($id) {
        if(!empty($_POST)) {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $email    = isset($_POST['email']) ? $_POST['email'] : '';

            $validator = new FormValidator();
            $validator->validUsername('username', $username, "Your username is not valid (no spaces, uppercase, special character)");
            $validator->validEmail('email', $email, "Your email is not valid");

            if($validator->isValid()) {
                $model = new UsersModel();
                $model->update($id, [
                    'username' => $username,
                    'email'    => $email
                ]);

                if($_SESSION['id'] == $id) {
                    $this->logout();
                    App::redirect('signin');
                }

                else {
                    App::redirect('admin/users');
                }
            }

            else {
                $this->render('pages/admin/users_edit.twig', [
                    'title'       => 'Edit user',
                    'description' => 'Users - Just a simple inventory management system.',
                    'page'        => 'users',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'username' => $username,
                        'email'    => $email
                    ]
                ]);
            }
        }

        else {
            $model = new UsersModel();
            $data = $model->find($id);

            $this->render('pages/admin/users_edit.twig', [
                'title'       => 'Edit user',
                'description' => 'Users - Just a simple inventory management system.',
                'page'        => 'users',
                'data'        => $data
            ]);
        }
    }

    public function delete($id) {
        if(!empty($_POST)) {
            $model = new UsersModel();
            $model->delete($id);

            App::redirect('admin/users');
        }

        else {
            $model = new UsersModel();
            $data = $model->find($id);
            $this->render('pages/admin/users_delete.twig', [
                'title'       => 'Delete user',
                'description' => 'Users - Just a simple inventory management system.',
                'page'        => 'users',
                'data'        => $data
            ]);
        }
    }

    public function login() {
        if(!empty($_POST)) {
            $model = new UsersModel();

            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? hash('sha256', Pengaturan::getKonfigurasi()['salt'] . $_POST['password']) : '';

            if($model->login($username, $password)) {
                $user = $model->query("SELECT * FROM users WHERE username = ?", [
                    $username
                ], true);

                $_SESSION['auth']  = $username;
                $_SESSION['id']    = $user->id;
                $_SESSION['email'] = $user->email;

                App::redirect('admin/dashboard');
            }

            else {
                $errors = [
                    "Your username and your password don't match."
                ];
            }
        }

        $this->render('pages/signin.twig', [
            'title'       => 'Sign in',
            'description' => 'Sign in to the dashboard',
            'errors'      => isset($errors) ? $errors : ''
        ]);
    }

    public function logout() {
        session_destroy();
        App::redirect();
    }

}
