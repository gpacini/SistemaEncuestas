<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Se_respuestas_model extends CI_Model
{

    public $table = 'SE_Respuestas';
    public $id = 'idRespuesta';
    public $order = 'DESC';
    public $table_preguntas = "SE_Preguntas";
    public $table_usuarios = 'SE_UsuariosEncuestas';
    public $table_lugarDeTrabajo = 'SE_LugaresDeTrabajo';
    public $table_culturas = 'SE_Culturas';
    public $table_categorias = 'SE_Categorias';
    public $table_departamentos = 'SE_Departamentos';

    function __construct()
    {
        parent::__construct();
    }
    
    function get_by_encuesta_and_cultura($idEncuesta, $idCultura){
        $this->db->join($this->table_preguntas, $this->table_preguntas . ".idPregunta = ".$this->table.".idPregunta" );
        $this->db->where("idEncuesta", $idEncuesta);
        $this->db->where("idCultura", $idCultura);
        return $this->db->get($this->table)->result();
    }
    
    
    function get_by_encuesta_and_cultura_and_categoria($idEncuesta, $idCultura, $idCategoria){
        $this->db->join($this->table_preguntas, $this->table_preguntas . ".idPregunta = ".$this->table.".idPregunta" );
        $this->db->where("idEncuesta", $idEncuesta);
        $this->db->where("idCultura", $idCultura);
        $this->db->where("idCategoria", $idCategoria);
        return $this->db->get($this->table)->result();
    }
    
    function get_complete_by_encuesta_id($idEncuesta){
        $this->db->select("calificacion, sexo, edad, antiguedad, jerarquia, $this->table_lugarDeTrabajo.nombre as lugarDeTrabajo, $this->table_departamentos.nombre as departamento, $this->table_culturas.nombre as cultura, $this->table_categorias.nombre as categoria");
        $this->db->join($this->table_preguntas, $this->table_preguntas . ".idPregunta = ".$this->table.".idPregunta" , 'left');
        $this->db->join($this->table_usuarios, $this->table_usuarios . ".idUsuario = ".$this->table.".idUsuario" , 'left');
        $this->db->join($this->table_lugarDeTrabajo, $this->table_lugarDeTrabajo . ".idLugarTrabajo = ".$this->table_usuarios.".idLugarTrabajo" , 'left');
        $this->db->join($this->table_departamentos, $this->table_departamentos . ".idDepartamento = ".$this->table_usuarios.".idDepartamento" , 'left');
        $this->db->join($this->table_culturas, $this->table_culturas . ".idCultura = ".$this->table_preguntas.".idCultura" , 'left');
        $this->db->join($this->table_categorias, $this->table_categorias . ".idCategoria = ".$this->table_preguntas.".idCategoria" , 'left');
        $this->db->where($this->table_preguntas.".idEncuesta", $idEncuesta);
        return $this->db->get($this->table)->result( );
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit
    function index_limit($limit, $start = 0) {
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    
    // get search total rows
    function search_total_rows($keyword = NULL) {
        $this->db->like('idRespuesta', $keyword);
	$this->db->or_like('calificacion', $keyword);
	$this->db->or_like('idPregunta', $keyword);
	$this->db->or_like('idUsuario', $keyword);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idRespuesta', $keyword);
	$this->db->or_like('calificacion', $keyword);
	$this->db->or_like('idPregunta', $keyword);
	$this->db->or_like('idUsuario', $keyword);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data) {
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
    
    function customUpdate($idUsuario, $newId){
        $this->db->where("idUsuario", $idUsuario);
        $this->db->update($this->table, array("idUsuario" => $newId ));
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file se_respuestas_model.php */
/* Location: ./application/models/se_respuestas_model.php */