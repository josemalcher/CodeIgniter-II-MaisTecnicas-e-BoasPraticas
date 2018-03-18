<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendas extends CI_Controller
{
    public function nova()
    {
        $this->load->helper('date');
        //$usuario = $this->session->userdata("usuario_logado");
        $usuario = autoriza(); // << - Ajuste para o helper de verificação

        $this->load->model(array("vendas_model","produtos_model","usuarios_model"));

        $venda = array(
            "produto_id" => $this->input->post("produto_id"),
            "comprador" => $usuario["id"],
            "data_de_entrega" => dataPtBrParaMySql($this->input->post("data_de_entrega"))
        );
        $this->vendas_model->salva($venda);

        /* envio de emails - NÂO TESTADA!*/
        $this->load->library("email");
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_user'] = "malcher.malch@gmail.com";
        $config['smtp_pass'] = ""; // SENHA!
        $config['charset'] = "utf-8";
        $config['mailtype']= "html";
        $config['newline'] = "\r\n";
        $config['smtp_port'] = "465";
        $this->email->initialize($config);


        $produto = $this->produtos_model->busca($venda["produto_id"]); //busca nomes dos produtos
        $vendedor = $this->usuarios_model->busca($produto['usuario_id']);

        $dados = array("produto"=>$produto);
        $conteudo = $this->load->view("vendas/email.php",$dados, TRUE); // página modelo de email // TRUE = não renderize, devolva o conteúdo

        $this->email->from("malcher.malch@gmail.com","Mercado");
        $this->email->to(array($vendedor['email']));
        $this->email->subject("Seu produto {$produto['nome']} foi vendido");
        $this->email->message($conteudo); // mensagem separada para views/email.php
        $this->email->send();


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

        $this->load->template("vendas/index", $dados);
    }
}