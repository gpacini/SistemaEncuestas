<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(APPPATH.'libraries/phpass-0.1/PasswordHash.php');

/**
 * Noticias
 *
 */
class Usuario extends CI_Model {

    private $table_name = 'users';

    function __construct() {
        parent::__construct();
    }

    function agregarUsuario($username, $email, $password) {
        $this->load->library('tank_auth');
        $data = $this->tank_auth->create_user($username, $email, $password, FALSE);
        
        echo $data["user_id"];
        $this->role->crearUsuario($data["user_id"]);
        return $data['user_id'];
    }
    
    function asignarRol($user_id, $role_id)
    {
        $this->load->model('role');
        $this->role->eliminarRoles($user_id);
        $this->role->crearUsuarioRol($user_id, $role_id);
    }

    function darUsuarios($items, $pagina) {
        $this->db->limit($items, $pagina);
        $query = $this->db->get($this->table_name);
        $data = array();
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $data[$i]["id"] = $row->id;
                $data[$i]["username"] = $row->username;
                $data[$i]["email"] = $row->email;
                $i++;
            }
        }
        return $data;
    }

    function editarUsuario($id, $username, $email, $password) {
        $data['username'] = $username;
        $data['email'] = $email;
        $this->load->config('tank_auth', TRUE);
        $hasher = new PasswordHash(
                $this->config->item('phpass_hash_strength', 'tank_auth'), $this->config->item('phpass_hash_portable', 'tank_auth'));
        $hashed_password = $hasher->HashPassword($password);
        $data['password'] = $hashed_password;
        $this->db->where("id", $id);
        $str = $this->db->update($this->table_name, $data);
        return $str;
    }

    function darDatosUsuario($id) {
        $sql = "SELECT id, username, email FROM " . $this->table_name . " WHERE id=$id";
        $query = $this->db->query($sql);
        $data = array();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data["id"] = $row->id;
            $data["username"] = $row->username;
            $data["email"] = $row->email;
        } else {
            $data["id"] = -1;
        }
        return $data;
    }
    
    function eliminarUsuario($id) {
        $this->db->delete($this->table_name, array('id' => $id)); 
    }

    public function contarItems() {
        return $this->db->count_all($this->table_name);
    }

}
