<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_article_category', 'type' => 'int'    ),
			array( 'name' => 'title',               'type' => 'string' ),
			array( 'name' => 'link_label',          'type' => 'string' ),
			array( 'name' => 'anons',               'type' => 'string' ),
			array( 'name' => 'text',                'type' => 'string' ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$article = $dalc->SQL_CreateItem(
		'articles',
		array(
			'title'               => $item['title'],
			'link_label'          => $item['link_label'],
			'id_article_category' => $item['id_article_category'],
			'anons'               => $item['anons'],
			'text'                => $item['text']
		)
	);

	//

	if ( $article ) {

		echo json_encode(array(
			"success" => "true",
			"id"      => $article["id"]
		));

	} else {

		echo json_encode(array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>