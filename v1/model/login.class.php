<?php
class Login{
	
	public function logeo($email, $pass)
	{
		$email = preg_replace('~[^A-Za-z0-9@-_.]~','',$email);
		$pass  = preg_replace('~[^A-Za-z0-9@-_.]~','',$pass);
		ini_set("date.timezone", "America/Buenos_Aires");
		$sql = new mySql();
		if(strlen($email)<3){
			return json_encode(array("code"=>"400", "msg"=>"*Ingrese un correo valido."));
		}elseif(strlen($pass)<3){
			return json_encode(array("code"=>"400", "msg"=>"*Ingrese una contraseña valida."));
		}else{	
			$res = $sql->query("SELECT PASS_USUARIO, ESTADO_USUARIO, ID_USUARIO, CADUCA_USUARIO  FROM usuario WHERE CORREO_USUARIO = '".$email."' ;");

				
			if( $sql->num_rows($res) > 0 ){
				while($row = $sql->fetch_assoc($res)){
					
					if( $row["PASS_USUARIO"] == hash('sha512', $pass)){
						if( $row["ESTADO_USUARIO"] == 1 ){
							$datehoy = date("Y-m-d");
							$dateOff = date($row["CADUCA_USUARIO"]);
							
							if($datehoy <= $dateOff){
								$sha = new Encrypter();
								$tok = $sha->encrypt($row["ID_USUARIO"]);
								$_SESSION["ide"] = $row["ID_USUARIO"];
								setcookie("ses", $tok, time() + (86400*7), "/" , "inboxshot.com" , NULL, true);
								$sql->query("INSERT INTO sessions SET sessionId = '".$tok."', userId = '".$row["ID_USUARIO"]."', userIp = '".$_SERVER['REMOTE_ADDR']."'");
								return json_encode(array("code"=>"200"));
							}else{
								return json_encode(array("code"=>"400", "msg"=>"*Su tiempo de suscripción ha terminado."));
							}
						}else{
							return json_encode(array("code"=>"888", "msg"=>"*Su tiempo de suscripción ha terminado."));
						}
					}else{
						return json_encode(array("code"=>"400", "msg"=>"*Su correo o contraseña son incorrectos."));
					}
				}
			}else{
				return json_encode(array("code"=>"400", "msg"=>"*Su correo o contraseña son incorrectos. (k)"));
			}
		}
	}
	
	public function checkValidate($ide, $token)
	{
		$sha = new Encrypter();
		if($ide != $sha->decrypt($token))
			return false;
		else
			return true;
	}
}
?>