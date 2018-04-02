/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true
    });
    //$(".datepicker").datepicker("setDate", "01/01/1970");
});

var currentTab = "datosPersonales";
var actions = new Array( );
var idPersona = 0;

window.onload = function() {
    openTabAction('datosPersonales');
    setActions( );
};

function setActions( ) {
    if (typeof action === 'undefined') {
        action = "create";
    }
    actions = ({
        "datosPersonales": action,
        "datosContacto": action
    });
}

var openTab = function openTab(nombreTab) {
    saveCurrentTab(openTabAction, nombreTab, null);
};

var openTabAction = function openTabAction(nombreTab) {
    $('.tab-contenido').css("display", "none");
    $('#tab-' + nombreTab).css("display", "block");
    currentTab = nombreTab;
};

function saveCurrentTab(successFunction, option1, option2) {
    switch (currentTab) {
        case "datosPersonales":
            guardarPersona(successFunction, option1);
            break;
        case "conyugye":
            guardarConyugue(successFunction, option1);
            break;
        case "datosContacto":
            guardarDatosContacto(successFunction, option1);
            break;
        case "formacionAcademica":
            guardarDatosAcademicos(successFunction, option1);
            break;
        case "idiomas":
            guardarIdiomas(successFunction, option1);
            break;
        case "experienciasLaborales":
            guardarExperienciasLaborales(successFunction, option1);
            break;
        case "aspiracionesSalariales":
            guardarAspiracionesSalariales(successFunction, option1);
            break;
        case "observaciones":
            guardarObservaciones(successFunction, option1);
            break;
        case "referenciasLaborales":
            guardarReferenciasLaborales(successFunction, option1);
            break;
    }
}

function runSuccessFunction(successFunction, option1, option2) {
    if (typeof successFunction !== 'undefined') {
        if (typeof option1 !== 'undefined') {
            successFunction(option1);
        } else {
            successFunction( );
        }
    }
}

// -------------------------- DATOS PERSONALES ---------------------------- //

var datosPersonalesDone = false;
var conyugueDone = false;
var datosContactoDone = false;
var personaSuccessFunction;
var personaOption1;

function guardarPersona(successFunction, option1) {
    datosPersonalesDone = false;
    conyugueDone = false;
    datosContactoDone = false;
    personaSuccessFunction = successFunction;
    personaOption1 = option1;
    guardarDatosPersonales( );
    guardarConyugue( );
    guardarDatosContacto( );
    $("#datosPersonalesErrores").html("");
}

function personaGuardada(tipoDatos) {
    switch (tipoDatos) {
        case "datosPersonales":
            datosPersonalesDone = true;
            break;
        case "conyugue":
            conyugueDone = true;
            break;
        case "datosContacto":
            datosContactoDone = true;
            break;
    }
    if (datosPersonalesDone && conyugueDone && datosContactoDone) {
        runSuccessFunction(personaSuccessFunction, personaOption1);
    }
}

function printSuccessMessage(message, clase) {
    mensaje = "<div class='alert alert-success fade in " + clase + "'>" + message + "</div>";
    $("#successMessage").append(mensaje);
    setTimeout(function() {
        $("." + clase).remove( );
    }, 3000);
}

//METODOS DATOS PERSONALES

function guardarDatosPersonales() {
    var url = actions['datosPersonales'] === "create" ? urlDatosPersonales : urlDatosPersonalesUpdate;
    $.post(url, $("#form-persona").serialize())
            .done(function(data) {
                var info = jQuery.parseJSON(data);
                if (info.success) {
                    personaGuardada("datosPersonales");
                    actions['datosPersonales'] = 'update';
                    $(".idPersona").val(info.id);
                    idPersona = info.id;
                    printSuccessMessage("Se guard&oacute; la informaci&oacute;n persona", "personaGuardada");
                } else {
                    $('#datosPersonalesErrores').append(info.errores);
                }
            });
}

// METODOS CONYUGUE

function guardarConyugue() {
    var url = $("#form-conyugue").find(".accion").val() === "create" ? urlConyugue : urlConyugueUpdate;
    if ($("#nombresConyugue").val() === "" || $("#nombresConyugue").val() === " ") { //No se lleno entonces no se guarda
        personaGuardada("conyugue");
    } else {
        $.post(url, $("#form-conyugue").serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        $("#idConyugue").val(info.id);
                        actions['conyugue'] = 'update';
                        personaGuardada("conyugue");
                        printSuccessMessage("Se guardo&oacute;la informaci&oacute;n del conyugue.", "conyugueGuardado");
                    } else {
                        $('#datosPersonalesErrores').append(info.errores);
                    }
                });
    }
}

// METODOS CONTACTO

function guardarDatosContacto() {
    var url = actions['datosContacto'] === "create" ? urlDatosContacto : urlDatosContactoUpdate;
    $.post(url, $("#form-datosContacto").serialize())
            .done(function(data) {
                var info = jQuery.parseJSON(data);
                if (info.success) {
                    actions['datosContacto'] = 'update';
                    personaGuardada("datosContacto");
                    $("#idPersonasContacto").val(info.id);
                    printSuccessMessage("Se guard&oacute; la informaci&oacute;n de contacto", "contactoGuardado");
                } else {
                    $('#datosPersonalesErrores').append(info.errores);
                }
            });
}

// -------------------------- DATOS ACADEMICOS ---------------------------- //

//VARIABLES DATOS ACADEMICOS

var formacionAcademicaAction;
var formacionAcademicaOption1;
var correrAccionFormacionAcademica = false;

//VARIABLES FORMACION ACADEMICA

var countFormacionAcademicaGuardados = 0;
var formacionAcademicaDone = false;
var countFormacionAcademica = 1;

//METODOS FORMACION ACADEMICA

function guardarDatosAcademicos(successFunction, option1) {
    formacionAcademicaAction = successFunction;
    formacionAcademicaOption1 = option1;
    countFormacionAcademicaGuardados = 0;
    formacionAcademicaDone = false;
    idiomasDone = false;
    countIdiomasGuardados = 0;
    correrAccionFormacionAcademica = true;
    guardarFormacionAcademica( );
    guardarIdiomas( );
    $('#datosFormacionAcademicaError').html("");
}

function guardarFormacionAcademica() {
    $(".form-formacionAcademica").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlFormacionAcademica : urlFormacionAcademicaUpdate;
        if ($(this).find(".nivelFormacionAcademica").val() === "" || $(this).find(".nivelFormacionAcademica").val() === " ") { //No se lleno entonces no se guarda
            formacionAcademicaGuardada( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idFormacionAcademica").val(info.id);
                        form.find(".accion").val('update');
                        formacionAcademicaGuardada( );
                        printSuccessMessage("Se guard&oacute; el estudio.", "estudioGuardado");
                    } else {
                        $('#datosFormacionAcademicaError').append(info.errores);
                    }
                });
    });
}

function formacionAcademicaGuardada() {
    countFormacionAcademicaGuardados++;
    if (countFormacionAcademicaGuardados === countFormacionAcademica) {
        formacionAcademicaDone = true;
    }
    if (formacionAcademicaDone && idiomasDone && correrAccionFormacionAcademica) {
        runSuccessFunction(formacionAcademicaAction, formacionAcademicaOption1);
        correrAccionFormacionAcademica = false;
    }
}

function agregarFormacionAcademica() {
    var nuevoForm = $(".form-formacionAcademica").first().clone()
            .appendTo(".contenidoFormacionAcademica");
    nuevoForm.find(".nivel").val("");
    nuevoForm.find(".institucion").val("");
    nuevoForm.find(".anoInicio").val("");
    nuevoForm.find(".anoFinal").val("");
    nuevoForm.find(".idFormacionAcademica").val("");
    nuevoForm.find(".accion").val("create");
    nuevoForm.find(".idPersona").val(idPersona);
    countFormacionAcademica++;
}

//VARIABLES IDIOMAS

var countIdiomasGuardados = 0;
var idiomasDone = false;
var countIdiomas = 1;

//METODOS IDIOMAS

function guardarIdiomas() {
    $(".form-idioma").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlIdiomas : urlIdiomasUpdate;
        if ($(this).find(".idioma").val() === "" || $(this).find(".idioma").val() === " ") { //No se lleno entonces no se guarda
            idiomaGuardado( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idIdiomas").val(info.id);
                        form.find(".accion").val('update');
                        idiomaGuardado( );
                        printSuccessMessage("Se guard&oacute; el idioma.", "idiomaGuardado");
                    } else {
                        $('#datosFormacionAcademicaError').append(info.errores);
                    }
                });
    });
}

function idiomaGuardado() {
    countIdiomasGuardados++;
    if (countIdiomasGuardados === countIdiomas) {
        idiomasDone = true;
    }
    if (formacionAcademicaDone && idiomasDone && correrAccionFormacionAcademica) {
        runSuccessFunction(formacionAcademicaAction, formacionAcademicaOption1);
        correrAccionFormacionAcademica = false;
    }
}

function agregarIdioma() {
    var nuevoForm = $(".form-idioma").first().clone()
            .appendTo(".contenidoIdiomas");
    nuevoForm.find(".nivelIdioma").val("");
    nuevoForm.find(".idioma").val("");
    nuevoForm.find(".accion").val("create");
    nuevoForm.find(".idPersona").val(idPersona);
    nuevoForm.find(".idIdiomas").val("");
    countFormacionAcademica++;
}


// -------------------------- EXPERIENCIA LABORAL ---------------------------- //

//VARIABLES EXPERIENCIA LABORAL

var countExperienciasLaboralesGuardados = 0;
var experienciasLaboralesDone = false;
var experienciasLaboralesAction;
var experienciasLaboralesOption1;
var countExperienciasLaborales = 1;

//METODOS EXPERIENCIA LABORAL

function guardarExperienciasLaborales(successFunction, option1) {
    experienciasLaboralesAction = successFunction;
    experienciasLaboralesOption1 = option1;
    countExperienciasLaboralesGuardados = 0;
    experienciasLaboralesDone = false;
    guardarExperienciaLaboral( );
    $('#datosExperienciaLaboral').html("");
}

function guardarExperienciaLaboral() {
    $(".form-experienciaLaboral").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlExperienciasLaborales : urlExperienciasLaboralesUpdate;
        if ($(this).find(".empresa").val() === "" || $(this).find(".empresa").val() === " ") { //No se lleno entonces no se guarda
            experienciaLaboralGuardada( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idExperienciasLaborales").val(info.id);
                        form.find(".accion").val('update');
                        experienciaLaboralGuardada( );
                        printSuccessMessage("Se guard&oacute; la experiencia laboral.", "experienciaGuardada");
                    } else {
                        $('#datosExperienciaLaboral').append(info.errores);
                    }
                });
    });
}

function experienciaLaboralGuardada() {
    countExperienciasLaboralesGuardados++;
    if (countExperienciasLaboralesGuardados === countExperienciasLaborales) {
        experienciasLaboralesDone = true;
    }
    if (experienciasLaboralesDone) {
        runSuccessFunction(experienciasLaboralesAction, experienciasLaboralesOption1);
    }
}

function agregarExperienciaLaboral() {
    var nuevoForm = $(".form-experienciaLaboral").first().clone()
            .appendTo(".contenidoExperienciaLaboral");
    nuevoForm.find(".empresa").val("");
    nuevoForm.find(".sectorEmpresa").val("");
    nuevoForm.find(".ultimoCargo").val("");
    nuevoForm.find(".otrosCargos").val("");
    nuevoForm.find(".fechaInicio").val("");
    nuevoForm.find(".fechaSalida").val("");
    nuevoForm.find(".responsabilidades").val("");
    nuevoForm.find(".logros").val("");
    nuevoForm.find(".salario").val("");
    nuevoForm.find(".beneficios").val("");
    nuevoForm.find(".motivoSalida").val("");
    nuevoForm.find(".accion").val("create");
    nuevoForm.find(".idPersona").val(idPersona);
    nuevoForm.find(".idExperienciasLaborales").val("");
    countExperienciasLaborales++;
}

// -------------------------- ASPIRACION SALARIAL ---------------------------- //


function guardarAspiracionesSalariales(successFunction, option1) {
    $('#datosAspiracionLaboralError').html("");
    var url = $("#form-aspiracionSalarial").find(".accion").val() === "create" ? urlAspiracionesSalariales : urlAspiracionesSalarialesUpdate;
    var formData = new FormData($("#form-aspiracionSalarial")[0]);
    $.ajax({
        url: url,  
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
                var info = jQuery.parseJSON(data);
                if (info.success) {
                    $("#form-aspiracionSalarial").find(".accion").val('update');
                    runSuccessFunction(successFunction, option1);
                    $("#idAspiracionesSalariales").val(info.id);
                    $('#datosAspiracionSalarialErrores').append(info.errores);
                    printSuccessMessage("Se guard&oacute; la aspiraci&oacute; salarial", "aspiracionGuardado");
                } else {
                    $('#datosAspiracionSalarialErrores').append(info.errores);
                }
            }
    });
}


// -------------------------- REFERENCIAS LABORALES ---------------------------- //

//VARIABLES REFERENCIAS LABORALES


var countReferenciasLaboralesGuardados = 0;
var referenciasLaboralesDone = false;
var referenciasLaboralesAction;
var referenciasLaboralesOption1;
var countReferenciasLaborales = 1;

//METODOS REFERENCIAS LABORALES

function guardarReferenciasLaborales(successFunction, option1) {
    referenciasLaboralesAction = successFunction;
    referenciasLaboralesOption1 = option1;
    countReferenciasLaboralesGuardados = 0;
    referenciasLaboralesDone = false;
    guardarReferenciaLaboral( );
    $('#datosReferenciaLaboralError').html("");
}

function guardarReferenciaLaboral() {
    $(".form-referenciaLaboral").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlReferenciasLaborales : urlReferenciasLaboralesUpdate;
        if ($(this).find(".nombresReferencia").val() === "" || $(this).find(".nombresReferencia").val() === " ") { //No se lleno entonces no se guarda
            referenciaLaboralGuardada( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idReferenciasLaborales").val(info.id);
                        form.find(".accion").val('update');
                        referenciaLaboralGuardada( );
                        printSuccessMessage("Se guard&oacute; la referencia laboral.", "referenciaGuardado");
                    } else {
                        $('#datosReferenciaLaboralError').append(info.errores);
                    }

                });
    });
}

function referenciaLaboralGuardada() {
    countReferenciasLaboralesGuardados++;
    if (countReferenciasLaboralesGuardados === countReferenciasLaborales) {
        referenciasLaboralesDone = true;
    }
    if (referenciasLaboralesDone) {
        runSuccessFunction(referenciasLaboralesAction, referenciasLaboralesOption1);
    }
}

function agregarReferenciaLaboral() {
    var nuevoForm = $(".form-referenciaLaboral").first().clone()
            .appendTo(".contenidoReferenciaLaboral");
    nuevoForm.find(".nombresReferencia").val("");
    nuevoForm.find(".apellidosReferencia").val("");
    nuevoForm.find(".cargoReferencia").val("");
    nuevoForm.find(".empresaReferencia").val("");
    nuevoForm.find(".celularReferencia").val("");
    nuevoForm.find(".relacionReferencia").val("");
    nuevoForm.find(".accion").val("create");
    nuevoForm.find(".idPersona").val(idPersona);
    nuevoForm.find(".idReferenciasLaborales").val("");
    countReferenciasLaborales++;
}


// -------------------------- OBSERVACIONES ---------------------------- //

//VARIABLES OBSERVACIONES

var countObservacionesGuardados = 0;
var observacionesDone = false;
var observacionesAction;
var observacionesOption1;
var countObservaciones = 1;

//METODOS OBSERVACIONES

function guardarObservaciones(successFunction, option1) {
    observacionesAction = successFunction;
    observacionesOption1 = option1;
    countObservacionesGuardados = 0;
    observacionesDone = false;
    guardarObservacion( );
    $('#datosObservacionesError').html("");
}

function guardarObservacion() {
    $(".form-observacion").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlObservaciones : urlObservacionesUpdate;
        if ($(this).find(".observacion").val() === "" || $(this).find(".observacion").val() === " ") { //No se lleno entonces no se guarda
            observacionGuardada( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idObservaciones").val(info.id);
                        form.find(".accion").val('update');
                        observacionGuardada( );
                        printSuccessMessage("Se guard&oacute; la observaci&oacute;n.", "observacionGuardado");
                    } else {
                        $('#datosObservacionesError').append(info.errores);
                    }
                });
    });
}

function observacionGuardada() {
    countObservacionesGuardados++;
    if (countObservacionesGuardados === countObservaciones) {
        observacionesDone = true;
    }
    if (observacionesDone) {
        runSuccessFunction(observacionesAction, observacionesOption1);
    }
}

function agregarObservacion() {
    var nuevoForm = $(".form-observacion").first().clone()
            .appendTo(".contenidoObservaciones");
    nuevoForm.find(".observacion").val("");
    nuevoForm.find(".idPersona").val(idPersona);
    nuevoForm.find(".idObservaciones").val("");
    countObservaciones++;
}

//---------------------- AGREGAR A PROCESO ---------------------------------------


function agregarAProceso() {
    var url = urlBuscarProcesos;
    $.ajax({
        url: url,
        type: 'POST',
        data: {idPersona : $(".idPersona").first().val() },
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