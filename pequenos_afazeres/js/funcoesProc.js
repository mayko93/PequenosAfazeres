//valor da compra
var amount = $('#itemAmount1').val();
//var amount = "2000";
//console.log(amount);

//endereco do servidor
var endereco = $('#enderecoServidor').val();

/* const inputEndereco = document.querySelector("#enderecoServidor");
const endereco = inputEndereco.value; */
//console.log(endereco);

gerarId();
function gerarId(){

    //endereco do projeto (lembrar de alterar no arquivo configuracao quando tiver hospedado)
    
    $.ajax({

        //URL do arquivo responsavel por pegar o ID da sessao
        url: endereco + "idSessao.php",
        type: 'POST',
        dataType: 'json',
        success: function(response){
            //console.log(response);

            //ID da sessao retornado pelo PagSeguro
            PagSeguroDirectPayment.setSessionId(response.id);
  
        },
        complete: function(response) {
            listarMeiosPagamento();
        }
    });
}

function listarMeiosPagamento(){
    PagSeguroDirectPayment.getPaymentMethods({
        amount: amount,
        success: function(response) {
            // Retorna os meios de pagamento disponíveis.
            //console.log(response);
            $.each(response.paymentMethods.CREDIT_CARD.options, function(i, obj){
                //todos os nomes das bandeiras dos cartoes
                //$('.meio-pagamento').append("<span>"+ obj.name +"</span>")
                
                //imagens das bandeiras dos cartoes
                $('.meio-pagamento').append("<span><img src='https://stc.pagseguro.uol.com.br"+ obj.images.SMALL.path + "'></span>");
            })
        },
        error: function(response) {
            // Callback para chamadas que falharam.
        },
        complete: function(response) {
            
        }
    });
}

$('#numCartao').on('keyup', function(){
    var numCartao = $(this).val();
    var qtdNumeros = numCartao.length;
    //console.log(numCartao);

    if(qtdNumeros == 6){
    PagSeguroDirectPayment.getBrand({
        cardBin: numCartao,
        success: function(response) {
          //bandeira encontrada
          $('#msgCartaoInvalido').empty();
          var imgBandeira = response.brand.name;
          $('.bandeiraCartao').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/" + imgBandeira + ".png'>");
          
          //para implementar parcelamento
          qtdParcelas(imgBandeira);
        },
        error: function(response) {
          //tratamento do erro
          $('.bandeiraCartao').empty();
          $('#msgCartaoInvalido').html("<span style='color: red; font-weight:bold ;'>Cartão inválido! Verifique.</span>")
        },
        complete: function(response) {
          //tratamento comum para todas chamadas
        }
    });
}
});

function qtdParcelas(bandeira){

    //recuperando do formulario a quantidade de parcelas sem juros
    var noInterestInstallmentQuantity = $('#noInterestInstallmentQuantity').val();

    PagSeguroDirectPayment.getInstallments({
        amount: amount,

        //quantidade de parcelas sem juros
        maxInstallmentNoInterest: noInterestInstallmentQuantity,
        brand: bandeira,
        success: function(response){
            // Retorna as opções de parcelamento disponíveis
            $.each(response.installments, function(i, objetoA){
                $.each(objetoA, function(j, objetoB){

                    //Acrescentar duas casas decimais apos o ponto
                    var valorParcelaDouble = objetoB.installmentAmount.toFixed(2);
                    
                    //quantidade de parcelas estatico
                    //$('#qtdParcelas').append(objetoB.quantity);

                    //Apresentar quantidade de parcelas e o valor das parcelas para o usuário no campo SELECT
                    $('#selectQtdParcelas').show().append("<option style='font-weight:bold ;'' value='" + objetoB.quantity + "'data-valorParcelas='"+valorParcelaDouble+"'>" + objetoB.quantity + "x de R$ " + valorParcelaDouble + "</option>");
                });
            });
       },
        error: function(response) {
            // callback para chamadas que falharam.
       },
        complete: function(response){
            // Callback para todas chamadas.
       }
});
}

$('#selectQtdParcelas').change(function(){
    $('#valorParcelas').val($('#selectQtdParcelas').find(':selected').attr('data-valorParcelas'));
});

//gerar hash no do cartao
$("#formPagamento").on("submit", function(event){
    $('#aguarde').show().append("<span class='visually-hidden'>Aguarde...</span>");
    event.preventDefault();

    //gerar token do cartao
    PagSeguroDirectPayment.createCardToken({
        cardNumber: $('#numCartao').val(), // Número do cartão de crédito
        brand: $('#nomeBandeiraCartao').val(), // Bandeira do cartão
        cvv: $('#cvc').val(), // CVV do cartão
        expirationMonth: $('#mesValidade').val(), // Mês da expiração do cartão
        expirationYear: $('#anoValidade').val(), // Ano da expiração do cartão, é necessário os 4 dígitos.
        success: function(response) {
             // Retorna o cartão tokenizado.
             //console.log(response);
        },
        error: function(response) {
                 // Callback para chamadas que falharam.
        },
        complete: function(response) {
             // Callback para todas chamadas.
             //console.log(response);
             $('#tokenCartao').val(response.card.token) ;
             recuperarHashCartao();
        }
     });
})

function recuperarHashCartao(){
    PagSeguroDirectPayment.onSenderHashReady(function(response){
        //console.log("response_status:_" + response.status);
        //console.log("msg de erro 01: "+response.message);
        if(response.status == 'error') {
            console.log("01_Deu erro aqui: "+response.message);
            return false;
        }else{
        $("#hashCartao").val(response.senderHash); //Hash estará disponível nesta variável.
        var dadosFormPagamento = $("#formPagamento").serialize();

        //console.log("Dados do formulario: " + dadosFormPagamento);

        $.ajax({
            method: "POST",
            url: endereco+"pagamentoProc.php",
            data: dadosFormPagamento,
            dataType: 'json',
            success: function(response){
                //console.log("02_sucessoResponse" + JSON.stringify(response));

            },
            error: function(response){                
                //console.log("03_ErroResponse" + JSON.stringify(response));

            },
            complete: function (response) {
                //console.log("04_CompleteResponse" + JSON.stringify(response));

                window.location.href = "homeCliente.php";           
            }
        })
             }
    });
}