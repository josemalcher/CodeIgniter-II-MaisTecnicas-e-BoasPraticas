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

    public function novo()
    {
        $this->form_validation->set_rules("nome", "nome", "required|min_length[5]|callback_nao_tenha_a_palavra_melhor");
        $this->form_validation->set_rules("preco", "preco", "trim|required|min_length[2]");
        $this->form_validation->set_rules("descricao", "descricao", "trim|required|min_length[10]");

        $this->form_validation->set_error_delimiters("<p class='alert alert-danger'>", "</p>");

        $sucesso = $this->form_validation->run();

        if ($sucesso) {
            $usuarioLogado = $this->session->userdata("usuario_logado");
            $produto = array(
                "nome" => $this->input->post("nome"),
                "preco" => $this->input->post("preco"),
                "descricao" => $this->input->post("descricao"),
                "usuario_id" => $usuarioLogado["id"]
            );
            $this->load->model("produtos_model");
            $this->produtos_model->salva($produto);
            $this->session->set_flashdata("success", "Produto Salvo com sucesso");
            redirect('/');
        } else {
            $this->load->view("produtos/formulario");
        }
    }

    public function mostra($id)
    {
        //$id = $this->input->get("id"); // mudança para recebimento via parametro ao inves de GET
        $this->load->model("produtos_model");
        $produto = $this->produtos_model->busca($id);
        $dados = array("produto" => $produto);
        $this->load->helper("typography");
        $this->load->view("produtos/mostra", $dados);
    }

    public function nao_tenha_a_palavra_melhor($nomeProduto)
    {
        $posicao = strpos($nomeProduto, "melhor");
        if ($posicao == FALSE) {
            return TRUE;
        } else {
            $this->form_validation->set_message("nao_tenha_a_palavra_melhor", "O campo '%s' não pode conter a palavra melhor");
            return FALSE;
        }
    }

}