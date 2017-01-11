<?php 
require '../v1/model/session.class.php';
require '../v1/model/csrf.class.php';
require '../v1/model/login.class.php';
$ses = new Session();
$ses->verifyLogin();

$csrf = new CSRF();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token();

$form_names = $csrf->form_names(array('user', 'password'), false);

$msg="";
if(isset($_POST[$form_names['user']], $_POST[$form_names['password']])) {
	
	if($csrf->check_valid('post')) {
        $user = $_POST[$form_names['user']];
        $password = $_POST[$form_names['password']];

        $login = new Login();
        $json = $login->logeo($user, $password);
        $json = json_decode($json, true);

        if($json["code"] == "200"){
            header("Location: ../");
            exit();
        }else if($json["code"] == "888"){
            header("Location: uuups.php");
            exit();
        }else{
            $msg = $json["msg"];
        }
    }
    $form_names = $csrf->form_names(array('user', 'password'), true);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InboxShot</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/form-elements.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="top-content" style="height: 100vh;background: rgba(0, 0, 0, 0.38);">
        <div class="inner-bg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 text">
                        <img src="../assets/img/logo.png" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3 form-box">
                     <div class="form-top">
                      <div class="form-top-left">
                       <h3>Ingreso a nuestro sitio</h3>
                       <p>Por favor ingresa tu correo electrónico y contraseña</p>
                   </div>
                   <div class="form-top-right">
                       <i class="fa fa-lock"></i>
                   </div>
               </div>
               <div class="form-bottom">
                   <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>"> 
                     <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />                                   
                     <div class="form-group" >
                       <input type="text" class="form-control form-username" name="<?= $form_names['user'] ?>" placeholder="Correo electrónico">
                   </div>
                   <div class="form-group input-group">
                       <input id="pass" autocomplete="off" type="password" class="form-control" name="<?= $form_names['password'] ?>" placeholder="Contraseña">
                       <span id="show-hide-pass" class="input-group-addon" style="cursor:pointer"><i id="iconic" class="fa fa-eye"></i></span>
                   </div>
                   <button type="submit" class="btn">Ingresar</button>
                   <div class="col-md-12 login2 hidden-xs hidden-sm" style="color:#FF6011;" ><?= $msg ?></div>
               </form>
           </div>
       </div>
   </div>
</div>
</div>

</div>
<script src="../assets/js/jquery-1.11.1.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.backstretch.min.js"></script>
<script src="../assets/js/scripts.js"></script>
</body>

</html>