<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id',         'type' => 'int'    ),
			array( 'name' => 'label',      'type' => 'string' ),
			array( 'name' => 'link_label', 'type' => 'string' ),
			array( 'name' => 'parent',     'type' => 'int'    ),
		),
		$request
	);

	//

	$article_category_dalc = new ArticleCategory_DALC();

	$parent = $article_category_dalc->GetArticleCategory( $item['parent'] );

	$item['level'] = 1;

	if ( isset($parent) ) {

		$item['level'] = $parent['level'] + 1;

	}

	//

	$article_category_dalc->SQL_UpdateItems(
		'article_categories',
		array( $item ),
		array( 'label', 'link_label', 'parent', 'level' )
	);

	echo json_encode(array(
		"success" => "true"
	));

?>