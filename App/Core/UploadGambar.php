<?php
namespace App\Core;

class UploadGambar {

    public function add($media) {
        $target_dir    = __DIR__ . '/../../public/uploads/';
        $temp          = explode('.', $media['name']);
        $file          = round(microtime(true)) . '.' . end($temp);
        $target_file   = $target_dir . $file;

        if(move_uploaded_file($media["tmp_name"], $target_file)) {
            return $file;
        }

        else {
            throw new \Error("File tidak bisa di load");
        }
    }
    
}
