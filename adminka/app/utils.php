<?php

class Utils {

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct( ) {

	}

	//--------------------------------------------------------------------------
	// 

	public static function GetRequestParam ( $name, $type, $default = null, $request ) {

		$field = null;

		if ( isset($default) ) {

			$field = $default;

		} else {

			switch ($type) {
				case 'string':
				case 'datetime':
					$field = '';
					break;
				case 'int':
					$field = 0;
					break;
				case 'float':
					$field = 0.0;
					break;
			}
		}

		//
		
		if (isset($_REQUEST[$name])) {
	
			$field = $_REQUEST[$name];
	
		} else {
	
			if (isset($request->params->$name)) {
	
				$field = $request->params->$name;
	
			}
		}

		//

		if ($type == 'string') {

			$field = addslashes($field);

		}

		return $field;

	}

	//--------------------------------------------------------------------------
	// 

	public static function GetRequestParamList ( $arr, $request ) {

		$data = array();

		foreach ( $arr as $item ) {

			if (! array_key_exists('default', $item)) {

				$item['default'] = null;

			}

			$data[$item['name']] = Utils::GetRequestParam( $item['name'], $item['type'], $item['default'], $request );

		}

		return $data;

	}

};

?>