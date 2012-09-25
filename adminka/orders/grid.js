
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
				name: 'email'
			},
			{
				name: 'phone'
			},
			{
				name: 'dt'
			},
			{
				name: 'total'
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
	        url: 'app/Orders/data_for_grid.php',
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
				dataIndex: 'fio',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return '<a href="orders.php?noframe=1&id=' + record.get('id') + '">' +
						record.get('fio') +
						'</a>';
				},
				text: 'Заказчик'
			},
			{
				xtype: 'numbercolumn',
				width: 100,
				align: 'right',
				dataIndex: 'total',
				text: 'Сумма'
			},
			{
				xtype: 'gridcolumn',
				width: 150,
				dataIndex: 'email',
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return '<a href="mailto://"' + record.get('email') + '">' + record.get('email') + '</a>';
				},
				text: 'E-mail'
			},
			{
				xtype: 'gridcolumn',
				width: 125,
				dataIndex: 'phone',
				text: 'Телефон'
			},
			{
				xtype: 'gridcolumn',
				width: 125,
				dataIndex: 'dt',
				renderer: Ext.util.Format.dateRenderer('d.m.Y H:i'),
				text: 'Дата оформления'
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
