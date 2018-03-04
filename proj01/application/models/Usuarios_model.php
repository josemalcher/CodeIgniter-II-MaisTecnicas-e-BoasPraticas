<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{

    public function salvar($usuario)
    {
        $this->db->insert("usuario", $usuario);  
    }

    public function buscaPorEmailSenha($email, $senha)
    {
        $this->db->where("email", $email);
        $this->db->where("senha", $senha);
        $usuario = $this->db->get("usuario")->row_array(); //somente a primeira linha
        return $usuario;
    }


}