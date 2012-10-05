<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id', 'type' => 'int' ),
		),
		$request
	);

	//

	$article_dalc = new Article_DALC();

	$article = $article_dalc->GetArticle($item['id']);

	echo json_encode(array(
	    "success" => "true",
	    "total"   => isset( $article ) ? 1 : 0,
	    "data"    => $article
	));

?>