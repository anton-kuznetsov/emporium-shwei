<?php

class CategoryPage_UI extends Page_UI {

	protected $options = array();

	function __construct( $modules = array(), $options = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/CategoryPage/';

		$this->options = $options;

	}

	function render() {

		global $week_days_rus;
		global $month_rus;
		global $site_root;

		$data = array();

		switch ( $this->options['page_type'] ) {
			case 'category':
				$product_category_bllc = new Category_DALC();
				$data = $product_category_bllc->GetCategory( $this->options['id_category'] );
				break;
			case 'article':
				$article_bllc = new Article_BLLC();
				$data = $article_bllc->GetArticle( $this->options['id_article'] );
				break;
			case 'article_category':
				$article_category_bllc = new ArticleCategory_BLLC();
				$data = $article_category_bllc->GetArticleCategory( $this->options['id_article_category'] );
				break;
		}

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>