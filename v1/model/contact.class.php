<?php
class Contact{

	//agregar contacto manual
	public function addContact($id,$nombre,$apellido,$correo,$sexo,$fecha,$grupo,$telefono,$celular,$pais,$ciudad,$empresa,$http){
		if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
			$date = '';
			if(strlen($fecha)>6){
				$date = date_create($fecha);
				$date = date_format($date,"Y-m-d");
			}
			require_once('elastic.class.php');
			$elastic = new Elastic();
			$pub     = $elastic->getPublic($id);

			$gender = strlen($sexo) > 0 ? "&gender=".urlencode($sexo) : "";
			$home = $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/contact/add".
				"?publicAccountID=".urlencode($pub["pub"]).		
				"&email=".urlencode($correo).
				"&firstName=".urlencode($nombre).
				"&lastName=".urlencode($apellido).
				"&phone=".urlencode($telefono).
				"&mobileNumber=".urlencode($celular).
				"&notes=".urlencode($grupo).
				$gender.
				"&birthDate=".urlencode($date).
				"&city=".urlencode($ciudad).
				"&country=".urlencode($pais).
				"&organizationName=".urlencode($empresa).
				"&website=".urlencode($http).
				"&requiresActivation=false");

			$json = json_decode($home, true);

			if (strpos($home, 'already subscribed') !== false) 
				return json_encode(array("status"=>false, "msg"=>"El contacto ya existe en su base de datos"));

			if (strpos($home, 'has been successfully subscribed') !== false)
				return json_encode(array("status"=>true, "msg"=>"El contacto ha sido agregado exitosamente"));

			if (strpos($home, 'We can not add your email') !== false)
				return json_encode(array("status"=>false, "msg"=>"El contacto no pudo ser agregado, verifique su límite de contactos permitidos."));

			return json_encode(array("status"=>false, "msg"=>$json["error"]));
			
		}else{
			return json_encode(array("status"=>false, "msg"=>"El correo ingresado no es válido"));
		}
	}

	public function getDataClient($ide, $mail){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($ide);
		$json = $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/contact/loadcontact?apikey=".$key["key"]."&email=".urlencode($mail));
		$json = json_decode($json, true);
		
		$nom = $json["data"]["firstname"] != NULL ? $json["data"]["firstname"] : "";
		$ape = $json["data"]["lastname"] != NULL ? $json["data"]["lastname"] : "";
		$mai = $json["data"]["email"] != NULL ? $json["data"]["email"] : "";
		$sex = $json["data"]["gender"] != NULL ? $json["data"]["gender"] : "";
		$fec = $json["data"]["birthdate"] != NULL ? date("d-m-Y", strtotime($json["data"]["birthdate"]))  : "";
		$gru = $json["data"]["notes"] != NULL ? $json["data"]["notes"] : "";
		$fon = $json["data"]["phone"] != NULL ? $json["data"]["phone"] : "";
		$cel = $json["data"]["mobilenumber"] != NULL ? $json["data"]["mobilenumber"] : "";
		$pai = $json["data"]["country"] != NULL ? $json["data"]["country"] : "";
		$ciu = $json["data"]["city"] != NULL ? $json["data"]["city"] : "";
		$emp = $json["data"]["organizationname"] != NULL ? $json["data"]["organizationname"] : "";
		$web = $json["data"]["websiteurl"] != NULL ? $json["data"]["websiteurl"] : "";
		$gra = $json["data"]["gravatarhash"] != NULL ? $json["data"]["gravatarhash"] : "";

		$auxSex = '<option></option>';
		$auxSex .= '<option value="m" ';
		$auxSex .= $sex == "m" ? 'selected="selected"' : '';
		$auxSex .= '>Masculino</option>';
		$auxSex .= '<option value="f" ';
		$auxSex .= $sex == "f" ? 'selected="selected"' : '';
		$auxSex .= '>Femenino</option>';

		return json_encode(array("nom"=>$nom,"ape"=>$ape,"mai"=>$mai,"sex"=>$auxSex,"fec"=>$fec,"gru"=>$gru,
			"fon"=>$fon,"cel"=>$cel,"pai"=>$pai,"ciu"=>$ciu,"emp"=>$emp,"web"=>$web, "gra"=>$gra));
	}

	public function updateContact($id, $idc, $nombre, $apellido, $correo, $sexo, $fecha, $grupo, $telefono, $celular, $pais, $ciudad, $empresa, $url){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key = $elastic->getApiKey($id);
		
		$gender = strlen($sexo) > 0 ? $sexo : "";
		$fecha = strlen($fecha) > 0 ? date("Y-m-d", strtotime($fecha)) : "";
		
		$html = $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/contact/update".
			"?apikey=".$key["key"].
			"&email=".urlencode($idc).
			"&newEmail=".urlencode($correo).
			"&firstName=".urlencode($nombre).
			"&lastName=".urlencode($apellido).
			"&company=".urlencode($empresa).				  
			"&city=".urlencode($ciudad).
			"&country=".urlencode($pais).
			"&birthDate=".$fecha.
			"&gender=".$gender.
			"&phone=".urlencode($telefono).
			"&notes=".urlencode($grupo).
			"&websiteUrl=".urlencode($url).
			"&mobileNumber=".urlencode($celular));

		$json = json_decode($html, true);

		if($json["success"]==true)				
			return json_encode(array("status"=>true, "msg"=>"El contacto fue editado exitosamente"));
		else{
			if (strpos($json["error"], 'Contact already exists for this email address.') !== false) {
				return json_encode(array("status"=>false, "msg"=>'El correo electrónico ya existe en su base de datos (es recomendable eliminarlo)'));
			}else
			return json_encode(array("status"=>false, "msg"=>$json["error"]));
		}
	}

	//obtener todos los contactos
	public function getContacts($id){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);
		$json =  $elastic->fileGetContentsCurl("https://api.elasticemail.com/contactshards/list?version=2&offset=0&limit=999999&allcontacts=true&apikey=".$key["key"]);

		$source = json_decode($json);

		foreach($source->data as $i => $field) {
			if(!is_null($field->birthdate)){
				$date = date_create($field->birthdate);
				$field->birthdate = date_format($date,"d/m/Y");
			}
		}

		return json_encode($source);
	}

	//limpiar saltos de linea
	public function clearEmpy($txt){
		$buscar     = array(chr(13).chr(10), "\r\n", "\n", "\r");
		$reemplazar = array("", "", "", "");
		$cadena     = str_ireplace($buscar,$reemplazar,$txt);
		$cadena     = addslashes($cadena);
		return $cadena;
	}

	public function getFriendlyError($error){
		if (strpos($error, "The email account that you tried to reach does not exist") !== false) {
			$error = "La cuenta de correo electrónico no existe";
		}else if(strpos($error, "DNS Error") !== false){
			$error = "Error de DNS";
		}else if(strpos($error, "taken: mailbox unavailable") !== false){
			$error = "El buzón no se encuentra disponible";
		}else if(strpos($error, "Invalid email address") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Recipient address rejected") !== false){
			$error = "El servidor rechazo la dirección";
		}else if(strpos($error, "This account has been disabled") !== false){
			$error = "Esta cuenta ha sido deshabilitada";
		}else if(strpos($error, "unknown or illegal alias") !== false){
			$error = "Usuario desconocido o ilegal";
		}else if(strpos($error, "This user doesnt have a yahoo.es") !== false){
			$error = "Usuario no posee un cuenta yahoo.es";
		}else if(strpos($error, "I cannot deliver mail") !== false){
			$error = "No se pudo entregar el correo";
		}else if(strpos($error, "Relaying") !== false){
			$error = "El dominio no es procesado por su SMTP";
		}else if(strpos($error, "User unknown") !== false){
			$error = "Usuario desconocido";
		}else if(strpos($error, "No Such User Here") !== false){
			$error = "La cuenta de correo electrónico no existe";
		}else if(strpos($error, "Invalid Address") !== false){
			$error = "La cuenta de correo electrónico no existe";
		}else if(strpos($error, "The recipient address") !== false){
			$error = "La cuenta de correo electrónico no existe";
		}else if(strpos($error, "This user doesnt have a yahoo.com") !== false){
			$error = "Usuario no posee un cuenta yahoo.com";
		}else if(strpos($error, "Recipient not found") !== false){
			$error = "Destinatario no encontrado";
		}else if(strpos($error, "We dont handle mail") !== false){
			$error = "La cuenta de correo electrónico no existe";
		}else if(strpos($error, "Unrouteable address") !== false){
			$error = "Usuario desconocido";
		}else if(strpos($error, "No such") !== false){
			$error = "La cuenta de correo electrónico no existe";
		}else if(strpos($error, "Relay access denied") !== false){
			$error = "La cuenta de correo electrónico no existe";
		}else if(strpos($error, "Usuario Desconocido") !== false){
			$error = "Usuario Desconocido";
		}else if(strpos($error, "no mailbox by that name") !== false){
			$error = "No se encontro ninguna direccion";
		}else if(strpos($error, "This user doesnt have a yahoo.cl") !== false){
			$error = "Usuario no posee un cuenta yahoo.cl";
		}else if(strpos($error, "Invalid Recipient") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Command rejected") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Address rejected") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Recipient unknown") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "dominio migrado a") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "No existe ese usuario") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Mailbox does not exist") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "del destinatario no existe") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Recipient unknown") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "User not known") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "No existe ese usuario") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Account is not active") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Mailbox does not exist") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Address rejected") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "Su mensaje ha sido rechazado") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "not a valid mailbox") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "This user doesnt have a") !== false){
			$error = "El correo electrónico no es valido";
		}else if(strpos($error, "unknown email address") !== false){
			$error = "Dirección de correo desconocida";
		}else if(strpos($error, "Sorry dear sender") !== false){
			$error = "La cuenta de correo electrónico no existe";
		}else if(strpos($error, "unknown user account") !== false){
			$error = "Usuario desconocido";
		}else if(strpos($error, "Sorry, no valid recipients") !== false){
			$error = "Usuario desconocido";
		}else if(strpos($error, "recipient rejected") !== false){
			$error = "Usuario desconocido";
		}else if(strpos($error, "is not a known user") !== false){
			$error = "Usuario desconocido";
		}else if(strpos($error, "Account not available") !== false){
			$error = "El buzón no se encuentra disponible";
		}else if(strpos($error, "Denied") !== false){
			$error = "El servidor respondio acceso denegado";
		}else if(strpos($error, "Connection rejected by policy") !== false){
			$error = "Conexión rechazada por la políticas del servidor";
		}else if(strpos($error, "Mailbox Inactive") !== false){
			$error = "El buzón se encuentra inactivo";
		}else {
			$error = "El buzón no se encuentra disponible";
		}
		return $error;
	}

	public function deleteContact($id, $email){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);

		$json = $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/contact/delete?apikey=".$key["key"]."&emails=".$email);
		$json = json_decode($json, true);
		
		if($json["success"] == true)
			return json_encode(array("status"=>true, "msg"=>"El contacto fue eliminado exitosamente"));
		else
			return json_encode(array("status"=>false, "msg"=>"Upps! hubo un error, reintente"));
	}

	public function deleteAllBounce($id){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);
		$json = $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/contact/delete?apikey=".$key["key"]."&rule=Status%20=%20Bounced");
		$json = json_decode($json, true);
		
		if($json["success"]==true)
			return json_encode(array("status"=>true, "msg"=>"Los contactos fueron eliminados exitosamente"));
		else
			return json_encode(array("status"=>false, "msg"=>"Upps! hubo un error, reintente"));
	}

	public function uploadContact($id, $lista){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);
		$url = 'https://api.elasticemail.com/v2/contact/upload?apikey='.$key["key"].'&listID='.$lista.'&status=Active';
		$header = array('Content-Type: multipart/form-data');

		$postfields = array(
			'contactFile' => curl_file_create($_FILES[0]['tmp_name'],$_FILES[0]['type'],$_FILES[0]['name'])
			);

		$resource = curl_init();
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => true,
			CURLOPT_POST => 1,
			CURLOPT_HTTPHEADER => $header,
			CURLOPT_POSTFIELDS => $postfields,
			CURLOPT_INFILESIZE => $_FILES['contactFile']['size'],
			CURLOPT_RETURNTRANSFER => true
			);

		curl_setopt_array($resource, $options);
		$result = curl_exec($resource);
		curl_close($resource);

		$arr = explode("{", $result);
		$json = json_decode('{'.$arr[1], true);


		if($json["success"] == true)
			return json_encode(array('status'=>true, 'msg'=>'Se han procesado '.$json["data"].' contactos'));
		else{
			if (strpos($json["error"], 'Your column header must contain the word Email') !== false) {
				return json_encode(array('status'=>false, 'msg'=>'No es posible encontrar la columna de correo electrónico en el archivo CSV . Alguna columna debe contener la palabra "email'));
				
			}else if(strpos($json["error"], 'Your source CSV file has duplicate column names') !== false){
				return json_encode(array('status'=>false, 'msg'=>'Alguna de las columnas esta repetida o asegúrate de que estén separadas por "coma"'));

			}else if(strpos($json["error"], 'The maximum amount of contacts your account') !== false){
				$resultado = intval(preg_replace('/[^0-9]+/', '', $json["error"]), 10); 
				return json_encode(array('status'=>false, 'msg'=>'El máximo de contactos que puedes tener es de '.$resultado));
				
			}else if(strpos($json["error"], 'Invalid file content type') !== false){
				return json_encode(array('status'=>false, 'msg'=>'El tipo del archivo no es válido'));
			}else{
				return json_encode(array('status'=>false, 'msg'=>$json["error"]));
			}
		}
	}

	public function getList($id){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);
		$json = $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/list/list?apikey=".$key["key"]);

		$json = json_decode($json);

		foreach($json->data as $i => $field) {
			if(!is_null($field->dateadded)){
				$date = date_create($field->dateadded);
				$field->dateadded = date_format($date,"d/m/Y");
			}
		}
		return json_encode($json);
	}

	public function deleteList($id, $name){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);
		$json = $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/list/delete?apikey=".$key["key"]."&listName=".$name);

		$json = json_decode($json, true);
		
		if($json["success"] == true)
			return json_encode(array("status"=>true, "msg"=>"La lista fue eliminada exitosamente"));
		else
			return json_encode(array("status"=>false, "msg"=>"Ups! ocurrio un error, reintente"));

	}

	public function newList($id, $name){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);
		$json = $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/list/add?apikey=".$key["key"]."&listName=".
			urlencode($name)."&createEmptyList=true&allowUnsubscribe=true&rule=&emails=&allContacts=false");

		$json = json_decode($json, true);
		
		if($json["success"] == true)
			return json_encode(array("status"=>true, "msg"=>"La lista fue creada exitosamente", "date"=>date('d/m/Y')));
		else{
			if(strpos($json["error"], 'A list with the given name already exists') !== false )
				return json_encode(array("status"=>false, "msg"=>"El nombre para la lista ya esta en uso"));
			else
				return json_encode(array("status"=>false, "msg"=>"Ups! ocurrio un error, reintente"));
		}
	}

	public function listList($id, $name){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);
		return $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/contact/getcontactsbylist?apikey=".$key["key"]."&listName=".urlencode($name)."&limit=9999999&offset=0");
	}

	public function getDesuscrito($id){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);
		return $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/contact/loadblocked?apikey=".$key["key"]."&search=&status=Unsubscribed&limit=0&offset=20");
	}

	public function getRebotado($id){
		require_once('elastic.class.php');
		$elastic = new Elastic();
		$key  = $elastic->getApiKey($id);
		$json = $elastic->fileGetContentsCurl("https://api.elasticemail.com/v2/contact/loadblocked?apikey=".$key["key"]."&search=&status=Bounced&limit=999999");

		$json = json_decode($json);

		foreach($json->data as $i => $field) {
			if(!is_null($field->friendlyerrormessage)){
				$field->friendlyerrormessage = $this->getFriendlyError($field->friendlyerrormessage);
			}
		}
		return json_encode($json);
	}

}
?>