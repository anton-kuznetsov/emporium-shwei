
var menu_tree = {};

//--------------------------------------------------------------------------------------------------
// Модель данных

menu_tree.model = Ext.define (
	'menu_tree.model',
	{
	    extend: 'Ext.data.Model',
	    idProperty: 'id',
	    fields: [
	        {
	            name: 'id'
	        },
	        {
	            name: 'text'
	        },
	        {
	            name: 'href_panel'
	        },
	        {
	            name: 'leaf'
	        },
	        {
	            name: 'cls'
	        }
	    ]
	}
);

//--------------------------------------------------------------------------------------------------
// Источник данных

menu_tree.store = Ext.create(
	'Ext.data.TreeStore',
	{
	    proxy: {
	        type: 'ajax',
	        url: 'app/Tree/ajax.php',
			reader: {
				type: 'json'
			}
	    },

		model: menu_tree.model,	    

		autoLoad: true,
		autoSync: true,
		clearOnLoad: false	    
	}
);

//--------------------------------------------------------------------------------------------------
// 

menu_tree.view = {
	onItemClick: function(dataview, record, item, index, e, options) {

        var i = record;
        var tr = dataview;
        var frame = tr.up().up().items.get('frame_panel');

        frame.loader = new Ext.ComponentLoader({
            url: i.get('href_panel'),
            autoLoad: true,
            renderer: 'html',
            target: frame,           // !!! обязательно !!!
            scripts: true,
            text: "Loading..."
        });
    }
}

//--------------------------------------------------------------------------------------------------
// Панель

menu_tree.panel = Ext.create(
	'Ext.tree.Panel',
	{
		title: 'Навигация',

		store: menu_tree.store,

		autoScroll: false,
        collapsed: false,
		rootVisible: false,

		width: 300,
	    height: 200,

		region: 'west',

		viewConfig: {
			draggable: false,
			autoScroll: false,
			listeners: {
				itemclick: {
					fn: menu_tree.view.onItemClick
				}
			}
		}
	}
);
