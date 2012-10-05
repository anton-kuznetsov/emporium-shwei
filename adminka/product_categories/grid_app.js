
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
	        	{
					xtype: 'panel',
					layout: {
						type: 'border'
					},
					title: 'Категории товаров',
					region: 'center',
					items: [
						grid.panel
					],
					dockedItems: [
					    {
					        xtype: 'toolbar',
					        dock: 'top',
					        items: [
					            {
					                xtype: 'button',
					                text: 'Добавить',
					                listeners: {
					                    click: {
					                        fn: AddBtn_onClick,
					                    }
					                }
					            },
					            {
					                xtype: 'button',
					                text: 'Удалить',
					                listeners: {
					                    click: {
					                        fn: DeleteBtn_onClick,
					                    }
					                }
					            }
					        ]
					    }
					]
	        	}
			]
	    });

	    function AddBtn_onClick (button, e, options) {

			location.href = 'product_categories.php?noframe=1&_add=1';

    	};

    	function DeleteBtn_onClick (button, e, options) {

			var sel = grid.panel.getSelectionModel().getSelection();
 
		    var ids = '-1';

			if ( sel.length > 0 ) {

			    for ( i = 0; i <= sel.length - 1; i++ ) {
	
			        ids = ids + ', ' + sel[i].get('id');
	
			    }

			 	Ext.Msg.confirm (
				 	'Удаление',
					'Вы действительно хотите удалить выбранные запись?',
					function(btn, text) {
						if (btn == 'yes'){
						    Ext.Ajax.request(
								{
						        	url: 'app/Categories/delete.php',
						        	method: 'POST',
						        	params: {
										'ids': ids
									},
						        	success: function(obj) {
										grid.store.load();
							        },
									failure: function(){
										Ext.MessageBox.alert('Failed', 'Произошла системная ошибка');
										grid.store.load();
									}
				   				}
							);
						}
					}
				);

			} else {

				Ext.MessageBox.alert('Удаление', 'Выберите записи, которые следует удалить');

			}
    	};
	}
});