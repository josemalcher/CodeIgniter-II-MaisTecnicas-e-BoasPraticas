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
<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/ie10-viewport-bug-workaround.js') ?>"></script>
</body>
</html>
    </body>
</html>