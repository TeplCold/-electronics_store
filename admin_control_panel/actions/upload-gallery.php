<?php
if ($_FILES['galleryimg']['name'][0]) {

    for ($i = 0; $i < count($_FILES['galleryimg']['name']); $i++) {

        $error_gallery = "";

        if ($_FILES['galleryimg']['name'][$i]) {

            $galleryimgType = $_FILES['galleryimg']['type'][$i]; // тип файла
            $types = array("image/gif", "image/png", "image/jpeg"); // массив допустимых расширений

            // расширение картинки                  
            $imgext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['galleryimg']['name'][$i]));
            //папка для загрузки
            $uploaddir = '../assets/products/';
            //новое сгенерированное имя файла
            $newfilename = $_POST["form_title"] . '-' . $id . rand(1, 100) . '.' . $imgext;
            $newfilename = preg_replace('/[а-я]+/iu', "", $newfilename);
            //путь к файлу (папка.фаил)
            $uploadfile = $uploaddir . $newfilename;

            if (!in_array($galleryimgType, $types)) {
                $error_gallery = "<p id='form-error'>Допустимые расширения - .gif, .jpg, .png</p>";
                $_SESSION['answer'] = $error_gallery;
                continue;
            }

            if (empty($error_gallery)) {

                if (@move_uploaded_file($_FILES['galleryimg']['tmp_name'][$i], $uploadfile)) {

                    mysqli_query($link, "INSERT INTO image_products(products_id,image)
						VALUES(						
                            '" . $id . "',
                            '" . $newfilename . "'                              
						)");
                } else {
                    $_SESSION['answer'] = "Ошибка загрузки фала.";
                }
            }
        }
    }
}
