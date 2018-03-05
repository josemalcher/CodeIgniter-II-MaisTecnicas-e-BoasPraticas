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

#### proj01/application/views/produtos/index.php

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

#### proj01/application/controllers/Produtos.php

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

#### proj01/application/models/produtos_model.php

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

#### proj01/application/config/routes.php

```php
$route['produtos/(:num)'] = "produtos/mostra/$1";
```

#### proj01/application/controllers/Produtos.php
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

####  proj01/application/views/produtos/index.php
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

#### proj01/application/views/produtos/mostra.php
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

[Voltar ao Índice](#indice)

---

## <a name="parte4">Validação customizada e mensagens em português</a>

[Voltar ao Índice](#indice)

---

## <a name="parte5">Migrações e evolução do banco de dados</a>

[Voltar ao Índice](#indice)

---

## <a name="parte6">Vendendo produtos e formatação de datas no mysql</a>

[Voltar ao Índice](#indice)

---

## <a name="parte7">Marcando os produtos como vendidos: condicionais e mais migrations</a>

[Voltar ao Índice](#indice)

---

## <a name="parte8">Join de tabelas e minhas vendas</a>

[Voltar ao Índice](#indice)

---

## <a name="parte9">Protegendo rotas com autorização</a>

[Voltar ao Índice](#indice)

---

## <a name="parte10">Enviando emails</a>

[Voltar ao Índice](#indice)

---

## <a name="parte11">Cabeçalho e rodapé: customizando o Code Igniter</a>

[Voltar ao Índice](#indice)

---
