<?php
session_start();

$f3=require('lib/base.php');
$f3->set('DEBUG',1);
$f3->config('config.ini');


////////////////////////////////////////////
//CONTACTOS
////////////////////////////////////////////
$f3->route('POST /contact/upload/@lista',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();
		echo $contact->uploadContact($_SESSION["ide"], $f3->get('PARAMS.lista'));
	}
);

$f3->route('POST /contact/new',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();
		echo $contact->addContact( $_SESSION["ide"], $_POST["nombre"], $_POST["apellido"], $_POST["correo"], $_POST["sexo"], $_POST["fecha"], $_POST["grupo"], $_POST["telefono"], $_POST["celular"], $_POST["pais"], $_POST["ciudad"], $_POST["empresa"], $_POST["http"] );
	}
);

$f3->route('GET /contact/list',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();
		echo $contact->getContacts($_SESSION["ide"]);
	}
);

$f3->route('GET /contact/get/@correo',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();
		echo $contact->getDataClient($_SESSION["ide"], $f3->get('PARAMS.correo'));
	}
);

$f3->route('GET /contact/delete/@email',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();
		echo $contact->deleteContact($_SESSION["ide"], $f3->get('PARAMS.email'));
	}
);









$f3->route('GET /contact/update',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();

		echo $contact->updateContact($_SESSION["ide"], $_POST["idc"], $_POST["nom"], $_POST["ape"], $_POST["cor"], $_POST["sex"], $_POST["fec"], $_POST["gru"], $_POST["tel"], $_POST["cel"], $_POST["pai"], $_POST["ciu"], $_POST["emp"], $_POST["htt"]);
	}
);

$f3->route('GET /contact/loadbounce',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();

		echo $contact->getBounce($_SESSION["ide"]);
	}
);




$f3->route('GET /contact/deleteallbounce',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();

		echo $contact->deleteAllBounce($_SESSION["ide"]);
	}
);

////////////////////////////////////////////
//LISTA //contactos
////////////////////////////////////////////
$f3->route('GET /list/list',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();

		echo $contact->getList($_SESSION["ide"]);
	}
);

$f3->route('GET /list/new/@name',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();

		echo $contact->newList($_SESSION["ide"], $f3->get('PARAMS.name'));
	}
);

$f3->route('GET /list/list/@name',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();

		echo $contact->listList($_SESSION["ide"], $f3->get('PARAMS.name'));
	}
);

$f3->route('GET /list/new/@name',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();

		echo $contact->newList($_SESSION["ide"], $f3->get('PARAMS.name'));
	}
);

$f3->route('GET /list/desuscrito',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();

		echo $contact->getDesuscrito($_SESSION["ide"]);
	}
);

$f3->route('GET /list/rebotado',
	function($f3) {
		require_once("model/contact.class.php");
		$contact = new Contact();

		echo $contact->getRebotado($_SESSION["ide"]);
	}
);





////////////////////////////////////////////
//CAMPAÑAS
////////////////////////////////////////////
$f3->route('GET /campaign/graphic/@type',
	function($f3) {
		require_once("model/campaign.class.php");
		$campaign = new Campaign();

		echo $campaign->getGraphic($_SESSION["ide"], $f3->get('PARAMS.type'));
	}
);



////////////////////////////////////////////
//USUARIO
////////////////////////////////////////////
$f3->route('GET /user/name',
	function($f3) {
		require_once("model/user.class.php");
		$user = new User();

		echo $user->getName($_SESSION["ide"]);
	}
);

$f3->route('GET /user/notify',
	function($f3) {
		require_once("model/notify.class.php");
		$notify = new Notify();

		echo $notify->getNotify($_SESSION["ide"]);
	}
);





$f3->route('GET /',
	function($f3) {
		
	}
);

$f3->run();
