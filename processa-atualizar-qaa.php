<?php
session_start();
$_SESSION["check"] = 'style="display: inline;"';

$obterdominio = $_SESSION['dominio'];
include($obterdominio . '/' . 'conexao.php');;


$respostasimnao = $_POST['respostasimnao'];
$codigo = $_POST['codigo'];
$cnpj = $_POST['cnpj'];
$modalidade = $_POST['mod'];

$questao = $_POST['questao'];
$resposta = $_POST['resposta'];

$certificado = $_POST['certificado'];

$resposta = $text_description = str_replace("&nbsp;", "</br>", $resposta);

$resposta = addslashes($resposta);


$retorno = $_POST['retorno'];


$possui = $_POST['possui'];
$pergunta = $_POST['pergunta'];
if ($possui == '0') {
	$possui = 'não';
}

mysqli_query($conexao, "SET NAMES 'utf8'");
mysqli_query($conexao, 'SET character_set_connection=utf8');
mysqli_query($conexao, 'SET character_set_client=utf8');
mysqli_query($conexao, 'SET character_set_results=utf8');

$obter_versao_atual = mysqli_query($conexao, "select * from status_qaas order by id DESC");
$registros = mysqli_fetch_array($obter_versao_atual);
$versao = $registros['versao'];
if ($versao == '') {
	$versao = 0;
}


if ($retorno == 'salvar') {

	$salvar = mysqli_query($conexao, "insert into resposta_qaa 
	set  questao='$questao', resposta='$resposta', resposta_sim_nao='$respostasimnao', possui_nao_possui='$possui', pergunta_sim_nao='$pergunta'  WHERE id='$codigo' and versao='$versao'  and certificado='$certificado'  ");

	$atualizar = mysqli_query($conexao, "insert into resposta_qaa 
	set  questao='$questao', resposta='$resposta', resposta_sim_nao='$respostasimnao', possui_nao_possui='$possui', pergunta_sim_nao='$pergunta'  WHERE id='$codigo' and versao='$versao'  and certificado='$certificado'  ");

	if ($salvar) { ?>

		<div class="alert alert-success alert-dismissible fade show" role="alert">
			Questão <?php echo $retorno ?>SALVA1 com sucesso!!


		</div>
	<?php }


	if ($update) { ?>

		<div class="alert alert-success alert-dismissible fade show" role="alert">
			Questão <?php echo $retorno ?> SALVA2 com sucesso!!

		</div>

		<?php }
} else {


	$atualizar = mysqli_query($conexao, "insert into resposta_qaa 
set  questao='$questao', resposta='$resposta', resposta_sim_nao='$respostasimnao', possui_nao_possui='$possui', pergunta_sim_nao='$pergunta'  WHERE id='$codigo' and versao='$versao' and certificado='$certificado'  ");

	$pesq = mysqli_query($conexao, "select * from resposta_qaa WHERE codigo_questao='$codigo' and cnpj='$cnpj' and salvar='$salvar'");
	$registros_pesq = mysqli_fetch_array($pesq);
	$num = mysqli_num_rows($pesq);

	if ($num == 0) {

		$inserir = mysqli_query($conexao, "insert into resposta_qaa(codigo_questao,resposta,certificado,cnpj,codigo_modalidade,salvar,resposta_sim_nao,pergunta_sim_nao,versao, possui_nao_possui)values('$codigo','$resposta','$certificado','$cnpj','$modalidade','1','$respostasimnao','$pergunta','$versao','$possui'),");



		if ($inserir) { ?>

			<div class="alert alert-success alert-dismissible fade show " role="alert">
				Questão <?php echo $retorno ?>salvar3 com sucesso!!

			</div>

		<?php } ?>

	<?php	}


	if ($num == 1) {
		$update = mysqli_query($conexao, "update resposta_qaa set resposta='$resposta' WHERE codigo_questao='$codigo' and cnpj='$cnpj' and codigo_modalidade='$modalidade' ");
	}

	if ($update) { ?>

		<div class="alert alert-success alert-dismissible fade show" role="alert">
			Questão <?php echo $retorno ?>salvar4 com sucesso!!

		</div>

<?php }
} ?>