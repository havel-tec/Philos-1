<?php
session_start();
$obterdominio=$_SESSION['dominio'];
include('../'.$obterdominio.'/'.'conexao.php');
mysqli_query($conexao,"SET NAMES 'utf8'");
mysqli_query($conexao,'SET character_set_connection=utf8');
mysqli_query($conexao,'SET character_set_client=utf8');
mysqli_query($conexao,'SET character_set_results=utf8');

$codigo=$_POST['codigo_matriz'];
$inicio=$_POST['inicio'];



			@$data_min=$_POST['inicio'];
			$ano_min= substr($data_min,6,10);
			$mes_min= substr($data_min,3,2);
			$dia_min= substr($data_min,0,2);
			
			@$data_min=$ano_min."-".$mes_min."-".$dia_min;



$vencimento=$_POST['vencimento'];

@$data_max=$_POST['vencimento'];
			$ano_max= substr($data_max,6,10);
			$mes_max= substr($data_max,3,2);
			$dia_max= substr($data_max,0,2);
			
			@$data_max=$ano_max."-".$mes_max."-".$dia_max;  











$prioridade=$_POST['prioridade'];
$titulo=$_POST['titulo'];
$descricao=$_POST['descricao'];

$gravar=mysqli_query($conexao,"insert into workflow(codigo_matriz_risco,planejamento,prioridade,data_inicio,data_vencimento,descricao,tratamento,status)values('$codigo','$titulo','$prioridade','$data_min','$data_max','$descricao','1','Aberto') ");


if($gravar){ ?>


<?php }else{ ?>

	
<?php	
}
?>
