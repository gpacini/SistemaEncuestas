<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class encuesta extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    
    public function index($id){
        
        $empezar = $this->input->post("empezar", TRUE);
        
        if( $empezar ){
        
            $this->load->model('se_encuestas_model');
            $this->load->model('se_preguntas_model');
            $this->load->model('se_departamentos_model');
            $this->load->model('se_lugaresdetrabajo_model');
        
            $encuesta = $this->se_encuestas_model->get_by_id($id);
        
            $data['preguntas'] = $this->se_preguntas_model->get_by_encuesta_id($id);
            $data['lugaresDeTrabajo'] = $this->se_lugaresdetrabajo_model->get_by_encuesta_id($id);
            $data['departamentos'] = $this->se_departamentos_model->get_by_encuesta_id($id);
            $data['idEncuesta'] = $id;
            $data['titulo'] = $encuesta->titulo;
        
            $this->load->view("encuesta/encuesta_form", $data);
        
        } else {
            $this->load->model('se_encuestas_model');
            $encuesta = $this->se_encuestas_model->get_by_id($id);
            $data['titulo'] = $encuesta->titulo;
            $data['mensaje'] = $encuesta->mensaje;
            $data['idEncuesta'] = $id;
            $this->load->view("encuesta/encuesta_mensaje", $data);
        }
    }
    
    function felicitaciones(){
        $this->load->view("encuesta/felicitaciones");
    }

};

/* End of file se_categorias.php */
/* Location: ./application/controllers/se_categorias.php */