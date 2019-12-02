<?php
    function conecta($servidor, $usuario, $senha, $banco) {
        /**
         * Definicao da funcao conecta
         * @param string $servidor
         * @param string $usuario
         * @param string $senha
         * @param string $banco
         * @return conexao com BD
         * @author Daniella Salles
         */

        // faz a conexao com o banco - 
        // funcao generica que pede parametros que podem ser usados por outros bancos de dados e arquivos
        $mysqli = mysqli_connect($servidor, $usuario, $senha, $banco);

        // detecta se houve erro na conexao e exibe msg em caso de erro
        if(mysqli_connect_errno()) {
            echo 'ERRO: '.mysqli_connect_error($mysqli);
        }

        // retorna a conexao para ser acessivel fora da funcao
        return $mysqli;
    }

    // funcao para insercao das pessoas, os parametros sao passados no index. 
    // caso nao seja inserido algum dos campos, o padrao é preencher com vazio
    function inserePessoa($mysqli, 
                          $nome='', 
                          $cpf='', 
                          $datanasc='') {

        $cpf = str_replace('.', '', $cpf);
        $cpf = str_replace('-', '', $cpf); 
        if(!is_numeric($cpf)) {
            echo 'cpf inválido!';
            return '';
        }
        $query = "INSERT INTO pessoa(nome, datanasc, cpf)
                  VALUES('$nome', '$datanasc', $cpf)";
        
        // executa a query de insercao
        mysqli_query($mysqli, $query);
       
        // verifica se aconteceu algum erro
        if(mysqli_errno($mysqli)) {
            echo mysqli_error($mysqli);
        }
    } 

    // Enumera as opções de estado civil existentes no banco e cria opções no formulario
    function enumEstadoCivil ($mysqli) {
        $query = "SELECT ID_estcivil, estadocivil 
                  FROM estado_civil";
        $enumEstadoCivil = mysqli_query ($mysqli, $query);
        return $enumEstadoCivil;
    }


    function insereEscolaridade($mysqli, 
        $escolaridade) {
        $query = "INSERT INTO escolaridade(escolaridade)
        VALUES ('$escolaridade')";

        mysqli_query($mysqli, $query);

    }

    // atribui ID_estcivil na tabela pessoa de acordo com o marcado no formulario
    function atribuiEstCivil($mysqli, $postEstCivil) {

            $postEstCivil = intval($_POST['estado-civil']); 
            $IDatualPessoa = mysqli_insert_id($mysqli);
            $query = "UPDATE pessoa 
                    SET pessoa.ID_estcivil = '$postEstCivil'
                    WHERE ID_pessoa = '$IDatualPessoa'";

            mysqli_query($mysqli, $query);
        
    }
    
    function atribuiDadosPessoais($mysqli, $post, $coluna) {
        $IDatualPessoa = mysqli_insert_id($mysqli);
        $query = "UPDATE pessoa
                SET '$coluna' = '$post'
                WHERE ID_pessoa = $IDatualPessoa";

        $atribuiDadosPessoais = mysqli_query($mysqli, $query);
        return $atribuiDadosPessoais;
    }
        
        /*
        if($_POST['escolaridade']) {
            $query = "UPDATE pessoa 
                     SET escolaridade.ID_estcivil = '$postDados'
                     WHERE ID_pessoa = '$IDatual'";
            $estadocivil = mysqli_query($mysqli, $query);
        }
        */

    function exibePessoa ($mysqli, $paginaCorrente=1, $qtdPorPagina=5) {
        // constroi a query de insercao de dados de uma pessoa
        $listaPessoa = [];
        $offset = ($paginaCorrente-1) * $qtdPorPagina;
        $query = "SELECT nome, datanasc 
                  FROM pessoa 
                  ORDER BY nome ASC
                  LIMIT $qtdPorPagina 
                  OFFSET $offset";
        $resultado = mysqli_query($mysqli, $query);
            if(mysqli_errno($mysqli)) {
                echo mysqli_error($mysqli);
            } else {
                while($linha = mysqli_fetch_assoc($resultado)) {
                    array_push($listaPessoa, $linha);
                }
            }
        return $listaPessoa;
    }

    function getQtdTotalPessoas($mysqli) {
        $query = 'SELECT count(*) as qtd from pessoa';
        $resultado = mysqli_query($mysqli, $query);
        if(mysqli_errno($mysqli)) {
            echo mysqli_error($mysqli);
            return false;
        }
        $qtd = mysqli_fetch_assoc($resultado);
        return $qtd['qtd'];
    }
// arquivo puro php não precisa ser fechado