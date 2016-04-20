function entrarAlpanel(dataString){
      $.post('index.php?controller=Usuarios&operation=iniciarSession',dataString, function(data){
        console.log(data);
        if(data == "1"){
           alert("Bienvenido al panel de administración de Heppi mercado saludable");
           parent.location.href = "index.php?lang=es&vista=inventario";
       }else{
         alert(data);
       }
    });
}
function cambiarEstadoPedido(data){
    $.post('index.php?controller=Pedidos&operation=cambiarEstadoPedido',data, function(data){
        alert(data);
    });
}
function agregarInventario(dataString){
    $.post('index.php?controller=Productos&operation=insertarProducto',dataString, function(data){
       if(data == "1"){
           alert("Se ha insertado correctamente el registro");
           location.reload();
       }else{
         alert(data);
       }
    });
}
function agregarProducto(dataString){
    $.post('index.php?controller=Productos&operation=agregarProductos',dataString, function(data){
        console.log(data);
//       if(data == "1"){
//           alert("Se ha insertado correctamente el registro");
//           location.reload();
//       }else{
//         alert(data);
//       }
    });
}
function marcarSelect(select,valor){
    var lista = document.getElementById(select);
    for (i = 0; i < lista.options.length; i++) {
        if (lista.options[i].value == valor) {
            lista.options[i].setAttribute("selected","");
        }
    }
}
function mostrardata(fechaini, fechaend){
    $.post('index.php?controller=Pedidos&operation=selectProducto',{fechaini:fechaini,fechaend:fechaend}, function(data){
      $("#informestabla").html(data);
//       if(data == "1"){
//           alert("Se ha insertado correctamente el registro");
//           location.reload();
//       }else{
//         alert(data);
//       }
    });
}
function insertarProducto(dataString){
    $.post('index.php?controller=Productos&operation=insertarProductoTienda',dataString, function(data){
        alert(data);
//       if(data == "1"){
//           alert("Se ha insertado correctamente el registro");
//           location.reload();
//       }else{
//         alert(data);
//       }
    });
}
function guardarCambios(dataString){
    $.post('index.php?controller=Productos&operation=guardarCambiosProducto',dataString, function(data){
        alert(data);
//       if(data == "1"){
//           alert("Se ha insertado correctamente el registro");
//           location.reload();
//       }else{
//         alert(data);
//       }
    });
}
function separarMultiselect(select){
      var selected = '';
        select.each(function(){
        selected += $(this).val() + ','; 
        });
        fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
        selected = selected.substr( 0, fin ); // elimino la coma final
        return selected;
}
function ejecutarFuncion(data,url,swreturn,msg){
 
   // var dataFull = "informacion="+data;
 
        $.ajax({
            type:'post',
        data:data, 
        url: url,
        async: swreturn,
        dataType:'html',
     
        beforeSend: function (objeto) {
           // alert(msg);
        },
     
      
        dataType: "html",
        error: function (objeto, quepaso, otroobj) {
            alert("Estas viendo esto por que fallé");
            alert("Pasó lo siguiente: " + quepaso);
        },
        global: true,
        ifModified: false,
        processData: true,
        success: function (datos) {
            if(swreturn){
                 if(datos == 1){
                    ejecutarFuncion(dataFull,url,swreturn)
                }else{
                     console.log(datos);
                }
               
            } else {
                if(datos == 1){
                    ejecutarFuncion(dataFull,url,swreturn)
                }else{
                    globaldata =  datos;
                }
                
            }
   
        },
        timeout: 3000,
        type: "GET"
    });

}
function construirRuta(controlador,accion){
  return "index.php?controller="+controlador+"&operation="+accion+"";
}