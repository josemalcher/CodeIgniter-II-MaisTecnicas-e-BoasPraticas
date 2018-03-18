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
<!--TEMPLATE CABECALHO-->
<div class="container">
    <?php if ($this->session->flashdata("success")) : ?>
        <p class="alert alert-success"><?= $this->session->flashdata("success"); ?></p>
    <?php endif; ?>
    <?php if ($this->session->flashdata("danger")) : ?>
        <p class="alert alert-danger"><?= $this->session->flashdata("danger"); ?></p>
    <?php endif; ?>
