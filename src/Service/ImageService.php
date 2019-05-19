<?php

class ImageService
{
    public function imageOperation($kind, $kindId)
    {
        $filename = $_FILES['imageFile']['name'];
        $path = '../content/images/' . $kind . '/' . $kindId . '/';
        if (!file_exists($path)) {
            mkdir($path);
        }
        $path .= $filename;

        if (!file_exists($path)) {
            $upload = move_uploaded_file($_FILES['imageFile']['tmp_name'], $path);
        } else {
            echo "<div class=\"flash-message text-center alert alert-danger alert-dismissible\" role=\"alert\">";
            echo '<strong>Zdjęcie o podanej nazwie już istnieje!</strong>';
            echo "</div>";
            die();
        }

        return array(
            'path' => $path,
            'upload' => $upload
        );
    }
}
