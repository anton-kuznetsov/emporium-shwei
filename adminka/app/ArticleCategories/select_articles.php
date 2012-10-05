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

	$request = new Request(array('restful' => true));

	//

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_article_category', 'type' => 'int' ),
		),
		$request
	);

	//

	$article_dalc = new Article_DALC();

	$where = ' id_article_category = ' . $item['id_article_category'];

	$articles = $article_dalc->GetItemsLimit(
		array(
			"title",
			"id_article_category",
			"link_label"
		),
		$where,
		$start, $limit
	);

	$articles_qty = count($articles);

	$array = array();

	foreach ($articles as $article) {

		array_push($array, $article);

	}

	//

	echo json_encode(array(
	    "totalCount" => $articles_qty,
	    "items"      => $array
	));

?>