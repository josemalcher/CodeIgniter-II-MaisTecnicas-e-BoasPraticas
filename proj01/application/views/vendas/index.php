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


<script src="<?= base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/ie10-viewport-bug-workaround.js') ?>"></script>
</body>
</html>