# CodeIgniter II - Mais técnicas e boas práticas

---

## <a name="indice">Índice</a>

- [Mostrando um produto e a tipografia](#parte1)   
- [Limitando conteúdo html e evitando injection de script](#parte2)   
- [Validação](#parte3)   
- [Validação customizada e mensagens em português](#parte4)   
- [Migrações e evolução do banco de dados](#parte5)   
- [Vendendo produtos e formatação de datas no mysql](#parte6)   
- [Marcando os produtos como vendidos: condicionais e mais migrations](#parte7)   
- [oin de tabelas e minhas vendas](#parte8)   
- [Protegendo rotas com autorização](#parte9)   
- [Enviando emails](#parte10)   
- [Cabeçalho e rodapé: customizando o Code Igniter](#parte11)   

---

## <a name="parte1">Mostrando um produto e a tipografia</a>

-  proj01/application/views/produtos/index.php

```php
 <h1>Produtos</h1>
        <table class="table">
            <?php foreach ($produtos as $produto) : ?>
                <tr>
                    <td><?= anchor("produtos/mostra?id={$produto['id']}", $produto["nome"])?></td>
                    <td><?= numeroEmReais($produto["preco"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <hr>
```

-  proj01/application/controllers/Produtos.php

```php
    public function mostra(){
        $id = $this->input->get("id");
        $this->load->model("produtos_model");
        $produto = $this->produtos_model->busca($id);
        $dados = array("produto" => $produto);
        $this->load->helper("typography");
        $this->load->view("produtos/mostra",$dados);
    }
```

-  proj01/application/models/produtos_model.php

```php
   public function busca($id){
        return $this->db->get_where("produtos", array(
            "id" => $id
        ))->row_array();
    }

```



[Voltar ao Índice](#indice)

---

## <a name="parte2">Limitando conteúdo html e evitando injection de script</a>

-  proj01/application/config/routes.php

```php
$route['produtos/(:num)'] = "produtos/mostra/$1";
```

-  proj01/application/controllers/Produtos.php
```php
 public function mostra($id){
        //$id = $this->input->get("id"); // mudança para recebimento via parametro ao inves de GET
        $this->load->model("produtos_model");
        $produto = $this->produtos_model->busca($id);
        $dados = array("produto" => $produto);
        $this->load->helper("typography");
        $this->load->view("produtos/mostra",$dados);
    }
```

-   proj01/application/views/produtos/index.php
```php
  <h1>Produtos</h1>
        <table class="table">
            <?php foreach ($produtos as $produto) : ?>
                <tr>
                    <td><?= anchor("produtos/{$produto['id']}", $produto["nome"])?></td>
                    <td><?= character_limiter($produto["descricao"],10) ?></td>
                    <td><?= numeroEmReais($produto["preco"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <hr>
```

-  proj01/application/views/produtos/mostra.php
```php
<div class="container">
    NOME: <?= $produto["nome"]; ?> <br>
    PREÇO: <?= $produto["preco"]; ?> <br>
    DESCRIÇÃO: <?= auto_typography(html_escape($produto["descricao"])); ?> <br>
</div>
```



[Voltar ao Índice](#indice)

---

## <a name="parte3">Validação</a>

-  proj01/application/controllers/Produtos.php
```php
public function novo()
    {
        $this->load->library("form_validation");
        $this->form_validation->set_rules("nome","nome","required|min_length[5]");
        $this->form_validation->set_rules("preco","preco","trim|required|min_length[10]");
        $this->form_validation->set_rules("descricao","descricao","trim | required|min_length[10]");

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
```

-  proj01/application/views/produtos/formulario.php
```php
 <div class="container">
            <h1>Cadastro de Itens</h1>
            <?= validation_errors("<p class='alert alert-danger'>", "</p>") ?>
            <?php

            echo form_open("produtos/novo");
            echo form_label("Nome:", "nome");
            echo form_input(array(
                "name" => "nome",
                "id" => "nome",
                "class" => "form-control",
                "value" => set_value("nome",""),
                "maxlength" => "255"
            )); echo form_error("nome");

            echo form_label("Preço", "preco");
            echo form_input(array(
                "name" => "preco",
                "id" => "preco",
                "class" => "form-control",
                "maxlength" => "255",
                "value" => set_value("preco",""),
                "type" => "number"
            ));echo form_error("preco");

            echo form_textarea(array(
                "name" => "descricao",
                "id" => "descricao",
                "value" => set_value("descricao", ""),
                "class" => "form-control"
            )); echo form_error("descricao");
            echo form_button(array(
                "class" => "btn btn-primary",
                "content" => "Cadastrar",
                "type" => "submit"
            ));
            echo form_close();

            ?>
</div>
```

[Voltar ao Índice](#indice)

---

## <a name="parte4">Validação customizada e mensagens em português</a>

04 - alidação customizada e mensagens em português

-  proj01/application/controllers/Produtos.php
```php
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
```

-  proj01/application/views/produtos/formulario.php
```php
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Curso CI">
    <meta name="author" content="José Malcher Jr.">
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <title>Site Institucional - Cadastro de itens</title>
</head>
<body>
<div class="container">
    <h1>Cadastro de Itens</h1>
    <?php

    echo form_open("produtos/novo");
    echo form_label("Nome:", "nome");
    echo form_input(array(
        "name" => "nome",
        "id" => "nome",
        "class" => "form-control",
        "value" => set_value("nome", ""),
        "maxlength" => "255"
    ));
    echo form_error("nome");

    echo form_label("Preço", "preco");
    echo form_input(array(
        "name" => "preco",
        "id" => "preco",
        "class" => "form-control",
        "maxlength" => "255",
        "value" => set_value("preco", ""),
        "type" => "number"
    ));
    echo form_error("preco");

    echo form_textarea(array(
        "name" => "descricao",
        "id" => "descricao",
        "value" => set_value("descricao", ""),
        "class" => "form-control"
    ));
    echo form_error("descricao");
    echo form_button(array(
        "class" => "btn btn-primary",
        "content" => "Cadastrar",
        "type" => "submit"
    ));
    echo form_close();

    ?>
</div>
<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/ie10-viewport-bug-workaround.js') ?>"></script>
</body>
</html>
</body>
</html>
```

[Voltar ao Índice](#indice)

---

## <a name="parte5">Migrações e evolução do banco de dados</a>

- proj01/application/config/migration.php
```php
$config['migration_enabled'] = TRUE;
$config['migration_type'] = 'sequential';
$config['migration_version'] = 1;
```

- proj01/application/migrations/001_cria_tabela_de_vendas.php
```php
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Cria_tabela_de_vendas extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'auto_increment' => true
            ),
            'produto_id' => array(
                'type' => 'INT'
            ),
            'comprador' => array(
                'type' => 'INT'
            ),
            'data_de_entrega' => array(
                'type' => 'DATE'
            ),
        ));
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('vendas');
    }

    public function down()
    { //voltar "atrás"
        $this->dbforge->drop_table('vendas');
    }

}

```

- proj01/application/controllers/utils.php
```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utils extends CI_Controller
{
    public function migrate(){
        $this->load->library("migration");

        if ($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
        }
    }
}
```


[Voltar ao Índice](#indice)

---

## <a name="parte6">Vendendo produtos e formatação de datas no mysql</a>

-  proj01/application/helpers/date_helper.php

```php
<?php
function dataPtBrParaMySql($dataPtBr)
{
    $partes = explode("/", "$dataPtBr");
    return "{$partes[2]}-{$partes[1]}-{$partes[0]}";
}
```

-  proj01/application/models/Vendas_model.php
```php
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Vendas_model extends CI_Model
{
    public function salva($venda)
    {
        $this->db->insert("vendas", $venda);
    }
}

```

-  proj01/application/controllers/Vendas.php
```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendas extends CI_Controller
{
    public function nova()
    {
        $this->load->helper('date');
        $usuario = $this->session->userdata("usuario_logado");

        $this->load->model("vendas_model");

        $venda = array(
            "produto_id" => $this->input->post("produto_id"),
            "comprador_id"=> $usuario["id"],
            "data_de_entrega" => dataPtBrParaMySql($this->input->post("data_de_entrega"))
        );
        $this->vendas_model->salva($venda);
        $this->session->set_flashdata("success","Pedido de comprar efetuado com sucesso");
        redirect(base_url());
    }
}
```

-   proj01/application/views/produtos/mostra.php
```php

<div class="container">
    NOME: <?= $produto["nome"]; ?> <br>
    PREÇO: <?= $produto["preco"]; ?> <br>
    DESCRIÇÃO: <?= auto_typography(html_escape($produto["descricao"])); ?> <br>

    <h2>Compre Agora Mesmo!</h2>
    <?php
    echo form_open("vendas/nova");

    echo form_hidden("produto_id", $produto["id"]);

    echo form_label("Data de entrega", "data_de_entrega");
    echo form_input(array(
        "name" => "data_de_entrega",
        "class" => "form-control",
        "id" => "data_de_entrega",
        "maxlength" => "255",
        "value" => ""
    ));
    echo form_button(array(
        "class" => "btn btn-primary",
        "content" => "comprar",
        "type" => "submit"
    ));

    echo form_close();

    ?>

</div>

```

[Voltar ao Índice](#indice)

---

## <a name="parte7">Marcando os produtos como vendidos: condicionais e mais migrations</a>


- proj01/application/migrations/002_adiciona_vendido_ao_produto.php
```php
<?php

class Migration_adiciona_vendido_ao_produto extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('produtos', array(
            'vendido'=>array(
                'type'=>'boolean',
                'default'=> 0
            )
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('produtos','vendido');
    }
}
```

- proj01/application/config/migration.php

```php
$config['migration_version'] = 2;
```

- proj01/application/models/Vendas_model.php

```php
class Vendas_model extends CI_Model
{
    public function salva($venda)
    {
        $this->db->insert("vendas", $venda);
        $this->db->update("produtos",
            array("vendido" => 1),
            array("id"=> $venda["produto_id"])
        );
    }
}

```

#### LISTAR APENAS OS NÃO VENDIDOS

- proj01/application/models/produtos_model.php
```php
  public function buscaTodos()
    {
        $this->db->where("vendido",false);
        return $this->db->get("produtos")->result_array();
    }
```

[Voltar ao Índice](#indice)

---

## <a name="parte8">Join de tabelas e minhas vendas</a>

Listagem das vendas do usuário

- proj01/application/controllers/Vendas.php
 
```php

    public function index()
    {
        $usuario = $this->session->userdata("usuario_logado");
        $this->load->model("produtos_model");
        $produtosVendidos = $this->produtos_model->buscaVendidos($usuario);
        $dados = array("produtosVendidos" => $produtosVendidos);
        $this->load->view("vendas/index", $dados);
    }
```
 
- proj01/application/models/produtos_model.php

```php
    public function buscaVendidos($usuario)
    {
        $id = $usuario["id"];
        $this->db->select("produtos.*, vendas.data_de_entrega");
        $this->db->from("produtos");
        $this->db->join("vendas", "vendas.produto_id = produtos.id");
        $this->db->where("vendido",true);
        $this->db->where("usuario_id",$id);
        return $this->db->get()->result_array();

    }
```

- proj01/application/helpers/date_helper.php
```php
// função para ajustar a data no view para o formato BR
function dataMysqlParaPtBr($dataMysql){
    $data = new DateTime($dataMysql);
    return $data->format("d/m/Y");
}
```

- proj01/application/views/vendas/index.php

```php
<div class="container">
    <h1>Minhas Vendas</h1>
    <table class="table">
        <?php foreach ($produtosVendidos as $produto) : ?>
            <tr>
                <td><?= $produto["nome"]; ?></td>
                <td><?= dataMysqlParaPtBr($produto["data_de_entrega"]);  ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <hr>
</div>
```

[Voltar ao Índice](#indice)

---

## <a name="parte9">Protegendo rotas com autorização</a>

- proj01/application/helpers/auth_helper.php

```php
<?php
function autoriza()
{
    $ci = get_instance();
    $usuarioLogado = $ci->session->userdata("usuario_logado");
    if (!$usuarioLogado) {
        $ci->session->set_flashdata("danger", "Você precisa estar logado!");
        redirect("/");
    }
    return $usuarioLogado;
}
```

- proj01/application/controllers/Vendas.php
- proj01/application/controllers/Produtos.php

```php
  //$usuario = $this->session->userdata("usuario_logado");
    $usuario = autoriza(); // << - Ajuste para o helper de verificação
```

[Voltar ao Índice](#indice)

---

## <a name="parte10">Enviando emails</a>

[Voltar ao Índice](#indice)

---

## <a name="parte11">Cabeçalho e rodapé: customizando o Code Igniter</a>

[Voltar ao Índice](#indice)

---
