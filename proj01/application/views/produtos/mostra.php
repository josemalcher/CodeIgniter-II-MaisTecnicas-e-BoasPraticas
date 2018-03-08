<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Curso CI">
    <meta name="author" content="José Malcher Jr.">

    <title>Site Institucional - Cadastro de itens</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

</head>
<body>

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


<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/ie10-viewport-bug-workaround.js') ?>"></script>
</body>
</html>