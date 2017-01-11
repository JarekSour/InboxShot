<?php 
class User{


	public function getName($id){
		require_once('mysql.class.php');
		$sql = new mySql();
		$res = $sql->query("SELECT * FROM `usuario` WHERE ID_USUARIO = '".$id."';");

		if($sql->num_rows($res) > 0 )
			while($row = $sql->fetch_assoc($res)) 
				return json_encode(array("status"=>true, "nom"=>$row['NOMBRE_USUARIO']));
		else
			return json_encode(array("status"=>false));
	}

	
}
?>