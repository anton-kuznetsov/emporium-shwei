<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";

	//

	$article_category_dalc = new ArticleCategory_DALC();

	$where = '';

	$article_categories = $article_category_dalc->GetItemsLimit(
		array(
			"label",
			"parent",
			"level"
		),
		$where
	);

	$article_categories_qty = count( $article_categories ); 

	$array = array();

	// Первый "пустой" элемент списка

	array_push(
		$array,
		array(
			"id"     => 0,
			"label"  => 'Выберите категорию...',
			"parent" => 0,
			"level"  => 1
		)
	);

	//

	if (isset($article_categories)) {

		foreach ($article_categories as $article_category) {

			array_push($array, $article_category);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $article_categories_qty,
	    "items"      => $array
	));

?>