/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ACTUAlIZAR = 0;
var REGISTRAR = 1;

var action = 0;

var post = false;

$("#ingresoForm").submit(function(event) {
    if (!post) {
        console.log("Intentando enviar el form");
        event.preventDefault();
        var url = buscarPorCedulaUrl;
        console.log(buscarPorCedulaUrl);
        $.post(url, $("#ingresoForm").serialize())
                .done(function(data) {
                    post = true;
                    console.log(data);
                    var info = jQuery.parseJSON(data);
                    console.log("datos recibidos. Success:" + info.success);
                    if (info.success) {
                            $("#ingresoForm").attr("action", updateUrl);
                    } else { 
                            $("#ingresoForm").attr("action", createUrl);
                    }
                    console.log("Nuevo action del form: " + $("#ingresoForm").attr("action"));
                    $("#ingresoForm").submit();
            });
    }
});

function ingresarCedula( ) {
    $("#ingresoCedula").css("display", "block");
    action = ACTUAlIZAR;
}

function participarEnProceso( ){
    $.post(procesos)
                .done(function(data) {
                    console.log(data);
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        $("#seleccionProcesos").css("display", "block");
                        action = REGISTRAR;
                        info.procesos.forEach(function(proceso){
                            $("#selectProcesos").append("<option value='"+proceso.idProcesos+"'>P:"+proceso.codigo+" Cargo: "+proceso.cargo+" para " + proceso.ciudad + "</option>");
                        });
                    } else {
                        
                    }
                });
} 

function participar( ){
    $("#hiddenProceso").val($("#selectProcesos").find(":selected").val());
    $("#ingresoCedula").css("display", "block");
    $("#seleccionProcesos").css("display", "hidden");
}