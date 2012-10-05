<?php

	// Инициализация

	require_once "app/var.php";	

	//

	$id = 0;

	if (isset($_REQUEST ["id"])) {

		$id = $_REQUEST ["id"];

	}

	if (! isset($_REQUEST ["noframe"])) {

?>

<iframe src='<?php echo $site_url; ?>send_messages.php?noframe=1&id=<?php echo $id; ?>' width="100%" height="100%"></iframe>

<?php

	} else {

?>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta http-equiv="Expires" content="-1">
		<meta http-equiv="Cache-Control" content="No-Cache">
		<meta http-equiv="pragma" content="no-cache">

		<title>Baby-Suit.Ru :: Управление данными</title>

		<link rel="stylesheet" type="text/css" href="extjs/resources/css/ext-all.css">

		<link rel="stylesheet" type="text/css" href="resources/css/style.css">

    	<script type="text/javascript" src="extjs/ext-all-debug.js"></script>
		<script type="text/javascript" src="utils.js"></script>

<?php

	if ( $id ) {

?>

		<script type="text/javascript">

			var request_param_id = <?php echo $id; ?>;

		</script>

    	<script type="text/javascript" src="send_messages/form.js"></script>

    	<script type="text/javascript" src="send_messages/form_app.js"></script>

<?php

	} else {

?>

		<script type="text/javascript">

		</script>

    	<script type="text/javascript" src="send_messages/grid.js"></script>

    	<script type="text/javascript" src="send_messages/grid_app.js"></script>

<?php

	}

?>

	</head>
	<body>

	</body>
</html>

<?php

	}

?>