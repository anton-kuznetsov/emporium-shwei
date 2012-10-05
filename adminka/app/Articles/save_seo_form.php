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
			array( 'name' => 'page_title', 'type' => 'string' ),
			array( 'name' => 'meta_desc',  'type' => 'string' ),
			array( 'name' => 'meta_key',   'type' => 'string' ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$dalc->SQL_UpdateItems(
		'articles',
		array( $item ),
		array( 'page_title', 'meta_desc', 'meta_key' )
	);

	echo json_encode(array(
		"success" => "true"
	));

?>