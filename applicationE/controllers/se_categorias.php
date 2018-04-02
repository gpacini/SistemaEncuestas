<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Se_categorias extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('se_categorias_model');
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
		'idEncuesta' => $this->input->post('idEncuesta',TRUE),
	    );

            $id = $this->se_categorias_model->insert($data);
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
		'nombre' => $this->input->post('nombre',TRUE),
		'idEncuesta' => $this->input->post('idEncuesta',TRUE),
	    );

            $this->se_categorias_model->update($this->input->post('idCategoria', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            $return['id'] = $this->input->post('idCategoria', TRUE);
            $return['success'] = true;
        }
        echo json_encode($return);
    }
    
    public function delete($id) 
    {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );
        $row = $this->se_categorias_model->get_by_id($id);

        if ($row) {
            $this->se_categorias_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('se_categorias'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_categorias'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nombre', 'Categoria', 'trim|required');
	$this->form_validation->set_rules('idEncuesta', ' ', 'trim|required|numeric');

	$this->form_validation->set_rules('idCategoria', 'idCategoria', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file se_categorias.php */
/* Location: ./application/controllers/se_categorias.php */