<html>
    <head>
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/css/personas.css" />
        <?php if(isset($css)){ echo $css; } ?>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico"/>
        <script> var baseURL = "<?php echo base_url(); ?>";
        </script>
        <title><?php echo $titulo; ?></title> 
        <style>
            body{
                padding: 15px;
                padding-top: 70px;
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
        <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" >Sistema de Encuestas</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
              <li><a href="<?php echo site_url('se_encuestas'); ?>">Encuestas</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
              <li><a class="btn" href="<?php echo site_url('auth/logout'); ?>">Cerrar Sesi&oacute;n</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
        <div id="contenido">
            <?php
            $this->load->view($pagina, $contenido)
            ?>
        </div>
    </div>
</body>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
<script src="http://code.jquery.com/jquery-1.11.3.min.js" language="javascript" ></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js" language="javascript" ></script>
<script src="<?php echo base_url(); ?>assets/javascript/bootstrap.js" language="javascript" ></script>
<script language="javascript">
$(function() {
    $('.confirm').click(function(e) {
        e.preventDefault();
        if (window.confirm("Está seguro?")) {
            location.href = this.href;
        }
    });
});
</script>
<script>
    $(function(){
$('.confirm-form').submit(function() {
    var c = confirm("Está seguro que quiere suspender el proceso?");
    return c;
});
    });
</script>
<?php if(isset($js)){ echo $js; } ?>
</html>
