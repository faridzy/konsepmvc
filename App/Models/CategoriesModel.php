<?php
namespace App\Models;

use \App\Core\App;
use \App\Models\Model;

class CategoriesModel extends Model {

    protected $table = "categories";

    public function allotment() {
        $categories = $this->all();
        $categories_value = [];

        foreach($categories as $category) {
            $count = count($this->query("SELECT id FROM products WHERE category = ?", [$category->id]));

            $quantity = 0;
            foreach($this->query("SELECT quantity FROM products WHERE category = ?", [$category->id]) as $product) {
                $quantity+= $product->quantity;
            }

            $categories_value[] = [
                'name'     => $category->title,
                'count'    => $count,
                'quantity' => $quantity
            ];
        }

        return $categories_value;
    }

}
