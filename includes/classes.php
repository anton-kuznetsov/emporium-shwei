<?php

	require_once "_pages/Page_UI.php";
	require_once "_pages/HomePage/HomePage_UI.php";
	require_once "_pages/CategoryPage/CategoryPage_UI.php";
	require_once "_pages/SearchPage/SearchPage_UI.php";
	require_once "_pages/ProductPage/ProductPage_BLLC.php";
	require_once "_pages/ProductPage/ProductPage_UI.php";
	require_once "_pages/InfoPage/InfoPage_UI.php";
	require_once "_pages/CartPage/CartPage_BLLC.php";
	require_once "_pages/CartPage/CartPage_UI.php";
	require_once "_pages/CreateOrderPage/CreateOrderPage_BLLC.php";
	require_once "_pages/CreateOrderPage/CreateOrderPage_UI.php";
	require_once "_pages/SendMessagePage/SendMessagePage_BLLC.php";
	require_once "_pages/SendMessagePage/SendMessagePage_UI.php";

	// BASE MODULES

	require_once "_base/DALC.php";

	require_once "_base/UI.php";

	// Currency - Валюта

	require_once "_base/Currency_DALC.php";

	// Product - Товар

	require_once "_base/Product_DALC.php";

	//

	require_once "_base/Brand_DALC.php";

	require_once "_base/Category_DALC.php";

	require_once "_base/Cart_DALC.php";

	require_once "_base/Order_DALC.php";

	//

	require_once "_base/Managers_DALC.php";

	// Articles - Статьи

	require_once "_base/Article_DALC.php";
	require_once "_base/ArticleCategory_DALC.php";
	require_once "article/Article_BLLC.php";
	require_once "article/Article_UI.php";
	require_once "article_category/ArticleCategory_BLLC.php";
	require_once "article_category/ArticleCategory_UI.php";

	// EXTENTIONS



	// TopMenu

	require_once "top_menu/TopMenu_UI.php";

	// Modal Cart

	require_once "modal_cart/ModalCart_DALC.php";

	require_once "modal_cart/ModalCart_BLLC.php";

	require_once "modal_cart/ModalCart_UI.php";

	// Slider

	require_once "slider/Slider_DALC.php";

	require_once "slider/Slider_BLLC.php";

	require_once "slider/Slider_UI.php";

	// Product Scroller

	require_once "product_scroller/ProductScroller_DALC.php";

	require_once "product_scroller/ProductScroller_BLLC.php";

	require_once "product_scroller/ProductScroller_UI.php";

	// Featured Products

	require_once "featured_products/FeaturedProducts_DALC.php";

	require_once "featured_products/FeaturedProducts_BLLC.php";

	require_once "featured_products/FeaturedProducts_UI.php";

	// Breadcrumbs

	require_once "breadcrumbs/Breadcrumbs_DALC.php";

	require_once "breadcrumbs/Breadcrumbs_BLLC.php";

	require_once "breadcrumbs/Breadcrumbs_UI.php";

	// Content Slider

	require_once "content_slider/ContentSlider_DALC.php";

	require_once "content_slider/ContentSlider_BLLC.php";

	require_once "content_slider/ContentSlider_UI.php";

	// Category Info

	require_once "category_info/CategoryInfo_DALC.php";

	require_once "category_info/CategoryInfo_BLLC.php";

	require_once "category_info/CategoryInfo_UI.php";

	// Products

 	require_once "product/Product_BLLC.php";

	require_once "product/Product_UI.php";

	// Products

 	require_once "brand/Brand_BLLC.php";

	require_once "brand/Brand_UI.php";

	// Category Products

	require_once "category_products/CategoryProducts_DALC.php";

	require_once "category_products/CategoryProducts_BLLC.php";

	require_once "category_products/CategoryProducts_UI.php";

	// Search Results

	require_once "search_results/SearchResults_DALC.php";

	require_once "search_results/SearchResults_BLLC.php";	

	require_once "search_results/SearchResults_UI.php";

	// Info Page Content

	require_once "info_page_content/InfoPageContent_UI.php";

	// Shoping Cart

	require_once "shoping_cart/ShopingCart_DALC.php";

	require_once "shoping_cart/ShopingCart_BLLC.php";

	require_once "shoping_cart/ShopingCart_UI.php";

	// Create Order

	require_once "create_order/CreateOrder_BLLC.php";

	require_once "create_order/CreateOrder_UI.php";

	// Order

	require_once "order/Order_BLLC.php";



	// *** LEFT COLUMN ***

	// Side Menu

	require_once "side_menu/SideMenu_UI.php";

	// Brand Side Menu

	require_once "brand_side_menu/BrandSideMenu_DALC.php";

	require_once "brand_side_menu/BrandSideMenu_BLLC.php";

	require_once "brand_side_menu/BrandSideMenu_UI.php";

	// Accessories Side Menu

	require_once "accessories_side_menu/AccessoriesSideMenu_DALC.php";

	require_once "accessories_side_menu/AccessoriesSideMenu_BLLC.php";

	require_once "accessories_side_menu/AccessoriesSideMenu_UI.php";

	// Column Cart

	require_once "column_cart/ColumnCart_DALC.php";

	require_once "column_cart/ColumnCart_BLLC.php";

	require_once "column_cart/ColumnCart_UI.php";

	// Newsletter

	require_once "newsletter/Newsletter_DALC.php";

	require_once "newsletter/Newsletter_BLLC.php";

	require_once "newsletter/Newsletter_UI.php";

	// Column Compare Products

	require_once "column_compare_products/ColumnCompareProducts_DALC.php";

	require_once "column_compare_products/ColumnCompareProducts_BLLC.php";

	require_once "column_compare_products/ColumnCompareProducts_UI.php";



	// *** FOOTER #1 ***

	// Footer Viewed

	require_once "footer_viewed/FooterViewed_UI.php";

	// Product Footer Viewed

	require_once "product_footer_viewed/ProductFooterViewed_DALC.php";

	require_once "product_footer_viewed/ProductFooterViewed_BLLC.php";

	require_once "product_footer_viewed/ProductFooterViewed_UI.php";

	// Brand Footer Viewed

	require_once "brand_footer_viewed/BrandFooterViewed_DALC.php";

	require_once "brand_footer_viewed/BrandFooterViewed_BLLC.php";

	require_once "brand_footer_viewed/BrandFooterViewed_UI.php";



	// *** FOOTER #2 ***

	// New Footer List

	require_once "new_footer_list/NewFooterList_DALC.php";

	require_once "new_footer_list/NewFooterList_BLLC.php";

	require_once "new_footer_list/NewFooterList_UI.php";

	// Bestseller Footer List

	require_once "bestseller_footer_list/BestsellerFooterList_DALC.php";

	require_once "bestseller_footer_list/BestsellerFooterList_BLLC.php";

	require_once "bestseller_footer_list/BestsellerFooterList_UI.php";

	// Popular Footer List

	require_once "popular_footer_list/PopularFooterList_DALC.php";

	require_once "popular_footer_list/PopularFooterList_BLLC.php";

	require_once "popular_footer_list/PopularFooterList_UI.php";

	// Footer Menu

	require_once "footer_menu/FooterMenu_UI.php";

	// Send Message

	require_once "send_message/SendMessage_DALC.php";
	require_once "send_message/SendMessage_BLLC.php";
	require_once "send_message/SendMessage_UI.php";

	// DALC

	require_once "dalc/global.php";

?>