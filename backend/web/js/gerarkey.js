//Quando se clica no butao com id : btn-gerarkey cria automaticamento uma key
//e coloca no input com id : key

$('#btn-gerarkey').click(gerarKey);

function gerarKey() {
    var chaveativacao = Math.random().toString(36).substring(2, 12).toUpperCase();
    $('#chavedigital-chaveativacao').val(chaveativacao);
}