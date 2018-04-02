<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Se_encuestas extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('se_encuestas_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->comprobarRol('admin');
        $this->load->model("se_usuariosencuestas_model");
        $data['menu'] = $this->renderMenu();
        $keyword = '';
        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'se_encuestas/index/';
        $config['total_rows'] = $this->se_encuestas_model->total_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'se_encuestas.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(3, 0);
        $se_encuestas = $this->se_encuestas_model->index_limit($config['per_page'], $start);
        foreach ($se_encuestas as $encuesta) {
            $encuesta->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_id($encuesta->idEncuestas));
        }
        $data['pagina'] = 'se_encuestas/se_encuestas_list';
        $data['titulo'] = 'Encuestas';
        $data['contenido'] = array(
            'se_encuestas_data' => $se_encuestas,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $this->load->view('_layout', $data);
    }

    public function search() {
        $this->comprobarRol('admin');
        $this->load->model("se_usuariosencuestas_model");
        $data['menu'] = $this->renderMenu();
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(2) == 'search') {
            $config['base_url'] = base_url() . 'se_encuestas/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'se_encuestas/index/';
        }

        $config['total_rows'] = $this->se_encuestas_model->search_total_rows($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'se_encuestas/search/' . $keyword . '.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $se_encuestas = $this->se_encuestas_model->search_index_limit($config['per_page'], $start, $keyword);
        foreach ($se_encuestas as $encuesta) {
            $encuesta->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_id($encuesta->idEncuestas));
        }

        $data['pagina'] = 'se_encuestas/se_encuestas_list';
        $data['titulo'] = 'Encuestas';
        $data['contenido'] = array(
            'se_encuestas_data' => $se_encuestas,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('_layout', $data);
    }

    public function read($id) {
        $this->comprobarRol('admin');
        $row = $this->se_encuestas_model->get_by_id($id);
        if ($row) {

            $this->startArrays();

            $this->load->model("se_usuariosencuestas_model");
            $this->load->model("se_departamentos_model");
            $this->load->model("se_lugaresdetrabajo_model");

            $departamentos = $this->se_departamentos_model->get_by_encuesta_id($id);
            $lugaresDeTrabajo = $this->se_lugaresdetrabajo_model->get_by_encuesta_id($id);

            foreach ($departamentos as $departamento) {
                $departamento->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_departamento($id, $departamento->idDepartamento));
            }

            foreach ($lugaresDeTrabajo as $lugarDeTrabajo) {
                $lugarDeTrabajo->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_lugarDeTrabajo($id, $lugarDeTrabajo->idLugarTrabajo));
            }

            $edades = $this->edades;
            foreach ($edades as $edad) {
                $edad->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_edad($id, $edad->edad));
            }
            $sexos = $this->sexos;
            foreach ($sexos as $sexo) {
                $sexo->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_sexo($id, $sexo->sexo));
            }
            $jerarquias = $this->jerarquias;
            foreach ($jerarquias as $jerarquia) {
                $jerarquia->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_jerarquia($id, $jerarquia->jerarquia));
            }
            $antiguedades = $this->antiguedades;
            foreach ($antiguedades as $antiguedad) {
                $antiguedad->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_antiguedad($id, $antiguedad->antiguedad));
            }

            $data['pagina'] = 'se_encuestas/se_encuestas_read';
            $data['titulo'] = 'Encuesta';
            $data['contenido'] = array(
                'idEncuestas' => $row->idEncuestas,
                'nombre' => $row->nombre,
                'titulo' => $row->titulo,
                'mensaje' => $row->mensaje,
                'empresa' => $row->empresa,
                'totalEncuestados' => $row->totalEncuestados,
                'encuestados' => count($this->se_usuariosencuestas_model->get_by_encuesta_id($id)),
                'departamentos' => $departamentos,
                'lugaresDeTrabajo' => $lugaresDeTrabajo,
                'edades' => $edades,
                "sexos" => $sexos,
                'jerarquias' => $jerarquias,
                'antiguedades' => $antiguedades,
            );
            $this->load->view('_layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_encuestas'));
        }
    }
    
    
    public function estadisticas($id) {
        $this->comprobarRol('admin');
        $row = $this->se_encuestas_model->get_by_id($id);
        if ($row) {

            $this->startArrays();

            $this->load->model("se_usuariosencuestas_model");
            $this->load->model("se_departamentos_model");
            $this->load->model("se_lugaresdetrabajo_model");

            $departamentos = $this->se_departamentos_model->get_by_encuesta_id($id);
            $lugaresDeTrabajo = $this->se_lugaresdetrabajo_model->get_by_encuesta_id($id);

            foreach ($departamentos as $departamento) {
                $departamento->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_departamento($id, $departamento->idDepartamento));
            }

            foreach ($lugaresDeTrabajo as $lugarDeTrabajo) {
                $lugarDeTrabajo->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_lugarDeTrabajo($id, $lugarDeTrabajo->idLugarTrabajo));
            }

            $edades = $this->edades;
            foreach ($edades as $edad) {
                $edad->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_edad($id, $edad->edad));
            }
            $sexos = $this->sexos;
            foreach ($sexos as $sexo) {
                $sexo->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_sexo($id, $sexo->sexo));
            }
            $jerarquias = $this->jerarquias;
            foreach ($jerarquias as $jerarquia) {
                $jerarquia->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_jerarquia($id, $jerarquia->jerarquia));
            }
            $antiguedades = $this->antiguedades;
            foreach ($antiguedades as $antiguedad) {
                $antiguedad->encuestados = count($this->se_usuariosencuestas_model->get_by_encuesta_and_antiguedad($id, $antiguedad->antiguedad));
            }

            $data['pagina'] = 'se_encuestas/se_encuestas_statistics';
            $data['titulo'] = 'Encuesta';
            $data['contenido'] = array(
                'idEncuestas' => $row->idEncuestas,
                'nombre' => $row->nombre,
                'titulo' => $row->titulo,
                'mensaje' => $row->mensaje,
                'empresa' => $row->empresa,
                'totalEncuestados' => $row->totalEncuestados,
                'encuestados' => count($this->se_usuariosencuestas_model->get_by_encuesta_id($id)),
                'departamentos' => $departamentos,
                'lugaresDeTrabajo' => $lugaresDeTrabajo,
                'edades' => $edades,
                "sexos" => $sexos,
                'jerarquias' => $jerarquias,
                'antiguedades' => $antiguedades,
            );
            $this->load->view('_layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_encuestas'));
        }
    }

    public function resultados($id) {
        $this->comprobarRol('admin');
        $row = $this->se_encuestas_model->get_by_id($id);
        if ($row) {

            ini_set('memory_limit', '250M');

            $this->startArrays();

            $this->load->model("se_usuariosencuestas_model");
            $this->load->model("se_culturas_model");
            $this->load->model("se_categorias_model");
            $this->load->model("se_respuestas_model");
            
            $culturas = $this->se_culturas_model->get_by_encuesta_id($id);

            $puntajeTotal = 0;
            foreach ($culturas as $cultura) {
                $countCultura = 0;
                $calificacionCultura = 0;
                $cultura->categorias = $this->se_categorias_model->get_by_encuesta_id($id);
                foreach ($cultura->categorias as $categoria) {
                    $categoria->respuestas = $this->se_respuestas_model->get_by_encuesta_and_cultura_and_categoria($id, $cultura->idCultura, $categoria->idCategoria);
                    $count = 0;
                    $calificacion = 0;
                    foreach ($categoria->respuestas as $respuesta) {
                        $calificacion += $respuesta->calificacion;
                        $count++;
                        $calificacionCultura += $respuesta->calificacion;
                        $countCultura++;
                    }
                    $categoria->promedio = $calificacion/$count;
                    $cultura->totalCultura += $categoria->promedio;
                }
                $cultura->promedio = $calificacionCultura/$countCultura;
                $puntajeTotal += $cultura->promedio;
                
                $cultura->display = $this->quitar_tildes($cultura->nombre);
            }

            $data['pagina'] = 'se_encuestas/se_encuestas_details';
            $data['titulo'] = 'Encuesta';
            $data['contenido'] = array(
                'idEncuestas' => $row->idEncuestas,
                'nombre' => $row->nombre,
                'titulo' => $row->titulo,
                'mensaje' => $row->mensaje,
                'empresa' => $row->empresa,
                'totalEncuestados' => $row->totalEncuestados,
                'encuestados' => count($this->se_usuariosencuestas_model->get_by_encuesta_id($id)),
                'puntajeTotal' => $puntajeTotal,
                'culturas' => $culturas,
            );
            $this->load->view('_layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_encuestas'));
        }
    }
    
    private function addToCount($names, $counts, $respuesta){
        if (!isset($counts[$respuesta->lugarDeTrabajo])){
                    array_push($names, $respuesta->lugarDeTrabajo);
                    $counts[$respuesta->lugarDeTrabajo] = 0;
                }
        $counts[$respuesta->lugarDeTrabajo]++;
    }
    
    public function calificaciones($id){
        $this->comprobarRol('admin');
                $row = $this->se_encuestas_model->get_by_id($id);
        if ($row) {

            ini_set('memory_limit', '256M');

            $this->startArrays();

            $this->load->model("se_usuariosencuestas_model");
            $this->load->model("se_respuestas_model");
            $this->load->model("se_culturas_model");
            
            $culturas = $this->se_culturas_model->get_by_encuesta_id($id);

            $respuestas = json_encode($this->se_respuestas_model->get_complete_by_encuesta_id($id));
            $respuestas = str_replace("\\u00ed", "í", $respuestas);

            $data['pagina'] = 'se_encuestas/se_encuestas_scores';
            $data['titulo'] = 'Encuesta';
            $data['contenido'] = array(
                'idEncuestas' => $row->idEncuestas,
                'nombre' => $row->nombre,
                'titulo' => $row->titulo,
                'mensaje' => $row->mensaje,
                'empresa' => $row->empresa,
                'totalEncuestados' => $row->totalEncuestados,
                'encuestados' => count($this->se_usuariosencuestas_model->get_by_encuesta_id($id)),
                'respuestas' => $respuestas,
                'culturas' => $culturas,
            );
            $this->load->view('_layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_encuestas'));
        }
    }
    
    public function excel($id){
        $this->comprobarRol('admin');
        $row = $this->se_encuestas_model->get_by_id($id);
        if ($row) {

            ini_set('memory_limit', '400M');
            
            $this->load->model("se_respuestas_model");

            $respuestas = $this->se_respuestas_model->get_complete_by_encuesta_id($id);

            $data = array(
                'idEncuestas' => $row->idEncuestas,
                'nombre' => $row->nombre,
                'titulo' => $row->titulo,
                'mensaje' => $row->mensaje,
                'empresa' => $row->empresa,
                'respuestas' => $respuestas,
            );
            $this->load->view('se_encuestas/se_encuestas_excel', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_encuestas'));
        }
    }

    public function create() {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu();
        $data['pagina'] = 'se_encuestas/se_encuestas_form';
        $data['titulo'] = 'Crear Encuesta';
        $data['contenido'] = array(
            'button' => 'Crear',
            'action' => "create",
            'idEncuestas' => set_value('idEncuestas'),
            'nombre' => set_value('nombre'),
            'titulo' => set_value('titulo'),
            'mensaje' => set_value('mensaje'),
            'empresa' => set_value('empresa'),
            'totalEncuestados' => set_value('totalEncuestados'),
            'countCulturas' => 0,
            'countCategorias' => 0,
            'countLugaresDeTrabajo' => 0,
            'countDepartamentos' => 0,
            'countPreguntas' => 0,
            'culturas' => "",
            'categorias' => "",
            'lugaresDeTrabajo' => "",
            'departamento' => "",
            'preguntas' => "",
        );

        $data['js'] = "<script src='" . base_url() . "assets/javascript/encuestas.js' language='javascript' ></script>";

        $this->load->view('_layout', $data);
    }

    public function create_action() {
        $this->comprobarRol('admin');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $return['mensajeError'] = "No paso las validaciones";
            $return['success'] = false;
            $return['errores'] = validation_errors();
        } else {
            $data = array(
                'nombre' => $this->input->post('nombre', TRUE),
                'titulo' => $this->input->post('titulo', TRUE),
                'mensaje' => $this->input->post('mensaje', TRUE),
                'empresa' => $this->input->post('empresa', TRUE),
                'totalEncuestados' => $this->input->post('totalEncuestados', TRUE),
            );

            $id = $this->se_encuestas_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            $return['id'] = $id;
            $return['success'] = true;
        }
        echo json_encode($return);
    }

    public function update($id) {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu();
        $row = $this->se_encuestas_model->get_by_id($id);

        $this->load->model("se_categorias_model");
        $this->load->model("se_culturas_model");
        $this->load->model("se_departamentos_model");
        $this->load->model("se_lugaresdetrabajo_model");
        $this->load->model("se_preguntas_model");

        if ($row) {

            $culturas = $this->se_culturas_model->get_by_encuesta_id($row->idEncuestas);
            $categorias = $this->se_categorias_model->get_by_encuesta_id($row->idEncuestas);
            $departamentos = $this->se_departamentos_model->get_by_encuesta_id($row->idEncuestas);
            $lugaresDeTrabajo = $this->se_lugaresdetrabajo_model->get_by_encuesta_id($row->idEncuestas);
            $preguntas = $this->se_preguntas_model->get_by_encuesta_id($row->idEncuestas);
            $countCulturas = count($culturas);
            $countCategorias = count($categorias);
            $countDepartamentos = count($departamentos);
            $countLugaresDeTrabajo = count($lugaresDeTrabajo);
            $countPreguntas = count($preguntas);

            $data['pagina'] = 'se_encuestas/se_encuestas_form';
            $data['titulo'] = 'Actualizar Encuesta';
            $data['contenido'] = array(
                'button' => 'Actualizar',
                'action' => "update",
                'idEncuestas' => set_value('idEncuestas', $row->idEncuestas),
                'nombre' => set_value('nombre', $row->nombre),
                'titulo' => set_value('titulo', $row->titulo),
                'mensaje' => set_value('mensaje', $row->mensaje),
                'empresa' => set_value('empresa', $row->empresa),
                'totalEncuestados' => set_value('totalEncuestados', $row->totalEncuestados),
                'countCulturas' => $countCulturas,
                'countCategorias' => $countCategorias,
                'countLugaresDeTrabajo' => $countLugaresDeTrabajo,
                'countDepartamentos' => $countDepartamentos,
                'countPreguntas' => $countPreguntas,
                'culturas' => $culturas,
                'categorias' => $categorias,
                'lugaresDeTrabajo' => $lugaresDeTrabajo,
                'departamentos' => $departamentos,
                'preguntas' => $preguntas,
            );
            $data['js'] = "<script src='" . base_url() . "assets/javascript/encuestas.js' language='javascript' ></script>";
            $this->load->view('_layout', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_encuestas'));
        }
    }

    public function update_action() {
        $this->comprobarRol('admin');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $return['mensajeError'] = "No paso las validaciones";
            $return['success'] = false;
            $return['errores'] = validation_errors();
        } else {
            $data = array(
                'nombre' => $this->input->post('nombre', TRUE),
                'titulo' => $this->input->post('titulo', TRUE),
                'mensaje' => $this->input->post('mensaje', TRUE),
                'empresa' => $this->input->post('empresa', TRUE),
                'totalEncuestados' => $this->input->post('totalEncuestados', TRUE),
            );

            $this->se_encuestas_model->update($this->input->post('idEncuestas', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            $return['id'] = $this->input->post('idEncuestas', TRUE);
            $return['success'] = true;
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->comprobarRol('admin');
        $data['menu'] = $this->renderMenu();
        $row = $this->se_encuestas_model->get_by_id($id);

        if ($row) {
            $this->se_encuestas_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('se_encuestas'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('se_encuestas'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
        $this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
        $this->form_validation->set_rules('mensaje', 'Mensaje', 'trim');
        $this->form_validation->set_rules('empresa', 'Empresa', 'trim');
        $this->form_validation->set_rules('totalEncuestados', 'Total Encuestados', 'trim');

        $this->form_validation->set_rules('idEncuestas', 'idEncuestas', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function startArrays() {
        $this->edades = array();

        $edad = new stdClass();
        $edad->edad = "18_25";
        $edad->display = "18 a 25 años";
        array_push($this->edades, $edad);

        $edad = new stdClass();
        $edad->edad = "25_30";
        $edad->display = "25 a 30 años";
        array_push($this->edades, $edad);

        $edad = new stdClass();
        $edad->edad = "30_40";
        $edad->display = "30 a 40 años";
        array_push($this->edades, $edad);

        $edad = new stdClass();
        $edad->edad = "40_50";
        $edad->display = "40 a 50 años";
        array_push($this->edades, $edad);

        $edad = new stdClass();
        $edad->edad = "50";
        $edad->display = "Más de 50 años";
        array_push($this->edades, $edad);


        $this->antiguedades = array();

        $antiguedad = new stdClass();
        $antiguedad->antiguedad = "1";
        $antiguedad->display = "Menos de 1 año";
        array_push($this->antiguedades, $antiguedad);

        $antiguedad = new stdClass();
        $antiguedad->antiguedad = "1_2";
        $antiguedad->display = "1 a 2 años";
        array_push($this->antiguedades, $antiguedad);

        $antiguedad = new stdClass();
        $antiguedad->antiguedad = "2_5";
        $antiguedad->display = "2 a 5 años";
        array_push($this->antiguedades, $antiguedad);

        $antiguedad = new stdClass();
        $antiguedad->antiguedad = "5_10";
        $antiguedad->display = "5 a 10 años";
        array_push($this->antiguedades, $antiguedad);

        $antiguedad = new stdClass();
        $antiguedad->antiguedad = "10_15";
        $antiguedad->display = "10 a 15 años";
        array_push($this->antiguedades, $antiguedad);

        $antiguedad = new stdClass();
        $antiguedad->antiguedad = "15";
        $antiguedad->display = "Más de 15 años";
        array_push($this->antiguedades, $antiguedad);

        $this->sexos = array();

        $sexo = new stdClass();
        $sexo->sexo = "Masculino";
        $sexo->display = "Masculino";
        array_push($this->sexos, $sexo);

        $sexo = new stdClass();
        $sexo->sexo = "Femenino";
        $sexo->display = "Femenino";
        array_push($this->sexos, $sexo);

        $this->jerarquias = array();

        $jerarquia = new stdClass();
        $jerarquia->jerarquia = "alta_gerencia";
        $jerarquia->display = "Alta Gerencia";
        array_push($this->jerarquias, $jerarquia);

        $jerarquia = new stdClass();
        $jerarquia->jerarquia = "gerencia";
        $jerarquia->display = "Gerencia Media";
        array_push($this->jerarquias, $jerarquia);

        $jerarquia = new stdClass();
        $jerarquia->jerarquia = "jefatura";
        $jerarquia->display = "Jefaturas";
        array_push($this->jerarquias, $jerarquia);

        $jerarquia = new stdClass();
        $jerarquia->jerarquia = "supervision";
        $jerarquia->display = "Supervisión/Administrativo";
        array_push($this->jerarquias, $jerarquia);

        $jerarquia = new stdClass();
        $jerarquia->jerarquia = "operativo";
        $jerarquia->display = "Operativos";
        array_push($this->jerarquias, $jerarquia);
    }
    
}

;

/* End of file se_encuestas.php */
/* Location: ./application/controllers/se_encuestas.php */