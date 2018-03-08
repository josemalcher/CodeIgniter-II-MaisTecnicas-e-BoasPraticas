<?php
function dataPtBrParaMySql($dataPtBr)
{
    $partes = explode("/", "$dataPtBr");
    return "{$partes[2]}-{$partes[1]}-{$partes[0]}";
}