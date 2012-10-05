<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";

	//

	$nodes = array();

	// Список брендов

	$brand_dalc = new Brand_DALC();

	$brands_qty = $brand_dalc->Count();

	$products_json = null;

	if ($brands_qty) {

		$brands = $brand_dalc->GetItems();

		$brands_for_json = array();
	
		foreach ($brands as $brand) {
	
			array_push(
				$brands_for_json, 
				array (
					'text'       => $brand['label'],
					'id'         => $brand['id'],
					'href_panel' => $site_url . 'products.php?id_brand=' . $brand['id'],
					'leaf'       => true,
					'cls'        => 'file'
				)
			);	
		}
		
		$products_for_json = array (
			'text'       => 'Товары',
			'id'         => 'products',
			'href_panel' => $site_url . 'products.php',
			'leaf'       => false,
			'cls'        => 'folder',			
			'children'   => $brands_for_json
		);
		
	} else {

		$products_for_json = array (
			'text'       => 'Товары',
			'id'         => 'products',
			'href_panel' => $site_url . 'products.php',
			'leaf'       => true,
			'cls'        => 'file'
		);

	}

	//

	$nodes['id'] = "root";
	$nodes['text'] = "Root";
	$nodes['children'] = array(
		array (
			'text'       => 'Бренды',
			'id'         => 'brands',
			'href_panel' => $site_url . 'brands.php',
			'leaf'       => true,
			'cls'        => 'file'
		),
		array (
			'text'       => 'Категории товара',
			'id'         => 'product_categories',
			'href_panel' => $site_url . 'product_categories.php',
			'leaf'       => true,
			'cls'        => 'file'
		),
		$products_for_json,
		array (
			'text'       => 'Категории статей',
			'id'         => 'article_categories',
			'href_panel' => $site_url . 'article_categories.php',
			'leaf'       => true,
			'cls'        => 'file'
		),
		array (
			'text'       => 'Статьи',
			'id'         => 'articles',
			'href_panel' => $site_url . 'articles.php',
			'leaf'       => true,
			'cls'        => 'file'
		),
		array (
			'text'       => 'Оформленные заказы',
			'id'         => 'orders',
			'href_panel' => $site_url . 'orders.php',
			'leaf'       => true,
			'cls'        => 'file'
		),
		array (
			'text'       => 'Сообщения от пользователей',
			'id'         => 'send_messages',
			'href_panel' => $site_url . 'send_messages.php',
			'leaf'       => true,
			'cls'        => 'file'
		)
	); 

	echo json_encode($nodes);

?>