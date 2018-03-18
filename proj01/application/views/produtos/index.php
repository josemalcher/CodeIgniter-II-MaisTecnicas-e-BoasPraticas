

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


