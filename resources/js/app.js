const { isEmpty } = require('lodash');

require('./bootstrap');

$(document).ready(function(){
    getSepomex($("#txt_cp_sepomex").val());
});

window.cargarUsuarios = function(value)
{
    var ruta = $("#ruta_cargar_empleados").val();
    var combo = $("#cbo_empleado_servicio");
    combo.html("--Seleccione una opción--");
    $.ajax({
        url: ruta,
        data:{
            'value':value
        },
        success: function(respuesta) {
            console.log(respuesta);
            combo.append(respuesta);
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}
window.cargarUsuariosFinales = function(value)
{
    var ruta = $("#ruta_cargar_usuario_final").val();
    var combo = $("#cbo_usuario_final");
    combo.html("--Seleccione una opción--");
    $.ajax({
        url: ruta,
        data:{
            'value':value
        },
        success: function(respuesta) {
            console.log(respuesta);
            combo.append(respuesta);
        },
        error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
}
window.getSepomex = function(value) {
    $('#txt_cp_sepomex').css('color','black');
    $("#cbo_asentamiento_sepomex").html('');
    $("#txt_ciudad_sepomex").val('');
    $("#txt_municipio_sepomex").val('');
    $("#txt_estado_estado").val('');
    var ruta = $("#ruta_get_sepomex").val();
    if(!isNaN(value))
    {
        $.ajax({
            url: ruta,
            data:{
                'value':value
            },
            success: function(respuesta) {
                if(respuesta.length > 0 )
                {
                    $('#txt_cp_sepomex').css('color','green');
                    for(var i = 0; i < respuesta.length;i++)
                    {
                        $("#cbo_asentamiento_sepomex").append('<option value="'+respuesta[i].asentamiento+'">'+respuesta[i].asentamiento+'</option>');
                        $("#txt_ciudad_sepomex").val(respuesta[i].ciudad);
                        $("#txt_municipio_sepomex").val(respuesta[i].municipio);
                        $("#txt_estado_estado").val(respuesta[i].estado);
                    }
                }
            },
            error: function() {
                console.log("No se ha podido obtener la información");
            }
        });
    }else{
        $('#txt_cp_sepomex').css('color','red');
    }
}
