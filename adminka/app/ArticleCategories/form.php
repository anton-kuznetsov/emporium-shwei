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

	$article_category_dalc = new ArticleCategory_DALC();

	$article_category = $article_category_dalc->GetArticleCategory( $item['id'] );

	echo json_encode(array(
	    "success" => "true",
	    "total"   => isset( $article_category ) ? 1 : 0,
	    "data"    => $article_category
	));

?>