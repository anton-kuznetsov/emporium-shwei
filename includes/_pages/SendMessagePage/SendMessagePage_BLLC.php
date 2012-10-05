<?php

class SendMessagePage_BLLC {

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/_pages/SendMessagePage/';

	}

	//--------------------------------------------------------------------------
	//

	public function NewMessage( $data ) {

		$dalc = new DALC();

		$send_message = $dalc->SQL_CreateItem(
			'send_messages',
			array(
				'fio'     => $data['fio'],
				'email'   => $data['email'],
				'phone'   => $data['phone'],
				'subject' => $data['subject'],
				'text'    => $data['text'],
				'dt'      => date("Y-m-d H:i:s"),
				'status'  => SendMessage_BLLC::STATUS_CREATE
			)
		);

		//

		header("Location: " . SendMessage_UI::href( array( 'action' => 'step2', 'id' => $send_message['id'] ), 1));

		exit;

	}

	//--------------------------------------------------------------------------
	//

	public function SendMessage( $data ) {

		$send_message_bllc = new SendMessage_BLLC();

		$send_message_bllc->SetStatus( $data['id'], SendMessage_BLLC::STATUS_SEND );

		// Посылаю письмо

		$this->SendToManager( $data['id'] );

		//

		header("Location: " . SendMessage_UI::href( array( 'action' => 'step3' ), 1));

		exit;

	}

	//--------------------------------------------------------------------------
	//

	public function SendToManager( $id ) {

		$send_message_bllc = new SendMessage_BLLC();

		$data = $send_message_bllc->GetData( $id );

		//

		$to  = $data['client_manager']['email'];

		// тема письма

		$subject = 'Входящее сообщение №' . $id;

		// текст письма

		$message = 
			'<html><head><title>' . $subject . '</title></head>'.
		  	'<body>
			  	<p>
					Номер сообщения: ' . $id . '<br />
					Дата: ' . $data['dt_str'] . '
				</p>
				<p>
					<b>Отправитель</b><br />
					ФИО: ' . $data['fio'] . '<br />
					E-mail: ' . $data['email'] . '<br />
					Телефон: ' . $data['phone'] . '
				</p>
				<p>
					<b>' . $data['subject'] . '</b><br />' . nl2br( $data['text'] ) . '
				</p>
			</body></html>';

		// Для отправки HTML-письма должен быть установлен заголовок Content-type

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";

		// Дополнительные заголовки

		$headers .= 'To: <' . $data['client_manager']['email'] . '>' . "\r\n";
		$headers .= 'From: BabySuit.Ru <no-reply@babysuit.ru>' . "\r\n";
		$headers .= 'Cc: ' . "\r\n";
		$headers .= 'Bcc: ' . "\r\n";

		// Отправляем

		mail($to, $subject, $message, $headers);

	}

};

?>