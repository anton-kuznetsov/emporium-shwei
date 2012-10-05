
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
				name: 'label'
			},
			{
				name: 'level'
			},
			{
				name: 'parent'
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
	        url: 'app/ArticleCategories/grid.php',
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
				dataIndex: 'label',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return str_repeat_js('&nbsp;&nbsp;&nbsp;&nbsp;', (record.get('level') - 1)) +
						'<a href="article_categories.php?noframe=1&id=' + record.get('id') + '">' +
						record.get('label') +
						'</a>';
				},
				text: 'Наименование'
			},
			{
				xtype: 'numbercolumn',
				width: 80,
				align: 'right',
				dataIndex: 'level',
				format: '0',
				text: 'Уровень'
			},
			{
				xtype: 'numbercolumn',
				width: 80,
				align: 'right',
				dataIndex: 'parent',
				format: '0',
				text: 'Категория'
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
