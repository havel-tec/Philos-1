<?php
session_start();
unset($_SESSION['check']);

$obterdominio = $_SESSION['dominio'];
include('../' . $obterdominio . '/' . 'conexao.php');

$versao = $_POST['versao'];

$excluir = mysqli_query($conexao, "delete from status_qaas WHERE certificado='$versao'");


if ($excluir) {

    $deletar = mysqli_query($conexao, "delete from questoes_qaa WHERE certificado='$versao'");
    $deletar = mysqli_query($conexao, "delete from resposta_qaa WHERE certificado='$versao'");
    $deletar = mysqli_query($conexao, "delete from upload_qaa WHERE certificado='$versao'");
} else {
}
