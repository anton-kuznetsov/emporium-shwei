
var tabs = {};

//--------------------------------------------------------------------------------------------------
// Панель вкладки "Сообщение от пользователя"

var tab_info = {};

tab_info.onDelete = function () {

 	Ext.Msg.confirm (
	 	'Удаление записи',
		'Вы действительно хотите удалить эту запись?',
		function(btn, text) {
			if (btn == 'yes'){
			    Ext.Ajax.request(
					{
			        	url: 'app/SendMessages/delete.php',
			        	method: 'POST',
			        	params: {
							'ids': request_param_id
						},
			        	success: function(obj) {
							location.href = 'send_messages.php?noframe=1';
				        },
						failure: function(){
							Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
							location.href = 'send_messages.php?noframe=1';
						}
					}
				);
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

		items: [
            {
                xtype: 'fieldset',
                title: 'От кого',
                region: 'north',
                heigth: 400,
                items: [
					{
						xtype: 'hiddenfield',
						name: 'id',
						value: request_param_id
					},
                    {
                        fieldLabel: 'Отправитель',
						name: 'fio',
						xtype: 'textfield',
                        anchor: '100%',
                        readOnly: true
                    },
                    {
                        fieldLabel: 'E-Mail',
						name: 'email',
						xtype: 'textfield',
                        anchor: '100%',
                        readOnly: true
                    },
					{
                        fieldLabel: 'Телефон',
                        name: 'phone',
						xtype: 'textfield',
                        anchor: '100%',
                        readOnly: true
                    }
                ]
            },
            {
                xtype: 'fieldset',
                title: 'Сообщение',
                region: 'center',
                items: [
					{
                        fieldLabel: 'Заголовок',
						name: 'subject',
						xtype: 'textfield',
                        anchor: '100%',
                        readOnly: true
                    },
					{
                        fieldLabel: 'Дата создания',
						name: 'dt',
                        xtype: 'datefield',
                        format: 'd.m.Y',
                        altFormats: 'Y-m-d H:i:s',
                        anchor: '100%',
                        readOnly: true
                    },
                    {
                        fieldLabel: 'Статус',
						name: 'status',
						xtype: 'textfield',
                        anchor: '100%',
                        readOnly: true
                    },
                    {
                        fieldLabel: 'Текст',
						name: 'text',
						xtype: 'textareafield',
                        height: 500,
                        anchor: '100%',
                        readOnly: true
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
		url: 'app/SendMessages/form.php',
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
		title: 'Сообщение от пользователя',

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
