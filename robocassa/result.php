<?php

	require_once "../var.php";
	require_once "../includes/classes.php";

	//

	$out_summ = $_REQUEST["OutSum"];
	$inv_id = $_REQUEST["InvId"];
	$crc = $_REQUEST["SignatureValue"];
	
	$crc = strtoupper($crc);

	$my_crc = strtoupper(md5("$out_summ:$inv_id:$robocassa_pass2"));

	if (strtoupper($my_crc) != strtoupper($crc)) {

	  echo "bad sign\n";
	  exit();

	}

	echo "OK$inv_id\n";

	// Отметить что заказ оплачен на сумму = $out_summ

	$order_dalc = new Order_DALC(); 

	$order_dalc->Paying( $inv_id, $out_summ );

?>