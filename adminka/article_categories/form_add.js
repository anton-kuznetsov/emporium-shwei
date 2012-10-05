
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
						location.href = 'article_categories.php?noframe=1&id=' + action.result.id;
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

		url: 'app/ArticleCategories/add.php',

		items: [
            {
                xtype: 'fieldset',
                title: 'Описание',
                region: 'center',
                items: [
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
						handler: tab_info.onAddSave
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
