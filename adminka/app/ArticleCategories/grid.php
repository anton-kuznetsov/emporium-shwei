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

	//

	$where = '';

	$article_category_dalc = new ArticleCategory_DALC();

	$article_categories_qty = $article_category_dalc->Count();

	$article_categories = $article_category_dalc->GetItemsLimit(
		array(
			"label",
			"level",
			"parent"
		),
		$where,
		$start, $limit
	);

	$array = array();

	foreach ($article_categories as $article_category) {

		array_push($array, $article_category);

	}

	echo json_encode(Array(

	    "totalCount" => $article_categories_qty,
	    "items"      => $array

	));

?>