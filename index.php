<?php

	error_reporting(E_ALL ^E_NOTICE);
	ini_set('display_errors',1);

	session_start();
	session_name();

	//header("Expires: Mon, 19 Dec 2011 05:00:00  GMT");
	//header("Last-Modified: " . gmdate(  "D, d M Y H:i:s") . " GMT"); 
	//header("Cache-Control: no-cache,  must-revalidate"); 
	//header("Pragma: no-cache");

	require_once "var.php";
	require_once "includes/classes.php";

	if ( $ident == 'session' ) { $REMOTE_ADDR = $PHPSESSID; }

	//

	$global_dalc = new GlobalDALC();

	$options = $global_dalc->getGlobalParams();

	// Подгружаю шаблон

	function GetRequestParams( options = array() ) {

		res = array();

		if (isset(options)) {

			foreach (options as i) {

				switch ( i['type'] ) {
					case 'string':
						break;
					case 'int':
						break;
					case 'float':
						break;
				}

				res[i['name_param']] = i['default'];
				
				if ( isset($_REQUEST [i['name_request']]) ) {

					res[i['name_param']] = $_REQUEST [i['name_request']];

				}
			}
		}

		return res;
	}

	//

	$request_params = GetRequestParams(
		array(
			array(name_request => 't', name_param => 'page_type', type => 'string', default => 'index'),
			//
			array(name_request => 'label', name_param => 'label', type => 'string', default => ''),
			array(name_request => 'label', name_param => 'page_label', type => 'string', default => ''),
			//
			array(name_request => 'id', name_param => 'id', type => 'int', default => 0),
			array(name_request => 'id_category', name_param => 'id_category', type => 'int', default => 0),
			array(name_request => 'id_product', name_param => 'id_product', type => 'int', default => 0),
			array(name_request => 'id_item', name_param => 'id_item', type => 'int', default => 0),
			array(name_request => 'qty', name_param => 'qty', type => 'int', default => 0),
			array(name_request => 'id_brand', name_param => 'id_brand', type => 'int', default => 0),
			array(name_request => 'id_order', name_param => 'id_order', type => 'int', default => 0),
			array(name_request => 'id_cart', name_param => 'id_cart', type => 'int', default => 0),
			array(name_request => 'p', name_param => 'p', type => 'int', default => 1),
			array(name_request => 'limit', name_param => 'limit', type => 'int', default => 9),
			array(name_request => 'order', name_param => 'order', type => 'string', default => 'date'),
			array(name_request => 'action', name_param => 'action', type => 'string', default => ''),
			array(name_request => 'fio', name_param => 'fio', type => 'string', default => ''),
			array(name_request => 'email', name_param => 'email', type => 'string', default => ''),
			array(name_request => 'phone', name_param => 'phone', type => 'string', default => ''),
			array(name_request => 'q', name_param => 'q', type => 'string', default => ''),
			array(name_request => 'subject', name_param => 'subject', type => 'string', default => ''),
			array(name_request => 'text', name_param => 'text', type => 'string', default => ''),
			array(name_request => 'phone', name_param => 'phone', type => 'string', default => ''),
			// Robokassa
			array(name_request => 'OutSum', name_param => 'robokassa_out_summ', type => 'float', default => 0.0),
			array(name_request => 'InvId', name_param => 'robokassa_inv_id', type => 'int', default => 0),
			array(name_request => 'SignatureValue', name_param => 'robocassa_sign_value', type => 'string', default => ''),
		)
	);

	// Корректировка параметров

	if ( isset($request_params["p"]) && !($request_params["p"] > 0) ) {

		$request_params["p"] = 1;

	}

	if ( isset($request_params["limit"]) && !($request_params["limit"] > 0) ) {

		$request_params["limit"] = 9;

	}

	// подключение модулей

	$page = NULL;

	switch ($request_params['page_type']) {

		case 'index':

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new Slider_UI(),                // Слайдер лучших товаров
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new FeaturedProducts_UI(),      // Рекомендуемые товары
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	

			$page = new HomePage_UI($modules);

			break;

		case 'category':

			$bc_data = array();
			$bc_data["id_category"] = $request_params['id_category'];
			$bc_data["page_type"]   = $request_params['page_type'];

			$cp_data = array();
			$cp_data["id_category"] = $request_params['id_category'];
			$cp_data["id_brand"]    = $request_params['id_brand'];
			$cp_data["p"]           = $request_params['p'];
			$cp_data["limit"]       = $request_params['limit'];
			$cp_data["order"]       = $request_params['order'];

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new Breadcrumbs_UI( Breadcrumbs_UI::BC_TYPE_CATEGORY, $bc_data ), //
				new ContentSlider_UI( $cp_data ), //
				new CategoryInfo_UI( $cp_data ),  //
				new CategoryProducts_UI( $cp_data ),    //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	

			$page = new CategoryPage_UI($modules, $bc_data);

			break;

		case 'search':

			$p_data = array();
			$p_data["q"]     = $request_params['q'];
			$p_data["p"]     = $request_params['p'];
			$p_data["limit"] = $request_params['limit'];
			$p_data["order"] = $request_params['order'];

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new SearchResults_UI( $p_data ),    //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	

			$page = new SearchPage_UI($modules);

			break;

		case 'product':

			$bc_data = array();
			$bc_data["id_product"] = $request_params['id_product'];

			$pp_data = array();
			$pp_data["id_product"] = $request_params['id_product'];

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new Breadcrumbs_UI( Breadcrumbs_UI::BC_TYPE_PRODUCT, $bc_data ), //
				new Product_UI( $pp_data ),    //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	

			$page = new ProductPage_UI($modules, $pp_data);

			//

			$page->action();

			break;

		case 'article':

			$a_data = array();
			$a_data["id_article"] = $request_params['id'];
			$a_data["page_type"]  = $request_params['page_type'];

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new Breadcrumbs_UI( Breadcrumbs_UI::BC_TYPE_ARTICLE, $a_data ), //
				new Article_UI( $a_data ),    //
				null,
				null,
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             //				 
			);

			// Генератор страницы	
			$page = new CategoryPage_UI($modules, $a_data);
			break;

		case 'article_category':

			$ac_data = array();
			$ac_data["id_article_category"] = $request_params['id'];
			$ac_data["page_type"]           = $request_params['page_type'];

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new Breadcrumbs_UI( Breadcrumbs_UI::BC_TYPE_ARTICLE_CATEGORY, $ac_data ), //
				new ArticleCategory_UI( $ac_data ),    //
				null,
				null,
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new CategoryPage_UI($modules, $ac_data);
			break;

		case 'page':

			$c_data = array();
			$c_data["page_label"] = $request_params['page_label'];

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new InfoPageContent_UI( $c_data ),    //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	

			$page = new InfoPage_UI($modules, $c_data);

			//

			break;

		case 'brand':

			$bp_data = array();
			$bp_data["id_brand"] = $request_params['id_brand'];

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new Brand_UI( $bp_data ),       //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	

			$page = new BrandPage_UI($modules, $bp_data);

			break;

		case 'create_order':

			$p_data = array();
			$p_data["action"]   = $request_params['action'];
			$p_data["id_order"] = $request_params['id_order'];
			$p_data["id_cart"]  = $request_params['id_cart'];
			$p_data["fio"]      = $request_params['fio'];
			$p_data["email"]    = $request_params['email'];
			$p_data["phone"]    = $request_params['phone'];

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new CreateOrder_UI( $p_data ),  //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	

			$page = new CreateOrderPage_UI($modules, $p_data);

			//

			$page->action();

			//

			break;

		case 'cart':

			$cp_data = array();
			$cp_data["action"]     = $request_params['action'];
			$cp_data["id_product"] = $request_params['id_product'];
			$cp_data["id_item"]    = $request_params['id_item'];
			$cp_data["qty"]        = $request_params['qty'];

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new ShopingCart_UI(), //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы
			$page = new CartPage_UI($modules, $cp_data);

			//

			$page->action();

			//

			break;

		case 'send_message':

			$p_data = array();
			$p_data["action"]  = $request_params['action'];
			$p_data["id"]      = $request_params['id'];
			$p_data["fio"]     = $request_params['fio'];
			$p_data["email"]   = $request_params['email'];
			$p_data["phone"]   = $request_params['phone'];
			$p_data["subject"] = $request_params['subject'];
			$p_data["text"]    = $request_params['text'];

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new Slider_UI(),                // Слайдер лучших товаров
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new SendMessage_UI( $p_data ),  //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             //
			);

			//	
			$page = new SendMessagePage_UI($modules, $p_data);

			//
			$page->action();

			//
			break;

		case 'success_payment':

			$p_data = array();
			$p_data["sum"]      = $request_params['robokassa_out_summ'];
			$p_data["id_order"] = $request_params['robokassa_inv_id'];
			$p_data["crc"]      = $request_params['robokassa_sign_value'];

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new SuccessPayment_UI( $p_data ),  //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             //
			);

			//	
			$page = new InfoPage_UI($modules, $p_data);

			//
			break;

		case 'fail_payment':

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new FailPayment_UI(),           //
				// Левая колонка
				new BrandSideMenu_UI(),         // Меню по брендам
				new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             //
			);

			//	
			$page = new InfoPage_UI($modules, null);

			//
			break;

	}

	// Вывод страницы
	$page->render();

?>