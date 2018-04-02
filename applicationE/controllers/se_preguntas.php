<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Se_preguntas extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('se_preguntas_model');
        $this->load->library('form_validation');
    }
    
    public function create_action() 
    {
        $this->comprobarRol('admin');
        $this->_rules();

         if ($this->form_validation->run() == FALSE) {
            $return['mensajeError'] = "No paso las validaciones";
            $return['success'] = false;
            $return['errores'] = validation_errors();
        } else {
            $data = array(
		'pregunta' => $this->input->post('pregunta',TRUE),
		'idEncuesta' => $this->input->post('idEncuesta',TRUE),
		'idCultura' => $this->input->post('idCultura',TRUE),
		'idCategoria' => $this->input->post('idCategoria',TRUE),
	    );

            $id = $this->se_preguntas_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            $return['id'] = $id;
            $return['success'] = true;
        }
        echo json_encode($return);
    }
    
    public function update_action() 
    {
        $this->comprobarRol('admin');
         $this->_rules();
         if ($this->form_validation->run() == FALSE) {
            $return['mensajeError'] = "No paso las validaciones";
            $return['success'] = false;
            $return['errores'] = validation_errors();
        } else {
            $data = array(
		'pregunta' => $this->input->post('pregunta',TRUE),
		'idEncuesta' => $this->input->post('idEncuesta',TRUE),
		'idCultura' => $this->input->post('idCultura',TRUE),
		'idCategoria' => $this->input->post('idCategoria',TRUE),
	    );

            $this->se_preguntas_model->update($this->input->post('idPregunta', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            $return['id'] = $this->input->post('idPregunta', TRUE);
            $return['success'] = true;
        }
        echo json_encode($return);
    }
    
    public function delete($id) 
    {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );
        $row = $this->se_preguntas_model->get_by_id($id);

        if ($row) {
            $this->se_preguntas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('se_preguntas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_preguntas'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('pregunta', 'Pregunta', 'trim|required');
	$this->form_validation->set_rules('idEncuesta', '', 'trim|required|numeric');
	$this->form_validation->set_rules('idCultura', 'Cultura', 'trim|required|numeric');
	$this->form_validation->set_rules('idCategoria', 'Categoria', 'trim|required|numeric');

	$this->form_validation->set_rules('idPregunta', 'idPregunta', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file se_preguntas.php */
/* Location: ./application/controllers/se_preguntas.php */