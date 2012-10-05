<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

	$request = new Request(array('restful' => true));

	//

	$id_product = 0;

	if (isset($_REQUEST['id_product'])) {

		$id_product = $_REQUEST['id_product'];

	} else {

		if (isset($request->params->id_product)) {

			$id_product = $request->params->id_product;

		}
	}

//------------------------------------------------------------------------------
// $square_size - максимальный размер картинки
// $thumb_path - путь к каталогу куда сохранить уменьшенное изображение

function create_thumb ($square_size, $img_file, $ori_path, $thumb_path, $img_type) {

    $path = $ori_path;
    $img = $path.$img_file;

    switch ($img_type) {
        case "image/jpeg":
            $img_src = @imagecreatefromjpeg($img);
            break;
        case "image/png":
            $img_src = @imagecreatefrompng($img);
            break;
        case "image/x-png":
            $img_src = @imagecreatefrompng($img);
            break;
        case "image/gif":
            $img_src = @imagecreatefromgif($img);
            break;
    }

    $img_width = imagesx($img_src);
    $img_height = imagesy($img_src);

    if ($img_width == $img_height) {

        $tmp_width = $square_size;
        $tmp_height = $square_size;

    } else if ($img_height < $img_width) {

        $tmp_height = $square_size;
        $tmp_width = intval(($img_width / $img_height) * $square_size);

        if ($tmp_width % 2 != 0) {

            $tmp_width++;

        }
    } else if ($img_height > $img_width) {

        $tmp_width = $square_size;
        $tmp_height = intval(($img_height / $img_width) * $square_size);

        if ($tmp_height % 2 != 0) {

            $tmp_height++;

        }
    }
 
    $img_new = imagecreatetruecolor($tmp_width, $tmp_height);

    imagecopyresampled(
		$img_new,
		$img_src,
		0, 0, 0, 0,
		$tmp_width,
		$tmp_height,
		$img_width,
		$img_height
	);

	// путь к создаваемой картинке
    $thumb = $thumb_path.$img_file;

    switch ($img_type) {
        case "image/jpeg":
            imagejpeg($img_new, $thumb, 100);
            break;
        case "image/png":
            imagepng($img_new, $thumb);
            break;
        case "image/x-png":
            imagepng($img_new, $thumb);
            break;
        case "image/gif":
            imagegif($img_new, $thumb);
            break;
    }

    switch ($img_type) {
        case "image/jpeg":
            $img_thumb_square = imagecreatefromjpeg($thumb);
            break;
        case "image/png":
            $img_thumb_square = imagecreatefrompng($thumb);
            break;
        case "image/x-png":
            $img_thumb_square = imagecreatefrompng($thumb);
            break;
        case "image/gif":
            $img_thumb_square = imagecreatefromgif($thumb);
            break;
    }

    $thumb_width = imagesx($img_thumb_square);
    $thumb_height = imagesy($img_thumb_square);
 
    if ($thumb_height < $thumb_width) {

        // ширина
        $x_src = ($thumb_width - $square_size) / 2;
        $y_src = 0;

        $img_final = imagecreatetruecolor($square_size, $square_size);

        imagecopy(
			$img_final,
			$img_thumb_square,
			0, 0, $x_src, $y_src,
			$square_size,
			$square_size
		);

    } else if ($thumb_height > $thumb_width) {

        $x_src = 0;
        $y_src = ($thumb_height - $square_size) / 2;

        $img_final = imagecreatetruecolor($square_size, $square_size);

        imagecopy(
			$img_final,
			$img_thumb_square,
			0, 0, $x_src, $y_src,
			$square_size,
			$square_size
		);

    } else {

        $img_final = imagecreatetruecolor($square_size, $square_size);

        imagecopy(
			$img_final,
			$img_thumb_square,
			0, 0, 0, 0,
			$square_size,
			$square_size
		);

    }

    switch ($img_type) {
        case "image/jpeg":
            @imagejpeg($img_final, $thumb, 100);
            break;
        case "image/png":
            @imagepng($img_final, $thumb);
            break;
        case "image/x-png":
            @imagepng($img_final, $thumb);
            break;
        case "image/gif":
            @imagegif($img_final, $thumb);
            break;
    }
}

//------------------------------------------------------------------------------

	$ori_dir       = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/original/";
	$thumb_50_dir  = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/50x50/";
	$thumb_78_dir  = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/78x78/";
	$thumb_90_dir  = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/90x90/";
	$thumb_250_dir = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/250x250/";
	$thumb_500_dir = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/full/";

	// 

	$allowedType = array(
	    'image/jpeg',
		'image/png',
		'image/gif',
		'image/x-png'
	);

	$uploaded = 0;
	$failed = 0;

	if ( $_FILES['image']['name'] ) {

	    if ( in_array($_FILES['image']['type'], $allowedType) ) {

	        // 1 Mb
	        if ( $_FILES['image']['size'] <= 1048576 ) {

				//

				$dalc = new DALC();

				$product_photo = $dalc->SQL_CreateItem(
					'product_photos',
					array(
						'id_product' => $id_product,
						'file_name'  => ''
					)
				);

				//

				$new_image_name = 'p'.$product_photo["id_product"].'_'.$product_photo["id"];

				switch ($_FILES['image']['type']) {
			        case "image/jpeg":
			            $new_image_name .= '.jpg';
			            break;
			        case "image/png":
			        case "image/x-png":
			            $new_image_name .= '.png';
			            break;
			        case "image/gif":
			            $new_image_name .= '.gif';
			            break;
			    }

				$item = array();
				$item["id"] = $product_photo["id"];
				$item["file_name"] = $new_image_name;

				$dalc->SQL_UpdateItems(
					'product_photos',
					array( $item ),
					array( 'file_name' )
				);

				//

	            move_uploaded_file (
					$_FILES['image']['tmp_name'],
					//$ori_dir.$_FILES['image']['name']
					$ori_dir.$new_image_name
				);

				// Создание маленьких картинок

	            create_thumb (
	            	50,
					$new_image_name,
	                $ori_dir,
					$thumb_50_dir,
	                $_FILES['image']['type']
				);

	            create_thumb (
	            	78,
					$new_image_name,
	                $ori_dir,
					$thumb_78_dir,
	                $_FILES['image']['type']
				);

	            create_thumb (
	            	90,
					$new_image_name,
	                $ori_dir,
					$thumb_90_dir,
	                $_FILES['image']['type']
				);

	            create_thumb (
	            	250,
					$new_image_name,
	                $ori_dir,
					$thumb_250_dir,
	                $_FILES['image']['type']
				);

	            create_thumb (
	            	500,
					$new_image_name,
	                $ori_dir,
					$thumb_500_dir,
	                $_FILES['image']['type']
				);

	            $uploaded++;

	        } else {

	            $failed++;

	        }
	    } else if ($_FILES['image']['type'] != '') {

	        $failed++;

	    }
	}

	echo '{success: true, failed: '.$failed.', uploaded: '.$uploaded.'}';

?>