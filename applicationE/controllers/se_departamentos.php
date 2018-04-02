<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Se_departamentos extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('se_departamentos_model');
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
		'nombre' => $this->input->post('nombre',TRUE),
		'totalPersonas' => $this->input->post('totalPersonas',TRUE),
		'idEncuesta' => $this->input->post('idEncuesta',TRUE),
	    );

            $id = $this->se_departamentos_model->insert($data);
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
		'nombre' => $this->input->post('nombre',TRUE),
		'totalPersonas' => $this->input->post('totalPersonas',TRUE),
		'idEncuesta' => $this->input->post('idEncuesta',TRUE),
	    );

            $this->se_departamentos_model->update($this->input->post('idDepartamento', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            $return['id'] = $this->input->post('idDepartamento', TRUE);
            $return['success'] = true;
        }
        echo json_encode($return);
    }
    
    public function delete($id) 
    {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );
        $row = $this->se_departamentos_model->get_by_id($id);

        if ($row) {
            $this->se_departamentos_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('se_departamentos'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_departamentos'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nombre', 'Departamento', 'trim|required');
	$this->form_validation->set_rules('totalPersonas', 'Total Personas Departamento', 'trim|numeric');
	$this->form_validation->set_rules('idEncuesta', ' ', 'trim|required|numeric');

	$this->form_validation->set_rules('idDepartamento', 'idDepartamento', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file se_departamentos.php */
/* Location: ./application/controllers/se_departamentos.php */