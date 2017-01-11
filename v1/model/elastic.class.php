<?php
class Elastic{
	public function getPublic($id){
		require_once('mysql.class.php');
		$sql = new mySql();
		$res = $sql->query("SELECT PUBLIC_ELASTIC FROM usuario WHERE ID_USUARIO = '".$id."'");

		if($sql->num_rows($res) > 0){
			while($row = $sql->fetch_assoc($res))
				return array( "status"=>true, "pub"=>$row["PUBLIC_ELASTIC"] );
		}else{
			return array("status"=>false);
		}
	}

	public function getApiKey($id){
		require_once('mysql.class.php');
		$sql = new mySql();
		$res = $sql->query("SELECT KEY_ELASTIC FROM usuario WHERE ID_USUARIO = '".$id."'");

		if($sql->num_rows($res) > 0){
			while($row = $sql->fetch_assoc($res))
				return array( "status"=>true, "key"=>$row["KEY_ELASTIC"] );
		}else{
			return array("status"=>false);
		}
	}

	public function getUser($id){
		require_once('mysql.class.php');
		$sql = new mySql();
		$res = $sql->query("SELECT USR_ELASTIC FROM usuario WHERE ID_USUARIO = '".$id."'");
		
		if($sql->num_rows($res) > 0){
			while($row = $sql->fetch_assoc($res))
				return array( "status"=>true, "key"=>$row["USR_ELASTIC"] );
		}else{
			return array("status"=>false);
		}
	}
	
	public function getChannel($id, $cod){
		$data = 'https://api.elasticemail.com/v2/campaign/list?'.
		'apikey='.$this->getApiKey($id).
		'&search='.$cod;
		
		$html = $this->fileGetContentsCurl($data);
		$json = json_decode($html, true);	

		foreach($json['data'] as $item)
			return $item['channelid'];
	}

	public function fileGetContentsCurl($url){
		$handler = curl_init();
		curl_setopt($handler, CURLOPT_URL, $url);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER,true);
		$response = curl_exec ($handler);
		curl_close($handler);
		return $response;
	}

















}




?>