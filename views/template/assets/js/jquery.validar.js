function validarcontactoprensa(){
    var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,30}$/;
    var valor = $("#txtnombre").val();
    if (!expresion.test(valor)) {
        alert("El nombre ingresado no cumple con los requisitos");
        $("#txtnombre").focus();
        return false;
    }else{
        var expresion = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/i;
        var valor = $("#txtcorreo").val();
        if (!expresion.test(valor)) {
            alert("El correo ingresado no cumple con los requisitos");
            $("#txtcorreo").focus();
            return false;
        }else{
            var valor = $("#sltmedio option:selected").val();
            if (valor == 0) {
                alert("Debe seleccionar el medio al cual usted pertenece");
                return false;
            }
            else {
                var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,30}$/;
                var valor = $("#txtmedio").val();
                if (!expresion.test(valor)) {
                    alert("El nombre del medio ingresado no cumple con los requisitos");
                    $("#txtmedio").focus();
                    return false;
                }
                else {
                    var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,100}$/;
                    var valor = $("#txtasunto").val();
                    if (!expresion.test(valor)) {
                        alert("El asunto ingresado no cumple con los requisitos");
                        $("#txtasunto").focus();
                        return false;
                    } else {
                        if ($.trim($('#txtmensaje').val()) == '') {
                            alert("El mensaje ingresado no cumple con los requisitos");
                            $("#txtmensaje").focus();
                            return false;
                        } else {
                            return true;
                        }
                    }
                }
            }
        }
    }
}
function validarcontacto(){
    var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,30}$/;
    var valor = $("#txtnombre").val();
    if (!expresion.test(valor)) {
        alert("El nombre ingresado no cumple con los requisitos");
        $("#txtnombre").focus();
        return false;
    }else{
        var expresion = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/i;
        var valor = $("#txtcorreo").val();
        if (!expresion.test(valor)) {
            alert("El correo ingresado no cumple con los requisitos");
            $("#txtcorreo").focus();
            return false;
        }else{
            var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,100}$/;
            var valor = $("#txtasuntocontacto").val();
            if (!expresion.test(valor)) {
                alert("El asunto ingresado no cumple con los requisitos");
                $("#txtasuntocontacto").focus();
                return false;
            }else{
                if($.trim($('#txtmensaje').val()) == ''){
                    alert("El mensaje ingresado no cumple con los requisitos");
                    $("#txtmensaje").focus();
                    return false;
                }else{
                    return true;
                }
            }
        }
    }
}
function validarmyaccount(){
    var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,50}$/;
    var valor = $("#txtnombre").val();
    if (!expresion.test(valor)) {
        alert("El nombre ingresado no cumple con los requisitos");
        $("#txtnombre").focus();
        return false;
    }else{
        var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,50}$/;
        var valor = $("#txtapellidos").val();
        if (!expresion.test(valor)) {
            alert("El apellido ingresado no cumple con los requisitos");
            $("#txtapellidos").focus();
            return false;
        }else{
            var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9]{1,20}$/;
            var valor = $("#txtusuario").val();
            if (!expresion.test(valor)) {
                alert("El usuario ingresado no cumple con los requisitos");
                $("#txtusuario").focus();
                return false;
            }else{
                var expresion = /^[a-zA-Z0-9]{6,10}$/;
                var valor = $("#txtconstra").val();
                if (!expresion.test(valor)) {
                    alert("la contraseña ingresado no cumple con los requisitos el numero de caracteres debe ser igual o superior a 8");
                    $("#txtconstra").focus();
                    return false;
                }else{
                    var valor = $("#slttipodocumento option:selected").val();
                    if (valor == '0') {
                        alert("No se ha seleccionado ningun tipo de documento");
                        return false;
                    }else{
                        var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9 ]{4,30}$/;
                        var valor = $("#txtndocumento").val();
                        if (!expresion.test(valor)) {
                            alert("El nro de documento ingresado no cumple con los requisitos");
                            $("#txtndocumento").focus();
                            return false;
                        }else{
                            var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{5,50}$/;
                            var valor = $("#txttelefono").val();
                            if (!expresion.test(valor)) {
                                alert("El nro de telefono ingresado no cumple con los requisitos");
                                $("#txttelefono").focus();
                                return false;
                            }else{
                                var expresion = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/i;
                                var valor = $("#txtcorreo").val();
                                if (!expresion.test(valor)) {
                                    alert("El correo ingresado no cumple con los requisitos");
                                    $("#txtcorreo").focus();
                                    return false;
                                }else{
                                    var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,50}$/;
                                    var valor = $("#txtpais").val();
                                    if (!expresion.test(valor)) {
                                        alert("El pais ingresado no cumple con los requisitos");
                                        $("#txtpais").focus();
                                        return false;
                                    }else{
                                        var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,50}$/;
                                        var valor = $("#txtdepartemento").val();
                                        if (!expresion.test(valor)) {
                                            alert("El departamento ingresado no cumple con los requisitos");
                                            $("#txtdepartemento").focus();
                                            return false;
                                        }else{
                                            var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,50}$/;
                                            var valor = $("#txtciudad").val();
                                            if (!expresion.test(valor)) {
                                                alert("El ciudad ingresado no cumple con los requisitos");
                                                $("#txtciudad").focus();
                                                return false;
                                            }else{
                                                var expresion = /^[A-ZñÑaáéíóúÁÉÍÓÚ\.a-z0-9-# ]{1,50}$/;
                                                var valor = $("#txtdireccion").val();
                                                if (!expresion.test(valor)) {
                                                    alert("la direccion ingresada no cumple con los requisitos no son validos caractes como \"* # - _\"");
                                                    $("#txtdireccion").focus();
                                                    return false;
                                                }else{
                                                    return true;
                                                } 
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } 
                }
            }
        } 
    } 
}
