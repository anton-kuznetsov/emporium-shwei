<?php

	require_once "var.php";
	require_once "includes/classes.php";

	$file_name = "yml.xml";

	$data = "";

	if ( is_writeable($file_name) ) {

		echo "Writing header...";

		$data .= '<?xml version="1.0" encoding="utf-8"?>'."\n".'<!DOCTYPE yml_catalog SYSTEM "shops.dtd">'."\n";

		echo "Writing yml_catalog...";

		$dt_str = date('Y-m-d H:i');

		$data .= '<yml_catalog date="' . $dt_str . '">'."\n".'<shop>'."\n";

		// SHOP

		$data .= '<name>Shwei.Ru</name>'."\n".
		         '<company>Интернет-магазин Shwei.Ru, Чебоксары</company>'."\n".
				 '<url>http://shwei.ru/</url>'."\n". 
				 '<platform>EasyShop</platform>'."\n".
				 '<version>1.0</version>'."\n".
				 '<agency>StyleLab.Org</agency>'."\n".
				 '<email>shwei21@ya.ru</email>'."\n";

		// SHOP::CURRENCIES
    
    	$data .= '<currencies>'."\n".
		         '<currency id="RUR" rate="1"/>'."\n".
				 '</currencies>'."\n";

    	// end: SHOP::CURRENCIES
    
		// SHOP::CATEGORIES
    
    	$data .= '<categories>'."\n".
    	         '<category id="1">Швейные машины</category>'."\n".
    	         '<category id="2">Вязальные машины</category>'."\n".
    	         '<category id="3">Вышивальные машины</category>'."\n".
    	         '<category id="4">Оверлоки</category>'."\n".
				 '<category id="5">Швейно-вышивальные машины</category>'."\n".
    	         '<category id="6" parentId="1">Pаспошивальные швейные машины</category>'."\n".
    	         '<category id="7" parentId="1">Компьютерные швейные машины</category>'."\n".
    	         '<category id="8" parentId="1">Механические швейные машины</category>'."\n".
    	         '<category id="9" parentId="1">Электронные швейные машины</category>'."\n".
    	         '<category id="10" parentId="2">Механические вязальные машины</category>'."\n".
    	         '<category id="11" parentId="2">Электронные вязальные машины</category>'."\n".
    	         '<category id="101">Аксессуары</category>'."\n".
    	         '<category id="102" parentId="101">Для вязальных машин</category>'."\n".
    	         '<category id="103" parentId="102">Ажурные каретки</category>'."\n".
    	         '<category id="104" parentId="102">Каталоги с рисунками</category>'."\n".
    	         '<category id="105" parentId="102">Перфокарты</category>'."\n".
    	         '<category id="106" parentId="102">Перфораторы</category>'."\n".
    	         '<category id="107" parentId="102">Каретки интарсии</category>'."\n".
    	         '<category id="108" parentId="102">Моталки пряжи</category>'."\n".
    	         '<category id="109" parentId="102">Столы для машинки</category>'."\n".
    	         '<category id="110" parentId="102">Устройства смены цвета</category>'."\n".
    	         '<category id="111" parentId="102">Программное обеспечение</category>'."\n".
    	         '<category id="112">Отпариватели</category>'."\n".
		         '</categories>'."\n";

    	// end: SHOP::CATEGORIES

		$data .= '<local_delivery_cost>0</local_delivery_cost>'."\n";

		// SHOP::OFFERS

    	$data .= '<offers>'."\n";

		$dalc = new DALC();
		$product_dalc = new Product_DALC();
		$product_ui = new Product_UI();
		
		$products = $product_dalc->GetItems();
		$brands = $dalc->SQL_SelectAll('brands');

		foreach ( $products as $product) {

			$products_and_categories = $dalc->SQL_SelectList('products_and_categories', NULL, 'id_product = ' . $product['id'], '', 1 );

			$id_category = 0;

			foreach ($products_and_categories as $i) {

				$id_category = $i['id_category'];

			}

			$data .= '<offer id="' . $product['id'] . '" type="vendor.model" available="true">'."\n".
			         '<url>' . htmlentities($product_ui->href( array( 't' => 'product', 'id_product' => $product['id'] ), 1 )) . '</url>'."\n".
			         '<price>' . $product['price'] . '</price>'."\n".
			         '<currencyId>RUR</currencyId>'."\n".
			         '<categoryId>' . $id_category . '</categoryId>'."\n".
			         '<picture>' . $product['href_image_250'] . '</picture>'."\n".
			         '<pickup>true</pickup>'."\n".
			         '<vendor>' . $brands[$product['id_brand']]['label'] . '</vendor>'."\n".
			         '<model>' . $product['label'] . '</model>'."\n".
			         '<description>' . $product['overview'] . '</description>'."\n".
			         '</offer>'."\n";

		}

		$data .= '</offers>'."\n";

    	// end: SHOP::OFFERS

		// end: SHOP

		echo " [end] yml_catalog...";

	    $data .= '</shop>'."\n".'</yml_catalog>'."\n";

		echo "Opening file...";
		
		$fh = fopen($file_name, "w");

		fwrite($fh, $data);

		fclose($fh);

		echo "Done!";

	} else {
	
		print "Could not open file for writing";
	
	}

?>