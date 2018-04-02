<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Se_usuariosencuestas_model extends CI_Model
{

    public $table = 'SE_UsuariosEncuestas';
    public $id = 'idUsuario';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }
    
    function custom_query( ){
        $this->db->select("SE_UsuariosEncuestas.idUsuario as idUsuario, idPregunta, idRespuesta");
        $this->db->join("SE_Respuestas", "SE_UsuariosEncuestas.idUsuario = SE_Respuestas.idUsuario", "left");
        return $this->db->get($this->table)->result();
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
    
    //get data by idEncuesta
    function get_by_encuesta_id($id){
        $this->db->where('idEncuesta', $id);
        return $this->db->get($this->table)->result();
    }
    
    //get data by idEncuesta and idDepartamento
    function get_by_encuesta_and_departamento($idEncuesta, $idDepartamento){
        $this->db->where('idEncuesta', $idEncuesta);
        $this->db->where('idDepartamento', $idDepartamento);
        return $this->db->get($this->table)->result();
    }
    
    //get data by idEncuesta
    function get_by_encuesta_and_lugarDeTrabajo($idEncuesta, $idLugarTrabajo){
        $this->db->where('idEncuesta', $idEncuesta);
        $this->db->where('idLugarTrabajo', $idLugarTrabajo);
        return $this->db->get($this->table)->result();
    }
    
    function get_by_encuesta_and_sexo($idEncuesta, $sexo){
        $this->db->where('idEncuesta', $idEncuesta);
        $this->db->where('sexo', $sexo);
        return $this->db->get($this->table)->result();
    }
    
    function get_by_encuesta_and_jerarquia($idEncuesta, $jerarquia){
        $this->db->where('idEncuesta', $idEncuesta);
        $this->db->where('jerarquia', $jerarquia);
        return $this->db->get($this->table)->result();
    }
    
    function get_by_encuesta_and_edad($idEncuesta, $edad){
        $this->db->where('idEncuesta', $idEncuesta);
        $this->db->where('edad', $edad);
        return $this->db->get($this->table)->result();
    }
    
    function get_by_encuesta_and_antiguedad($idEncuesta, $antiguedad){
        $this->db->where('idEncuesta', $idEncuesta);
        $this->db->where('antiguedad', $antiguedad);
        return $this->db->get($this->table)->result();
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
        $this->db->like('idUsuario', $keyword);
	$this->db->or_like('sexo', $keyword);
	$this->db->or_like('edad', $keyword);
	$this->db->or_like('antiguedad', $keyword);
	$this->db->or_like('jerarquia', $keyword);
	$this->db->or_like('idLugarTrabajo', $keyword);
	$this->db->or_like('idDepartamento', $keyword);
	$this->db->or_like('idEncuesta', $keyword);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idUsuario', $keyword);
	$this->db->or_like('sexo', $keyword);
	$this->db->or_like('edad', $keyword);
	$this->db->or_like('antiguedad', $keyword);
	$this->db->or_like('jerarquia', $keyword);
	$this->db->or_like('idLugarTrabajo', $keyword);
	$this->db->or_like('idDepartamento', $keyword);
	$this->db->or_like('idEncuesta', $keyword);
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

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file se_usuariosencuestas_model.php */
/* Location: ./application/models/se_usuariosencuestas_model.php */