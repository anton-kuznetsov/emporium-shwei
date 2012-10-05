
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
				name: 'title'
			},
			{
				name: 'id_article_category'
			},
			{
				name: 'article_category'
			},
			{
				name: 'link_label'
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
	        url: 'app/Articles/grid.php',
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
				dataIndex: 'title',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					return '<a href="articles.php?noframe=1&id=' + record.get('id') + '">' +
						record.get('title') +
						'</a>';
				},
				text: 'Наименование'
			},
			{
				xtype: 'gridcolumn',
				width: 200,
				dataIndex: 'article_category',
				renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
					if ( record.get('article_category') == '' ) {
						return '';
					} else {
						return '<a href="article_categories.php?noframe=1&id=' + record.get('id_article_category') + '">' +
							record.get('article_category') +
							'</a>';
					}
				},
				text: 'Категория'
			},
			{
				xtype: 'gridcolumn',
				width: 200,
				dataIndex: 'link_label',
				text: 'Псевдоним для ссылки'
			},
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
