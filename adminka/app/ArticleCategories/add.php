<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
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

	$article_category = $article_category_dalc->SQL_CreateItem(
		'article_categories',
		array(
			'label'      => $item['label'],
			'link_label' => $item['link_label'],
			'parent'     => $item['parent'],
			'level'      => $item['level']
		)
	);

	//

	if ( isset($article_category) ) {

		echo json_encode(array(
			"success" => "true",
			"id"      => $article_category["id"]
		));

	} else {

		echo json_encode(array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>