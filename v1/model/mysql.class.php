<?php
class mySql{
	public function query($consulta){
		require("db.class.php");
		$result = mysqli_query($conn, $consulta);
		return $result;
	}
	
	public function fetch_assoc($result){
		$row = mysqli_fetch_assoc($result);
		return $row;
	}
	
	public function num_rows($result){
		$num = mysqli_num_rows($result);
		return $num;
	}
	
	public function prepare($consul){
		require("db.php");
		$result = mysqli_prepare($conn, $consul);
		return $result;
	}
}
?>