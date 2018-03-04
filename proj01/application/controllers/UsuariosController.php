<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsuariosController extends CI_Controller
{

    public function novo()
    {
        //$this->output->enable_profiler(true); //verificação de dados

        $usuario = array(
            "nome" => $this->input->post("nome"),
            "email" => $this->input->post("email"),
            "senha" => md5($this->input->post("senha"))
        );

        $this->load->model('usuarios_model');
        $this->usuarios_model->salvar($usuario);
        $this->load->view("usuarios/novo");
    }
    

}