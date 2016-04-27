var globaldata;
$(document).ready(function(){
    var talla;
    var color;
    var producto;
    var idioma;
    var cantidad;
    var sexo;
    color = $("#colores option:selected").val(); 
    talla = $("input[name='talla'] ").val();
    $("input[type ='radio']").click(function(){
        talla = $(this).val();
        chequearColor(talla,$("#idproducto").attr('val'),$("#idproducto").attr('lan'));
        selccionarGenero(talla,$("#idproducto").attr('val'),$("#idproducto").attr('lan'),color);
    })
    $("#colores").change(function(){
        color = $("#colores option:selected").val(); 
        selccionarGenero(talla,$("#idproducto").attr('val'),$("#idproducto").attr('lan'),color);
    })
    $("#sltgenero").change(function(){
        color = $("#colores option:selected").val(); 
        producto = $("#idproducto").attr('val');
        idioma = $("#idproducto").attr('lan');
        color = $("#colores option:selected").val(); 
        sexo = $("#sltgenero option:selected").val(); 
        cargarExistencias(talla,producto,idioma,color,sexo);
    })
    $("#content-margen-producto").delegate(".addcart","click",function(e){
        e.preventDefault();
        var producto = $(this).attr("valpro");
        var dataString = "producto="+producto;
        var urlc = construirRuta("Productos", "verificarCantidadAnular");
        var msgc = "null";
        ejecutarFuncion(dataString, urlc, false,msgc);
        if(globaldata <=0){
            alert("Actualmente este producto se encuentra agotado");
        }else{
            //alert("Por aca");
            var cantidad = prompt("Cantidad del producto");
            var producto = $(this).attr("valpro");
            if(cantidad > 0){
                agregarCarrito(cantidad,producto);
            }
        }
    })
    $("#btn-vaciar").click(function(event){
        event.preventDefault();
       
        vaciarCarrito();
    })
    $(".eliminar-item").click(function(event){
        event.preventDefault();
        var producto = $(this).attr("res");

        eliminarItemcart(producto);
    })
    $(".txtcantidad").change(function () {
        //Obtengo el registro que quiero modificarle la cantidad
        //Obtengo la cantidad de origen

        var id = $(this).attr('id');
        var idres = $(this).attr('pro');
        var ref = $(this).attr('res');

        var cantidad = $("#"+id+" option:selected").val();
        producto = $("#idproducto").attr('val');
        cambiarCantidad(cantidad,idres,ref);
      
    });
    $("#btn-pagar").click(function(event){
        event.preventDefault();
        var idioma = $("#info-web").attr('lan')
        var fancy = validarSession(idioma,$(this));
        if(fancy == 1){
            location.href="index.php?vista=tramitar_pedido";
        }else{
            $(this).attr("href","index.php?fancy=loguin");
            $("#btn-pagar").fancybox({
                 maxWidth    : 334,
            minHeight   : 261,
            maxHeight   : 261,

                 'autoScale' : true,
                 'transitionIn' : 'none',
                 'transitionOut' : 'none',
                 'type' : 'iframe'
               });
            $(this).fancybox({
             maxWidth    : 334,
            minHeight   : 261,
            maxHeight   : 261,
            'autoScale' : true,
            'transitionIn' : 'none',
            'transitionOut' : 'none',
            'type' : 'iframe'
            });
        }
    })
    $("#btn-enviar-registro").click(function(){
         var i =0;
        var data = validarmyaccount();
        if(data){
                 

            var string = $("#form-registro").serialize()+"&idioama="+$("#idproducto").attr("lan");
            agregarNuevousuario(string);
        }
    }) 
    $("#btn-guardar-perfil").click(function(e){
        e.preventDefault();
        data = $("#form-guardar-perfil").serialize();
        guardarPerfil(data)
    }) 
    $(".login").submit(function(e){
        e.preventDefault();
        var idioma = $("#password").attr('lan');
        var string = $(".login").serialize();
        iniciarSession(string,idioma);
    })
    $("#btn-pagar-todo").click(function(e){
        e.preventDefault();
        var string = $(".tramitar_pedido").serialize();
        hacerCompra(string+"&idioma="+$("#idpago").attr("val"),$("#idpago").attr("lan"));
    })
    $("#btn-registrarse-loguin").click(function(e){
      
         e.preventDefault();
         parent.location.href=  $("#btn-registrarse-loguin").prop("href");
//         parent.location.reload(true);
    })
    $(window).resize(function(){
      if($(window).width()>800){
          $("#main_menu").css("display","block"); 
      }else{
           $("#main_menu").css("display","none");
      } 
    })
    $('#raya').click(function(e){
        e.preventDefault();
       var prop =  $("#main_menu").css("display");
       if(prop =="none"){
            $("#main_menu").css("display","block");
       }else if(prop =="block") {
            $("#main_menu").css("display","none");
       }
       
    })
    $("#btnenviarcontacto").click(function(e){
        e.preventDefault();
        var data = validarcontacto();
        if(data){
            var string = $("#contactarNatural").serialize()+"&idioama="+$("#idproducto").attr("lan");
            contactarCliente(string);
        }
    })
    $("#btn-enviar-prensa").click(function(e){
        e.preventDefault();
        var data = validarcontactoprensa();
        if(data){
            var string = $("#form-prensa").serialize()+"&idioama="+$("#idproducto").attr("lan");
            contactarPrensa(string);
        }
    })
    $(".imagen-change").click(function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        var aux = $(this).html();
        if(id == 3){
           aux =  $("#1").html();
          
           $("#1").html($(this).html());
           $(this).html(aux);
           if($(".img3").hasClass('img1')){
                $(".img3").removeClass('img1');
                $(".1").addClass('img1'); 
           }else{
                $(".img1").removeClass('img1');
                $(".img3").addClass('img1'); 
           }
        }else{
            if(id == 1){
                alert("abajo");
                aux =  $("#3").html();
                $("#3").html($(this).html());
                $(this).html(aux);
            }
        }
        if(id == 4){
            aux =  $("#2").html();
            $("#2").html($(this).html());
            $(this).html(aux);
            if($(".img4").hasClass('img2')){
                $(".img4").removeClass('img2');
                $(".2").addClass('img2'); 
           }else{
               
                $(".img2").removeClass('img2');
                $(".img4").addClass('img2');
           }
            
        }else{
            if(id == 2){
                aux =  $("#4").html();
                $("#4").html($(this).html());
                $(this).html(aux);
                $(".img2").removeClass('img2');
                $(".img4").addClass('img2');
            }
        }
         $('.img1').addpowerzoom({
                            defaultpower: 2,
                            powerrange: [2,5],
                            largeimage: null,
                            magnifiersize: [230,230] //<--no comma following last option!)
                        })
        $('.img2').addpowerzoom({
              defaultpower: 2,
              powerrange: [2,5],
              largeimage: null,
              magnifiersize: [230,230] //<--no comma following last option!)
        })


    })
  //ANCLAS ANIMADAS

$('a.ancla').click(function(e){
            var height = $("header").height();
            var enlace  = $(this).attr('href');
            var top =$(enlace).offset().top;
            $('html, body').animate({
            scrollTop: top = top-height
            }, 1000);
            
  });

    $(".btncategorias").click(function(e){
        e.preventDefault();
        var ruta = $(this).attr("href");
        
        cargarprodutos(ruta);
        $("#categorias  li a").each(function(){
            if($(this).attr("id")=="actual"){
                $(this).removeAttr("id");
            }
        })
        $(this).attr("id","actual");
    })

   $("#btn-recuperarcontra").click(function(e){
        e.preventDefault();
        parent.location.href="index.php?vista=recuperarpwd";
   })
   $("#btn-recuperar-password").click(function(e){
        var slttipodocumento = $("#slttipodocumento option:selected").val();
        var txtcorreo = $("#txtcorreo").val();
        var txtndocumento = $("#txtndocumento").val();
        var dataString = "cedulacliente="+txtndocumento+"&tipodocumento="+slttipodocumento+"&mailcliente="+encodeURIComponent(txtcorreo);
        var urlc = construirRuta("Usuarios", "recuperarContrasena");
        var msgc = "null";
        ejecutarFuncion(dataString, urlc, false,msgc);
        alert(globaldata);

   });

});



// When the user clicks the button, open the modal 
mostrarModal = function(id) {
    document.getElementById('myModal' + id).style.display = "block";
        $('#zoom' + id).elevateZoom({
            zoomType : 'inner'
        }); 
};

// When the user clicks on <span> (x), close the modal
cerrarModal = function(id) {
    document.getElementById('myModal' + id).style.display = "none";
    $('.zoomContainer').remove();
}

// When the user clicks anywhere outside of the modal, close it




