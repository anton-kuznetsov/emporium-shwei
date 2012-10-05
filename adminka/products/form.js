
var tabs = {};

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Товар"

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

tab_info.models.brands = Ext.define (
	'tab_info.models.brands',
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

tab_info.stores.brands = Ext.create(
	'Ext.data.ArrayStore',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/Brands/select_for_combobox.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			}
	    },

		model: tab_info.models.brands,	    

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
			        	url: 'app/Products/delete.php',
			        	method: 'POST',
			        	params: {
							'ids': request_param_id
						},
			        	success: function(obj) {
							location.href = 'products.php?noframe=1';
				        },
						failure: function(){
							Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
							location.href = 'products.php?noframe=1';
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

		url: 'app/Products/save.php',

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
                        fieldLabel: 'Артикул',
                        name: 'articul',
						xtype: 'textfield',
                        anchor: '100%'
                    },
                    {
                        fieldLabel: 'Наименование',
						name: 'label',
						xtype: 'textfield',
                        anchor: '100%'
                    },
                    {
                        fieldLabel: 'Бренд',
						name: 'id_brand',
						xtype: 'combobox',
                        anchor: '100%',
                        store: tab_info.stores.brands,
						valueField: 'id',
						displayField: 'label',
						typeAhead: true,
						queryMode: 'local',
						emptyText: 'Выберите бренд...'
                    },
                    {
                        fieldLabel: 'Категория',
                        name: 'id_category',
						xtype: 'combobox',
                        anchor: '100%',                        
						store: tab_info.stores.categories,
						valueField: 'id',
						displayField: 'label',
						typeAhead: true,
						queryMode: 'local',
						emptyText: 'Выберите категорию...'
                    },
                    {
                        fieldLabel: 'Цена',
						name: 'price',
						xtype: 'numberfield',
                        maxValue: 100000,
                        minValue: 0,
                        anchor: '100%'
                    },
                    {
						fieldLabel: 'Краткий обзор',
						name: 'overview',
                        xtype: 'htmleditor',
                        height: 150,
                        style: 'background-color: white;',
                        anchor: '100%'
                    },
                    {
                        fieldLabel: 'Подробное описание',
						name: 'description',
						xtype: 'htmleditor',
                        height: 300,
                        style: 'background-color: white;',
                        anchor: '100%'
                    },
                    {
                        fieldLabel: 'Добавлен',
						name: 'dt',
                        xtype: 'datefield',
                        format: 'd.m.Y',
                        altFormats: 'Y-m-d H:i:s',
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
						handler: tab_info.onSave
					},
					{
						xtype: 'button',
						text: 'Удалить',
						handler: tab_info.onDelete
					},
					{
						xtype: 'button',
						text: 'Вернуться'
					}
				]
			}
		]
	}
);

tab_info.form.load(
	{
		url: 'app/Products/form.php',
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
		title: 'Товар',

		border: false,

		tabConfig: {
			xtype: 'tab',
			width: 150,
			region: 'west'
		},
		items: [
			tab_info.form
		]
	}
);

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Характеристики"

var tab_specifications = {};

tab_specifications.grid = {};

tab_specifications.grid.model = Ext.define (
	'tab_specifications.grid.model',
	{
	    extend: 'Ext.data.Model',
	    idProperty: 'id',
	    fields: [
			{
				name: 'id'
			},
			{
				name: 'label'
			},
			{
				name: 'value'
			},
	    ]
	}
);

tab_specifications.grid.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/Products/select_specifications.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			},
			extraParams: {
				id_product: request_param_id + 0,
			}
	    },

		model: tab_specifications.grid.model,

		autoLoad: true
	}
);

tab_specifications.grid.panel = Ext.create(
	'Ext.grid.Panel',
	{
		store: tab_specifications.grid.store,

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
				dataIndex: 'label',
				//flex: 1,
				text: 'Наименование'
			},
			{
				xtype: 'gridcolumn',
				dataIndex: 'value',
				text: 'Значение'
			}
		],

		dockedItems: [
		    {
		        xtype: 'pagingtoolbar',
		        width: 360,
		        displayInfo: true,
		        dock: 'bottom'
		    },
		    {
		        xtype: 'toolbar',
		        dock: 'top',
		        items: [
		            {
		                xtype: 'button',
		                text: 'Добавить'
		            },
		            {
		                xtype: 'button',
		                text: 'Удалить'
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

tab_specifications.panel = Ext.create(
	'Ext.panel.Panel',
	{
		layout: {
			type: 'border'
		},

		title: 'Характеристики',

		border: false,

		tabConfig: {
			xtype: 'tab',
			width: 150,
			region: 'west'
		},

		items: [
			tab_specifications.grid.panel
		]
	}
);

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Фотографии"

var tab_photos = {};

tab_photos.image_list = {};

tab_photos.image_list.model = Ext.define (
	'tab_specifications.grid.model',
	{
	    extend: 'Ext.data.Model',
	    idProperty: 'id',
	    fields: [
	    	{
				name: 'id'
			},
			{
				name: 'name'
			},
			{
				name: 'url'
			},
			{
				name: 'size',
				type: 'float'
			},
			{
				name: 'lastmod',
				type: 'date',
				dateFormat: 'timestamp'
			},
			{
				name: 'thumb_url'
			},
	    ]
	}
);

tab_photos.image_list.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/Products/select_images.php',
			reader: {
				type: 'json',
				root: 'data',
				totalProperty: 'total'
			},
			extraParams: {
				id_product: request_param_id + 0,
			}
	    },

		model: tab_photos.image_list.model,

		autoLoad: true
	}
);

tab_photos.image_list.image_tpl = new Ext.XTemplate(
    '<tpl for=".">',
        '<div class="thumb-wrap" id="{name}">',
        '<div class="thumb"><img src="{thumb_url}" title="{name}"></div>',
        '<span class="x-editable">{shortName}</span></div>',
    '</tpl>',
    '<div class="x-clear"></div>'
);

tab_photos.image_list.dataview = Ext.create( 
	'Ext.view.View',
	{
		id: 'images-view', // Обязательно!!! иначе не будут работать стили

	    store: tab_photos.image_list.store,

	    tpl: tab_photos.image_list.image_tpl,

	    //height: 400,
	    //autoHeight: false,

		region: 'center',

		border: false,

	    autoScroll: true,
	    multiSelect: true,
		trackOver: true,

	    overClass: 'x-view-over',
	    overItemCls: 'x-item-over',
	    itemSelector: 'div.thumb-wrap',

	    emptyText: 'Нет картинок',

	    style: 'border:1px solid #99BBE8; border-top-width: 0',

	    plugins: [
            Ext.create( 'Ext.ux.DataView.DragSelector', {} )
        ],

	    prepareData: function(data){
			data.shortName = Ext.util.Format.ellipsis(data.name, 15);
			data.sizeString = Ext.util.Format.fileSize(data.size);
// 	        data.dateString = data.lastmod.format("m/d/Y g:i a");
	        return data;
	    },

	    listeners: {
	        selectionchange: {
	            fn: function( dv, nodes ) {
	               // alert(nodes.length);
	            }
	        },
			itemclick: {
	            fn: function( dataview, record, item, index, e, eOpts ) {
	                tab_photos.image_info.tpl_detail.overwrite(tab_photos.image_info.panel.body, record.data);
	            }
	        }
	    }
	}
);

tab_photos.image_list.onDelete = function() {

	//var records = tab_photos.image_list.dataview.getSelectedRecords();
	var nodes = tab_photos.image_list.dataview.getSelectedNodes();

	var records = tab_photos.image_list.dataview.getRecords(nodes);

	if (records.length != 0) {

		var imgName = '';
		var imgIds = '-1';

		for (var i = 0; i < records.length; i++) {

			imgName = imgName + records[i].data.name + ';';
			imgIds = imgIds + ',' + records[i].data.id;

		}

		Ext.Ajax.request({
			url: 'app/Products/delete_images.php',
			method: 'post',
			params: {
				ids: imgIds,
				images: imgName,
				id_product: request_param_id + 0
			},
			success: function() {
				tab_photos.image_list.store.load();
			}
		});
	}
};

tab_photos.image_list.panel = Ext.create(
	'Ext.panel.Panel',
	{

		layout: {
			type: 'border'
		},

		border: false,

		region: 'center',
	
		title: 'Фотографии',
	
		items: [
			tab_photos.image_list.dataview
		],

		dockedItems: [
		    {
		        xtype: 'toolbar',
		        dock: 'top',
		        border: false,
		        items: [
		            {
		                xtype: 'button',
		                text: 'Удалить',
		                handler: tab_photos.image_list.onDelete
		            }
		        ]
		    }
		],

	}
);

tab_photos.image_info = {};

tab_photos.image_info.tpl_detail = new Ext.XTemplate(
    '<div class="details">',
        '<tpl for=".">',
            '<img src="{thumb_url}" width="100" heigth="100" ><div class="details-info">',
            '<b>Наименование:</b>',
            '<span>{name}</span><br/>',
            '<b>Размер:</b>',
            '<span>{sizeString}</span><br/>',
            '<b>Изменен:</b>',
            '<span>{dateString}</span><br/>',
            '<span><a href="{url}" target="_blank">Оригинал</a></span></div>',
        '</tpl>',
    '</div>'
);
 
tab_photos.image_info.panel = new Ext.Panel({

    title: 'Информация по выбранному изображению',

    //frame: true,

	region: 'south',

	border: false,

    height: 255,

    bodyPadding: 5,

    id: 'panelDetail',

    tpl: tab_photos.image_info.tpl_detail

});

tab_photos.image_upload = {};

tab_photos.image_upload.panel = Ext.create(
	'Ext.form.Panel',
	{

		layout: {
			type: 'border'
		},

		bodyPadding: 10,
		hideCollapseTool: false,
		preventHeader: true,
		region: 'north',

		border: false,

	    height: 106,
	
	    buttonAlign: 'left',

	    fileUpload: true,

	    items: [
	    	{
				xtype: 'fieldset',
                title: 'Загрузка изображений',
                region: 'center',
                bodyPadding: 10,
                items: [
                	{
						xtype: 'hiddenfield',
						name: 'id_product',
						value: request_param_id
					},
                	{
						name: 'image',
						xtype: 'fileuploadfield',
				        emptyText: '',
				        buttonText: 'Выберите файл',
				        width: 500
				    },
				    {
				        xtype: 'button',
						text: 'Загрузить',
				        handler: function() {
				            tab_photos.image_upload.panel.getForm().submit(
								{
					                url: 'app/Products/upload_images.php',
					                waitMsg: 'Загрузка...',
					                success: function(form, o) {
					                    obj = Ext.JSON.decode(o.response.responseText);
					                    if (obj.failed == '0' && obj.uploaded != '0') {
					                        Ext.Msg.alert('Выполнено', 'Файл загружен');
					                    } else if (obj.uploaded == '0') {
					                        Ext.Msg.alert('Success', 'Nothing Uploaded');
					                    }
					                    tab_photos.image_upload.panel.getForm().reset();
					                    tab_photos.image_list.store.load();
					                }
					            }
							);
				        }
				    },
					{
						xtype: 'button',
				        text: 'Очистить',
				        handler: function() {
				            tab_photos.image_upload.panel.getForm().reset();
				        }
				    }
				    
				]
			}			
		]
	}
);

tab_photos.panel = Ext.create(
	'Ext.panel.Panel',
	{
		title: 'Фотографии',

		border: false,
		
		layout: {
			type: 'border'
		},

		items: [
			tab_photos.image_upload.panel,
			tab_photos.image_list.panel,
			tab_photos.image_info.panel
		]
	}
);

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Похожие товары"

var tab_similar_products = {};

tab_similar_products.grid = {};

tab_similar_products.grid_src = {};

tab_similar_products.grid.model = Ext.define (
	'tab_similar_products.grid.model',
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

tab_similar_products.grid.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/Products/select_similar_products.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			},
			extraParams: {
				id_product: request_param_id + 0,
			}
	    },

		model: tab_similar_products.grid.model,

		autoLoad: true
	}
);

tab_similar_products.grid_src.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/Products/select_not_similar_products.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			},
			extraParams: {
				id_product: request_param_id + 0,
			}
	    },

		model: tab_similar_products.grid.model,

		autoLoad: true
	}
);

tab_similar_products.onRemoveSelect = function () {

	var sel = tab_similar_products.grid.panel.getSelectionModel().getSelection();

    var ids = '-1';

	if ( sel.length > 0 ) {

	    for ( i = 0; i <= sel.length - 1; i++ ) {

	        ids = ids + ', ' + sel[i].get('id');

	    }

	    Ext.Ajax.request(
			{
	        	url: 'app/Products/remove_similar_products.php',
	        	method: 'POST',
	        	params: {
					'id' : request_param_id,
					'ids': ids
				},
	        	success: function(obj) {
	        		tab_similar_products.grid.store.load();
					tab_similar_products.grid_src.store.load();
		        },
				failure: function(){
					Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
					tab_similar_products.grid.store.load();
					tab_similar_products.grid_src.store.load();
				}
			}
		);

	} else {

		Ext.MessageBox.alert('Удаление из похожих товаров', 'Выберите записи, которые следует исключить');

	}
};

tab_similar_products.grid.panel = Ext.create(
	'Ext.grid.Panel',
	{
		store: tab_similar_products.grid.store,

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
				store: tab_similar_products.grid.store,
			    dock: 'bottom'
			},
			{
			    xtype: 'toolbar',
			    dock: 'top',
			    items: [
			        {
			            xtype: 'button',
			            text: 'Удалить',
			            handler: tab_similar_products.onRemoveSelect
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

tab_similar_products.onAddSelect = function () {

	var sel = tab_similar_products.grid_src.panel.getSelectionModel().getSelection();

    var ids = '-1';

	if ( sel.length > 0 ) {

	    for ( i = 0; i <= sel.length - 1; i++ ) {

	        ids = ids + ', ' + sel[i].get('id');

	    }

	    Ext.Ajax.request(
			{
	        	url: 'app/Products/add_similar_products.php',
	        	method: 'POST',
	        	params: {
					'id' : request_param_id,
					'ids': ids
				},
	        	success: function(obj) {
	        		tab_similar_products.grid.store.load();
					tab_similar_products.grid_src.store.load();
		        },
				failure: function(){
					Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
					tab_similar_products.grid.store.load();
					tab_similar_products.grid_src.store.load();
				}
			}
		);

	} else {

		Ext.MessageBox.alert('Добавление в похожие товары', 'Выберите записи, которые следует добавить');

	}
};

tab_similar_products.grid_src.panel = Ext.create(
	'Ext.grid.Panel',
	{
		store: tab_similar_products.grid_src.store,

		title: 'Товары',
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
                        handler: tab_similar_products.onAddSelect
                    }
                ]
            },
            {
				xtype: 'pagingtoolbar',
			    displayInfo: true,
				store: tab_similar_products.grid_src.store,
			    dock: 'bottom'
            }
        ],

		selModel: Ext.create(
			'Ext.selection.CheckboxModel',
			{}
		),
	}
);

tab_similar_products.container_for_grid = Ext.create(
	'Ext.container.Container',
	{
		height: 255,

		layout: {
		    type: 'border'
		},

		region: 'north',

		items: [
			tab_similar_products.grid.panel,
			{
				xtype: 'panel',
				region: 'center',
				border: false,
                title: ''
			}
		]
	}
);

tab_similar_products.panel = Ext.create(
	'Ext.panel.Panel',
	{
		layout: {
			type: 'border'
		},

		title: 'Похожие товары',

		bodyPadding: 5,
		border: false,

		tabConfig: {
			xtype: 'tab',
			width: 150,
			region: 'west'
		},

		items: [			
			tab_similar_products.grid_src.panel,
			tab_similar_products.container_for_grid
		]
	}
);

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Акции"

var tab_actions = {};

tab_actions.panel = Ext.create(
	'Ext.panel.Panel',
	{
		title: 'Акции',

		border: false
	}
);

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Скидки"

var tab_sales = {};

tab_sales.panel = Ext.create(
	'Ext.panel.Panel',
	{
		title: 'Скидки',

		border: false
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

		url: 'app/Products/save_seo_form.php',

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
		url: 'app/Products/form.php',
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
			tab_specifications.panel,
			tab_photos.panel,
			tab_similar_products.panel,
			tab_actions.panel,
			tab_sales.panel,
			tab_seo.panel
		]
	}
);
