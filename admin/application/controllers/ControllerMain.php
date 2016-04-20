<?php
//require_once(LIBRARYS_LOCAL."phpmailer".DS."class.phpmailer.php");
//class ControllerMain extends PHPMailer {
class ControllerMain {
    private $_modelo;
    private $path_view;
    private $imagen_base;
    private $configurarionphmailer;
    function __construct() {
        $this->_modelo = new ModelMain();
        $this->imagen_base = BASE_URL . 'views' . DS . 'template' . DS . 'assets' . DS;
    
    }
    public  function getFieldsTable($tabla){
            $this->_modelo = new ModelMain();
            $vectorFields = array();
            $query ="SHOW COLUMNS FROM $tabla";
            $request_gross = $this->_modelo->selectPersonalizado($query);
            if($request_gross){
                foreach ($request_gross as $value) {
                     $vectorFields[]= $value['Field'];
                }
            }
            return $vectorFields;
    }
    private function loguin($array) {
        $_SESSION['sessionusuario'];
        $where = "loguin = '$array[user]' and pwd = '$array[pwd]' and estado = 1";
        $_SESSION['loguin'] = "12";
        $_SESSION['XBesX'] = "2";
        $request = $this->_modelo->selectUsers($where);

        if ($request) {
            $array_request = mysqli_fetch_assoc($request);

            $_SESSION['loguin'] = $array_request['loguin'];
            $_SESSION['XBesX'] = '1';
            $_SESSION['perfil'] = $array_request['perfil'];
            $_SESSION['nombre'] = $array_request['nombre'];
            $_SESSION['id'] = $array_request['idUsuario'];
            $this->redirect('index.php?vista=dashboarh', 1, null);
        } else {
            $this->redirect('index.php', 0, 'Sus datos no son validos');
        }
    }

    private function out() {
        unset($_SESSION['loguin']);
        unset($_SESSION['XBesX']);
        unset($_SESSION['perfil']);
        unset($_SESSION['nombre']);
        unset($_SESSION['id']);
        $this->redirect('index.php', 0, 'Su sesión ha terminado');
    }

    public function redirect($ruta, $sw, $mensaje) {

        if ($sw == 0) {
            echo "<script>
                                        alert('" . $mensaje . "');
                                        window.location ='" . $ruta . "';

                                </script>";
        } else if ($sw == 1) {
          echo "<script>
                                       
                                        window.location ='" . $ruta . "';

                                </script>";
        }else if($sw == 2){
            echo "<script>
                                        alert('" . $mensaje . "');
                                        window.location.reload();

                                </script>";
        }
    }
    public function verificarFuncion($vectorFuncion) {
        if (method_exists($vectorFuncion['1'], $vectorFuncion['2'])) {
            $funcion = $vectorFuncion[2];
         
            $resquest = $this->$funcion($vectorFuncion['post']);
            
            return $resquest;
        } else {
            echo "No exite este metodo";
        }
    }
    /* private function download($files){
      if (!isset($files['file']) || empty($files['file'])) {
      exit();
      }
      $root = "public";
      $file = basename($files['file']);
      $path = $root.$files['folder']."/".$files['carpeta']."/".$file;
      $type = '';

      if (is_file($path)) {
      $size = filesize($path);
      if (function_exists('mime_content_type')) {
      $type = mime_content_type($path);
      } else if (function_exists('finfo_file')) {
      $info = finfo_open(FILEINFO_MIME);
      $type = finfo_file($info, $path);
      finfo_close($info);
      }
      if ($type == '') {
      $type = "application/force-download";
      }

      header("Content-Type: $type");
      header("Content-Disposition: attachment; filename=\"$file\"");
      header("Content-Transfer-Encoding: binary");
      header("Content-Length: " . $size);
      // descargar achivo
      readfile($path);

      } else {
      echo $path;
      die("File not exist !!");
      }
      }
     */
    function download_file($files, $downloadfilename = null) {
        $file = basename($files['file']);
        $archivo = "public/" . $files['carpeta'] . "/" . $file;
        if (file_exists($archivo)) {
            $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $downloadfilename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
            ob_clean();
            flush();
            readfile($archivo);
            exit;
        }
    }
    static function makeObjects($nombre,$sw=0) {
        require_once(CONTROLLERS . "Controller" . $nombre . ".php");
        if($sw==0){
            require_once(MODELS . "Model" . $nombre . ".php");
        }
        $nombre = "Controller" . $nombre;
        $_control = new $nombre;
        return $_control;
    }
    public function cargarRecursos($clase){
       $recursos = $this->_modelo->selectStand("recursos","estado =1 and claserecurso = '$clase' order by orden asc");
       $headMain ="";
       if($recursos){
           foreach ($recursos as $value) {
              if($value['tipo']=="js"){
                  $headMain .= "<script type=\"text/javascript\" src=\"".RECURSOS."js".DS."$value[file].$value[tipo]\"></script>";
              }else if($value['tipo'] === "css"){
                   $headMain .= "<link rel=\"stylesheet\" href=\"".RECURSOS."css".DS."$value[file].$value[tipo]\" />";
              }
           }
       }
       return $headMain;
    }
    public function cargarMenu($lang ="es",$tipo = null,$privasidad = 0){
        if($lang != "es" &&  $lang != "it" && $lang != "en"){
            $lang ="es";
        }
       //$tipo = "normal" equivalte a null o   $tipo ="dos-niveles" o $tipo ="traducido" $tipo ="traducido-dos-niveles"
        $priv = $privasidad == 0 ? "AND menu.nivel_privacidad = 0" :  "AND (menu.nivel_privacidad = 0 OR menu.nivel_privacidad = 1)";
        switch ($tipo) {
            case null:
                if($lang != null){
                   
                    $query ="SELECT menu.url, menuxidioma.traduccion, menuxidioma.idioma FROM
                            menu INNER JOIN menuxidioma ON menu.idmenu = menuxidioma.menu
                            WHERE menu.estado = 1 
                            AND menuxidioma.idioma = '$lang'
                            $priv
                            ORDER BY menu.orden";
                    try {
                        $recursos = $this->_modelo->selectPersonalizado($query);
                        $n=0;
                        $num_rows = $recursos->rowCount();
                        if($num_rows >0){
                            echo "<ul id =\"menu\">";
                            foreach ($recursos as $value) {
                                if($n == $num_rows){
                                    echo "<li><a  href =\"$value[idioma]-$value[url]\">$value[traduccion]</a></li>";
                                }else{
                                    echo "<li><a id='last' href =\"$value[idioma]-$value[url]\">$value[traduccion]</a></li>";  
                                }
                                $n++;
                            }
                            echo "</ul>";
                        }else{
                            echo "Esta sección no se encuentra configurada correctamente <br />";
                        } 
                    } catch (Exception $exc) {
                        echo "Se ha presentado un error verifique sus datos ERROR: <br />";
                        echo $exc;
                    } 
                }else{
                    try {
                        $recursos = $this->_modelo->selectStand("menu", "estado = 1  $priv order  by orden asc");
                        $n=0;
                        $num_rows = $recursos->rowCount();
                        if($num_rows >0){
                            echo "<ul id =\"menu\">";
                            foreach ($recursos as $value) {
                                if($n == $num_rows){
                                    echo "<li><a  href =\"$value[url]\">$value[nombreitem]</a></li>";
                                }else{
                                    echo "<li><a id='last' href =\"$value[url]\">$value[nombreitem]</a></li>";  
                                }
                                $n++;
                            }
                            echo "</ul>";
                        }else{
                            echo "Esta sección no se encuentra configurada correctamente <br />";
                        } 
                    } catch (Exception $exc) {
                        echo "Se ha presentado un error verifique sus datos ERROR: <br />";
                        echo $exc;
                    }          
                } 
               break;
            case "dos-niveles":
                if($lang != null){
                    $query ="SELECT menu.idmenu, menu.url,menu.submenu, menuxidioma.traduccion, menuxidioma.idioma FROM
                            menu INNER JOIN menuxidioma ON menu.idmenu = menuxidioma.menu
                            WHERE menu.estado = 1 
                            AND menuxidioma.idioma = '$lang'
                            $priv
                            ORDER BY menu.orden";
                    try {
                        $recursos = $this->_modelo->selectPersonalizado($query);
                        $n=0;
                        $num_rows = $recursos->rowCount();
                        if($num_rows >0){
                            echo "<ul id =\"menu\">";
                            foreach ($recursos as $value) {
                                $submenus ="";
                                if($value['submenu'] == 1){
                                    $submenus = $this->loadSubmenu($value['idmenu'],$lang);
                                    if(!$submenus){
                                        echo "Agregue porfavor item de submenu o revise su configuración";
                                    }
                                    if($n == $num_rows){
                                        echo "<li><a  href =\"#\">$value[traduccion]</a>"
                                            . "$submenus</li>";
                                    }else{
                                        echo "<li><a id='last' href =\"#\">$value[traduccion]</a>"
                                                . "$submenus</li>";  
                                    }
                                }else{
                                    if($n == $num_rows){
                                        echo "<li><a  href =\"$value[idioma]-$value[url]\">$value[traduccion]</a>"
                                            . "$submenus</li>";
                                    }else{
                                        echo "<li><a id='last' href =\"$value[idioma]-$value[url]\">$value[traduccion]</a>"
                                                . "$submenus</li>";  
                                    }
                                   
                                }
                                 $n++;
                            }
                            echo "</ul>";
                        }else{
                            echo "Esta sección no se encuentra configurada correctamente <br />";
                        } 
                    } catch (Exception $exc) {
                        echo "Se ha presentado un error verifique sus datos ERROR: <br />";
                        echo $exc;
                    } 
                }else{
                    try {
                        $recursos = $this->_modelo->selectStand("menu", "estado = 1 $priv order  by orden asc");
                        $n=0;
                        $num_rows = $recursos->rowCount();
                        if($num_rows >0){
                            echo "<ul id =\"menu\">";
                            foreach ($recursos as $value) {
                                $submenus ="";
                                if($value['submenu'] == 1){
                                    $submenus = $this->loadSubmenu($value['idmenu'],"es",1);
                                    if(!$submenus){
                                        echo "Agregue porfavor item de submenu o revise su configuración";
                                    }
                                }
                                if($n == $num_rows){
                                    echo "<li><a  href =\"$value[url]\">$value[nombreitem]</a>"
                                            . "$submenus</li>";
                                }else{
                                    echo "<li><a id='last' href =\"$value[url]\">$value[nombreitem]</a>"
                                            . "$submenus</li>";  
                                }
                                $n++;
                            }
                            echo "</ul>";
                        }else{
                            echo "Esta sección no se encuentra configurada correctamente <br />";
                        } 
                    } catch (Exception $exc) {
                        echo "Se ha presentado un error verifique sus datos ERROR: <br />";
                        echo $exc;
                    }          
                } 
               break;
            case "traducido-dos-niveles":


               break;
           default:
               break;
        }
    }
    private function loadSubmenu($idmenu,$idioma,$sw_idioma = 0){
        if($sw_idioma == 0){
            try {
                $recursos = $this->_modelo->selectStand("submenu", "estado = 1 AND idioma = '$idioma' AND idmenu = $idmenu order  by orden asc");
                if($recursos){
                    $submenu ="<ul class ='submenu'>";
                    foreach ($recursos as $value) {
                      $submenu .="<li><a href ='$idioma-$value[url]'>$value[nombre]</a></li>"; 
                    }
                    $submenu .="</ul>";
                    return $submenu;
                }else{
                    return false;
                }
            }catch (Exception $exc) {
                echo "ERROR: <br/>";
                echo $exc->getTraceAsString();
            }
        }else if($sw_idioma == 1){
            try {
                $recursos = $this->_modelo->selectStand("submenu", "estado = 1 AND idioma = '$idioma' AND idmenu = $idmenu order  by orden asc");
                if($recursos){
                    $submenu ="<ul class ='submenu'>";
                    foreach ($recursos as $value) {
                      $submenu .="<li><a href ='$value[url]'>$value[nombre]</a></li>"; 
                    }
                    $submenu .="</ul>";
                    return $submenu;
                }else{
                    return false;
                }
            }catch (Exception $exc) {
                echo "ERROR: <br/>";
                echo $exc->getTraceAsString();
            }
        } 
        
    }
    public function carRedes(){
       $recursos = $this->_modelo->selectStand("redessociales","estado =1 order by orden asc");
       if($recursos){
           echo "<ul class =\"redes\">";
           foreach ($recursos as $value) {
               echo "<li><a id= \"$value[nombre]\" target=\"_blank\" href =\"$value[url]\" alt =\"$value[nombre]\"></a></li>";
           }
           echo "</ul>";
       }
    }
    public function cargarIdiomas(){
        $recursos = $this->_modelo->selectStand("idioma","estado =1");
       if($recursos){
           echo "<ul id =\"idiomas\">";
           foreach ($recursos as $value) {
               echo "<li><a href =\"$value[abrevitura]\">$value[nombre]</a></li>";
           }
           echo "</ul>";
       }
    }
    public function  cargarPrensa($lang){
       $recursos = $this->_modelo->selectStand("prensa","idioma = '$lang' and estado =1 order by fecha limit 2");
       if($recursos){
           echo "<ul id =\"presaMini\">";
           foreach ($recursos as $value) {
               echo "<li><a class ='foto' href =\"#\"><img src=\"public/prensa/$value[imgprensa]\" /></a><a href =\"#\">". $value['titulprensa']."</a></li>";
           }
           echo "</ul>";
       }
    }
    public function arrayPdo($pdo){
      $arrayEnd =  array();
        foreach ($pdo as $value) {
            $arrayEnd = $value;
        }
        return $arrayEnd;
    }

    public function loadslider($nombre,$idioma ="es"){
        if($idioma != "es" || $idioma != "it" || $idioma != "en"){
            $idioma ="es";
        }
        //$recursos = $this-> cargarRecursos("slider");
       // echo $recursos;    
        $queryConfi ="select configuracionslider.alto,
        configuracionslider.animacion,  configuracionslider.ancho,  configuracionslider.control, 
        configuracionslider.navegacion, configuracionslider.reproduccion 
        from configuracionslider inner join slider on configuracionslider.idconfiguracionslider = slider.idslider 
        where  slider.nombre ='$nombre'";
 
        $queryItems = " SELECT itemslider.img, itemslider.seo,slider.nombre from slider inner join itemslider on slider.idslider = itemslider.slider "
                . "where itemslider.idioma = '$idioma' and slider.nombre ='$nombre'";
         
        $configurarionSlider = $this->_modelo->selectPersonalizado($queryConfi);
        $itemSlider = $this->_modelo->selectPersonalizado($queryItems);
        
        if($itemSlider){

            echo "<div id=\"$nombre\">";
               
             
                                echo "<span class ='border-blanco-info'>“El ciclismo es mi vida parce,
siempre pedaleo hacia la meta
con berraquera y ahora quiero
compartirles algo de lo que
me apasiona”</span>"
                    . "<div class=\"slides-container\">";
            foreach ($itemSlider as $value) {
                echo "<img src='public".DS."item-sliders".DS."$value[img]' alt='$value[seo]' />";
                 
                }
                 
            echo "</div>"
            . " <nav class=\"slides-navigation\">
	      <a href=\"#\" class=\"next\"></a>
	      <a href=\"#\" class=\"prev\"></a>
	    </nav></div>"
                ;
        }
        $num_rows = $itemSlider->rowCount();
        $config = $this->arrayPdo($configurarionSlider);
       
        echo "<script>";
        if($num_rows <= 1){
             echo "
                $(function() {
                    $('#$nombre').superslides({
                      hashchange: $config[control],
                      play: $config[reproduccion],
                      animation: '$config[animacion]'
                    });
                    $('#$nombre').superslides('stop');                              
                });";
        }else{
           echo "$(function() {
                    $('#$nombre').superslides({
                      hashchange: $config[control],
                      play: $config[reproduccion],
                      animation: '$config[animacion]'
                    });
                    $('#$nombre').superslides('stop');                              
                    $('#$nombre').on('mouseenter', function() {
                      $(this).superslides('stop');
                      console.log('Stopped')
                    });
                    $('#$nombre').on('mouseleave', function() {
                      $(this).superslides('start');
                      console.log('Started')
                    });
                });
            ";
        }
        echo "</script>";
    }
    public function loadsliderSocial($nombre,$idioma ="es"){
        if($idioma != "es" || $idioma != "it" || $idioma != "en"){
            $idioma ="es";
        }
        //$recursos = $this-> cargarRecursos("slider");
       // echo $recursos;    
        $queryConfi ="select configuracionslider.alto,
        configuracionslider.animacion,  configuracionslider.ancho,  configuracionslider.control, 
        configuracionslider.navegacion, configuracionslider.reproduccion 
        from configuracionslider inner join slider on configuracionslider.idconfiguracionslider = slider.idslider 
        where  slider.nombre ='$nombre'";
 
        $queryItems = " SELECT itemslider.img, itemslider.seo,slider.nombre from slider inner join itemslider on slider.idslider = itemslider.slider "
                . "where itemslider.idioma = '$idioma' and slider.nombre ='$nombre'";
         
        $configurarionSlider = $this->_modelo->selectPersonalizado($queryConfi);
        $itemSlider = $this->_modelo->selectPersonalizado($queryItems);
        
        if($itemSlider){

            echo "<div id=\"$nombre\">"
                    . "<div class=\"slides-container\">";
            foreach ($itemSlider as $value) {
                echo "<img src='public".DS."item-sliders".DS."$value[img]' alt='$value[seo]' />";
                 
                }
          echo "</div></div>";
        }
        $num_rows = $itemSlider->rowCount();
        $config = $this->arrayPdo($configurarionSlider);
       
        echo "<script>";
        if($num_rows <= 1){
             echo "
                $(function() {
                    $('#$nombre').superslides({
                        inherit_width_from: '.$config[contenedor]',
                        inherit_height_from: '.$config[contenedor]'
                    });
                });";
        }else{
           echo "$(function() {
                    $('#$nombre').superslides({
                      inherit_width_from: '.$config[contenedor]',
                        inherit_height_from: '.$config[contenedor]'
                    });
                    
                });
            ";
        }
        echo "</script>";
    }
    public function cargarTipodedocumento($lang){
        $query ="select * from tipodocumento where estado = 1";
        $itemsconsulta = $this->_modelo->selectPersonalizado($query);
        $options="<option value ='0' > ".$this->translate(trim('Seleccione un valor'), $lang)."</option>";
        foreach ($itemsconsulta as $value) {
            $options .= "<option value= '$value[idtipodocumento]'>".$this->translate(trim($value['nombre']), $lang)."</option>";
        }
        return $options;
    }
    public function urls_amigables($url) {
        // Tranformamos todo a minusculas
        $url = strtolower($url);
        //Rememplazamos caracteres especiales latinos
        $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');
        $url = str_replace($find, $repl, $url);
        // Añadimos los guiones
        $find = array(' ', '&', '\r\n', '\n', '+');
        $url = str_replace($find, '-', $url);
        // Eliminamos y Reemplazamos otros carácteres especiales
        $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
        $repl = array('', '-', '');
        $url = preg_replace($find, $repl, $url);
        return $url;
    }
    public function libreriasbasicas($objeFramework){
        foreach($objeFramework as $valor){
            require_once MODELS."Model".$valor.".php";
            require_once CONTROLLERS."Controller".$valor.".php";
        }
    }
    public  function translate($palabra,$lang){
        require 'lang/lenguaje.php';
	$translation = null;
	switch ($lang) {
            case 'es':
                $translation = $es[$palabra];
                break;
            case 'it':
                $translation = $it[$palabra];
                break;
            case 'en':
                $translation = $en[$palabra];
                break;
	}
	return $translation; 
    }
    public  function translateJava($vector){
        require 'lang/lenguaje.php';
        $translation = null;
        switch ($vector['idioma']) {
            case 'es':
                $translation = $es[trim($vector['text'])];
                break;
            case 'it':
                $translation = $it[$vector['text']];
                break;
            case 'en':
                $translation = $en[$vector['text']];
                break;
        }
        echo $translation;
    }
    public function crearSelect($values, $text, $idselect, $data, $forma=0,$otro="null",$tipo = ""){
        $select ="";
        if($tipo != ""){
            $primeroption ="";
        }else{
            $primeroption = "<option value =\"0\" selected =\"\">Seleccione un valor </option>";
        }
        if($forma == 0){
            if($otro != "null"){
                $select .= "<select $tipo name =\"$idselect\" id =\"$idselect\" $otro>";
                
            }else{
                $select .= "<select $tipo name =\"$idselect\" id =\"$idselect\" >";
            }
            $select .= $primeroption;
            foreach ($data as $value) {
                 $select .="<option value =\"$data[$value]\">$data[$text]</option>";
            }   
            $select .="</select>";
            return $select ;
        }else{
            if($otro != "null"){
                echo "<select $tipo name =\"$idselect\" id =\"$idselect\" $otro>";
            }else{
                echo "<select $tipo name =\"$idselect\" id =\"$idselect\" >";
            }
            echo  $primeroption;
            foreach ($data as $value) {
                 echo "<option value =\"$value[$values]\">$value[$text]</option>";
            }   
            echo "</select>";
        }
        
    }
    public function cargarSliders() {
        $query = "SELECT * FROM `itemslider`";
        $inventario = $this->_modelo->selectPersonalizado($query);
        echo "<table class=\"table table-striped table-bordered bootstrap-datatable datatable responsive\">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Img</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
        foreach ($inventario as $value) {
            if ($value['estado'] == 0) {
                $estado = "<span class=\"label-default label label-danger\">Desactivado</span>";
            } else {
                $estado = "<span class=\"label-default label label-danger\">Activo</span>";
            }
            echo "<td class=\"center\">$value[id]</td>
                    <td class=\"center\">$value[img]</td>
                    <td class=\"center\">
                       $estado
                    </td>
                    <td class=\"center\">
                        <a class=\"btn btn-info\" href=\"index.php?vista=editar_Slider&idSlider=$value[id]\">
                            <i class=\"glyphicon glyphicon-edit icon-white\"></i>
                            Editar
                        </a>
                        <a val='$value[id]' class=\"btn delslider btn-danger\" href=\"#\">
                            <i class=\"glyphicon glyphicon-trash icon-white\"></i>
                            Eliminar
                        </a>
                    </td>
                </tr>";
        }
        echo "</tbody>"
        . "</table>";
    }
}