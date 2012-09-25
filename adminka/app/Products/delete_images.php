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

	//

echo '1';

	$ids = '';

	if (isset($_REQUEST['ids'])) {

		$ids = $_REQUEST['ids'];

	} else {

		if (isset($request->params->ids)) {

			$ids = $request->params->ids;

		}
	}

	//

	$images = '';

	if (isset($_REQUEST['images'])) {

		$images = $_REQUEST['images'];

	} else {

		if (isset($request->params->images)) {

			$images = $request->params->images;

		}
	}

	//

	$dalc = new DALC();

	$dalc->SQL_DeleteItems (
		'product_photos',
		' id IN (' . $ids . ') '
	);

	//

	$ori_dir       = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/original/";
	$thumb_50_dir  = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/50x50/";
	$thumb_78_dir  = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/78x78/";
	$thumb_90_dir  = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/90x90/";
	$thumb_250_dir = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/250x250/";
	$thumb_500_dir = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/full/";

	$arrayImg = explode(";", $images);

	foreach($arrayImg as $imgname) {

	    if ($imgname != "") {

	        unlink($dir.$imgname);
	        unlink($thumb_50_dir.$imgname);
	        unlink($thumb_78_dir.$imgname);
	        unlink($thumb_90_dir.$imgname);
	        unlink($thumb_250_dir.$imgname);

	    }
	}

	echo json_encode(Array(
	    "success" => "true"
	));

?>