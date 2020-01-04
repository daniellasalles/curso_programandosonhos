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

    // FIELDSET = DADOS PESSOAIS
    // funcao para insercao das pessoas, os parametros sao passados no index. 
    // caso nao seja inserido algum dos campos, o padrao é preencher com vazio
    function inserePessoa($mysqli, 
                          $nome='',
                          $datanasc='', 
                          $cpf='', 
                          $info='') {

        $cpf = str_replace('.', '', $cpf);
        $cpf = str_replace('-', '', $cpf); 
        if(!is_numeric($cpf)) {
            echo 'cpf inválido!';
            return '';
        }
        $query = "INSERT INTO pessoa(nome, datanasc, cpf, informacoes)
                  VALUES('$nome', '$datanasc', $cpf, '$info')";
        // executa a query de insercao
        mysqli_query($mysqli, $query);
        // verifica se aconteceu algum erro
        if(mysqli_errno($mysqli)) {
            echo mysqli_error($mysqli);

        }
    } 


    // Enumera as opções de estado civil existentes no banco e cria opções no formulario
    function enumEstadoCivil($mysqli) {
        $query = "SELECT ID_estcivil, estadocivil 
                  FROM estado_civil";
        $enumEstadoCivil = mysqli_query ($mysqli, $query);
        return $enumEstadoCivil;
    }



    // FIELDSET = ENDEREÇO

    // Enumera as opções de tipo de logradouro
    function enumLogradouro($mysqli) {
        $query = "SELECT ID_logradouro, tipologradouro 
                    FROM tipo_logradouro";
        $enumLogradouro = mysqli_query ($mysqli, $query);
        return $enumLogradouro;
    }

    // Insere dados do endereço
    function insereEndereco($mysqli,
                            $cep,
                            $logradouro,
                            $numero,
                            $complemento = '' ) {
        $query = "INSERT INTO endereco (cep, logradouro, numero, complemento)
                  VALUES ('$cep', '$logradouro', $numero, '$complemento')";
        mysqli_query($mysqli, $query);
    }


    // FIELDSET = ESCOLARIDADE
    // Enumera as opções de escolaridade
    function enumEscolaridade($mysqli) {
        $query = "SELECT ID_escolaridade, escolaridade
                  FROM escolaridade";
        $enumEscolaridade = mysqli_query($mysqli, $query);
        return $enumEscolaridade;    
    }

    // Enumera as opções de outros conhecimentos
    function enumConhecimento($mysqli) {
        $query = "SELECT ID_conhecimento, conhecimento
                  FROM conhecimento";
        $enumConhecimento = mysqli_query($mysqli, $query);
        return $enumConhecimento;
    }


    // Atribui todos as chaves estrangeiras e relaciona as tabelas
    
    // atribui ID_estcivil na tabela pessoa de acordo com o marcado no formulario
    function atribuiEstCivil($mysqli, $postEstCivil, $IDpessoa) {
        $query = "UPDATE pessoa 
                  SET pessoa.ID_estcivil = $postEstCivil
                  WHERE ID_pessoa = $IDpessoa";
        mysqli_query($mysqli, $query);
    }

    // Atribui ID do tipo de logradouro ao endereco
    function atribuiLogradouro($mysqli, $postLogradouro, $IDendereco) {
        $query = "UPDATE endereco
                    SET endereco.ID_logradouro = $postLogradouro 
                    WHERE ID_endereco = $IDendereco";
        mysqli_query($mysqli, $query);
    }

    // Atribui ID endereco na tabela pessoa
    function atribuiEndereco($mysqli, $IDendereco, $IDpessoa) {
        $query = "UPDATE pessoa
                  SET pessoa.ID_endereco = $IDendereco
                  WHERE ID_pessoa = $IDpessoa";
        mysqli_query($mysqli, $query);
    }

    // Atribui ID escolaridade na tabela pessoa
    function atribuiEscolaridade($mysqli, $postEscolaridade, $IDpessoa) {
        $query = "UPDATE pessoa
                  SET pessoa.ID_escolaridade = $postEscolaridade
                  WHERE ID_pessoa = $IDpessoa";
        mysqli_query($mysqli, $query);
    }

    // Insere dados sobre outros cursos na tabela pessoa
    function insereIngles($mysqli, $postIngles, $IDpessoa){
        $query = "UPDATE pessoa SET ingles = 'Sim' WHERE ID_pessoa = $IDpessoa";
        mysqli_query($mysqli, $query);
    }
    function insereInformatica($mysqli, $postInformatica, $IDpessoa) {
        $query = "UPDATE pessoa SET informatica = 'Sim' WHERE ID_pessoa = $IDpessoa";
        mysqli_query($mysqli, $query);
    }


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
