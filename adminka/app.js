
// Ext.Loader.setConfig({enabled:true});

// Подгружаю классы, которые буду использовать

Ext.require('Ext.container.Viewport');

// Приложение

Ext.application({
	name: 'Baby-Suit.Ru :: Управление данными',
	launch: function() {

//**************************************************************************************************
// Дерево навигации (menu_tree.js)
//  - menu_tree
//      - menu_tree.model
//      - menu_tree.store
//      - menu_tree.panel
//**************************************************************************************************

    	Ext.create('Ext.Viewport', {
	        layout: {
	            type: 'border',
	            padding: 5
	        },
	        items: [

				// Правая часть

				menu_tree.panel,

				// Центр

				{
					xtype: 'panel',
					id: 'frame_panel',
					itemId: 'frame_panel',
					region: 'center',
					padding: '0 0 0 5px',
					border: false
				},
			]
	    });
	}
});