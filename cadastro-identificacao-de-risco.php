<?php  
$nav_menu_principal='gestaoderisco';
$nav_menu_pagina='matrizderiscos';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1, shrink-to-fit=no">
	<title>Dashboard Philos</title>
	<link rel="stylesheet" type="text/css" href="bibliotecas/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bibliotecas/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/sb-admin.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="shortcut icon" href="imgs/favicon2.fw.png" />
	<link rel="stylesheet" type="text/css" href="css/datatable.css">
		<style>
		.risco-oea{display: none}
	
	</style>
</head>
	
		
	
<body class=" fixed-nav sticky-footer" id="page-top" >
<!-- Navegação !-->	
<?php
	include('menu.php');
	$deletar=mysqli_query($conexao,"dete * from tabela_itens_qaa_temp");
?>	
<!-- Navegação !-->	
	
<form action="processa-cadastro-identificacao-risco.php" method="post">	
	<div class="content-wrapper">
		<div class="container-fluid">
		<div class="row mb-5" style="margin-top: -16px; ">
				<div class="col-md-12 bg-padrao position-fixed p-2 text-right" style="z-index: 999999">
					
					<div class="row">
						<div class="col-md-9">
							<a href="dashboard.php"><span class="text-white breadcrumb-item">Dashboard | Matriz de riscos</span></a>
						</div>
					</div>
					
					
				</div>
			</div>
            
  
            
<div class="row ml-4 mr-4">
<div class="col-12 mt-4">

	
 <div class="row">
   
        <div class="col-md-12 mb-3">
        <input type="button" class="btn btn-primary" value="Voltar" onclick='history.go(-1)'><br>
             <h4 class="mt-5 mb-3">Cadastro de Identificação de Riscos</h4>
        </div>
	 
	 <div class="col-md-2 mb-4">
           <label>Data de Identificação</label>
           <input type="text" name="cad-data-id-risco" id="cad-data-id-risco"  class="form-control datepicker" autocomplete="off" value="<?php echo date('d/m/Y') ?>" readonly>
        </div>
    
               
         <div class="col-md-10 mb-4">
           <label>Evento de Risco</label>
          
			<textarea name="cad-evento" id="cad-evento"  class="form-control"  required rows="3"></textarea> 
			 
			 
        </div>
        
          <div class="col-md-4 mb-4">
           <label>Origem</label>
          
			<select class="form-control" name="cad-origem" id="cad-origem">
			  	<option value="0">Escolher</option>
				<option>Análise de Processo</option>
				<option>BIA</option>
				<option>Não Conformidade</option>
				<option>SWOT</option>
			 </select>  
        </div>
        
          <div class="col-md-4 mb-4">
           <label>Fator de Risco</label>
           <input type="text" name="cad-fator" id="cad-fator"  class="form-control" required>
        </div>
        
          
        
        <div class="col-md-4 mb-4">
			<label>Classif. Risco Corporativo</label>
			<select class="form-control" name="cad-classificacao-risco" id="cad-classificacao-risco">
				<option value="0">Escolha</option>
            <?php
            mysqli_query($conexao,"SET NAMES 'utf8'");
	mysqli_query($conexao,'SET character_set_connection=utf8');
	mysqli_query($conexao,'SET character_set_client=utf8');
	mysqli_query($conexao,'SET character_set_results=utf8');
            $selecao_areas=mysqli_query($conexao,"select * from parametrizacao");
            while($registros_areas=mysqli_fetch_array($selecao_areas)){
            ?>
                <option value="<?php echo $registros_areas['id'] ?>" ><?php echo $registros_areas['nome'] ?></option>
                
            <?php } ?>    
			</select>
		</div>
        
          <div class="col-md-5 mb-4">
			<label>Área</label>
			<select class="form-control" name="cad-area-risco" id="cad-area-risco" onChange="CarregarDemaisAreas()">
				<option value="0">Escolha</option>
            <?php
            mysqli_query($conexao,"SET NAMES 'utf8'");
	mysqli_query($conexao,'SET character_set_connection=utf8');
	mysqli_query($conexao,'SET character_set_client=utf8');
	mysqli_query($conexao,'SET character_set_results=utf8');
            $selecao_areas=mysqli_query($conexao,"select * from areas order by area ASC");
            while($registros_areas=mysqli_fetch_array($selecao_areas)){
            ?>
                <option value="<?php echo $registros_areas['id'] ?>"><?php echo $registros_areas['area'] ?></option>
                
            <?php } ?>    
			</select>
		</div>
        
        

  <div class="col-md-4 mb-4">
			<label>Processo</label>
	  <div id="carregar-processos"></div>
		</div>        

        
         <div class="col-md-3 mb-4">
           <label>Risco OEA?</label>
           <select class="form-control" name="cad-item-oea" id="cad-item-oea" onChange="RiscoOEA()" >
               <option>Sim</option>
               <option selected>Não</option>
           </select>
        </div>
        
        
       
        <div class="col-md-5 mb-4">
           <label class="risco-oea">Item de QAA</label>
           <select class="form-control risco-oea" name="cad-item-qaa" id="cad-item-qaa" >
               <option value="0">Escolher</option>
              <?php
			   $selecao_qaa=mysqli_query($conexao,"select * from questoes_qaa WHERE questao_principal='0' order by titulo ASC");
			   while($registros_qaa=mysqli_fetch_array($selecao_qaa)){
			   ?>
			   
			   <option value="<?php echo $registros_qaa['id'] ?>"><?php echo $registros_qaa['titulo'] ?></option>
			   
			   <?php }?>
           </select>
        </div>
	 
	  <div class="col-md-3 mb-4">
       	<label class="risco-oea">&nbsp;&nbsp;</label>
		  <input type="button" class="btn btn-primary risco-oea" value="Adicionar Item" onClick="AdicionarItem()">
	  </div>
        
    
	 <div class="col-md-12 mb-4 risco-oea">
		 <h5 class="mt-4"><strong>Itens de QAA</strong></h5>
		 <div id="carregar-itens-qaa"></div>
	 </div>	 
	
        
         <div class="col-md-12">
			
			<h5 class="mt-4"><strong>Demais áreas impactadas pelo risco</strong></h5>
			 <div id="carregar-demais-areas-impactadas-pelo-risco"></div>
			
		</div>
        
        <div class="col-md-12">
            <input type="submit" value="Gravar" class="btn btn-primary">
        </div>
        
    </div>   
     
    
    
	

</div>	
</div>
			</div>
		</div>

	</div>
</form>	
	
<!-------------Contadores--------->	
	<input type="hidden" value="1" id="contador_terceiros">
	<input type="hidden" value="1" id="contador_filiais">
	
	 <script src="bibliotecas/jquery/jquery.min.js"></script>
	<script src="bibliotecas/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="bibliotecas/jquery-easing/jquery.easing.min.js"></script>
	<script src="js/sb-admin.min.js" type="text/javascript"></script>
	<script src="js/jquery.mask.min.js"></script>
	<script src="js/mascaras.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	
	<script>
		
		$a=jQuery.noConflict()
		
		$a(document).ready(function() {
			
	CarregarItensQaa()	
			ItensQaa()
			
	
} );
		
		
		
	function ItensQaa(){	
		
	
		
	$a(document).ready(function() {
    $a('#tabela-itens-qaa').DataTable();
} );
		
		
		
	$a("#tabela-itens-qaa").dataTable({
                "bJQueryUI": true,
                "oLanguage": {
                    "sProcessing":   "Processando...",
                    "sLengthMenu":   "Mostrar _MENU_ registros",
                    "sZeroRecords":  "Não foram encontrados resultados",
                    "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                    "sInfoFiltered": "",
                    "sInfoPostFix":  "",
                    "sSearch":       "Buscar:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Primeiro",
                        "sPrevious": "Anterior",
                        "sNext":     "Seguinte",
                        "sLast":     "Último"
                    }
                }
            })
		
		
	}
	</script>
	
	
	
	  <script>
	$f=jQuery.noConflict()	 
		  
		 $f(".datepicker").datepicker({
    dateFormat: 'dd/mm/yy',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    nextText: 'Próximo',
    prevText: 'Anterior'
}); 
		  
		  
  $f(function() {
    $f(".datepicker").datepicker();
  } );
  
  
  $f(document).ready(function(){
  $f('#cad-implementacao').hide()
  $f('#label-implementacao').hide()
  
	  LimparTabelaOEA()
	CarregarDemaisAreas()
	CarregarProcessos() 
	 
  })
  
 
  function CarregarDemaisAreas(){
	 
	  var codigo = $f('#cad-area-risco option:selected').val()
	  	  $f.ajax({
		  type: 'post',
		  data: 'codigo='+codigo,
		  url:'funcoes/tabela-demais-areas-impactadas.php',
		  success: function(retorno){
			$f('#carregar-demais-areas-impactadas-pelo-risco').html(retorno)  
      }
       })
	CarregarProcessos()
  }
		  
	  function CarregarProcessos(){
	 
	  var codigo = $f('#cad-area-risco option:selected').val()
	  if(codigo==''){codigo=0}
	  	  $f.ajax({
		  type: 'post',
		  data: 'codigo='+codigo,
		  url:'funcoes/identificacao-risco-processos.php',
		  success: function(retorno){
			$f('#carregar-processos').html(retorno)  
      }
       })
	
  }	  
		  
	
		 function CarregarItensQaa(){
			 
		$f.ajax({
		  type: 'post',
		  data: 'codigo=',
		  url:'funcoes/carregar-itens-qaa.php',
		  success: function(retorno){
			$f('#carregar-itens-qaa').html(retorno) 
			 
      }
       })
			
			 
		 } 
		  
		  
		 function AdicionarItem(){
			 
		var item = $f('#cad-item-qaa option:selected').val()	 
			
		$f.ajax({
		  type: 'post',
		  data: 'item='+item,
		  url:'funcoes/gravar-item-qaa.php',
		  success: function(retorno){
			
			CarregarItensQaa()
			 
      }
       })
		 } 
		  
		  
		  
		function ExcluirItem(codigo){
			
				if (window.confirm("Você deseja excluir o Item?")) {

	  $f.ajax({
			  type: 'post',
			  data: 'codigo='+codigo,
			  url:'funcoes/excluir-itens-qaa.php',
			  success: function(retorno){
				CarregarItensQaa() 
			 
		  }
		   })  	
}
			
		} 
		  
		  
		  
		 function RiscoOEA(){
	 
	var ItemOEA= $f('#cad-item-oea option:selected').val() 
	 
	if(ItemOEA=='Sim'){
		$f('.risco-oea').show()
	}else{
		$f('.risco-oea').hide()
	}
	
 } 
		  
		function LimparTabelaOEA(){
			
				  $f.ajax({
			  type: 'post',
			  data: 'codigo=',
			  url:'funcoes/excluir-tabela-temp-risco-qaa.php',
			  success: function(retorno){
		  }
		   })  	
		}  
  
  </script>	

<script>
	$rodape=jQuery.noConflict()
	function AtivarLink(){
		$rodape('#<?php echo $nav_menu_principal ?>').addClass('show')
		$rodape('#menu-<?php echo $nav_menu_pagina ?>').css('font-weight','bold')
		
	}
	AtivarLink()
</script>	 	

</body>
</html>