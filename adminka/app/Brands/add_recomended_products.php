<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id',  'type' => 'int'                       ),
			array( 'name' => 'ids', 'type' => 'string', 'default' => '-1' ),
		),
		$request
	);

	//

	$product_dalc = new Product_DALC();

	$products = $product_dalc->GetItemsByIds($item['ids']);

	if (isset($products)) {

		foreach ($products as $product) {

			$product_dalc->SQL_CreateItem(
				'brand_recomended_products',
				array(
					'id_brand'   => $item['id'],
					'id_product' => $product['id']
				)
			);

		}
	}

	echo json_encode(array(
		"success" => "true"
	));

?>