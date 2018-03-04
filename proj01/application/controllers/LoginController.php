<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{

    public function autenticar()
    {
        //$this->output->enable_profiler(true);
        $this->load->model("usuarios_model");
        $email = $this->input->post("email");
        $senha = md5($this->input->post("senha"));
        $usuario = $this->usuarios_model->buscaPorEmailSenha($email,$senha);

        if($usuario){
            //$this->session->set_userdata(array("usuario_logado" => $usuario));
            $this->session->set_userdata("usuario_logado" , $usuario);
            $this->session->set_flashdata("success", "Logado com sucesso"); // dura apenas a uma requisição
            //$dados = array("mensagem"=> "Login com sucesso");
        }else{
            //$dados = array("mensagem" => "usuário ou senha incorretos!");
            $this->session->set_flashdata("danger", "Usuárui ou senha incorreto");
        }

        //$this->load->view("login/autenticar", $dados);
        redirect('/');


    }
    public function logout()
    {
        $this->session->unset_userdata("usuario_logado");
        //$this->load->view("login/logout");
        $this->session->set_flashdata("success","Deslogado com sucesso");
        redirect('/');
    }

}