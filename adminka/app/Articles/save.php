<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id',                  'type' => 'int'    ),
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

	$dalc->SQL_UpdateItems(
		'articles',
		array( $item ),
		array( 'title', 'link_label', 'id_article_category', 'anons', 'text' )
	);

	echo json_encode(array(
		"success" => "true"
	));

?>