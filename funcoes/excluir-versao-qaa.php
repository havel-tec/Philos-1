<?php
session_start();
$obterdominio = $_SESSION['dominio'];
include('../' . $obterdominio . '/' . 'conexao.php');

$versao = $_POST['versao'];

$excluir = mysqli_query($conexao, "delete from status_qaas WHERE versao='$versao'");


if ($excluir) {

    $deletar = mysqli_query($conexao, "delete from questoes_qaa WHERE versao='$versao'");
} else {
}
