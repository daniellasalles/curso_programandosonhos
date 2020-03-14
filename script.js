function validaForm() {
   limpaErros();
    //nome = nome.trim();
    //nome = document.getElementById('nome').value;
    carInvalidos = new Array('#', '&', '%', '.', ',', '@', '!', '*', '$', '@', '*');
    var erros = new Array();
    nome = document.getElementById('nome').value;
    // Validação do campo nome
    if(nome) {
        // Verifica existência de caracteres especiais
        for(y = 0; y < carInvalidos.length; y++) {
            if(nome.indexOf(carInvalidos[y]) != -1) {
                erros.push("Favor verificar o preenchimento do campo \"nome\".");
            }
        }
    }

    // Validação do campo CPF
    cpf = document.getElementById('cpf').value;

    cpf = cpf.replace(/(\.|\-)/g, '');
    
    if(cpf) {
        //Verifica se foram preenchidos todos os dígitos
            if(cpf.length != 11 || isNaN(cpf)) {
                erros.push("CPF inválido");
            }

       // for(y = 0; y < carInvalidos.length, y++)

    }

    // Cria uma div com a listagem dos erros de preenchimento
    if(erros.length) {
        for(x = 0; x < erros.length; x++) {
            //alert(erros[x]);
            divErros = document.createElement('div');
            divErros.innerHTML = erros[x];
            divErros.className = 'divErros';
            document.getElementById('form').appendChild(divErros);

            }

        document.getElementById('acessar').addEventListener("submit", function(event){
            event.preventDefault()
        })
        return false;
            
    }
}

function limpaErros() {
	// Arranja todos os elementos com a classe 'erro' dentro do formulário
	erros = document.getElementById("form").getElementsByClassName("divErros");
	// Para cada erro no arranjo
	for(x=(erros.length-1); x >= 0; x--) {
		// Remove o elemento com a clasee erro do fomulário
		document.getElementById("form").removeChild(erros[x]);
	}
}

function maskCPF(entradaCPF) {
    
    /* if(entradaCPF.length == 3) {
        cpfSubstr1 = entradaCPF.substring(0, 3);
        cpfSubstr2 = entradaCPF.substring(3, 6);
        document.getElementById('cpf').value = cpfSubstr1 + '.' + cpfSubstr2;
    }
*/

    // Formata o CPF após digitação de todos os dígitos
    if(entradaCPF.length == 11 ) {
        
        cpfSubstr1 = entradaCPF.substring(0, 3);
        cpfSubstr2 = entradaCPF.substring(3, 6);
        cpfSubstr3 = entradaCPF.substring(6, 9);
        cpfSubstr4 = entradaCPF.substring(9, entradaCPF.length)
        document.getElementById('cpf').value = cpfSubstr1 + '.' + cpfSubstr2 + '.' + cpfSubstr3 + '-' + cpfSubstr4;
    }
}

function maskCEP(entradaCEP) {

}