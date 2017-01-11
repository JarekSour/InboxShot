<?php
class Notify{
	
	//notificaciones
	public function getNotify($id){
		require_once('mysql.class.php');
		$sql = new mySql();
		$res = $sql->query("SELECT * FROM `notificacion` WHERE `ID_USUARIO` =".$id." AND `LECTURA_NOTIFICACION` =0 ORDER BY `ID_NOTIFICACION` DESC ");
		
		$data = array();
		if($sql->num_rows($res)>0){
			while($row = $sql->fetch_assoc($res)){
				$ans = $sql->query("SELECT * from ".$row["TIPO_CAMPANA_NOTIFICACION"]." WHERE ID_USUARIO = '".$id."' AND ID_".strtoupper($row["TIPO_CAMPANA_NOTIFICACION"])." = ".$row["ID_CAMPANA"]."  ;");
				$fila = $sql->fetch_assoc($ans);
				
				$colorborde = $row["ESTADO_NOTIFICACION"] == 0 ? "danger2" : "success2";
				$colortext  = $row["ESTADO_NOTIFICACION"] == 0 ? "dangerNotify" : "successNotify";
				$texto      = $row["ESTADO_NOTIFICACION"] == 0 ? "Los creditos no son suficientes para enviar la campaña" : "La campaña ha sido enviada exitosamente";


				array_push($data, array('id' => $row["ID_NOTIFICACION"], 'colborde'=> $colorborde, 'coltext'=> $colortext, 'txt'=>$texto, 'nombre'=> $fila["NOMBRE_".strtoupper($row["TIPO_CAMPANA_NOTIFICACION"])], 'tipo' => ucwords($row["TIPO_CAMPANA_NOTIFICACION"]), 'fecha'=>date("H:i d/m/Y", strtotime($row["FECHA_NOTIFICACION"])) ));
			}

			return json_encode(array("status"=> true, "data"=>$data, "num"=>$sql->num_rows($res)));

		}else{

			array_push($data, array('txt' => "Aún no posee notificaciones"));

			return json_encode(array("status"=> false, "data"=>$data, "num"=>0));
		}
	}

	public function deleteNotify($id){
		$sql = new mySql();
		
		$res = $sql->query("SELECT * FROM notificacion WHERE ID_NOTIFICACION = ".$id." ;");
		$row = $sql->fetch_assoc($res);
		
		$sql->query("DELETE FROM `notificacion` WHERE ID_USUARIO = '".$row["ID_USUARIO"]."' AND ID_CAMPANA = '".$row["ID_CAMPANA"]."' AND TIPO_CAMPANA_NOTIFICACION = '".$row["TIPO_CAMPANA_NOTIFICACION"]."' AND ESTADO_NOTIFICACION  = '".$row["ESTADO_NOTIFICACION"]."' ");
		
		return true;
	}
	
	public function seeNotify($id){
		$sql = new mySql();
		
		$res = $sql->query("SELECT * FROM notificacion WHERE ID_NOTIFICACION = ".$id." ;");
		$row = $sql->fetch_assoc($res);
		
		$ans = $sql->query("SELECT * FROM ".$row["TIPO_CAMPANA_NOTIFICACION"]." WHERE ID_".strtoupper($row["TIPO_CAMPANA_NOTIFICACION"])." = ".$row["ID_CAMPANA"]." ;");
		$fila = $sql->fetch_assoc($ans);
		
		return "detalle".$row["TIPO_CAMPANA_NOTIFICACION"].".php?code=".$fila["URL_".strtoupper($row["TIPO_CAMPANA_NOTIFICACION"])]."&idecamp=".$row["ID_CAMPANA"];
	
	}
}
?>