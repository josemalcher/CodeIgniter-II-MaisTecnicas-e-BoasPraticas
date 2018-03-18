
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
