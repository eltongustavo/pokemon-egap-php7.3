document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formulario');
    const nome = document.getElementById('nome');
    const telefone = document.getElementById('telefone');
    const senha = document.getElementById('senha');
    const confirmarSenha = document.getElementById('confirmarSenha');
    const submitBtn = document.getElementById('submitBtn');
    const mensagem = document.getElementById('mensagem');

    function validateForm() {
        // Verifica se todos os campos estão preenchidos
        if (nome.value.trim() === '' || senha.value.trim() === '' || confirmarSenha.value.trim() === '' || telefone.value.trim() == '') {
            mensagem.innerHTML = '<div class="alert alert-danger">Todos os campos são obrigatórios</div>';
            submitBtn.disabled = true;
            return;
        }

        // Verifica se as senhas são iguais
        if (senha.value !== confirmarSenha.value) {
            mensagem.innerHTML = '<div class="alert alert-danger">As senhas não coincidem</div>';
            submitBtn.disabled = true;
            return;
        }

        //verifica se a senha possui no mínimo 8 caracteres
        if(!sizePassword(senha.value)){
            mensagem.innerHTML = '<div class="alert alert-danger">Senha precisa ter no mínimo 8 caracteres</div>';
            submitBtn.disabled = true;
            return;
        }

        //verifica o tamanho do input nome
        if(!nameExceed(nome.value)){
            mensagem.innerHTML = '<div class="alert alert-danger">Nome muito longo</div>';
            submitBtn.disabled = true;
            return;
        }

        if(!isTelefone(telefone.value)){
            mensagem.innerHTML = '<div class="alert alert-danger">Telefone Inválido</div>';
            submitBtn.disabled = true;
            return;
        }

        // Se tudo estiver válido, habilita o botão de submit
        mensagem.innerHTML = '';
        submitBtn.disabled = false;
    }

    // Adiciona eventos de escuta para os campos
    nome.addEventListener('input', validateForm);
    telefone.addEventListener('input', validateForm);
    senha.addEventListener('input', validateForm);
    confirmarSenha.addEventListener('input', validateForm);

    // Validação no submit do formulário
    form.addEventListener('submit', function(event) {
        validateForm(); // Verifica se o formulário está válido antes de enviar

        if (submitBtn.disabled) {
            event.preventDefault(); // Impede o envio do formulário se inválido
        }
    });
});

function isNumeric(value) {
    tamanho = value.lenght();
    const number = Number(value); // Converte a string para número
    return !isNaN(number) && isFinite(number);
}

function nameExceed(value){
    if(value.length > 99){
        return false;
    }
    return true;
}

function sizePassword(value){
    if(value.length < 8){
        return false;
    }
    return true;
}

function isTelefone(value){
    const regex = /^\+?[0-9]{1,4}[-.\s]?[0-9]{1,15}$/;

    if (regex.test(value)) {
        return true;
    }
    
    return false;
}
