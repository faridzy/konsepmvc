<?php
namespace App\Models;

use \App\Core\App;
use \App\Models\Model;

class ProductsModel extends Model {

    protected $table = "products";

    public function all() {
        return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category
                             FROM {$this->table}
                             LEFT JOIN categories
                             ON products.category = categories.id
                             ORDER BY products.id");
    }

    public function search($order, $query) {
        if($order == 'quantity') {
            return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category
                                 FROM {$this->table}
                                 LEFT JOIN categories
                                 ON products.category = categories.id
                                 WHERE products.title LIKE ?
                                 ORDER BY products.quantity", [
                "%$query%"
            ]);
        }

        else if($order == 'id') {
            return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category
                                 FROM {$this->table}
                                 LEFT JOIN categories
                                 ON products.category = categories.id
                                 WHERE products.title LIKE ?
                                 ORDER BY products.id", [
                "%$query%"
            ]);
        }

        else if($order == 'price') {
            return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category
                                 FROM {$this->table}
                                 LEFT JOIN categories
                                 ON products.category = categories.id
                                 WHERE products.title LIKE ?
                                 ORDER BY products.price", [
                "%$query%"
            ]);
        }

        else if($order == 'category') {
            return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category
                                 FROM {$this->table}
                                 LEFT JOIN categories
                                 ON products.category = categories.id
                                 WHERE products.title LIKE ?
                                 ORDER BY products.category", [
                "%$query%"
            ]);
        }
    }

    public function value() {
        $elements = $this->query("SELECT * FROM {$this->table}");
        return count($elements);
    }

    public function count() {
        $count = 0;

        foreach($this->query("SELECT quantity FROM {$this->table}") as $item) {
            $count+= $item->quantity;
        }

        return $count;
    }

    public function average($column) {
        $count = $this->value();
        $column_total = 0;

        foreach($this->query("SELECT $column FROM {$this->table}") as $item) {
            $column_total+= $item->$column;
        }

        if($count == 0) {
            return 0;
        }

        else {
            return $column_total / $count;
        }
    }

    public function low($count) {
        return $this->query("SELECT products.id, products.title, products.price, products.quantity, products.media, categories.title AS category
                             FROM {$this->table}
                             LEFT JOIN categories
                             ON products.category = categories.id
                             ORDER BY products.quantity ASC
                             LIMIT $count");
    }

}
