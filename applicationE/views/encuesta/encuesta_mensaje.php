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
        <div class="col-md-12" style="text-align: justify; text-justify: inter-word;">
            <p><?php echo nl2br($mensaje); ?></p>
            <br />
            <p>Haz click en el siguiente boton y la encuesta va a empezar. Al final no te olvides de dar click en el boton "Guardar Encuesta"
                para que tus respuestas sean guardadas. </p>
        </div>
        <div class="col-md-4 col-md-offset-4" >
        <form method="post" action="<?php echo site_url("encuesta/".$idEncuesta); ?>">
            <input type="hidden" name="empezar" value="empezar" />
            <input type="submit" name="submit" value="Empezar Encuesta" class="form-control btn-primary btn" />
        </form>
        </div>
    </div>
</body>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
<script src="http://code.jquery.com/jquery-1.11.3.min.js" language="javascript" ></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js" language="javascript" ></script>
<script src="<?php echo base_url(); ?>assets/javascript/bootstrap.js" language="javascript" ></script>
<?php if(isset($js)){ echo $js; } ?>
</html>
