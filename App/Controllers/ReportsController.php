<?php
namespace App\Controllers;

use \App\Core\App;
use \App\Core\ValidasiForm;
use \App\Core\Pengaturan;
use \App\Core\Mailer;
use \App\Controllers\Controller;
use \App\Models\ReportsModel;
use \DateTime;

class ReportsController extends Controller {

    public function all() {
        $model = new ReportsModel();
        $data  = $model->all();

        $this->render('pages/admin/reports.twig', [
            'title'       => 'Laporan',
            'description' => 'Laporan - Inventory Sederhana',
            'page'        => 'reports',
            'reports'  => $data
        ]);
    }

    public function add() {
        if(!empty($_POST)) {
            $title     = isset($_POST['title']) ? $_POST['title'] : '';
            $validator = new ValidasiForm();
            $validator->notEmpty('title', $title, "Title tidak boleh kosong");

            if($validator->isValid()) {
                $model = new ReportsModel();
                $file  = $model->generate();
                $model->create([
                    'title'       => $title,
                    'file'        => $file,
                    'user'        => $_SESSION['auth']
                ]);

                $content = App::getTwig()->render('mail_report.twig', [
                    'username'    => $_SESSION['auth'],
                    'file'        => $title,
                    'link'        => Pengaturan::getKonfigurasi()['url'] . 'uploads/' . $file,
                    'title'       => Pengaturan::getKonfigurasi()['name'],
                    'description' => Pengaturan::getKonfigurasi()['description']
                ]);

                $mailer = new Mailer();
                $mailer->setFrom(Pengaturan::getKonfigurasi()['mail']['from'], 'Mailer');
                $mailer->addAddress($_SESSION['email']);
                $mailer->Subject = 'Hello ' . $_SESSION['auth'] . ', laporan sudah siap!';
                $mailer->msgHTML($content);
                $mailer->send();

                App::redirect('admin/reports');
            }

            else {
                $this->render('pages/admin/reports_add.twig', [
                    'title'       => 'Tambah laporan',
                    'description' => 'Laporan - Inventory Sederhana',
                    'page'        => 'reports',
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'title'       => $title,
                    ]
                ]);
            }
        }

        else {
            $this->render('pages/admin/reports_add.twig', [
                'title'       => 'Tambah Laporan',
                'description' => 'Laporan - Inventory Sederhana',
                'page'        => 'reports'
            ]);
        }
    }

    public function delete($id) {
        if(!empty($_POST)) {
            $model = new ReportsModel();
            $file  = $model->find($id)->file;
            unlink(__DIR__ . '/../../public/uploads/' . $file);
            $model->delete($id);

            App::redirect('admin/reports');
        }

        else {
            $model = new ReportsModel();
            $data = $model->find($id);
            $this->render('pages/admin/reports_delete.twig', [
                'title'       => 'Delete laporan',
                'description' => 'Laporan - Inventory Sederhana',
                'page'        => 'reports',
                'data'        => $data
            ]);
        }
    }

}
