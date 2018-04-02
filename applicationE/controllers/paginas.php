<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paginas extends MY_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
    }

    public function index() {
        if( $this->data['logged_in'] ){
            $this->checkRoleRedirect ();
        } else {
        redirect('auth/login');
        }
    }

    public function login() {
         if( $this->data['logged_in'] ){
            $this->checkRoleRedirect ();
        } else {
        redirect('auth/login');
        }
    }

    public function logout() {
        redirect("auth/logout");
    }
    
    public function checkRoleRedirect( ){
        if( $this->checkRol("admin") ){
            redirect('se_encuestas');
            return;
        }
        redirect('paginas/index');
    }
    
    public function sinpermiso( )
    {
        $data['pagina'] = 'paginas_publicas/sinpermiso';
        $data['titulo'] = "Acceso prohibido";
        $data['contenido']['vacio'] = "";
        $this->load->view('public_layout', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */