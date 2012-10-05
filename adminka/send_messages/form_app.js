
// Подгружаю классы, которые буду использовать

Ext.require('Ext.container.Viewport');

// Приложение

Ext.application({
	name: 'Baby-Suit.Ru :: Управление данными',
	launch: function() {

    	var cw;

//******************************************************************************
// Каркас экрана
//******************************************************************************

    	Ext.create('Ext.Viewport', {
	        layout: {
	            type: 'border'
	        },
	        items: [
				tabs.panel
			]
	    });
	}
});