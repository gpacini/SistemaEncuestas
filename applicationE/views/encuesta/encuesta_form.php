<html>
    <head>
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/personas.css" />
        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico"/>
        <title><?php echo $titulo; ?></title> 
        <style>
            body{
                padding: 15px;
                padding-top: 30px;
            }
        </style>
        <?php
        echo meta('Content-type', 'text/html; charset=utf-8', 'equiv');
        ?>
    </head>
    <body id="<?php
    if (isset($body_id)) {
        echo $body_id;
    }
    ?>">
        <div id="contenido">
            <div class="col-md-12">
                <img src="<?php echo base_url(); ?>assets/logo.jpg" class="col-md-4 " style="width:150px; height:auto;"/>
            </div>
            <div class="col-md-4 col-md-offset-4" style="text-align:center;" >
                <h2><?php echo $titulo; ?></h2>
            </div>
            <div class="col-md-12">
                <div class="col-md-12">
                    <p>Recuerda que tus respuestas deben reflejar la presencia de la situación bajo un criterio de frecuencia: </p>
                    <ol>
                        <li>Nunca está presente esta característica</li>
                        <li>Rara vez está presente </li>
                        <li>Usualmente esta presente esta característica</li>
                        <li>Casi siempre está presente esta característica</li>
                        <li>Siempre está presente esta característica</li>
                    </ol>
                    <p>Para terminar la encuesta todas las preguntas deben ser respondidas, ninguna puede quedar en blanco. </p>
                    <p>No te olvides de dar click en el botón "Guardar Encuesta" al final de la página y esperar el mensaje 
                        de confirmación para que tus respuestas sean guardadas.</p>
                </div>
            </div>
            <div class="col-md-12" id="panelErrores" ></div>
            <div class="col-md-12 datosDemograficos">
                <form id="datosDemograficos">
                    <div class="col-md-12">
                        <div class="form-group col-md-6">
                            <label for="varchar">Sexo </label>
                            <select name="sexo" class="form-control">
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="varchar">Edad </label>
                            <select name="edad" class="form-control">
                                <option value="18_25">18 a 25 años</option>
                                <option value="25_30">25 a 30 años</option>
                                <option value="30_40">30 a 40 años</option>
                                <option value="40_50">40 a 50 años</option>
                                <option value="50">Más de 50 años</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group col-md-6">
                            <label for="varchar">Antigüedad </label>
                            <select name="antiguedad" class="form-control">
                                <option value="1">Menos de 1 año</option>
                                <option value="1_2">1 a 2 años</option>
                                <option value="2_5">2 a 5 años</option>
                                <option value="5_10">5 a 10 años</option>
                                <option value="10_15">10 a 15 años</option>
                                <option value="15">Más de 15 años</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="varchar">Lugar de Trabajo </label>
                            <select name="idLugarTrabajo" class="form-control">
                                <option value="NULL"></option>
                                <?php foreach ($lugaresDeTrabajo as $lugarDeTrabajo) {
                                    ?>
                                    <option value="<?php echo $lugarDeTrabajo->idLugarTrabajo; ?>"><?php echo $lugarDeTrabajo->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group col-md-6" style="display: none;">
                            <label for="varchar">Cargo de Trabajo </label>
                            <select name="jerarquia" class="form-control">
                                <option value="alta_gerencia">Alta Gerencia</option>
                                <option value="gerencia">Gerencia Media</option>
                                <option value="jefatura">Jefatura</option>
                                <option value="supervision">Supervision/Administrativo</option>
                                <option value="operativo">Operativo</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" style="display: none;">
                            <label for="varchar">Departamento al que pertenece </label>
                            <select name="idDepartamento" class="form-control">
                                <option value="NULL" ></option>
                                <?php foreach ($departamentos as $departamento) {
                                    ?>
                                    <option value="<?php echo $departamento->idDepartamento; ?>"><?php echo $departamento->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" class="accion" value="create" />
                    <input type="hidden" name="idEncuesta" value="<?php echo $idEncuesta; ?>" />
                    <input type="hidden" name="idUsuario" class="idUsuario" value="" />
                </form>
            </div>
            <div class="col-md-12 datosPreguntas">
                <?php
                $counterPreguntas = 1;
                foreach ($preguntas as $pregunta) {
                    ?>
                    <form class="form-respuesta">
                        <div class="form-group col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px lightgray solid;">
                            <strong class="col-xs-8 col-sm-8 col-md-10"><?php echo $counterPreguntas . ".- " . $pregunta->pregunta; ?></strong>
                            <input type="radio" name="calificacion" value="1"/> 1
                            <input type="radio" name="calificacion" value="2"/> 2
                            <input type="radio" name="calificacion" value="3"/> 3
                            <input type="radio" name="calificacion" value="4"/> 4
                            <input type="radio" name="calificacion" value="5"/> 5
                            <input type="hidden" name="idUsuario" class="idUsuario" value="" />
                            <input type="hidden" name="idEncuesta" value="<?php echo $idEncuesta; ?>" />
                            <input type="hidden" name="idPregunta" value="<?php echo $pregunta->idPregunta; ?>" />
                            <input type="hidden" name="idRespuesta" class="idRespuesta" value="" />
                            <input type="hidden" class="counter_pregunta" value="<?php echo $counterPreguntas; ?>" />
                            <input type="hidden" class="accion" value="create" />
                        </div>
                    </form>

                    <?php
                    $counterPreguntas += 1;
                }
                ?>
            </div>
            
            
<div id="divTemporalErrores">
    
</div>

            <div  class="col-md-12">
                <div class="col-md-4 col-md-offset-4">
                    <a type="submit" class="btn btn-primary form-control" id="btn-guardar" >Guardar Encuesta</a> 
                </div>
            </div>
            <br /> &nbsp;
            <br /> &nbsp;
            <br /> &nbsp;
            <br /> &nbsp;
            <br /> &nbsp;
            <br /> &nbsp;
            <br /> &nbsp;
            <br /> &nbsp;
            <br /> &nbsp;
            <br /> &nbsp;
        </div>
    </body>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
    <script src="http://code.jquery.com/jquery-1.11.3.min.js" language="javascript" ></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js" language="javascript" ></script>
    <script src="<?php echo base_url(); ?>assets/javascript/bootstrap.js" language="javascript" ></script>
    <?php
    if (isset($js)) {
        echo $js;
    }
    ?>

    <script>

        <?php
        echo "var urlUsuarioEncuesta = '" . site_url('se_usuariosencuestas/create_action') . "';";
        echo "var urlUsuarioEncuestaUpdate = '" . site_url('se_usuariosencuestas/update_action') . "';";
        echo "var urlRespuestas = '" . site_url('se_respuestas/create_action') . "';";
        echo "var urlRespuestasUpdate = '" . site_url('se_respuestas/update_action') . "';";
        echo "var countPreguntas = " . count($preguntas);
        ?>

        $(function() {
            $("#btn-guardar").click(function(e) {
                e.preventDefault();
                var save = true;
                $(".form-respuesta").each(function( ) {
                    if (!$(this).find("input[name='calificacion']:checked").val( )) {
                        alert("La pregunta " + $(this).find('.counter_pregunta').val() + " no ha sido respondida.");
                        save = false;
                    } 
                });
                if( save ) {
                    $("#btn-guardar").attr("disabled", "TRUE");
                    $("#btn-guardar").attr("value", "Enviando Respuestas");
                    guardarUsuarioEncuesta();
                }
            });
        });

        function guardarUsuarioEncuesta( ) {
            var url = $("#datosDemograficos").find(".accion").val() === "create" ? urlUsuarioEncuesta : urlUsuarioEncuestaUpdate;
            var form = $("#datosDemograficos");
            $.post(urlUsuarioEncuesta, $("#datosDemograficos").serialize())
                    .done(function(data) {
            var info = jQuery.parseJSON(data);
            if (info.success) {
                $(".idUsuario").val(info.id);
                form.find(".accion").val('update');
                guardarRespuestas( );
            } else {
                $("#panelErrores").append(info.errores);
            }
            })
                    .fail(function(data){
                        console.log(data);
                $("#divTemporalErrores").append(data.responseText);
            });
        }

        var countRespuestasGuardadas = 0;

        function guardarRespuestas( ) {
            countRespuestasGuardadas = 0;
            $(".form-respuesta").each(function( ) {
                var url = $(this).find(".accion").val() === "create" ? urlRespuestas : urlRespuestasUpdate;
                    var form = $(this);
                    $.post(url, $(this).serialize())
                            .done(function(data) {
                                var info = jQuery.parseJSON(data);
                                if (info.success) {
                                    form.find(".idRespuesta").val(info.id);
                                    form.find(".accion").val('update');
                                    respuestaGuardada( );
                                } else {
                                    $('#panelErrores').append(info.errores);
                                }
                            });
            });
        }
        
        function respuestaGuardada() {
            countRespuestasGuardadas++;
            if (countRespuestasGuardadas === countPreguntas) {
                window.location.replace("<?php echo site_url("encuesta/felicitaciones"); ?>");
            }
        }

</script>
</html>
