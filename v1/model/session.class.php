<?php
ini_set('session.cookie_httponly', 1);
session_start();
require_once("mysql.class.php");
require_once("sha.class.php");

class Session{
	public function verifyLoginView(){
		if(isset($_COOKIE["ses"])){
			$sql = new mySql();
			$sha = new Encrypter();
			
			$sessionId = $sha->decrypt($_COOKIE['ses']);
			$res = $sql->query("SELECT userId FROM sessions WHERE sessionId = '".$_COOKIE["ses"]."' AND userId = '".$sessionId."' AND userIp = '".$_SERVER['REMOTE_ADDR']."'");
			
			if($sql->num_rows($res) > 0){

				$consul = $sql->query("SELECT * FROM usuario WHERE ID_USUARIO = '".$sessionId."' AND ESTADO_USUARIO = 0;");

				if($sql->num_rows($consul) > 0){
					setcookie("ses", "" , time() - 3600, "/");
					session_destroy();
					header ("Location: uuups.php");
					exit();
				}else{
					while($row = $sql->fetch_assoc($res)){
						$_SESSION["ide"] = $row["userId"];
					}
				}

			}else{
				setcookie("ses", "" , time() - 3600, "/");
				session_destroy();
				header ("Location: login.php");
				exit();
			}
		}else{
			setcookie("ses", "" , time() - 3600, "/");
			session_destroy();
			header ("Location: login.php");
			exit();
		}
	}
	
	public function verifyLogin(){
		if(isset($_COOKIE["ses"])){
			$sql = new mySql();
			$sha = new Encrypter();

			$sessionId = $sha->decrypt($_COOKIE["ses"]);
			$res = $sql->query("SELECT userId FROM sessions WHERE sessionId = '".$_COOKIE["ses"]."' AND userId = '".$sessionId."' AND userIp = '".$_SERVER['REMOTE_ADDR']."'");
			
			if($sql->num_rows($res) > 0){
				while($row = $sql->fetch_assoc($res)){
					$_SESSION["ide"] = $row["userId"];
					header ("Location: ../");
					exit();
				}
			}else{
				setcookie("ses", "" , time() - 3600, "/");
			}
		}else{
			setcookie("ses", "" , time() - 3600, "/");
		}
	}
}
?>