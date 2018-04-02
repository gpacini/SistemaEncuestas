<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Se_lugaresdetrabajo extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('se_lugaresdetrabajo_model');
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

            $id = $this->se_lugaresdetrabajo_model->insert($data);
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

            $this->se_lugaresdetrabajo_model->update($this->input->post('idLugarTrabajo', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            $return['id'] = $this->input->post('idLugarTrabajo', TRUE);
            $return['success'] = true;
        }
        echo json_encode($return);
    }
    
    
    public function delete($id) 
    {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );
        $row = $this->se_lugaresdetrabajo_model->get_by_id($id);

        if ($row) {
            $this->se_lugaresdetrabajo_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('se_lugaresdetrabajo'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_lugaresdetrabajo'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nombre', 'Lugar de Trabajo', 'trim|required');
	$this->form_validation->set_rules('totalPersonas', 'Total Personas Lugar de Trabajo', 'trim|numeric');
	$this->form_validation->set_rules('idEncuesta', ' ', 'trim|required|numeric');

	$this->form_validation->set_rules('idLugarTrabajo', 'idLugarTrabajo', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file se_lugaresdetrabajo.php */
/* Location: ./application/controllers/se_lugaresdetrabajo.php */