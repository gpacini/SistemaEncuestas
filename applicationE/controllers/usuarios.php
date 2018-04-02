
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author yank8252
 */
class Usuarios extends MY_Controller {

    public function index() {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );

        $this->load->model('usuario');

        $data['pagina'] = 'usuarios/index';
        $data['titulo'] = 'Selecci&oacute; Personal';
        $data['body_id'] = "paginaAdminUsuarios";

        $itemsPagina = 10;

        $pagina = ($this->uri->segment(10)) ? $this->uri->segment(10) : 0;
        $usuarios = $this->usuario->darUsuarios($itemsPagina, $pagina);
        $this->load->model('role');
        
        $usuarios_final = array( );
        foreach($usuarios as $usuario)
        {
            $role_id = $this->role->getPermissions($usuario['id']);
            $usuario['rol'] = $this->role->get_by_id($role_id[0]);
            array_push($usuarios_final, $usuario);
        }
        
        $data['contenido']['usuarios'] = $usuarios_final;

        $config = array();
        $config["base_url"] = base_url() . "admin/usuarios/index";
        $config["total_rows"] = $this->usuario->contarItems();
        $config["per_page"] = $itemsPagina;
        $config["uri_segment"] = 10;
        $config['full_tag_open'] = "<div class='pagination' >";
        $config['full_tag_close'] = "</div>";
        $config['anchor_class'] = "class='btn btn-default btn-group-xs'";
        $config['cur_tag_open'] = "&nbsp;<a class='active btn btn-default btn-group-xs'>";
        $config['cur_tag_close'] = "</a>";

        $this->load->library("pagination");
        $this->pagination->initialize($config);

        $data["paginacion"] = $this->pagination->create_links();

        $this->load->view('_layout', $data);
    }

    public function editar($id) {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );
        $this->load->helper('form');
        $this->load->model('usuario');
        $data['pagina'] = 'usuarios/editar';
         $data['titulo'] = 'Selecci&oacute; Personal';
        $data['contenido']['user'] = $this->usuario->darDatosUsuario($id);
        $this->load->view('_layout', $data);
    }

    public function editarConfirmar() {
        $this->comprobarRol('admin');
        $id = $this->input->post('id');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post("password");
        $this->load->model('usuario');
        $this->usuario->editarUsuario($id, $username, $email, $password);
        redirect("usuarios");
    }
    
    public function asignarRol($id)
    {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );
        $this->load->helper('form');
        $this->load->model('usuario');
        $data['pagina'] = 'usuarios/roles';
        $data['titulo'] = 'Selecci&oacute; Personal';
        $data['contenido']['user'] = $this->usuario->darDatosUsuario($id);
        $data['contenido']['roles'] = $this->role->get_all( );
        $data['contenido']['user_id'] = $id;
        $this->load->view('_layout', $data);
    }
    

    public function asignarRolConfirmar() {
        $this->comprobarRol("admin");
        $this->load->model('usuario');
        $this->usuario->asignarRol($this->input->post('user_id'), $this->input->post('role_id'));
        redirect('usuarios');
    }

    public function crear() {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu( );
        $this->load->helper('form');
        $this->load->model('usuario');
        $data['pagina'] = 'usuarios/crear';
            $data['titulo'] = 'Selecci&oacute; Personal';
        $data['contenido']['vacio'] = '';
        $this->load->view('_layout', $data);
    }

    public function crearConfirmar() {
        $this->comprobarRol("admin");
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $this->load->model('usuario');
        $id = $this->usuario->agregarUsuario($username, $email, $password);
        
        
        $this->load->model('role');
        $role_id = $this->role->getRoleId('admin');
        $this->usuario->asignarRol($id, $role_id);
        
        redirect("usuarios");
    }

}
