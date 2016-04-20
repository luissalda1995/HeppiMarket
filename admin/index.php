<?php
@session_start();
if(!isset($_SESSION['contador'])){
    $_SESSION['contador'] = 0;
}
//header('Content-Type: text/html; charset=UTF-8'); 
define('DS', "/");
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS);
define('CONFIG', APP_PATH . DS . 'config' . DS);
error_reporting(E_ALL);
ini_set("display_errors", "1");
require_once(CONFIG . 'config_app.php');
require_once(CONTROLLERS . 'ControllerMain.php');
require_once(MODELS . 'ModelMain.php');
require_once(CONFIG . 'DataBase.php');

$_controlMain = new ControllerMain();
$_controlMain->libreriasbasicas($objeFramework);
$_objvista = new ControllerVista();
$lang = isset($_GET['lang']) ? $_GET['lang'] : "es";
if($lang != "es" &&  $lang != "it" && $lang != "en"){
    $lang ="es";
}
$view;
if(isset($_GET['vista'])){
   $view = $_GET['vista']; 
}else{
    
}

//$view = isset($_GET['vista']) ? $_GET['vista'] : "login"; //remplazar por el archivo inicial
$vectorFuncion = array();
$operation = isset($_REQUEST['operation']) ? $_REQUEST['operation']:"";
$render_fancy =isset($_GET['fancy']) ? $_GET['fancy'] : "";
if(isset($_REQUEST['controller'])){
    $controller=$_REQUEST['controller'];
    require_once(CONTROLLERS."Controller".trim($controller).".php");
    if(file_exists(MODELS."Model".trim($controller).".php")){
        require_once(MODELS."Model".trim($controller).".php");
      
    }
    $controlle ="Controller".trim($controller);
    $_control = new $controlle;
    $vectorFuncion = array(
    '1' => $_control,
    '2' => $operation,
    'post' => $_REQUEST);
}
if(!isset($_GET['id_pago']) && empty($_GET['id_pago'])){
    $swpasarella = 0;
}else{
        $obje = ControllerMain::makeObjects("Pasarella",1);
        $obje->guardarPago($_GET['id_pago']);
     
}

if(TYPE_APP == 1){
    if($operation !=""){
        $_control->verificarFuncion($vectorFuncion);
    }else{
        if(!empty($render_fancy)){
            $_objvista->renderizarFancy($render_fancy);
        }else{
            $_objvista->renderizarVista($view,$lang,true);
        }
    }
}else if (TYPE_APP == 2){
    if($operation !=""){
        $_control->verificarFuncion($vectorFuncion);
    }else{
        if(!empty($render_fancy)){
            $_objvista->renderizarFancy($render_fancy);
        }else{
            if(empty($view)){
                $_objvista->renderizarVista("login");
            }else{
                $_objvista->renderizarVista($view,"es",true);
            }
        }
    }
}

//
//session_destroy();
 //session_destroy($_SESSION['carrito']);
//for($i = 0;$i< count($_SESSION['carrito']);$i++){
//    echo $_SESSION[$i];
//}
//echo count($_SESSION['carrito']);
//print_r($_SESSION['carrito']);
//echo $_SESSION['contador'];

