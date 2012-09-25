<?php

	// В базовом классе
	protected $href_params = array ();

	// В базовом классе 
	function href ( $vars = array(), $is_return = 0 ) {

		global $site_path;

		$res = $site_path . '/index.php';

		//

		foreach ($this->href_params as $p) {

			if ( array_key_exists($p['name'], $vars) ) {
				$res .= ( $res == '' ? '?' : '&') . $p['name'] . '=' . $vars[$p['name']];
			} else {
				$res .= ( $res == '' ? '?' : '&') . $p['name'] . '=' . $p['value'];
			}
		}	

		//

		if ( $is_return ) {
			return $res;
		} else {
			echo $res;
		}	
	}

	// В конструкторе наследника
	{
		$href_params = array (
			array ( 'name' => 't',           'value' => $_REQUEST ['t']           ),
			array ( 'name' => 'id_category', 'value' => $_REQUEST ['id_category'] ),
			array ( 'name' => 'id_brand',    'value' => $_REQUEST ['id_brand']    ),
			array ( 'name' => 'order',       'value' => $_REQUEST ['order']       ),
			array ( 'name' => 'p',           'value' => $_REQUEST ['p']           ),
			array ( 'name' => 'limit',       'value' => $_REQUEST ['limit']       ),
		);
	}

?>

<?php $this->href(array( 'p' => 6 )); ?>
<?php $this->href(array( 'limit' => 9 )); ?>
<?php $this->href(array( 'order' => 'date' )); ?>



