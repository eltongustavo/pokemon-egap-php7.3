const input_txt = document.querySelector('#txt');
const container = document.querySelector('#container');
const selec_treinadores = document.querySelectorAll('.opc-treinador');

selec_treinadores.forEach(treinador => {
    treinador.addEventListener('click', e => {
        selec_treinadores.forEach(treinador => {
            treinador.classList.remove('selecionado');
        });
        e.target.parentElement.classList.add('selecionado');
    });
});

input_txt.addEventListener('change', (event) => {

    //Limpa a div "container" toda vez que o foco é alterado
    container.innerHTML = '';

    //recebe [object file] do input
    const arquivo = event.target.files[0];

    //verifica se o arquivo está no formato txt
    if(!is_txt(arquivo)){
        input_txt.value = "";
        alert("Arquivo não é um txt!");
        return;
    }
    
    if(arquivo){
        const leitor = new FileReader();
        leitor.onload = (event) => {
            
        const conteudo = event.target.result.trim();
        // Divide o conteúdo usando duas quebras de linha (pode incluir espaços)
        let lista_pokemon = conteudo.split(/\n\s*\n/); 
        
        //adiciona as informações de cada pokémon em um array
        let pokemons = new Array();
        lista_pokemon.forEach(p => {
            pokemons.push(p.trim());
        });

        //verifica se a equipe tem 6 pokémons
        if (pokemons.length !== 6) {
            alert("Equipe incompleta!");
            input_txt.value = ""; // Limpa o campo de entrada
            return;
        }
        
        //verificar se existe algum item de mega evolução banida
        for(let i = 0; i < pokemons.length; i++){
            console.log(pokemons[i]);
            if(pokemons[i].includes("Kangaskhanite") || pokemons[i].includes("Metagrossite") || pokemons[i].includes("Heracronita")){
                alert("Item de Mega Evolução Banida Identificado!");
                input_txt.value = ""; // Limpa o campo de entrada
                return;
            }
        }
     
        //separa a primeira linha do array contendo os dados de cada pokémon
        let nomePokemons = [];
        pokemons.forEach(p => {
            nomePokemons.push(p.split("\n")[0]);
        });

        //remove os dados sobre sexualidade do pokémon
        nomePokemons.forEach( (n, index) => {
            n = n.replace("(M)", "");
            n = n.replace("(F)", "");
            nomePokemons[index] = n;
        });

        //remove os apelidos dos pokémons e adiciona os nomes separadamente em um array
        nomePokemons.forEach( (n, index) => {
            if(n.includes("(")){
                let pos_abertura = n.indexOf("(") + 1;
                let pos_fechamento = n.indexOf(")");
                nomePokemons[index] = n.substring(pos_abertura, pos_fechamento).toLowerCase();
            }else{
                let pos_espaco = n.indexOf(" ");
                nomePokemons[index] = n.substring(0, pos_espaco).toLowerCase();
            }
        });
        
        //verifica se existe algum pokémon banido ou repetido no time
        if(!listaValida(nomePokemons, lista_banidos())) {
            alert("Pokemon Banido/Repetido identificado");
            input_txt.value = "";
            return;
        }

        //verifica se palavras que devem estar em 100% dos arquivos do showdown existem
        let validacoes = ["Ability:", "Level:", "-"];
        for (let i = 0; i < pokemons.length; i++) {
            for (let j = 0; j < validacoes.length; j++) {
                if (!pokemons[i].includes(validacoes[j])) {
                    alert("Formatação inválida no arquivo txt!");
                    input_txt.value = ''; // Limpa o campo de entrada
                    return;
                }
            }
        }

        addPokemons(nomePokemons); //função que adiciona os pokémon nos inputs
        
        }
        leitor.readAsText(arquivo); // Isso inicia a leitura do arquivo (NECESSÁRIO PARA O ONLOAD FUNCIONAR);
    }

    //função que recebe um arquivo e testa se a extensão dele é .txt
    function is_txt(arquivo){
        const extensao = arquivo.name.split(".").pop();
        if(extensao != 'txt'){
            return false;
        }
        return true;
    }

    
    //função que adiciona os pokémons nos inputs do site
    // Função que adiciona os pokémons nos inputs do site
    function addPokemons(pokemons) {
        pokemons.forEach((pk, index) => {
            let div = document.createElement('div');
            let img = document.createElement('img');
            let input = document.createElement('input');

            img.src = `https://d1r7q4bq3q8y2z.cloudfront.net/${pk}.png`;
            img.setAttribute('width', '100%');

            input.setAttribute('type', 'hidden');
            input.setAttribute('name', `p${index+1}`);
            input.setAttribute('value', pk);    

            div.classList.add('col-6', 'col-md-4', 'col-lg-2');
            div.appendChild(img);
            div.appendChild(input); // Adiciona o input ao div

            container.appendChild(div);
        });
    }


    //função que verifica se existem pokémons banidos ou repetidos no time
    function listaValida(pokemons, banidos, mega_banidos) {
        const duplicata = new Set(pokemons);

        if (pokemons.length != duplicata.size) {
            return false;
        }

        for (let i = 0; i < banidos.length; i++) {
            if (pokemons.includes(banidos[i])) {
                return false;
            }
        }

        return true;
    };

    //lista que contém todos os pokémons banidos
    function lista_banidos(){
        const pokemonArray = [
            'kangaskhan-mega',
            "heracross-mega",
            'metagross-mega',
            'greninja-ash',
            'mewtwo',
            'mew',
            'lugia',
            'ho-oh',
            'celebi',
            'kyogre',
            'groudon',
            'rayquaza',
            'jirachi',
            'deoxys',
            'dialga',
            'palkia',
            'giratina',
            'phione',
            'manaphy',
            'darkrai',
            'shaymin',
            'arceus',
            'victini',
            'reshiram',
            'zekrom',
            'kyurem',
            'keldeo',
            'meloetta',
            'genesect',
            'xerneas',
            'yveltal',
            'zygarde',
            'diancie',
            'hoopa',
            'volcanion',
            'cosmog',
            'cosmoem',
            'solgaleo',
            'lunala',
            'necrozma',
            'magearna',
            'marshadow'
        ];
        return pokemonArray;
    };

});
