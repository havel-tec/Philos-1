<?php
session_start();
$obterdominio = $_SESSION['dominio'];
include('../' . $obterdominio . '/' . 'conexao.php');
mysqli_query($conexao, "SET NAMES 'utf8'");
mysqli_query($conexao, 'SET character_set_connection=utf8');
mysqli_query($conexao, 'SET character_set_client=utf8');
mysqli_query($conexao, 'SET character_set_results=utf8');


$codigo = $_POST['codigo'];
$certificado = $_POST['certificado'];
$cnpj = $_POST['cnpj'];
$mod = $_POST['mod'];
@$usuario = $_SESSION['usuario'];

$selecao = mysqli_query($conexao, "select * from usuarios_empresa WHERE email='$usuario'");
$registros = mysqli_fetch_array($selecao);
$tipo = $registros['tipo'];
$id_usuario = $registros['id'];
$cod_grupo = $registros['grupo'];

//Obter versão mais recente//
$obter_versao_atual = mysqli_query($conexao, "select * from status_qaas order by id DESC");
$registros = mysqli_fetch_array($obter_versao_atual);
$versao = $registros['versao'];
if ($versao == '') {
	$versao = 0;
}


$selecao = mysqli_query($conexao, "select * from questoes_qaa WHERE cod='$codigo' and versao='$versao' ");
$registros = mysqli_fetch_array($selecao);
$id = $registros['id'];
$codigo_anterior = $registros['codigo_anterior'];


$pesquisar_respostas = mysqli_query($conexao, "select * from resposta_qaa WHERE codigo_questao='$id' and cnpj='$cnpj'");
$registros_respostas = mysqli_fetch_array($pesquisar_respostas);
$exibir_resposta = $registros_respostas['resposta'];




if ($exibir_resposta == '' and $codigo_anterior != '') {

	$pesquisar_respostas2 = mysqli_query($conexao, "select * from resposta_qaa WHERE codigo_questao='$codigo_anterior' and cnpj='$cnpj'");
	$registros_respostas2 = mysqli_fetch_array($pesquisar_respostas2);
	$exibir_resposta = $registros_respostas2['resposta'];
}

?>


<style>


</style>

<div id="resposta-alertas"></div>
<?php
$verificar_grupo = mysqli_query($conexao, "select * from grupos_permissoes WHERE codigo_menu='10' and codigo_grupo='$cod_grupo' and cadastrar='1' ");
$numero_grupo = mysqli_num_rows($verificar_grupo);
if ($numero_grupo >= 1) {
?>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" onClick="CarregaUsers(<?php echo $codigo ?>)">
		Aprovadores
	</button>
<?php } ?>


<input type="hidden" id="quest-codigo" value="<?php echo $registros['id'] ?>">
<input type="hidden" id="cad-cnpj" value="<?php echo $cnpj ?>">

<input type="hidden" id="cad-mod" value="<?php echo $mod ?>">


<label class="mt-3">Questão</label>
<textarea rows="3" class="form-control textarea" id="quest-questao"><?php echo $registros['questao'] ?></textarea>



<?php
$verificar_grupo = mysqli_query($conexao, "select * from grupos_permissoes WHERE codigo_menu='10' and codigo_grupo='$cod_grupo' and editar='1' ");
$numero_grupo = mysqli_num_rows($verificar_grupo);
if ($numero_grupo >= 1) {
?>
	<script>
		document.getElementById("quest-questao").readOnly = true;
	</script>
<?php  } ?>



<?php
if ($registros['pergunta_sim_nao'] != '') {
?>

	<label class="mt-3">

		<!--<input type="text" value="<?php echo $registros['pergunta_sim_nao'] ?>" class="form-control" name="cad-pergunta" id="cad-pergunta">
--->

	</label>

	<input type="radio" <?php if ($registros['resposta_sim_nao'] == 'Sim') { ?> checked <?php } ?> name="cad-resposta-sim-nao" id="cad-resposta-sim-nao" value="Sim"> Sim

	<input type="radio" <?php if ($registros['resposta_sim_nao'] == 'Não') { ?> checked <?php } ?> name="cad-resposta-sim-nao" id="cad-resposta-sim-nao" value="Não"> Não


<?php  } ?>


<label class="mt-3">Resposta<font style="color: red">(Em caso de colar textos de outras ferramentas utilize <strong>shift+control+v</strong> para colar</font>)</label>
<textarea class="form-control" id="editor1" value="<?php echo $registros_respostas['resposta']; ?><?php echo $registros_resposta['versao'];  ?><?php echo $registros_respostas['codigo_qaa'];  ?>"><?php print($registros_respostas['resposta']); ?></textarea>



<label class="mt-3">Essa resposta possui documentos ou evidências a serem anexadas?
</label>
<?php $possui = $registros['possui_nao_possui'];



$selecao3 = mysqli_query($conexao, "select * from upload_qaa WHERE codigo_qaa='$codigo' and cnpj='$cnpj'");
$num = mysqli_num_rows($selecao3);
if ($num >= 1) {
	$possui = 'sim';
} else {
	$possui = 'não';
}







if ($possui == '0') {
	$possui = 'não';
	$possui2 = 'Não Possui';
}
if ($possui == '') {
	$possui = 'não';
}
if ($possui == 'não') {
	$possui2 = 'Não Possui';
}
if ($possui == 'sim') {
	$possui2 = 'Possui';
}
?>

<select class="form-control mt-3 mb-4" name="cad-documentos" id="cad-documentos" onChange="Uploads()">
	<option value="<?php echo $possui ?>">
		<?php echo $possui2 ?>
	</option>






	<?php if ($possui == 'sim') { ?>
		<option value="não">Não Possui</option>
	<?php } ?>

	<?php if ($possui == 'não') { ?>
		<option value="sim">Possui</option>
	<?php } ?>

</select>








<div id="carrega-anexos-qaa"></div>



<div id="upload-arquivos"></div>

<?php
$verificar_grupo = mysqli_query($conexao, "select * from grupos_permissoes WHERE codigo_menu='10' and codigo_grupo='8' and editar='1' ");
$numero_grupo = mysqli_num_rows($verificar_grupo);
if ($numero_grupo == 1) {
?>


	<input type="button" value="atualizar" class="btn btn-primary mt-1" onClick="AtualizarQAA('atualizada')">

	<input type="button" value="salvar" class="btn btn-success mt-1" onClick="AtualizarQAA('salvar')">



<?php } ?>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 999999999">
	<div class="modal-dialog modal-dialog-centered" role="document" style="z-index: 999999999">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Responsáveis</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="resposta-modal"></div>

				<div id="carregar-listar-usuarios"></div>

			</div>
			<div class="modal-footer">
				<select class="form-control" id="novo-user">
					<option value="0">Novo usuário</option>
					<?php
					$selecao_usuarios = mysqli_query($conexao, "select * from usuarios_empresa");
					while ($registros_usuarios = mysqli_fetch_array($selecao_usuarios)) {
					?>

						<option value="<?php echo $registros_usuarios['id'] ?>"><?php echo $registros_usuarios['nome'] ?>|<?php echo $registros_usuarios['email'] ?></option>

					<?php } ?>

				</select>

				<input type="button" value="Adicionar" class="btn btn-primary" onclick="AdicionarResponsavel(<?php echo $codigo ?>)">

			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	CKEDITOR.replace('editor1', {
		extraPlugins: 'autogrow',
		removePlugins: 'resize',
		entities: false,




	});


	CKEDITOR.on('editor1', function(event) {
		editor.on('configLoaded', function() {

			editor.config.basicEntities = false;
			editor.config.entities_greek = false;
			editor.config.entities_latin = false;
			editor.config.entities_additional = '';
			editor.config.basicEntities = false;
			config.fillEmptyBlocks = false;



		});
	});


	CKEDITOR.on('instanceReady', function(ev) {
		ev.editor.on('editor1', function(evt) {

		}, null, null, 9);
	});
</script>
<script>











</script>



<script>
	$h = jQuery.noConflict()


	$h(document).ready(function() {

		var test = document.getElementById("quest-resposta").scrollHeight;



		$h('#quest-resposta').css('height', test + 30)

	})
</script>