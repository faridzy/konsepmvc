<?php
namespace App\Controllers;

use \App\Core\App;
use \App\Core\ValidasiForm;
use \App\Core\Pengaturan;
use \App\Controllers\Controller;
use \App\Models\CategoriesModel;
use \App\Models\RevisionsModel;
use \DateTime;

class CategoriesController extends Controller {

    //Menampilkan semua kategori
    public function all() {
        //membuat object baru $model dari Categories Model
        $model = new CategoriesModel();
        //assign value dari fungsi all di model
        $data  = $model->all();
        //mengarahkan ke halaman categories
        $this->render('pages/admin/categories.twig', [
            'title'       => 'Kategori ',
            'description' => 'Kategori - inventory Sederhana.',
            'page'        => 'categories',
            'categories'  => $data
        ]);
    }
    //fungsi tambah kategori
    public function add() {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            //Membuat object untuk validasi
            $validator = new ValidasiForm();
            //memanggil fungsi notEmpty 
            $validator->notEmpty('title', $title, "Judul tidak boleh kosong");
            $validator->notEmpty('description', $description, "Deskripsi tidak boleh kosong");

            //Cek Kondisi validasi
            if($validator->isValid()) {
                $model = new CategoriesModel();
                $model->create([
                    'title'       => $title,
                    'description' => $description
                ]);

                App::redirect('admin/categories');
            }

            else {
                $this->render('pages/admin/categories_add.twig', [
                    'title'       => 'Tambah Kategori',
                    'description' => 'Kategori - Inventory Sederhana.',
                    'page'        => 'categories',
                    //menampilkan pesan error bila validasi gagal
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'title'       => $title,
                        'description' => $description
                    ]
                ]);
            }
        }

        else {
            $this->render('pages/admin/categories_add.twig', [
                'title'       => 'Tambah Kategori',
                'description' => 'Kategori -Inventory Sederhana.',
                'page'        => 'categories'
            ]);
        }
    }
    //edit data kategori
    public function edit($id) {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';

            $validator = new ValidasiForm();
            $validator->notEmpty('title', $title, "judul tidak boleh kosong");
            $validator->notEmpty('description', $description, "Deskripsi tidak boleh kosong");

            if($validator->isValid()) {
                $model = new CategoriesModel();
                $model->update($id, [
                    'title'       => $title,
                    'description' => $description
                ]);

                $revisions = new RevisionsModel();
                $revisions->create([
                    'type'    => 'categories',
                    'type_id' => $id,
                    'user'    => $_SESSION['auth']
                ]);

                App::redirect('admin/categories');
            }

            else {
                $model = new RevisionsModel();
                $revisions = $model->revisions($id, 'categories');

                $this->render('pages/admin/categories_edit.twig', [
                    'title'       => 'Edit Kategori',
                    'description' => 'Kategori - Inventory Sederhana.',
                    'page'        => 'categories',
                    'revisions'   => $revisions,
                    'errors'      => $validator->getErrors(),
                    'data'        => [
                        'title'       => $title,
                        'description' => $description
                    ]
                ]);
            }
        }

        else {
            $model = new CategoriesModel();
            $data = $model->find($id);

            $model2    = new RevisionsModel();
            $revisions = $model2->revisions($id, 'categories');

            $this->render('pages/admin/categories_edit.twig', [
                'title'       => 'Edit Kategori',
                'description' => 'Kategori-Inventory Sederhana.',
                'page'        => 'categories',
                'revisions'   => $revisions,
                'data'        => $data
            ]);
        }
    }
    //hapus data
    public function delete($id) {
        if(!empty($_POST)) {
            $model = new CategoriesModel();
            //hapus data dengan peramater $id
            $model->delete($id);

            App::redirect('admin/categories');
        }

        else {
            $model = new CategoriesModel();
            $data = $model->find($id);
            $this->render('pages/admin/categories_delete.twig', [
                'title'       => 'Hapus Kategori',
                'description' => 'Kategori- Inventory Sederhana.',
                'page'        => 'categories',
                'data'        => $data
            ]);
        }
    }

    public function single($id, $slug) {
        $model = new CategoriesModel();
        $data  = $model->find($id);

        if($data->slug === $slug) {
            $this->render('pages/single.twig', [
                'title'       => 'Single',
                'description' => 'Inventory Sederhana.',
                'page'        => 'products',
                'post' => $data
            ]);
        }

        else {
            App::error();
        }
    }

    public function api($id = null) {
        if($id) {
            $model = new CategoriesModel();
            $data  = $model->find($id);

            header('Content-Type: application/json');
            echo json_encode($data);
        }

        else {
            $model = new CategoriesModel();
            $data  = $model->all();

            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

}
