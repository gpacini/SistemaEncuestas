<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Noticias
 *
 */
class Role extends CI_Model {

    private $table_name = 'roles';
    private $users_roles = "users_roles";
    public $id = 'id';
    public $order = 'DESC';

    function __construct() {
        parent::__construct();
    }
    
    public function getPermissions( $user_id ) {
        $sql = "SELECT `role_id` FROM ". $this->users_roles . " WHERE `user_id`=".$user_id;
        $query = $this->db->query($sql);
        $data = array();
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $data[$i] = $row->role_id;
                $i++;
            }
        }
        return $data;
    }
    
    public function get_all( )
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table_name)->result();
    }
    
    public function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table_name)->row();
    }

    public function defaultRole() {
        $sql = "SELECT id FROM " . $this->table_name . " WHERE `default`=1";
        $query = $this->db->query($sql);
        $id = -1;
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $id = $row->id;
        }
        return $id;
    }
    
    public function getRoleId($rol){
        $sql = "SELECT id FROM " . $this->table_name . " WHERE `role`='".$rol."'";
        $query = $this->db->query($sql);
        $id = -1;
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $id = $row->id;
        }
        return $id;
    }
    
    public function crearUsuarioRol( $user_id, $role_id )
    {
        $data = array();
        $data["user_id"] = $user_id;
        $data["role_id"] = $role_id;
        
        $this->db->insert($this->users_roles, $data);
    }
    
    
    public function crearUsuario( $user_id )
    {
        $default = $this->defaultRole();
        $data = array();
        $data["user_id"] = $user_id;
        $data["role_id"] = $default;
        
        $this->db->insert($this->users_roles, $data);
    }
    
    public function eliminarRoles($user_id)
    {
        $this->db->where("user_id", $user_id);
        $this->db->delete($this->users_roles);
    }

    public function contarItems() {
        return $this->db->count_all($this->table_name);
    }

}
