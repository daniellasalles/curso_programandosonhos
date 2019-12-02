<?php
  // "chama" o arquivo database da pasta raiz
  require('database.php');
  // passa os parametros para a funcao conecta
  $mysqli = conecta('localhost', 'root', '', 'form_cadastro');
  // recupera lista de pessoas para exibir abaixo do form
  // pega o valor da página corrente
  $pagCor = $_GET['paginaCorrente'] ?? 1;
  // define quantidade de resultados exibidos por pagina
  $qtdPorPagina = 5;
  // exibe a lista de pessoas de acordo com a pagina corrente e qtde maxima por pagina
  $listaPessoa = exibePessoa($mysqli, 
                            $pagCor ?? 1, 
                            $qtdPorPagina ?? 5);
  // qtde total de inscritos
  $qtdeInscritos = getQtdTotalPessoas($mysqli);
  $qtdPaginas = ceil($qtdeInscritos / $qtdPorPagina);

  $enumEstadoCivil = enumEstadoCivil($mysqli);
?>


<!DOCTYPE html>
<html lang="pt-br">

    <head>
      <title>Introdução ao HTML / Projeto Programando Sonhos</title>
      <meta name="author" content="Nome do Autor">
      <meta name="description" content="Introdução ao HTML">
      <meta name="keywords" content="HTML,CSS,Projeto Programando Sonhos,PBH">        
        
    	<link href="css/estilos.css" rel="stylesheet" type="text/css">
    
      <script>
        function pagina(valor) {
          let qtdPaginas = <?= $qtdPaginas ?>;
          if(valor <= 0) {
            valor = 1;
          } else if(valor > qtdPaginas) {
              valor = qtdPaginas;
          }

          document.getElementById('paginaCorrente').value = valor;
          document.getElementById('paginacao').submit();
        }
        </script>
    </head>
    
<body>  
    
  <header>
  
    <h1>Projeto Programando Sonhos</h1>

    <h2>Introdução ao HTML</h2>

  </header>
  
  <section id="exemplo">
  
    <h2>Formulário de Inscrição</h2>
  
            
    <form name="inscricao" method="post" action="">
    <p><small>Os campos marcados com <span style="color:red; font-weight:bold; font-size:18px">*</span> são de preenchimento obrigatório.</small></p>

      <fieldset>
        <legend>Dados Pessoais</legend>
        <p>
          <label for="nome">Nome <span class="asterisco">*</span></label>
          <input name="nome" type="text" id="nome" size="50" maxlength="50" required>
          <label for="nascimento">Data de nascimento</label>
          <input name="nascimento"  type="date" id="nascimento" size="12" maxlength="10" placeholder="__/__/____">
        </p>
        <p>
          <label for="cpf">CPF <span class="asterisco">*</span></label>
          <input name="cpf" type="text" id="cpf" size="16" maxlength="14" required>
        </p>
        <p>
          <label>Estado Civil</label>
          <?php
            
            foreach($enumEstadoCivil as $key => $value) {
          ?>
            <label><input type="radio" name="estado-civil" id="estado-civil" value="<?= $value['ID_estcivil']?>" id="estado-civil_1"> <?= $value['estadocivil'] ?></label>
            
          <?php
            }
          ?>

          <br>
        </p>
      </fieldset>
      
      <!-- 
      <fieldset>
        <legend>Endereço</legend>
        <p>
          <label for="cep">CEP <span class="asterisco">*</span></label>
          <input name="cep" type="text" id="cep" size="12" maxlength="9" required>
        </p>
        <p>
          <label for="tipo-endereco">Tipo</label>
          <select name="tipo-endereco" id="tipo-endereco">
            <option>selecione...</option>
            <option>Rua</option>
            <option>Alameda</option>
            <option>Avenida</option>
          </select>
        <br>    
        <label for="logradouro">Logradouro</label>
        <input name="logradouro" type="text" id="logradouro" size="50" maxlength="50">
        <label for="numero">Número
        <input name="numero" type="text" id="numero" size="7" maxlength="5"></label>
        <label for="complemento">Complemento</label>
        <input name="complemento" type="text" id="complemento" size="7" maxlength="5">
        </p>
      </fieldset>
      -->

      <fieldset>
        <legend>Formação Acadêmica </legend>
        <p>
          <label for="escolaridade">Escolaridade <span class="asterisco">*</span></label>
          <input name="escolaridade" type="text" id="escolaridade" size="55" maxlength="70" required>
        </p>
        <p>
          <label>Outros conhecimentos:</label>
          <label><input type="checkbox" name="outroscursos1" value="checkbox1" id="outroscursos1">Inglês básico</label>
          <label><input type="checkbox" name="outroscursos1" value="checkbox2" id="outroscursos2">Informática básica</label>
        </p>
        <p>
          <label for="info">Mais informações:</label>
          <br>
          <textarea maxlength="250" id="info"></textarea>
        </p>
      </fieldset>

      <!-- -->                 
        <input type="submit" name="acessar" id="acessar" value="ENVIAR INSCRIÇÂO">&nbsp;&nbsp;<input type="reset" name="cancelar" id="cancelar" value="CANCELAR">         
        
        <?php
          if($_POST) {
            // recupera parametros POST. Os parâmetros no colchetes são os nomes dos campos do formulário HTML
            inserePessoa($mysqli, 
                         $_POST['nome'],
                         $_POST['cpf'],
                         $_POST['nascimento'] ?? ''
                         );

            insereEscolaridade($mysqli, $_POST['escolaridade']);

            // atribui estado civil a cada pessoa
            if (isset($_POST['estado-civil'])) {
                atribuiEstCivil($mysqli,
                $_POST['estado-civil']
                );
            }
          }
             
        ?>
    </form>

    <hr>
    
        <h2>Relação de Inscritos</h2>
  
    <table class="inscritos">
      <tr>
        <th width="50%" scope="col">Nome</th>
        <th width="5%" scope="col">Idade</th>
        <th width="35%" scope="col">Escolaridade</th>
        <th width="5%" scope="col">Inglês </th>
        <th width="5%" scope="col">Informática</th>
      </tr>
      
      <?php
        foreach($listaPessoa as $key => $value) {
      ?>
        <tr>
          <td><?= $value['nome']; ?></td>
          <td><?php
              $d1 = new DateTime($value['datanasc']);
              $d2 = new DateTime('today');
              $diff = $d2 -> diff($d1);
              echo $diff->y;
              ?></td>
          <td>&nbsp;</td>
          <td>S/N</td>
          <td>S/N</td>
        </tr>
      <?php
      }
      ?>

    </table>
    
    <form action="" method="get" id='paginacao'>
      <input type="hidden" name='paginaCorrente' id='paginaCorrente'>

    <ul class="paginacao"> 
      <li onClick='pagina(<?= $pagCor - 1 ?>)'><<</li>
      <?php 
        for($i = 0; $i < $qtdPaginas; $i++) {
      ?>
      <!-- xyz ? abc : aa  operador ternário é equivalente a if (?) e else (:) -->
      <li class="<?= ($i+1 == $pagCor) ? 'atual' : '' ?>" 
          onClick='pagina(<?= $i +1 ?>)'><?= $i +1 ?></li>
      <?php
        }
        ?>
      <li onClick='pagina(<?= $pagCor + 1 ?>)'>>></li> 
    </ul>

  <h4>Total de inscritos: <?= $qtdeInscritos ?></h4>    

  </section>
  
  <footer>   
  
        <div>
              
          <div class="logo-prodabel">
              <img src="img/logo-prodabel.png" alt="palavra prodabel na cor verde" title="Empresa de Informática e Informação de Belo Horizonte">
          </div>
                  
          <div class="logo-pbh">
      <img src="https://prefeitura.pbh.gov.br/sites/default/files/estrutura-de-governo/comunicacao/2019/PBH75_7.png" alt="brasão da prefeitura de belo horizonte" title="Prefeitura de Belo Horizonte">
          </div>
                  
        </div>            

  </footer>
            
<!-- ======================================================================= -->
</body>
</html>