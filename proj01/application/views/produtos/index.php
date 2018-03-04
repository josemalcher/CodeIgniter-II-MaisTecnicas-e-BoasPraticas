<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Curso CI">
    <meta name="author" content="José Malcher Jr.">

    <title>Site Institucional</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

</head>
<body>

    <div class="container">
        <?php if($this->session->flashdata("success")) : ?>
        <p class="alert alert-success"><?= $this->session->flashdata("success"); ?></p>
        <?php endif; ?>
        <?php if ($this->session->flashdata("danger")) : ?>
        <p class="alert alert-danger"><?= $this->session->flashdata("danger"); ?></p>
        <?php endif; ?>
        

        <h1>Produtos</h1>
        <table class="table">
            <?php foreach ($produtos as $produto) : ?>
                <tr>
                    <td><?= $produto["nome"]; ?></td>
                    <td><?= numeroEmReais($produto["preco"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <hr>
        
        <?php if ($this->session->userdata("usuario_logado")) : ?>
            <?= anchor('produtos/formulario', 'Novo Produto', array("class" => "btn btn-primary")); ?>
            
            <?= anchor('LoginController/logout', 'Logout', array("class" => "btn btn-primary")); ?>
        <?php else : ?>
        <h1>Login</h1>
        <?php 
        echo form_open("LoginController/autenticar");
        echo form_label("Email:", "email");
        echo form_input(array(
            "name" => "email",
            "id" => "email",
            "class" => "form-control",
            "maxlength" => "255"
        ));
        echo form_label("SENHA:", "senha");
        echo form_password(array(
            "name" => "senha",
            "id" => "senha",
            "class" => "form-control",
            "maxlength" => "255"
        ));
        echo form_button(array(
            "class" => "btn btn-primary",
            "content" => "LOGIN",
            "type" => "submit"
        ));
        echo form_close();
        ?>

        <h1>Cadastro de Usuários</h1>

        <?php 
        echo form_open("UsuariosController/novo");

        echo form_label("Nome:", "nome");
        echo form_input(array(
            "name" => "nome",
            "id" => "nome",
            "class" => "form-control",
            "maxlength" => "255"
        ));
        echo form_label("Email:", "email");
        echo form_input(array(
            "name" => "email",
            "id" => "email",
            "class" => "form-control",
            "maxlength" => "255"
        ));
        echo form_label("SENHA:", "senha");
        echo form_password(array(
            "name" => "senha",
            "id" => "senha",
            "class" => "form-control",
            "maxlength" => "255"
        ));
        echo form_button(array(
            "class" => "btn btn-primary",
            "content" => "Cadastrar",
            "type" => "submit"
        ));


        echo form_close();
        ?>

        <?php endif; ?>
    </div>


<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/ie10-viewport-bug-workaround.js') ?>"></script>
</body>
</html>