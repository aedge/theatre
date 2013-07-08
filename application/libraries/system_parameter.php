<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class system_parameter {
	
	public static function getSP( $section, $key ) {
		
		$this -> db -> select('value');
		$this -> db -> from('systemparameter');
		$this -> db -> where('section', $section);
		$this -> db -> where('key', $key);
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
		 return $query->row()->value;
		}
		else
		{
		 return false;
		}	
	}	
	
	public static function setSP( $section, $key, $value ) {
		
		$this -> db -> query("insert into systemparameter (`section`,`key`,`value`) values ('$section','$key','$value') on duplicate key update `value`='$value'");
		
		return true;
	}
}

?>