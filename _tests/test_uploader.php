<?php

require '../vendor/autoload.php';

use Codemim\Uploader\Uploader;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploader = new Uploader();

    if (!$uploader->add($_FILES['files'])) {
        echo $uploader->getFilesError();
    } else {
        $uploader->upload();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="#" enctype="multipart/form-data">
        <input type="file" name="files[]" multiple />
        <button type="submit">Enviar</button>
    </form>
</body>

</html>