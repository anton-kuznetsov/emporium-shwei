
var tabs = {};

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Категория товара"

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
	        url: 'app/Categories/select_for_combobox.php',
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
			if (btn == 'yes') {
			    Ext.Ajax.request (
					{
			        	url: 'app/Categories/delete.php',
			        	method: 'POST',
			        	params: {
							'ids': request_param_id
						},
			        	success: function(obj) {
							location.href = 'product_categories.php?noframe=1';
				        },
						failure: function(){
							Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
							location.href = 'product_categories.php?noframe=1';
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

		url: 'app/Categories/save.php',

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
		url: 'app/Categories/form.php',
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
		title: 'Категория товара',

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
// Панель вкладки "Рекомендуемые товары"

var tab_recomended_products = {};

tab_recomended_products.grid = {};

tab_recomended_products.grid_src = {};

tab_recomended_products.grid.model = Ext.define (
	'tab_recomended_products.grid.model',
	{
	    extend: 'Ext.data.Model',
	    idProperty: 'id',
	    fields: [
			{
				name: 'id'
			},
			{
				name: 'articul'
			},
			{
				name: 'label'
			},
			{
				name: 'price'
			}
	    ]
	}
);

tab_recomended_products.grid.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/Categories/select_recomended_products.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			},
			extraParams: {
				id_category: request_param_id + 0,
			}
	    },

		model: tab_recomended_products.grid.model,

		autoLoad: true
	}
);

tab_recomended_products.grid_src.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/Categories/select_not_recomended_products.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			},
			extraParams: {
				id_category: request_param_id + 0,
			}
	    },

		model: tab_recomended_products.grid.model,

		autoLoad: true
	}
);

tab_recomended_products.onRemoveSelect = function () {

	var sel = tab_recomended_products.grid.panel.getSelectionModel().getSelection();

    var ids = '-1';

	if ( sel.length > 0 ) {

	    for ( i = 0; i <= sel.length - 1; i++ ) {

	        ids = ids + ', ' + sel[i].get('id');

	    }

	    Ext.Ajax.request(
			{
	        	url: 'app/Categories/remove_recomended_products.php',
	        	method: 'POST',
	        	params: {
					'id' : request_param_id,
					'ids': ids
				},
	        	success: function(obj) {
	        		tab_recomended_products.grid.store.load();
					tab_recomended_products.grid_src.store.load();
		        },
				failure: function(){
					Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
					tab_recomended_products.grid.store.load();
					tab_recomended_products.grid_src.store.load();
				}
			}
		);

	} else {

		Ext.MessageBox.alert('Удаление из рекомендованных товаров', 'Выберите записи, которые следует исключить');

	}
};

tab_recomended_products.grid.panel = Ext.create(
	'Ext.grid.Panel',
	{
		store: tab_recomended_products.grid.store,

        height: 250,
        preventHeader: true,
        region: 'north',

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
				width: 80,
				dataIndex: 'articul',
				fixed: false,
				text: 'Артикул'
			},
			{
				xtype: 'gridcolumn',
				dataIndex: 'label',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return '<a href="products.php?noframe=1&id=' + record.get('id') + '">' +
						record.get('label') +
						'</a>';
				},
				text: 'Наименование'
			},
			{
				xtype: 'numbercolumn',
				width: 100,
				align: 'right',
				dataIndex: 'price',
				text: 'Цена'
			}
		],

		dockedItems: [
			{
			    xtype: 'pagingtoolbar',
			    displayInfo: true,
				store: tab_recomended_products.grid.store,
			    dock: 'bottom'
			},
			{
			    xtype: 'toolbar',
			    dock: 'top',
			    items: [
			        {
			            xtype: 'button',
			            text: 'Удалить',
			            handler: tab_recomended_products.onRemoveSelect
			        }
			    ]
			}
        ],

		selModel: Ext.create(
			'Ext.selection.CheckboxModel',
			{}
		),
	}
);

tab_recomended_products.onAddSelect = function () {

	var sel = tab_recomended_products.grid_src.panel.getSelectionModel().getSelection();

    var ids = '-1';

	if ( sel.length > 0 ) {

	    for ( i = 0; i <= sel.length - 1; i++ ) {

	        ids = ids + ', ' + sel[i].get('id');

	    }

	    Ext.Ajax.request(
			{
	        	url: 'app/Categories/add_recomended_products.php',
	        	method: 'POST',
	        	params: {
					'id' : request_param_id,
					'ids': ids
				},
	        	success: function(obj) {
	        		tab_recomended_products.grid.store.load();
					tab_recomended_products.grid_src.store.load();
		        },
				failure: function(){
					Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
					tab_recomended_products.grid.store.load();
					tab_recomended_products.grid_src.store.load();
				}
			}
		);

	} else {

		Ext.MessageBox.alert('Добавление в рекомендованные товары', 'Выберите записи, которые следует добавить');

	}
};

tab_recomended_products.grid_src.panel = Ext.create(
	'Ext.grid.Panel',
	{
		store: tab_recomended_products.grid_src.store,

		title: 'Товары категории',
        region: 'center',

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
				width: 80,
				dataIndex: 'articul',
				fixed: false,
				text: 'Артикул'
			},
			{
				xtype: 'gridcolumn',
				dataIndex: 'label',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return '<a href="products.php?noframe=1&id=' + record.get('id') + '">' +
						record.get('label') +
						'</a>';
				},
				text: 'Наименование'
			},
			{
				xtype: 'numbercolumn',
				width: 100,
				align: 'right',
				dataIndex: 'price',
				text: 'Цена'
			}
		],

		dockedItems: [
            {
                xtype: 'toolbar',
                dock: 'top',
                items: [
                    {
                        xtype: 'button',
                        text: 'Добавить',
                        handler: tab_recomended_products.onAddSelect
                    }
                ]
            },
            {
				xtype: 'pagingtoolbar',
			    displayInfo: true,
				store: tab_recomended_products.grid_src.store,
			    dock: 'bottom'
            }
        ],

		selModel: Ext.create(
			'Ext.selection.CheckboxModel',
			{}
		),
	}
);

tab_recomended_products.container_for_grid = Ext.create(
	'Ext.container.Container',
	{
		height: 255,

		layout: {
		    type: 'border'
		},

		region: 'north',

		items: [
			tab_recomended_products.grid.panel,
			{
				xtype: 'panel',
				region: 'center',
				border: false,
                title: ''
			}
		]
	}
);

tab_recomended_products.panel = Ext.create(
	'Ext.panel.Panel',
	{
		layout: {
			type: 'border'
		},

		title: 'Рекомендуемые товары',

		bodyPadding: 5,
		border: false,

		tabConfig: {
			xtype: 'tab',
			region: 'west'
		},

		items: [			
			tab_recomended_products.grid_src.panel,
			tab_recomended_products.container_for_grid
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

		url: 'app/Categories/save_seo_form.php',

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
		url: 'app/Categories/form.php',
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
			tab_recomended_products.panel,
			tab_seo.panel,
		]
	}
);
