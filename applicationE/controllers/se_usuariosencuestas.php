<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Se_usuariosencuestas extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('se_usuariosencuestas_model');
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
		'sexo' => $this->input->post('sexo',TRUE),
		'edad' => $this->input->post('edad',TRUE),
		'antiguedad' => $this->input->post('antiguedad',TRUE),
		'jerarquia' => $this->input->post('jerarquia',TRUE),
		'idEncuesta' => $this->input->post('idEncuesta',TRUE),
	    );
            
            if(strcmp($this->input->post('idLugarTrabajo'), 'NULL') != 0 ){
                $data['idLugarTrabajo'] = $this->input->post('idLugarTrabajo');
            }
            if(strcmp($this->input->post('idDepartamento'), 'NULL') != 0 ){
                $data['idDepartamento'] = $this->input->post('idDepartamento');
            }

            $id = $this->se_usuariosencuestas_model->insert($data);
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
		'sexo' => $this->input->post('sexo',TRUE),
		'edad' => $this->input->post('edad',TRUE),
		'antiguedad' => $this->input->post('antiguedad',TRUE),
		'jerarquia' => $this->input->post('jerarquia',TRUE),
		'idLugarTrabajo' => $this->input->post('idLugarTrabajo',TRUE),
		'idDepartamento' => $this->input->post('idDepartamento',TRUE),
		'idEncuesta' => $this->input->post('idEncuesta',TRUE),
	    );

            $this->se_usuariosencuestas_model->update($this->input->post('idUsuario', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            $return['id'] = $this->input->post('idUsuario', TRUE);
            $return['success'] = true;
        }
        echo json_encode($return);
    }
    
    public function delete($id) 
    {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );
        $row = $this->se_usuariosencuestas_model->get_by_id($id);

        if ($row) {
            $this->se_usuariosencuestas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('se_usuariosencuestas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_usuariosencuestas'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('sexo', 'Sexo', 'trim|required');
	$this->form_validation->set_rules('edad', 'Edad', 'trim|required');
	$this->form_validation->set_rules('antiguedad', 'Antiguedad', 'trim|required');
	$this->form_validation->set_rules('jerarquia', 'Jerarquia', 'trim|required');
	$this->form_validation->set_rules('idLugarTrabajo', '', 'trim');
	$this->form_validation->set_rules('idDepartamento', '', 'trim');
	$this->form_validation->set_rules('idEncuesta', '', 'trim|required|numeric');

	$this->form_validation->set_rules('idUsuario', 'idUsuario', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file se_usuariosencuestas.php */
/* Location: ./application/controllers/se_usuariosencuestas.php */