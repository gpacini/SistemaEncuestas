/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function agregarAProceso() {
    var url = urlBuscarProcesos;
    $.ajax({
        url: url,
        type: 'POST',
        data: {idPersona : $("#idPersona").val() },
        success: function(data) {
            var info = jQuery.parseJSON(data);
            info.procesos.forEach(function(proceso) {
                $("#select-agregarAProceso").append(
                        "<option value='" + proceso.idProcesos + "'>" + proceso.cargo + " para " + proceso.empresa + "</option>"
                        );
            });
            $("#select-agregarAProceso").css("display", "block");
            $("#btn-agregarAProceso").attr('onclick', "agregarAProcesoAction();");
            $("#btn-agregarAProceso").html("Agregar");
        }
    });
}

function agregarAProcesoAction() {
    var url = urlAgregarAProceso;
    $.post(url, $("#form-agregarAProceso").serialize())
            .done(function(data) {
                var info = jQuery.parseJSON(data);
                if (info.success) {
                    $("#form-agregarAProceso").remove();
                    $("#btn-agregarAProceso").remove();
                    $("#div-agregarAProceso").html("<span class='label label-success'>Se agrego el usuario al proceso.</span>");
                } else {
                    $("#div-agregarAProceso").append("<span class='label label-danger'>Se agrego el usuario al proceso.</span>");
                }
            });
}

