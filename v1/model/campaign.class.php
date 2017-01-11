<?php 
class Campaign{

	public function getGraphic($id, $tipo){
		require_once('mysql.class.php');
		$url    = ""; 
		$fecha  = "";
		$estado = "";

		if($tipo == "fidelizar"){
			$url = "URL_FIDELIZAR"; $fecha = "FECHA_ENVIO_FIDELIZAR"; $estado = "ESTADO_FIDELIZAR"; 
		}
		if($tipo == "vender"){
			$url = "URL_VENDER"; $fecha = "FECHA_ENVIO_VENDER"; $estado = "ESTADO_VENDER";
		}
		if($tipo == "invitar"){
			$url = "URL_INVITAR"; $fecha = "FECHA_ENVIO_INVITAR"; $estado = "ESTADO_INVITAR";
		}

		$sql 	 = new mySql();
		$res = $sql->query("SELECT * FROM `".$tipo."` WHERE `ID_USUARIO` = ".$id." AND ".$estado." = 1;");
		$arr = array();
		while($row = $sql->fetch_assoc($res)) {
			array_push($arr, array("id"=>$id, "url"=>$row[$url], "fecha"=>$row[$fecha]));
		}

		$json =  $this->getSummary($id, json_encode($arr));
		$json = json_decode($json, true);

		$deli = 0;$open = 0;
		foreach($json as $item){
			$deli = $item["deli"];
			$open = $item["open"];
		}

		return json_encode(array("envi"=>$deli,"aper"=>$open,"porce"=>$this->getPorcent($deli, $open)));
	}

	public function getPorcent($envi, $aper)
	{
		$porcent = 0;
		if($envi!=0){
			$porcent = (100*$aper)/$envi;
		}
		return round($porcent);
	}

	public function getSummary($id, $json){
		ini_set("date.timezone", "America/Buenos_Aires");
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key = $elastic->getApiKey($id);

		$nodes = array();
		$json = json_decode($json, true);

		foreach($json as $item){
			$data = 'https://api.elasticemail.com/v2/log/summary?'.
			'&apikey='.$key["key"].
			'&from='.str_replace(' ','T',$item["fecha"]).
			'&to='.date("Y-m-d")."T".date("H:i:s").
			'&channelname='.urlencode($item["url"]).
			'&interval=daily';
			array_push($nodes , $data);
		}
		
		$node_count = count($nodes);

		$curl_arr = array();
		$master = curl_multi_init();

		for($i = 0; $i < $node_count; $i++){
			$url =$nodes[$i];
			$curl_arr[$i] = curl_init($url);
			curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
			curl_multi_add_handle($master, $curl_arr[$i]);
		}

		do {
			curl_multi_exec($master,$running);
		} while($running > 0);
		
		$arr = array();
		$deli = array();
		$open = array();
		for($i = 0; $i < $node_count; $i++){
			$json = curl_multi_getcontent($curl_arr[$i]);
			$json = json_decode($json, true);
			if($json["success"]==true){
				foreach($json as $item) {
					array_push($deli, (int)$item['logstatussummary']['delivered']);
					array_push($open, (int)$item['logstatussummary']['opened']);
				}
			}
		}

		array_push($arr , array("deli"=>array_sum($deli), "open"=>array_sum($open)));

		curl_multi_close($master);
		return json_encode($arr);
	}





}

?>