<?php
namespace App\Controllers;

use \App\Core\App;
use \App\Core\UploadGambar;
use \App\Core\Pengaturan;
use \App\Controllers\Controller;
use \App\Models\RevisionsModel;
use \App\Models\CategoriesModel;
use \App\Models\ProductsModel;
use \App\Models\ReportsModel;
use \App\Core\ValidasiForm;

class ProductsController extends Controller {

    public function blank() {
        $this->render('pages/index.twig', [
            'title'       => 'Home',
            'description' => 'Inventory - Sederhana.'
        ]);
    }

    public function index() {
        $model = new ProductsModel();
        $value = $model->value();
        $count = $model->count();
        $average_quantity = $model->average('quantity');
        $average_price    = $model->average('price');
        $lows_products    = $model->low(5);

        $model2 = new CategoriesModel();
        $categories_value = $model2->allotment();

        $model3  = new ReportsModel();
        $reports = $model3->all();

        $stats = [
            'value' => $value,
            'count' => $count,
            'average_quantity' => round($average_quantity),
            'average_price'    => '$' .round($average_price, 2),
            'lows_products'    => $lows_products,
            'reports'          => $reports
        ];

        $this->render('pages/admin/dashboard.twig', [
            'title'       => 'Dashboard',
            'description' => 'Inventory -Sederhana.',
            'page'        => 'dashboard',
            'stats'       => $stats
        ]);
    }

    public function all() {
        $model = new ProductsModel();
        $data  = $model->all();
        $count = count($data);

        $this->render('pages/admin/products.twig', [
            'title'       => 'Produk',
            'description' => 'Produk - Inventory Sederhana.',
            'page'        => 'products',
            'products'    => $data,
            'count'       => $count
        ]);
    }

    public function add() {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $category    = isset($_POST['category']) ? $_POST['category'] : '';
            $price       = isset($_POST['price']) ? (int) $_POST['price'] : '';
            $quantity    = isset($_POST['quantity']) ? (int) $_POST['quantity'] : '';
            $media       = isset($_FILES['media']) ? $_FILES['media'] : '';

            $validator = new ValidasiForm();
            $validator->notEmpty('title', $title, "Judul tidak boleh kosong");
            $validator->notEmpty('description', $description, "Deskripsi tidak boleh kosong");
            $validator->validCategory('category', $category, "Kategori harus alid");
            $validator->isNumeric('price', $price,'Isikan harus angka');
            $validator->isInteger('quantity', $quantity, "Isikan harus angka");
            $validator->validImage('media', $media, "Media tidak valid");

            if($validator->isValid()) {
                $upload    = new UploadGambar();
                $media_url = $upload->add($media);

                $model = new ProductsModel();
                $model->create([
                    'title'       => $title,
                    'description' => $description,
                    'category'    => $category,
                    'price'       => $price,
                    'quantity'    => $quantity,
                    'media'       => $media_url
                ]);

                App::redirect('admin/products');
            }

            else {
                $model = new CategoriesModel();
                $categories  = $model->all();
                $this->render('pages/admin/products_add.twig', [
                    'title'       => 'Tambah Produk',
                    'description' => 'Produk - Inventory Sederhana.',
                    'page'        => 'products',
                    'errors'      => $validator->getErrors(),
                    'categories'  => $categories,
                    'data'        => [
                        'title'       => $title,
                        'description' => $description,
                        'price'       => $price,
                        'quantity'    => $quantity
                    ]
                ]);
            }
        }

        else {
            $model = new CategoriesModel();
            $categories  = $model->all();
            $this->render('pages/admin/products_add.twig', [
                'title'       => 'Tambah Produk',
                'description' => 'Produk- Inventory Sederhana.',
                'page'        => 'products',
                'categories'  => $categories
            ]);
        }
    }

    public function edit($id) {
        if(!empty($_POST)) {
            $title       = isset($_POST['title']) ? $_POST['title'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $category    = isset($_POST['category']) ? $_POST['category'] : '';
            $price       = isset($_POST['price']) ? (int) $_POST['price'] : '';
            $quantity    = isset($_POST['quantity']) ? (int) $_POST['quantity'] : '';

            $validator = new ValidasiForm();
            $validator->notEmpty('title', $title, "Judul tidak boleh kosong");
            $validator->notEmpty('description', $description, "Deskripsi tidak boleh kosong");
            $validator->validCategory('category', $category, "Kategori harus alid");
            $validator->isNumeric('price', $price,'Isikan harus angka');
            $validator->isInteger('quantity', $quantity, "Isikan harus angka");
            
            if($validator->isValid()) {
                $model = new ProductsModel();
                $model->update($id, [
                    'title'       => $title,
                    'description' => $description,
                    'category'    => $category,
                    'price'       => $price,
                    'quantity'    => $quantity
                ]);

                $revisions = new RevisionsModel();
                $revisions->create([
                    'type'    => 'products',
                    'type_id' => $id,
                    'user'    => $_SESSION['auth']
                ]);

                App::redirect('admin/products');
            }

            else {
                $model = new CategoriesModel();
                $categories  = $model->all();

                $model2 = new RevisionsModel();
                $revisions = $model2->revisions($id, 'products');

                $this->render('pages/admin/products_add.twig', [
                    'title'       => 'Edit Produk',
                    'description' => 'Produk - Inventory Sederhana',
                    'page'        => 'products',
                    'errors'      => $validator->getErrors(),
                    'revisions'   => $revisions,
                    'categories'  => $categories,
                    'data'        => [
                        'title'       => $title,
                        'description' => $description,
                        'price'       => $price,
                        'quantity'    => $quantity,
                        'category'    => $category
                    ]
                ]);
            }
        }

        else {
            $model = new CategoriesModel();
            $categories  = $model->all();

            $model2 = new ProductsModel();
            $data   = $model2->find($id);

            $model3 = new RevisionsModel();
            $revisions = $model3->revisions($id, 'products');

            $this->render('pages/admin/products_edit.twig', [
                'title'       => 'Edit Produk',
                'description' => 'Produk - Inventory Sederhana.',
                'page'        => 'products',
                'revisions'   => $revisions,
                'data'        => $data,
                'categories'  => $categories
            ]);
        }
    }

    public function delete($id) {
        if(!empty($_POST)) {
            $model = new ProductsModel();
            $file  = $model->find($id)->media;
            unlink(__DIR__ . '/../../public/uploads/' . $file);
            $model->delete($id);

            App::redirect('admin/products');
        }

        else {
            $model = new ProductsModel();
            $data  = $model->find($id);
            $this->render('pages/admin/products_delete.twig', [
                'title'       => 'Delete Produk',
                'description' => 'Produk - Inventory Sederhana',
                'page'        => 'products',
                'data'        => $data
            ]);
        }
    }

    public function search($get) {
        $query = isset($get['query']) ? $get['query'] : '';
        $order = isset($get['order']) ? $get['order'] : '';

        $model = new ProductsModel();
        $data  = $model->search($order, $query);

        echo json_encode($data);
    }

    public function api($id = null) {
        if($id) {
            $model = new ProductsModel();
            $data  = $model->find($id);

            $data->media = Pengaturan::getKonfigurasi()['url'] . 'uploads/' . $data->media;;

            header('Content-Type: application/json');
            echo json_encode($data);
        }

        else {
            $model = new ProductsModel();
            $data  = $model->all();

            foreach($data as $key => $element) {
                $data[$key]->media = Pengaturan::getKonfigurasi()['url'] . 'uploads/' . $data[$key]->media;
            }

            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    public function stats() {
        $model = new ProductsModel();
        $value = $model->value();
        $count = $model->count();
        $average_quantity = $model->average('quantity');
        $average_price    = $model->average('price');
        $lows_products    = $model->low(5);

        $model2 = new CategoriesModel();
        $categories_value = $model2->allotment();

        $stats = [
            'value' => $value,
            'count' => $count,
            'average_quantity' => $average_quantity,
            'average_price'    => $average_price,
            'categories'       => $categories_value,
            'lows_products'    => $lows_products
        ];

        echo json_encode($stats);
    }

}
