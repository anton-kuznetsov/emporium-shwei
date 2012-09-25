
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

tab_info.onAddSave = function () {

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

				tab_info.form.getForm().submit({
				    clientValidation: true,
				    method: 'GET',
				    success: function(form, action) {
				    	// action.result.id
						// { 'success': 'true', 'id': '1' }
						location.href = 'products.php?noframe=1&id=' + action.result.id;
				    },
				    failure: function(form, action) {
				        switch (action.failureType) {
				            case Ext.form.action.Action.CLIENT_INVALID:
				                Ext.Msg.alert('Failure', 'Form fields may not be submitted with invalid values');
				                break;
				            case Ext.form.action.Action.CONNECT_FAILURE:
				                Ext.Msg.alert('Failure', 'Ajax communication failed');
				                break;
				            case Ext.form.action.Action.SERVER_INVALID:
								Ext.Msg.alert('Failure', action.result.msg);
								break;
				       }
				    }
				});

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

		url: 'app/Products/add.php',

		items: [
            {
                xtype: 'fieldset',
                title: 'Описание',
                region: 'center',
                items: [
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
						handler: tab_info.onAddSave
					},
					{
						xtype: 'button',
						text: 'Отмена'
					}
				]
			}
		]
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
			tab_info.panel
		]
	}
);
