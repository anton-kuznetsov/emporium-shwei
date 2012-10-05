<?php



class CreateOrderPage_BLLC {



	function __construct() {



		global $folder_root;



		$this->folder_class = $folder_root . '/includes/_pages/CreateOrderPage/';



	}



	//--------------------------------------------------------------------------

	//



	public function NewOrder( $data ) {



		$cart_dalc = new Cart_DALC();



		$cart = $cart_dalc->GetCartBySession( session_id() );



		$order = $cart_dalc->SQL_CreateItem( 'orders', array( 'fio' => $data['fio'], 'email' => $data['email'], 'phone' => $data['phone'], 'dt' => date("Y-m-d H:i:s") ));



		//



		header("Location: " . CreateOrder_UI::href( array( 'action' => 'step2', 'id_order' => $order['id'] ), 1));

		exit;



	}



	//--------------------------------------------------------------------------

	//



	public function DoneOrder( $data ) {



		$order_dalc = new Order_DALC();

		$product_page_bllc = new ProductPage_BLLC();

		$cart_dalc = new Cart_DALC();



		$cart = $cart_dalc->GetCartBySession( session_id() );



		//



		$cart_items = $cart_dalc->GetCartItems( $cart['id'] );



		foreach ( $cart_items as $cart_item ) {



			$item = array ();

			$item['id_product'] = $cart_item['id_product'];

			$item['price'] = $cart_item['price'];

			$item['qty'] = $cart_item['qty'];

			$item['id_order'] = $data['id_order'];



			$order_dalc->CreateOrderItem( $item );



			$product_page_bllc->CountingBuy( $cart_item['id_product'] );



		}



		//



		$cart_dalc->SQL_DeleteItems( 'cart_items', ' id_cart = ' . $cart['id'] );



		// Посылаю письма



		$this->SendToClient( $data['id_order'] );

		$this->SendToManager( $data['id_order'] );



		//



		header("Location: " . CreateOrder_UI::href( array( 'action' => 'step3', 'id_order' => $data['id_order'] ), 1));

		exit;



	}



	//--------------------------------------------------------------------------

	//



	public function SendToClient( $id_order ) {



		$order_dalc = new Order_DALC();



		$order = $order_dalc->GetOrder( $id_order );



		$create_order_bllc = new Order_BLLC();



		$data = $create_order_bllc->GetData( $id_order );



		//

		

		$to  = $order['email'];

		

		// тема письма

		$subject = 'Ваш заказ № ' . $id_order;

		

		// текст письма

		$message = 

			'<html><head><title>' . $subject . '</title></head>'.

		  	'<body>

			  	<p>

					Номер заказа: ' . $id_order . '<br />

					Дата: ' . $data['dt_str'] . '

				</p>

				<p>

					<b>Заказчик</b><br />

					ФИО: ' . $data['fio'] . '<br />

					E-mail: ' . $data['email'] . '<br />

					Телефон: ' . $data['phone'] . '

				</p>

				<table id="order-table" style="width: 100%;" border="1" cellpadding="0" cellspacing="0">

					<col width="1" />

					<col />

					<col width="1" />

					<col width="1" />

					<col width="1" />

					<thead>

						<tr>

							<th rowspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">№</span></th>

							<th rowspan="1" style="padding: 4px;"><span style="white-space: nowrap; ">Наименование</span></th>

							<th colspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Цена</span></th>

							<th rowspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Кол-во</span></th>

							<th colspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Сумма</span></th>

						</tr>

					</thead>

					<tbody>';



		$i = 0;



		foreach ( $data['order_items'] as $item ) {



			$i++;



			$message .= 

						'<tr>

							<td style="text-align: center; padding: 4px;">

								' . $i . '

							</td>

							<td style="padding: 4px;">

								' . $item['label'] . '

							</td>

							<td style="text-align: right; padding: 4px;">

								<span style="white-space: nowrap; ">' . $item['price_str'] . '</span>

							</td>

							<td style="text-align: center; padding: 4px;">

								' . $item['qty'] . '

							</td>

							<td style="text-align: right; padding: 4px;">

								<span style="white-space: nowrap; ">' . $item['subtotal_str'] . '</span>

							</td>

						</tr>';



		}



		$message .=

					'</tbody>

				</table>

				<br />

				<p>

					Сумма заказа: <b>' . $data['total_str'] . '</b>

				</p>

				<p>

					<b>Менеджер по работе с клиентами</b><br />

					Имя: ' . $data['client_manager']['fio'] . '<br />

					Телефон: ' . $data['client_manager']['phone'] . '

				</p>

			</body></html>';



		// Для отправки HTML-письма должен быть установлен заголовок Content-type

		$headers  = 'MIME-Version: 1.0' . "\r\n";

// 		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";

		

		// Дополнительные заголовки

		$headers .= 'To: <' . $order['email'] . '>' . "\r\n";

		$headers .= 'From: Shwei.Ru <no-reply@shwei.ru>' . "\r\n";

		$headers .= 'Cc: ' . "\r\n";

		$headers .= 'Bcc: ' . "\r\n";

		

		// Отправляем

		mail($to, $subject, $message, $headers);



	}



	//--------------------------------------------------------------------------

	//



	public function SendToManager( $id_order ) {



		$order_dalc = new Order_DALC();



		$order = $order_dalc->GetOrder( $id_order );



		$create_order_bllc = new Order_BLLC();



		$data = $create_order_bllc->GetData( $id_order );



		//

		

		$to  = $data['client_manager']['email'];

		

		// тема письма

		$subject = 'Заказ № ' . $id_order;

		

		// текст письма

		$message = 

			'<html><head><title>' . $subject . '</title></head>'.

		  	'<body>

			  	<p>

					Номер заказа: ' . $id_order . '<br />

					Дата: ' . $data['dt_str'] . '

				</p>

				<p>

					<b>Заказчик</b><br />

					ФИО: ' . $data['fio'] . '<br />

					E-mail: ' . $data['email'] . '<br />

					Телефон: ' . $data['phone'] . '

				</p>

				<table id="order-table" style="width: 100%;" border="1" cellpadding="0" cellspacing="0">

					<col width="1" />

					<col />

					<col width="1" />

					<col width="1" />

					<col width="1" />

					<thead>

						<tr>

							<th rowspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">№</span></th>

							<th rowspan="1" style="padding: 4px;"><span style="white-space: nowrap; ">Наименование</span></th>

							<th colspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Цена</span></th>

							<th rowspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Кол-во</span></th>

							<th colspan="1" style="text-align: center; padding: 4px;"><span style="white-space: nowrap; ">Сумма</span></th>

						</tr>

					</thead>

					<tbody>';



		$i = 0;



		foreach ( $data['order_items'] as $item ) {



			$i++;



			$message .= 

						'<tr>

							<td style="text-align: center; padding: 4px;">

								' . $i . '

							</td>

							<td style="padding: 4px;">

								' . $item['label'] . '

							</td>

							<td style="text-align: right; padding: 4px;">

								<span style="white-space: nowrap; ">' . $item['price_str'] . '</span>

							</td>

							<td style="text-align: center; padding: 4px;">

								' . $item['qty'] . '

							</td>

							<td style="text-align: right; padding: 4px;">

								<span style="white-space: nowrap; ">' . $item['subtotal_str'] . '</span>

							</td>

						</tr>';



		}



		$message .=

					'</tbody>

				</table>

				<br />

				<p>

					Сумма заказа: <b>' . $data['total_str'] . '</b>

				</p>

			</body></html>';



		// Для отправки HTML-письма должен быть установлен заголовок Content-type

		$headers  = 'MIME-Version: 1.0' . "\r\n";

// 		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";

		

		// Дополнительные заголовки

		$headers .= 'To: <' . $data['client_manager']['email'] . '>' . "\r\n";

		$headers .= 'From: Shwei.Ru <no-reply@shwei.ru>' . "\r\n";

		$headers .= 'Cc: ' . "\r\n";

		$headers .= 'Bcc: ' . "\r\n";

		

		// Отправляем

		mail($to, $subject, $message, $headers);



	}



};



?>