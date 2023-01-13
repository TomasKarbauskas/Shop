<?php

trait UploadFiles
{
    public function upload(array $files, string $uploadDir): string
    {
        if ($files['name']) {
            move_uploaded_file($files['tmp_name'], "$uploadDir/{$files['name']}");
        }
        return $files['name'];
    }
}