/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var currentTab = "datosEncuesta";
var actions = new Array( );
var idEncuesta = 0;

window.onload = function() {
    openTabAction('datosEncuesta');
    setActions( );
};

function setActions( ) {
    if (typeof action === 'undefined') {
        action = "create";
    }
    actions = ({
        "datosEncuesta": action
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
        case "datosEncuesta":
            guardarDatosEncuesta(successFunction, option1);
            break;
        case "datosDemograficos":
            guardarDatosDemograficos(successFunction, option1);
            break;
        case "datosCulturasCategorias":
            guardarCulturasCategorias(successFunction, option1);
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

function printSuccessMessage(message, clase) {
    mensaje = "<div class='alert alert-success fade in " + clase + "'>" + message + "</div>";
    $("#successMessage").append(mensaje);
    setTimeout(function() {
        $("." + clase).remove( );
    }, 3000);
}


// -------------------------- DATOS ENCUESTA ---------------------------- //

var datosEncuestaSuccessFunction;
var datosEncuestaOption1;

function guardarDatosEncuesta(successFunction, option1){
    datosEncuestaSuccessFunction = successFunction;
    datosEncuestaOption1 = option1;
    guardarEncuesta( );
    $("#datosEncuestaErrores").html("");
}

function guardarEncuesta( ){
    var url = actions['datosEncuesta'] === "create" ? urlDatosEncuesta : urlDatosEncuestaUpdate;
    $.post(url, $("#form-encuesta").serialize())
            .done(function(data) {
                console.log(data);
                var info = jQuery.parseJSON(data);
                if (info.success) {
                    encuestaGuardada();
                    actions['datosEncuesta'] = 'update';
                    $(".idEncuesta").val(info.id);
                    idEncuesta = info.id;
                    printSuccessMessage("Se guard&oacute; la informaci&oacute;n de la encuesta", "encuestaGuardada");
                } else {
                    $('#datosEncuestaErrores').append(info.errores);
                }
            });
}

function encuestaGuardada(){
    runSuccessFunction(datosEncuestaSuccessFunction, datosEncuestaOption1);
}


// -------------------------- DATOS CULTURAS Y CATEGORIAS ---------------------------- //

//VARIABLES CULTURAS Y CATEGORIAS

var culturaCategoriaAction;
var culturaCategoriaOption1;
var correrAccionCulturaCategoria = false;

//VARIABLES CULTURAS

var countCulturasGuardados = 0;
var culturasDone = false;
var countCulturas = 1;

//METODOS CULTURAS Y CATEGORIAS

function guardarCulturasCategorias(successFunction, option1) {
    culturaCategoriaAction = successFunction;
    culturaCategoriaOption1 = option1;
    countCulturasGuardados = 0;
    culturasDone = false;
    categoriasDone = false;
    countCategoriasGuardados = 0;
    correrAccionCulturaCategoria = true;
    guardarCulturas( );
    guardarCategorias( );
    $('#datosCulturasCategoriasErrores').html("");
}

function guardarCulturas( ){
    $(".form-cultura").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlCulturas : urlCulturasUpdate;
        if ($(this).find(".nombre_cultura").val() === "" || $(this).find(".nombre_cultura").val() === " ") { //No se lleno entonces no se guarda
            culturaGuardada( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idCultura").val(info.id);
                        form.find(".accion").val('update');
                        culturaGuardada( );
                        printSuccessMessage("Se guard&oacute; la cultura.", "culturaGuardada");
                    } else {
                        $('#datosCulturasCategoriasError').append(info.errores);
                    }
                });
    });
}

function culturaGuardada() {
    countCulturasGuardados++;
    if (countCulturasGuardados === countCulturas) {
        culturasDone = true;
    }
    if (culturasDone && categoriasDone && correrAccionCulturaCategoria) {
        runSuccessFunction(culturaCategoriaAction, culturaCategoriaOption1);
        correrAccionCulturaCategoria = false;
    }
}

function agregarCultura() {
    var nuevoForm = $(".form-cultura").first().clone()
            .appendTo(".contenidoCulturas");
    nuevoForm.find(".nombre_cultura").val("");
    nuevoForm.find(".idCultura").val("");
    nuevoForm.find(".accion").val("create");
    nuevoForm.find(".idEncuesta").val(idEncuesta);
    countCulturas++;
}

//VARIABLES IDIOMAS

var countCategoriasGuardados = 0;
var categoriasDone = false;
var countCategorias = 1;

//METODOS CATEGORIAS

function guardarCategorias( ){
    $(".form-categoria").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlCategorias : urlCategoriasUpdate;
        if ($(this).find(".nombre_categoria").val() === "" || $(this).find(".nombre_categoria").val() === " ") { //No se lleno entonces no se guarda
            categoriaGuardada( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idCategoria").val(info.id);
                        form.find(".accion").val('update');
                        categoriaGuardada( );
                        printSuccessMessage("Se guard&oacute; la categoria.", "categoriaGuardada");
                    } else {
                        $('#datosCulturasCategoriasError').append(info.errores);
                    }
                });
    });
}

function categoriaGuardada() {
    countCategoriasGuardados++;
    if (countCategoriasGuardados === countCategorias) {
        categoriasDone = true;
    }
    if (culturasDone && categoriasDone && correrAccionCulturaCategoria) {
        runSuccessFunction(culturaCategoriaAction, culturaCategoriaOption1);
        correrAccionCulturaCategoria = false;
    }
}

function agregarCategoria() {
    var nuevoForm = $(".form-categoria").first().clone()
            .appendTo(".contenidoCategorias");
    nuevoForm.find(".nombre_categoria").val("");
    nuevoForm.find(".idCategoria").val("");
    nuevoForm.find(".accion").val("create");
    nuevoForm.find(".idEncuesta").val(idEncuesta);
    countCategorias++;
}



// -------------------------- DATOS DEMOGRAFICOS ---------------------------- //

//VARIABLES DEMOGRAFICOS

var datosDemograficosAction;
var datosDemograficosOption1;
var correrAccionDatosDemograficos = false;

//VARIABLES LUGARES DE TRABAJO

var countLugaresDeTrabajoGuardados = 0;
var lugaresDeTrabajoDone = false;
var countLugaresDeTrabajo = 1;

//METODOS LUGARES DE TRABAJO

function guardarDatosDemograficos(successFunction, option1) {
    datosDemograficosAction = successFunction;
    datosDemograficosOption1 = option1;
    countLugaresDeTrabajoGuardados = 0;
    lugaresDeTrabajoDone = false;
    departamentosDone = false;
    countDepartamentosGuardados = 0;
    correrAccionDatosDemograficos = true;
    guardarLugaresDeTrabajo( );
    guardarDepartamentos( );
    $('#datosDatosDemograficosErrores').html("");
}

function guardarLugaresDeTrabajo( ){
    $(".form-lugarDeTrabajo").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlLugaresDeTrabajo : urlLugaresDeTrabajoUpdate;
        if ($(this).find(".lugarDeTrabajo").val() === "" || $(this).find(".lugarDeTrabajo").val() === " ") { //No se lleno entonces no se guarda
            lugarDeTrabajoGuardado( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idLugarDeTrabajo").val(info.id);
                        form.find(".accion").val('update');
                        lugarDeTrabajoGuardado( );
                        printSuccessMessage("Se guard&oacute; el lugar de trabajo.", "lugarDeTrabajoGuardado");
                    } else {
                        $('#datosDemograficosErrores').append(info.errores);
                    }
                });
    });
}

function lugarDeTrabajoGuardado() {
    countLugaresDeTrabajoGuardados++;
    if (countLugaresDeTrabajoGuardados === countLugaresDeTrabajo) {
        lugaresDeTrabajoDone = true;
    }
    if (lugaresDeTrabajoDone && departamentosDone && correrAccionDatosDemograficos) {
        runSuccessFunction(datosDemograficosAction, datosDemograficosOption1);
        correrAccionDatosDemograficos = false;
    }
}

function agregarLugarDeTrabajo() {
    var nuevoForm = $(".form-lugarDeTrabajo").first().clone()
            .appendTo(".contenidoLugaresDeTrabajo");
    nuevoForm.find(".lugarDeTrabajo").val("");
    nuevoForm.find(".idLugarDeTrabajo").val("");
    nuevoForm.find(".totalPersonas").val("");
    nuevoForm.find(".accion").val("create");
    nuevoForm.find(".idEncuesta").val(idEncuesta);
    countLugaresDeTrabajo++;
}

//VARIABLES DEPARTAMENTOS

var countDepartamentosGuardados = 0;
var departamentosDone = false;
var countDepartamentos = 1;

//METODOS DEPARTAMENTOS

function guardarDepartamentos( ){
    $(".form-departamento").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlDepartamentos : urlDepartamentosUpdate;
        if ($(this).find(".departamento").val() === "" || $(this).find(".departamento").val() === " ") { //No se lleno entonces no se guarda
            departamentoGuardado( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idDepartamento").val(info.id);
                        form.find(".accion").val('update');
                        departamentoGuardado( );
                        printSuccessMessage("Se guard&oacute; el departamento.", "departamentoGuardada");
                    } else {
                        $('#datosDemograficosErrores').append(info.errores);
                    }
                });
    });
}

function departamentoGuardado() {
    countDepartamentosGuardados++;
    if (countDepartamentosGuardados === countDepartamentos) {
        departamentosDone = true;
    }
    if (lugaresDeTrabajoDone && departamentosDone && correrAccionDatosDemograficos) {
        runSuccessFunction(datosDemograficosAction, datosDemograficosOption1);
        correrAccionDatosDemograficos = false;
    }
}

function agregarDepartamento() {
    var nuevoForm = $(".form-departamento").first().clone()
            .appendTo(".contenidoDepartamentos");
    nuevoForm.find(".departamento").val("");
    nuevoForm.find(".idDepartamento").val("");
    nuevoForm.find(".totalPersonas").val("");
    nuevoForm.find(".accion").val("create");
    nuevoForm.find(".idEncuesta").val(idEncuesta);
    countDepartamentos++;
}



// -------------------------- DATOS PREGUNTAS ---------------------------- //

function openPreguntasTab( ){
    openTab("datosPreguntas");
    var selectCategoria = "<select class='form-control idCategoriaSelect' name='idCategoria' >";
    $(".form-categoria").each(function( ) {
        selectCategoria += "<option class='idCategoriaOption' value='"+$(this).find('.idCategoria').val()+"'>"+$(this).find('.nombre_categoria').val()+"</option>";
    });
    selectCategoria += "</select>";
    var selectCultura = "<select class='form-control idCulturaSelect' name='idCultura' >";
    $(".form-cultura").each(function( ) { 
        selectCultura += "<option class='idCulturaOption' value='"+$(this).find('.idCultura').val()+"'>"+$(this).find('.nombre_cultura').val()+"</option>";
    });
    selectCultura += "</select>";
    $(".pregunta_categoria_placeholder").html("").append(selectCategoria);
    $(".pregunta_cultura_placeholder").html("").append(selectCultura);
    
    $(".form-pregunta").each(function() { 
        $(this).find(".idCulturaSelect option[value='"+$(this).find(".cultura_value").html()+"']").attr("selected", true);
        $(this).find(".idCategoriaSelect option[value='"+$(this).find(".categoria_value").html()+"']").attr("selected", true);
    });
}

//VARIABLES PREGUNTAS

var datosPreguntasAction;
var datosPreguntasOption1;
var correrAccionDatosPreguntas = false;

var countPreguntasGuardadas = 0;
var preguntasDone = false;
var countPreguntas = 1;

//METODOS PREGUNTAS

function guardarDatosPreguntas(successFunction, option1) {
    datosPreguntasAction = successFunction;
    datosPreguntasOption1 = option1;
    countPreguntasGuardadas = 0;
    preguntasDone = false;
    correrAccionDatosPreguntas = true;
    guardarPreguntas( );
    $('#datosPreguntasErrores').html("");
}

function guardarPreguntas( ){
    $(".form-pregunta").each(function( ) {
        var url = $(this).find(".accion").val() === "create" ? urlPreguntas : urlPreguntasUpdate;
        if ($(this).find(".pregunta").val() === "" || $(this).find(".pregunta").val() === " ") { //No se lleno entonces no se guarda
            preguntaGuardada( );
        } else
            var form = $(this);
        $.post(url, $(this).serialize())
                .done(function(data) {
                    var info = jQuery.parseJSON(data);
                    if (info.success) {
                        form.find(".idPregunta").val(info.id);
                        form.find(".accion").val('update');
                        preguntaGuardada( );
                        printSuccessMessage("Se guard&oacute; la pregunta.", "preguntaGuardada");
                    } else {
                        $('#datosPreguntasErrores').append(info.errores);
                    }
                });
    });
}

function preguntaGuardada() {
    countPreguntasGuardadas++;
    if (countPreguntasGuardadas === countPreguntas) {
        preguntasDone = true;
    }
    if (preguntasDone && correrAccionDatosPreguntas) {
        runSuccessFunction(datosPreguntasAction, datosPreguntasOption1);
        correrAccionDatosPreguntas = false;
    }
}

function agregarPregunta() {
    var nuevoForm = $(".form-pregunta").first().clone()
            .appendTo(".contenidoPreguntas");
    nuevoForm.find(".idPregunta").val("");
    nuevoForm.find(".pregunta").val("");
    nuevoForm.find(".idCultura").val("");
    nuevoForm.find(".idCategoria").val("");
    nuevoForm.find(".accion").val("create");
    nuevoForm.find(".idEncuesta").val(idEncuesta);
    countPreguntas++;
}
