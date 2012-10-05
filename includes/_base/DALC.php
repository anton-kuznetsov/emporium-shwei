<?php



class DALC {



	// Параметры доступа к БД

	// логин

	private $db_login = 'root';

	// пароль

	private $db_pass = '';

	// имя хоста

	private $db_host = 'localhost';

	// имя базы данных

	private $db_name = 'shwei';



	// 

	protected $db = NULL;



	// Физическое расположение файла класса

	protected $folder_class = '';



	//--------------------------------------------------------------------------

	// Конструктор



	function __construct() {



		global $folder_root;



		$this->folder_class = $folder_root . '/includes/_base/';



		$this->db = mysql_connect($this->db_host, $this->db_login, $this->db_pass);

		mysql_select_db($this->db_name, $this->db);

		mysql_query('SET NAMES utf8');



	}



	//--------------------------------------------------------------------------

	// Получение списка записей из таблицы



	public function SQL_SelectAll( $table = NULL, $fields ) {



		$res = array ();



		//



		if (is_null($fields)) {



			$fields_str = "*";



		} else {



			$fields_str = "id, " . join(", ", $fields);

		

		}



		$result = mysql_query( "SELECT " . $fields_str . " FROM " . $table, $this->db );



		if (!$result) {

			die('Неверный запрос: ' . mysql_error());

		}



		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {



			$res[$row['id']] = $row;



		}



		mysql_free_result($result);



		//



		return $res;



	}



	//--------------------------------------------------------------------------

	// Получение записи из таблицы



	public function SQL_SelectItem($table = NULL, $fields = NULL, $id = 0 ) {



		$res = array ();



		//



		$fields_str = '';



		if (is_null($fields)) {



			$fields_str = "*";



		} else {



			$fields_str = "id, " . join(", ", $fields);

		

		}



		$where = " WHERE id = " . $id;



		$result = mysql_query( 

			" SELECT " . $fields_str .

			" FROM " . $table .

			$where, $this->db );



		if (!$result) {

			die('Неверный запрос: ' . mysql_error());

		}



		if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {



			$res = $row;



		}



		mysql_free_result($result);



		//



		return $res;



	}



	//--------------------------------------------------------------------------

	// Получение списка записей из таблицы



	public function SQL_SelectList($table = NULL, $fields = NULL, $where = '', $order = '', $limit = 0 ) {



		$res = array ();



		//



		$fields_str = '';



		if (is_null($fields)) {



			$fields_str = "*";



		} else {



			$fields_str = "id, " . join(", ", $fields);

		

		}



		if ( $where != '' ) {

			$where = " WHERE " . $where;

		}



		if ( $order != '' ) {

			$order = " ORDER BY " . $order;

		}



		if ( $limit != 0 ) {

			$limit = " LIMIT 0, " . $limit;

		} else {

			$limit = '';

		}



		$result = mysql_query( 

			" SELECT " . $fields_str .

			" FROM " . $table .

			$where .

			$order .

			$limit, $this->db );



		if (!$result) {

			die('Неверный запрос: ' . mysql_error());

		}



		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {



			$res[$row['id']] = $row;



		}



		mysql_free_result($result);



		//



		if ( count($res) > 0 ) {

			return $res;

		} else {

			return NULL;

		}

	}



	//--------------------------------------------------------------------------

	// Получение списка записей из таблицы



	public function SQL_SelectListDistinct($table = NULL, $fields = NULL, $where = '', $order = '', $limit = 0 ) {



		$res = array ();



		//



		$fields_str = '';



		if (is_null($fields)) {



			return NULL;



		} else {



			$fields_str = join(", ", $fields);

		

		}



		if ( $where != '' ) {

			$where = " WHERE " . $where;

		}



		if ( $order != '' ) {

			$order = " ORDER BY " . $order;

		}



		if ( $limit != 0 ) {

			$limit = " LIMIT 0, " . $limit;

		} else {

			$limit = '';

		}



		$result = mysql_query( 

			" SELECT DISTINCT " . $fields_str .

			" FROM " . $table .

			$where .

			$order .

			$limit, $this->db );



		if (!$result) {

			die('Неверный запрос: ' . mysql_error());

		}



		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {



			$res[count($res)] = $row;



		}



		mysql_free_result($result);



		//



		if ( count($res) > 0 ) {

			return $res;

		} else {

			return NULL;

		}

	}



	//--------------------------------------------------------------------------

	// Получение списка записей из таблицы



	public function SQL_SelectAllByIds( $table = NULL, $ids ) {



		$res = array ();



		//

		

		if ($ids == '') { return $res; }



		//



		$result = mysql_query( "SELECT * FROM " . $table . " WHERE id IN (" . $ids . ")", $this->db );



		if (!$result) {

			die('Неверный запрос: ' . mysql_error());

		}



		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {



			$res[$row['id']] = $row;



		}



		mysql_free_result($result);



		//



		return $res;



	}



	//--------------------------------------------------------------------------



	public function SQL_SelectIdsTree( $table = NULL, $parent_field = 'parent', $id = 0 ) {



		$res = '';

		$items = array ();



		$result = mysql_query( "SELECT id FROM " . $table . " WHERE " . $parent_field . " = " . $id . " ORDER BY id " , $this->db );



		if (!$result) {

			die('Неверный запрос: ' . mysql_error());

		}



		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {



			$items[$row['id']] = $row['id'];



		}



		mysql_free_result($result);



		foreach ($items as $id_child) {



			$res .= ($res != '' ? ',' : '') . $id_child;

			$str_from_child = $this -> SQL_SelectIdsTree( $table, $parent_field, $id_child );



			if ($str_from_child != '') {



				$res .= ($res != '' ? ',' : '') . $str_from_child;



			}

		}



		//



		return $res;



	}



	//--------------------------------------------------------------------------



	public function SQL_CreateItem( $table = NULL, $values = array() ) {



		$fields_str = '';

		$values_str = '';



		foreach ($values as $key => $value) {

			$fields_str .= ( $fields_str == '' ? '' : ', ') . $key;

			$values_str .= ( $values_str == '' ? '' : ', ') . "'" . $value . "'";

		}



		$result = mysql_query(

			" INSERT INTO " . $table .

			" ( " . $fields_str . " ) VALUES ( " . $values_str . ")",

			$this->db

		);

		

		if (!$result) {

			die('Неверный запрос: ' . mysql_error());

		}



		mysql_free_result($result);



		//



		$id_new_row = mysql_insert_id( $this->db );



		$data = $this->SQL_SelectItem( $table, NULL, $id_new_row ); 



		return $data;



	}



	//--------------------------------------------------------------------------



	public function SQL_UpdateItems( $table = NULL, $items = array(), $fields = array() ) {



		foreach ( $items as $item ) {



			$sets = '';			



			foreach ( $fields as $field ) {



				$sets = ( $sets == '' ? '' : ', ' ) . $field . " = '" . $item[$field] . "' ";



			}



			if ( $sets != '' ) {



				$result = mysql_query(

					" UPDATE " . $table .

					" SET " . $sets .

					" WHERE id = " . $item['id'],

					$this->db

				);

				

				if (!$result) {

					die('Неверный запрос: ' . mysql_error());

				}

			

				mysql_free_result($result);

			}

		}

	}



	//--------------------------------------------------------------------------



	public function SQL_DeleteItems( $table = NULL, $where = '' ) {



		if ( $where != '' ) {

			$where = " WHERE " . $where;

		}



		#



		$result = mysql_query(

			" DELETE FROM " . $table .

			$where,

			$this->db

		);



		if (!$result) {

			die('Неверный запрос: ' . mysql_error());

		}



		mysql_free_result($result);



	}

};



?>