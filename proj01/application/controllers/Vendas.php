<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendas extends CI_Controller
{
    public function nova()
    {
        $this->load->helper('date');
        //$usuario = $this->session->userdata("usuario_logado");
        $usuario = autoriza(); // << - Ajuste para o helper de verificação

        $this->load->model("vendas_model");

        $venda = array(
            "produto_id" => $this->input->post("produto_id"),
            "comprador" => $usuario["id"],
            "data_de_entrega" => dataPtBrParaMySql($this->input->post("data_de_entrega"))
        );
        $this->vendas_model->salva($venda);
        $this->session->set_flashdata("success", "Pedido de comprar efetuado com sucesso");
        redirect(base_url("/"));
    }

    public function index()
    {
        //$usuario = $this->session->userdata("usuario_logado");
        $usuario = autoriza();
        $this->load->model("produtos_model");
        $produtosVendidos = $this->produtos_model->buscaVendidos($usuario);
        $dados = array("produtosVendidos" => $produtosVendidos);

        $this->load->view("vendas/index", $dados);
    }
}