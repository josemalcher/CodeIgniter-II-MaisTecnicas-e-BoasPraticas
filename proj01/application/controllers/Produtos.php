<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produtos extends CI_Controller
{

    public function index()
    {

        //$this->output->enable_profiler(true);

        $this->load->helper(array('url', 'currency', 'form'));

        $this->load->model('produtos_model');
        $produtos = $this->produtos_model->buscaTodos();
        $dados = array("produtos" => $produtos);

        $this->load->view("produtos/index.php", $dados);
    }

    public function formulario()
    {
        $this->load->view("produtos/formulario");
    }

    public function novo(){

        $usuarioLogado = $this->session->userdata("usuario_logado"); 
        $produto = array(
            "nome"      => $this->input->post("nome"),
            "preco"     => $this->input->post("preco"),
            "descricao" => $this->input->post("descricao"),
            "usuario_id"=> $usuarioLogado["id"]
        );
        $this->load->model("produtos_model");
        $this->produtos_model->salva($produto);
        $this->session->set_flashdata("success","Produto Salvo com sucesso");
        redirect('/');

    }

}