<?php
define('DIRECTORIO','/public/files/');
define('DIRECTORIOROOT','/framework_v2/public/files/');
//print_r($_SERVER);


    function get_full_url() {
        $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
            !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
            ($https && $_SERVER['SERVER_PORT'] === 443 ||
            $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }
    function get_server_var($id) {
        return @$_SERVER[$id];
    }
    
     $url = get_full_url();
  // echo  
    //echo get_full_url().'/'.basename(get_server_var('SCRIPT_NAME'));
    //echo get_server_var('DOCUMENT_ROOT').DIRECTORIOROOT;
    //echo dirname(get_server_var('HTTP_REFERER')).DIRECTORIO;
  //  echo get_server_var('HTTP_REFERER');
      $vector = explode("/", $url);
     // print_r($vector);
     echo  tomarUrlAdmin($url);
     function tomarUrlAdmin($url){
         $vector = explode("/", $url);
         $urlFull = "";
         for ($i = 0; $i < count($vector); $i++) {
           if($vector[$i] != "admin"){
           if($i>0){
                $urlFull .=  "/".$vector[$i];
           }else{
               
               $urlFull .=  $vector[$i];
           }
               
           }else{
               $i = 9999;
           }
         }
         return $urlFull;
     }