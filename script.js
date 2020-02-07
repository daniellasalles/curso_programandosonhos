function validaForm() {
    //nome = nome.trim();
    //nome = document.getElementById('nome').value;
    carInvalidos = new Array('#', '&', '%', '.', ',', '@', '!', '*');
    var erros = new Array();
    nome = document.getElementById('nome').value;

    // Validação do campo nome
    if(nome) {
        // Verifica existência de caracteres especiais
        for(y = 0; y < carInvalidos.length; y++) {
            if(nome.indexOf(carInvalidos[y]) != -1) {
                erros.push("ERRO: Favor verificar o preenchimento do campo \"nome\".");
            }
        }

        /* if(nome.includes()) == true ) {
            erros.push("ERRO: Campo \"nome\" não pode conter números.");
            alert(erros);
        } */
    }


    // Cria uma div com a listagem dos erros de preenchimento
    if(erros.length) {
        for(x = 0; x <= erros.length; x++) {
            //alert(erros[x]);
            divErros = document.createElement('div');
            divErros.id = 'divErros';
            document.getElementById('form').appendChild(divErros);
            divErroNome = document.createElement('div');
            divErroNome.innerHTML = erros[x];
            document.getElementById('divErros').appendChild(divErroNome);

            return false;
        }

    }


}