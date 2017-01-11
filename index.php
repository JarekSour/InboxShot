<!DOCTYPE html>
<html>
<title>InboxShot</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootswatch.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/stylePieChar.css">
<link rel="stylesheet" href="css/estilo.css">
<link rel="stylesheet" href="css/angular-datatables.min.css">
<link rel="stylesheet" href="css/buttons.dataTables.min.css">

<script type="text/javascript" src="js/lib/jquery.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/lib/angular.min.js"></script>
<script type="text/javascript" src="js/lib/angular-route.min.js"></script>
<script type="text/javascript" src="js/lib/angular-animate.min.js"></script>
<script type="text/javascript" src="js/lib/angular-resource.min.js"></script>
<script type="text/javascript" src="js/lib/angular-datatables.min.js"></script>
<script type="text/javascript" src="js/lib/angular-modal-service.js"></script>
<script type="text/javascript" src="js/lib/angular-sanitize.min.js"></script>
<script type="text/javascript" src="js/lib/bootstrap.min.js"></script>
<script type="text/javascript" src="js/lib/angular.easypiechart.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="js/lib/bootstrap-filestyle.min.js"></script>
<style>
    canvas{
        display: block;
        margin-top: -216px;
        padding-bottom: 55px;
    }
    .loader{
        background: rgba(239, 239, 239, 0.7);
        height: 218px;
        position: absolute;
        margin-top: 34px;
        border-radius: 10px;
        text-align: center;
        width: 208px;
        margin-left: 67px;
    }
    .height70{
        height: 70px;
    }

    .marginTop{
        margin-top: 45px;
    }

    .marginTop20{
        margin-top:20px;
    }

    .centerBrowser{
        text-align: -webkit-center;text-align: -moz-center;-moz-text-align-last: center;text-align-last: center;
    }

    .bb-alert {
        position: fixed;
        bottom: 25%;
        right: -563px;
        margin-bottom: 0px;
        font-size: 1.2em;
        padding: 1em 1.3em;
        z-index: 2000;
    }

    td {
        cursor: pointer;
    }

    .hover06 figure img {
        -webkit-transform: rotate(0) scale(1);
        transform: rotate(0) scale(1);
    }

    .hover07 figure img {
        -webkit-transform: rotate(0) scale(1);
        transform: rotate(0) scale(1);
    }

    .hover06 figure:hover img {
        -webkit-transform: rotate(15deg) scale(1.2);
        transform: rotate(15deg) scale(1.2);
        -webkit-transition: .3s ease-in-out;
        transition: .3s ease-in-out;
    }

    .hover06 figure img {
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%);
        -webkit-transition: .3s ease-in-out;
        transition: .3s ease-in-out;
    }

    .hover07 figure img {
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%);
        -webkit-transition: .3s ease-in-out;
        transition: .3s ease-in-out;
    }

    .hover06 figure:hover img {
        -webkit-filter: grayscale(0);
        filter: grayscale(0);
    }

    figure {
        width: 70%;
    }

    .column div span {
        bottom: -20px;
        left: 0;
        z-index: -1;
        display: block;
        margin: 0;
        padding: 30px;
        color: #444;
        font-size: 18px;
        text-decoration: none;
        text-align: center;
    }

    .selectSelected {
        -webkit-transform: rotate(15deg) scale(1.2) !important;
        transform: rotate(15deg) scale(1.2) !important;
        -webkit-transition: .3s ease-in-out !important;
        transition: .3s ease-in-out !important;
        -webkit-filter: grayscale(0) !important;
        filter: grayscale(0) !important;
    }

    .ace_editor {
        border: 1px solid lightgray;
        margin: auto;
        height: 350px;
    }

    .scrollmargin {
        height: 20px;
        text-align: center;
    }

    .eover {
        background-color: rgba(0, 0, 0, 0.3);
        opacity: 0;
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        z-index: 1;
        -webkit-transition: all .2s ease-out 0s;
        -moz-transition: all .2s ease-out 0s;
        -ms-transition: all .2s ease-out 0s;
        -o-transition: all .2s ease-out 0s;
        transition: all .2s ease-out 0s;
    }

    .eglass {
        background-size: 100%;
        background-image: url(data:image/png;base64,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);
        background-repeat: no-repeat;
        border: 0 none;
        color: rgba(0, 0, 0, 0);
        display: block;
        font: 0/0 a;
        height: 69px;
        left: 50%;
        margin-left: -32px;
        cursor: pointer;
        margin-top: -32px;
        position: absolute;
        text-shadow: none;
        top: 50%;
        width: 64px;
    }

    .templateimg {
        height: 211px;
        max-width: 280px;
        width: 100%;
        position: relative;
        display: inline-block;
        overflow: hidden;
        border: 3px solid #DDD;
        text-align: center;
    }

    .templateimg:hover .eover,
    .epreviewimg:hover .eover,
    .gallery-item:hover .eover,
    .etemplateboxtd:hover .eover {
        opacity: 1
    }

    .templateimg,
    #etemplatepreview {
        border: 3px solid #DDD;
    }

    .help {
        font-size: 13px;
        color: gray;
    }

    .hid{
        display: none;
    }
</style>
<body ng-app="myApp">
    <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" ng-controller="myCtrl">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> 
                    <span class="sr-only">Toggle navigation</span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                </button>
                <a class="navbar-brand" href="#/"><img src="images/logo.png" width="220" height="63" class="img-responsive" alt="" /></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user fa-fw"></i> <span>{{nameUsr}}</span> <span class="caret"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            <ul class="dropdown-menu">
                                <li><a href="#perfil"><i class="fa fa fa-cog"></i> Configuracion</a></li>
                                <li><a href="#/" id="btnClose"><i class="fa fa-power-off"></i> Cerrar sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://support.inboxshot.com" target="_blank" class="dropdown-toggle" >Soporte</a></li>
                        <li>
                            <div>
                                <a data-toggle="dropdown" style="text-decoration: none;color: white;padding-left: 15px;padding-right: 15px;padding-top: 26px;padding-bottom: 28px;cursor: pointer;">
                                    Notificaciones <span class="badge" style="background:#ff4e25;" >{{numNotify}}</span>
                                </a>
                                <ul class="dropdown-menu notifications" role="menu" aria-labelledby="dLabel" style="min-width:420px; ">
                                    <div class="notifications-wrapper" id="notify" style="overflow:auto;max-height:250px;">
                                        <div ng-repeat="x in notify" class="content seeNotify" onclick="feature.viewNotify(this)" data-id="{{x.id}}" role="button">
                                            <div class="alert alert-danger {{x.colborde}}">
                                                <button class="close deleteNotify" onclick="feature.deleteNotify(this , event)" data-id="{{x.id}}" >
                                                    <i class="fa fa-times" aria-hidden="true" style="font-size: 17px;color: gray; text-decoration: none;"></i>
                                                </button><br>
                                                <p class="item-title {{x.coltext}}">{{x.txt}}</p>
                                                <p class="item-info">{{x.nombre}}, {{x.tipo}}</p>
                                                <p style="font-size: 10px;color: #848484;">{{x.fecha}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#/"  class="dropdown-toggle" >Campañas</a></li>
                        <li><a href="#automatizar"  class="dropdown-toggle" >Automatizar</a></li>
                        <li><a href="#contactos" class="dropdown-toggle" >Contactos</a></li>
                        <li><a href="https://www.youtube.com/channel/UCJlYioiHAae8pnZaK5HdqIw" target="_blank" class="dropdown-toggle" >Academia</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div ng-view>




        </div>

        <script type="text/javascript" src="js/lib/angular-datatables.bootstrap.min.js"></script>
        <script type="text/javascript" src="js/lib/bootbox.min.js"></script>
        <script type="text/javascript" src="js/index.js"></script>
        <script type="text/javascript" src="js/main.js"></script>

        <script type="text/javascript" src="js/addcontacto.js"></script>
        <script type="text/javascript" src="js/vercontacto.js"></script>
        <script type="text/javascript" src="js/verlista.js"></script>
        <script type="text/javascript" src="js/contactoslista.js"></script>
        <script type="text/javascript" src="js/verdesuscrito.js"></script>
        <script type="text/javascript" src="js/verrebotados.js"></script>

        <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
        <script src="js/lib/buttons.colVis.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
        <script src="js/lib/buttons.print.min.js"></script>
        <script src="js/lib/angular-datatables.buttons.min.js"></script>
        <script src="js/lib/angular-datatables.columnfilter.min.js"></script>

    </body>
    </html>


