
var tabs = {};

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Категория статей"

var tab_info = {};

tab_info.models = {};

tab_info.models.categories = Ext.define (
	'tab_info.models.categories',
	{
	    extend: 'Ext.data.Model',
	    idProperty: 'id',
	    fields: [
			{
				name: 'id'
			},
			{
				name: 'label'
			}
	    ]
	}
);

tab_info.stores = {};

tab_info.stores.categories = Ext.create(
	'Ext.data.ArrayStore',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/ArticleCategories/select_for_combobox.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			}
	    },

		model: tab_info.models.categories,	    

		autoLoad: true
	}
);

tab_info.onDelete = function () {

 	Ext.Msg.confirm (
	 	'Удаление записи',
		'Вы действительно хотите удалить эту запись?',
		function(btn, text) {
			if (btn == 'yes'){
			    Ext.Ajax.request(
					{
			        	url: 'app/ArticleCategories/delete.php',
			        	method: 'POST',
			        	params: {
							'ids': request_param_id
						},
			        	success: function(obj) {
							location.href = 'article_categories.php?noframe=1';
				        },
						failure: function(){
							Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
							location.href = 'article_categories.php?noframe=1';
						}
					}
				);
			}
		}
	);

};

tab_info.onSave = function () {

 	Ext.Msg.confirm (
	 	'Сохранение',
		'Вы действительно хотите сохранить изменения?',
		function(btn, text) {

			if (btn == 'yes') {

			    Ext.Msg.show ({
					title: 'Ждите...',
					msg: 'Сохранение данных',
					width: 150,
					icon: 'ext-mb-info',
					closable: false
				});

				tab_info.form.getForm().submit();

				Ext.Msg.hide();

			}
		}
	);

};

tab_info.form = Ext.create(
	'Ext.form.Panel',
	{
		layout: {
			type: 'border'
		},

		title: 'My Form',

		bodyPadding: 10,
		hideCollapseTool: false,
		preventHeader: true,
		region: 'center',

		border: false,

		url: 'app/ArticleCategories/save.php',

		items: [
            {
                xtype: 'fieldset',
                title: 'Описание',
                region: 'center',
                items: [
                	{
						xtype: 'hiddenfield',
						name: 'id',
						value: request_param_id
					},
                    {
                        fieldLabel: 'Наименование',
						name: 'label',
						xtype: 'textfield',
                        anchor: '100%'
                    },
					{
                        fieldLabel: 'Псевдоним',
						name: 'link_label',
						xtype: 'textfield',
                        anchor: '100%'
                    },
					{
                        fieldLabel: 'Родительская категория',
                        name: 'parent',
						xtype: 'combobox',
                        anchor: '100%',                        
						store: tab_info.stores.categories,
						valueField: 'id',
						displayField: 'label',
						typeAhead: true,
						queryMode: 'local',
						emptyText: 'Выберите категорию...'
                    }
                ]
            }
		],

		dockedItems: [
			{
				xtype: 'toolbar',
				width: 150,
				region: 'west',
				dock: 'bottom',
		        items: [
					{
						xtype: 'button',
						text: 'Сохранить',
						handler: tab_info.onSave
					},
					{
						xtype: 'button',
						text: 'Удалить',
						handler: tab_info.onDelete
					}
				]
			}
		]
	}
);

tab_info.form.load(
	{
		url: 'app/ArticleCategories/form.php',
		params: {
			'id': request_param_id
		},
		callback: function(){
			//
		},
		success: function(){
			//
		},
		failure: function(){
			//
		}
	}
);

tab_info.panel = Ext.create(
	'Ext.panel.Panel',
	{
		layout: {
			type: 'border'
		},
		title: 'Категория статей',

		border: false,

		tabConfig: {
			xtype: 'tab',
			region: 'west'
		},
		items: [
			tab_info.form
		]
	}
);

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Статьи"

var tab_artilces = {};

tab_artilces.grid = {};

tab_artilces.grid.model = Ext.define (
	'tab_artilces.grid.model',
	{
	    extend: 'Ext.data.Model',
	    idProperty: 'id',
	    fields: [
			{
				name: 'id'
			},
			{
				name: 'title'
			}
	    ]
	}
);

tab_artilces.grid.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/ArticleCategories/select_articles.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			},
			extraParams: {
				id_article_category: request_param_id + 0,
			}
	    },

		model: tab_artilces.grid.model,

		autoLoad: true
	}
);

tab_artilces.onDelete = function () {

	var sel = tab_artilces.grid.panel.getSelectionModel().getSelection();

    var ids = '-1';

	if ( sel.length > 0 ) {

	    for ( i = 0; i <= sel.length - 1; i++ ) {

	        ids = ids + ', ' + sel[i].get('id');

	    }

	 	Ext.Msg.confirm (
		 	'Удаление',
			'Вы действительно хотите удалить выбранные записи?',
			function(btn, text) {
				if (btn == 'yes'){
				    Ext.Ajax.request(
						{
				        	url: 'app/Articles/delete.php',
				        	method: 'POST',
				        	params: {
								'ids': ids
							},
				        	success: function(obj) {
								tab_artilces.grid.store.load();
					        },
							failure: function(){
								Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
								tab_artilces.grid.store.load();
							}
						}
					);
				}
			}
		);

	} else {

		Ext.MessageBox.alert('Удаление', 'Выберите записи, которые следует удалить');

	}
};

tab_artilces.onAddArticle = function () {

	location.href = 'articles.php?noframe=1&_add=1&id_category=' + request_param_id;
	
};

tab_artilces.grid.panel = Ext.create(
	'Ext.grid.Panel',
	{
		store: tab_artilces.grid.store,

		preventHeader: true,

		forceFit: true,
		region: 'center',
		border: false,

		columns: [
			{
				xtype: 'numbercolumn',
				width: 40,
				align: 'right',
				dataIndex: 'id',
				text: '#',
				format: '0'
			},
			{
				xtype: 'gridcolumn',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return '<a href="articles.php?noframe=1&id=' + record.get('id') + '">' +
						record.get('title') +
						'</a>';
				},
				text: 'Наименование'
			}
		],

		dockedItems: [
		    {
		        xtype: 'pagingtoolbar',
		        store: tab_artilces.grid.store,
		        displayInfo: true,
		        dock: 'bottom'
		    },
		    {
		        xtype: 'toolbar',
		        dock: 'top',
		        items: [
		            {
		                xtype: 'button',
		                text: 'Добавить',
		                handler: tab_artilces.onAddArticle
		            },
		            {
		                xtype: 'button',
		                text: 'Удалить',
		                handler: tab_artilces.onDelete
		            }
		        ]
		    }
		],

		selModel: Ext.create(
			'Ext.selection.CheckboxModel',
			{}
		),

		plugins: [
		    Ext.create(
				'Ext.grid.plugin.CellEditing',
				{
		        	ptype: 'cellediting'
		    	}
			)
		]
	}
);

tab_artilces.panel = Ext.create(
	'Ext.panel.Panel',
	{
		layout: {
			type: 'border'
		},

		title: 'Статьи',

		border: false,

		tabConfig: {
			xtype: 'tab',
			width: 150,
			region: 'west'
		},

		items: [
			tab_artilces.grid.panel
		]
	}
);

//--------------------------------------------------------------------------------------------------
// Панель вкладки "SEO"

var tab_seo = {};

tab_seo.model = Ext.define(
	'tab_seo.model',
	{
	    extend: 'Ext.data.Model',
	    fields: [
			{
				//
				name: 'page_title'
			},
	        {
	        	// 
				name: 'meta_desc'
			},
	        {
	        	// 
				name: 'meta_key'
			}
	    ]
	}
);

tab_seo.form = Ext.create(
	'Ext.form.Panel',
	{
		layout: {
			type: 'border'
		},

		title: 'My Form',

		bodyPadding: 10,
		hideCollapseTool: false,
		preventHeader: true,
		region: 'center',

		border: false,

		url: 'app/ArticleCategories/save_seo_form.php',

		items: [
            {
                xtype: 'fieldset',
                title: 'SEO',
                region: 'center',
                items: [
                	{
						xtype: 'hiddenfield',
						name: 'id',
						value: request_param_id
					},
                    {
                        fieldLabel: 'Заголовок страницы',
						name: 'page_title',
						xtype: 'textfield',
						labelWidth: 150,
                        anchor: '100%'
                    },
                    {
                        fieldLabel: 'Описание страницы',
						name: 'meta_desc',
						xtype: 'htmleditor',
						labelWidth: 150,
                        height: 150,
                        style: 'background-color: white;',
                        anchor: '100%'
                    },
                    {
                        fieldLabel: 'Ключевые слова',
						name: 'meta_key',
						xtype: 'htmleditor',
						labelWidth: 150,
                        height: 150,
                        style: 'background-color: white;',
                        anchor: '100%'
                    }
                ]
            }
		],
		
		dockedItems: [
			{
				xtype: 'toolbar',
				width: 150,
				region: 'west',
				dock: 'bottom',
		        items: [
					{
						xtype: 'button',
						text: 'Сохранить',
						handler: function() {
							tab_seo.form.getForm().submit();
						}
					}
				]
			}
		]
	}
);

tab_seo.form.load(
	{
		url: 'app/ArticleCategories/form.php',
		params: {
			'id': request_param_id
		},
		callback: function(){
			//
		},
		success: function(){
			//
		},
		failure: function(){
			//
		}
	}
);

tab_seo.panel = Ext.create(
	'Ext.panel.Panel',
	{
		layout: {
			type: 'border'
		},
		title: 'SEO',

		border: false,

		tabConfig: {
			xtype: 'tab',
			region: 'west'
		},
		items: [
			tab_seo.form
		]
	}
);

//--------------------------------------------------------------------------------------------------
// 

tabs.panel = Ext.create(
	'Ext.tab.Panel',
	{
		activeTab: 0,
		region: 'center',

		layout: {
			type: 'border'
		},

		items: [
			tab_info.panel,
			tab_artilces.panel,
			tab_seo.panel,
		]
	}
);
