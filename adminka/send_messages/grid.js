
var grid = {};

//--------------------------------------------------------------------------------------------------
// Модель данных

grid.model = Ext.define (
	'grid.model',
	{
	    extend: 'Ext.data.Model',
	    idProperty: 'id',
	    fields: [
			{
				name: 'id'
			},
			{
				name: 'fio'
			},
			{
				name: 'subject'
			},
			{
				name: 'dt'
			},
			{
				name: 'status'
			}
	    ]
	}
);

//--------------------------------------------------------------------------------------------------
// Источник данных

grid.store = Ext.create(
	'Ext.data.Store',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/SendMessages/data_for_grid.php',
			reader: {
				type: 'json',
				root: 'items',
				totalProperty: 'totalCount'
			}
	    },

		model: grid.model,	    

		autoLoad: true
	}
);

//--------------------------------------------------------------------------------------------------
// Панель

grid.panel = Ext.create(
	'Ext.grid.Panel',
	{
		store: grid.store,

		preventHeader: true,

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
				width: 80,
				dataIndex: 'status',
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					switch (record.get('status')) {
						case '1': return 'Создано'; break;
						case '2': return 'Отправлено'; break;
						default: return ''; break;
					}
				},
				text: 'Статус'
			},
			{
				xtype: 'gridcolumn',
				width: 200,
				dataIndex: 'fio',
				text: 'Отправитель'
			},
			{
				xtype: 'gridcolumn',
				dataIndex: 'subject',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return '<a href="send_messages.php?noframe=1&id=' + record.get('id') + '">' +
						record.get('subject') +
						'</a>';
				},
				text: 'Тема'
			},
			{
				xtype: 'gridcolumn',
				width: 100,
				dataIndex: 'dt',
				renderer: Ext.util.Format.dateRenderer('d.m.Y H:i'),
				text: 'Дата создания'
			}
		],
		dockedItems: [
			{
				xtype: 'pagingtoolbar',
				displayInfo: true,
				store: grid.store,
				dock: 'bottom'
			}
		],
		selModel: Ext.create('Ext.selection.CheckboxModel', {
			
		})
	}
);
