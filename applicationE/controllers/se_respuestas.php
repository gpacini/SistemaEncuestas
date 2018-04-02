<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Se_respuestas extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('se_respuestas_model');
        $this->load->library('form_validation');
    }
    
    public function create_action() 
    {
        $this->_rules();

         if ($this->form_validation->run() == FALSE) {
            $return['mensajeError'] = "No paso las validaciones";
            $return['success'] = false;
            $return['errores'] = validation_errors();
        } else {
            $data = array(
		'calificacion' => $this->input->post('calificacion',TRUE),
		'idPregunta' => $this->input->post('idPregunta',TRUE),
		'idUsuario' => $this->input->post('idUsuario',TRUE),
	    );
            
            $id = $this->se_respuestas_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            $return['id'] = $id;
            $return['success'] = true;
        }
        echo json_encode($return);
    }
    
    public function update_action() 
    {
         $this->_rules();
         if ($this->form_validation->run() == FALSE) {
            $return['mensajeError'] = "No paso las validaciones";
            $return['success'] = false;
            $return['errores'] = validation_errors();
        } else {
            $data = array(
		'calificacion' => $this->input->post('calificacion',TRUE),
		'idPregunta' => $this->input->post('idPregunta',TRUE),
		'idUsuario' => $this->input->post('idUsuario',TRUE),
	    );

            $this->se_respuestas_model->update($this->input->post('idRespuesta', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            $return['id'] = $this->input->post('idRespuesta', TRUE);
            $return['success'] = true;
        }
        echo json_encode($return);
    }
    
    public function delete($id) 
    {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );
        $row = $this->se_respuestas_model->get_by_id($id);

        if ($row) {
            $this->se_respuestas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('se_respuestas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_respuestas'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('calificacion', 'Calificacion', 'trim|required|numeric');
	$this->form_validation->set_rules('idPregunta', 'idPregunta', 'trim|required|numeric');
	$this->form_validation->set_rules('idUsuario', 'idUsuario', 'trim|required|numeric');

	$this->form_validation->set_rules('idRespuesta', 'idRespuesta', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file se_respuestas.php */
/* Location: ./application/controllers/se_respuestas.php */