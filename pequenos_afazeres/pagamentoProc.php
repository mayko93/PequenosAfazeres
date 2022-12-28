<?php
//VERIFICAR SE O USUÁRIO ESTÁ LOGADO
include_once("logado.php");

//ARQUIVO DE CONFIGURAÇÃO DO PARA O PAGSEGURO
include_once("configuracao.php");

// 2. CONECTAR AO BANCO DE DADOS
include_once("conexao.php");

$dadosFormPagamento = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$arrayDadosFormPagamento["email"]= EMAIL_PAGSEGURO;
$arrayDadosFormPagamento["token"]= TOKEN_PAGSEGURO;

$arrayDadosFormPagamento["paymentMode"]= "default";
$arrayDadosFormPagamento["paymentMethod"]= $dadosFormPagamento['paymentMethod'];
$arrayDadosFormPagamento["receiverEmail"]= EMAIL_ESTABELECIMENTO;
$arrayDadosFormPagamento["currency"]= $dadosFormPagamento['currency'];
$arrayDadosFormPagamento["extraAmount"]= $dadosFormPagamento['extraAmount'];
$arrayDadosFormPagamento["itemId1"]= $dadosFormPagamento['itemId1'];
$arrayDadosFormPagamento["itemDescription1"]= $dadosFormPagamento['itemDescription1'];
$arrayDadosFormPagamento["itemAmount1"]= $dadosFormPagamento['itemAmount1'];
$arrayDadosFormPagamento["itemQuantity1"]= $dadosFormPagamento['itemQuantity1'];
$arrayDadosFormPagamento["notificationURL"]= URL_NOTIFICACAO;
$arrayDadosFormPagamento["reference"]= $dadosFormPagamento['reference'];
$arrayDadosFormPagamento["senderName"]= $dadosFormPagamento['senderName'];
$arrayDadosFormPagamento["senderCPF"]= $dadosFormPagamento['senderCPF'];
$arrayDadosFormPagamento["senderAreaCode"]= $dadosFormPagamento['senderAreaCode'];
$arrayDadosFormPagamento["senderPhone"]= $dadosFormPagamento['senderPhone'];
$arrayDadosFormPagamento["senderEmail"]= $dadosFormPagamento['senderEmail'];
$arrayDadosFormPagamento["senderHash"]= $dadosFormPagamento['hashCartao'];
$arrayDadosFormPagamento["shippingAddressRequired"]= false;
$arrayDadosFormPagamento["creditCardToken"]= $dadosFormPagamento['tokenCartao'];
$arrayDadosFormPagamento["installmentQuantity"]= $dadosFormPagamento['selectQtdParcelas'];
$arrayDadosFormPagamento["installmentValue"]= $dadosFormPagamento['valorParcelas'];
$arrayDadosFormPagamento["noInterestInstallmentQuantity"]= $dadosFormPagamento['noInterestInstallmentQuantity'];
$arrayDadosFormPagamento["creditCardHolderName"]= $dadosFormPagamento['senderName'];
$arrayDadosFormPagamento["creditCardHolderCPF"]= $dadosFormPagamento['senderCPF'];
$arrayDadosFormPagamento["creditCardHolderBirthDate"]= $dadosFormPagamento['creditCardHolderBirthDate'];
$arrayDadosFormPagamento["creditCardHolderAreaCode"]= $dadosFormPagamento['senderAreaCode'];
$arrayDadosFormPagamento["creditCardHolderPhone"]= $dadosFormPagamento['senderPhone'];
$arrayDadosFormPagamento["billingAddressStreet"]= $dadosFormPagamento['billingAddressStreet'];
$arrayDadosFormPagamento["billingAddressNumber"]= $dadosFormPagamento['billingAddressNumber'];
$arrayDadosFormPagamento["billingAddressComplement"]= $dadosFormPagamento['billingAddressComplement'];
$arrayDadosFormPagamento["billingAddressDistrict"]= $dadosFormPagamento['billingAddressDistrict'];
$arrayDadosFormPagamento["billingAddressPostalCode"]= $dadosFormPagamento['billingAddressPostalCode'];
$arrayDadosFormPagamento["billingAddressCity"]= $dadosFormPagamento['billingAddressCity'];
$arrayDadosFormPagamento["billingAddressState"]= $dadosFormPagamento['billingAddressState'];
$arrayDadosFormPagamento["billingAddressCountry"]= $dadosFormPagamento['billingAddressCountry'];

$buildQuery = http_build_query($arrayDadosFormPagamento);
$URL_PAGSEGURO = URL_PAGSEGURO."transactions/";

$curl_init = curl_init($URL_PAGSEGURO);
curl_setopt($curl_init, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
//enviando o Length novamente em caso de erro
//curl_setopt($curl_init, CURLOPT_HTTPHEADER, array("Content-Length:0"));
curl_setopt($curl_init, CURLOPT_POST, true);
curl_setopt($curl_init, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_init, CURLOPT_POSTFIELDS, $buildQuery);
$retorno = curl_exec($curl_init);
curl_close($curl_init);
$xml = simplexml_load_string($retorno);

//----------------------------------------------------------------------
$referenceTarefa = $xml->reference;
$statusTarefa = $xml->status;

if(isset($xml->code)){
$sqlCadastrar = " INSERT INTO pagamento (idTarefa_FK, tipoPagamento, codigoTransacao, statusPagamento, criadoEm) VALUES(:idTarefa_FK, :tipoPagamento, :codigoTransacao, :statusPagamento, NOW()); ";

$cadastrar = $conn->prepare($sqlCadastrar);
$cadastrar->bindParam(':idTarefa_FK', $xml->reference, PDO::PARAM_INT);
$cadastrar->bindParam(':tipoPagamento', $xml->paymentMethod->type, PDO::PARAM_INT);
$cadastrar->bindParam(':codigoTransacao', $xml->code, PDO::PARAM_STR);
$cadastrar->bindParam(':statusPagamento', $xml->status, PDO::PARAM_INT);
$cadastrar->execute();


$sql .= " UPDATE tarefa SET statusTarefa = '$statusTarefa'";
$sql .= " WHERE id_tarefa = " . $referenceTarefa;

$resultado = mysqli_query($conexao, $sql);

$pg = "pago";
$msg = "<h5><span style='color: green; font-weight:bold ;'>Pagamento efetuado com sucesso!</span></h5>";
//header("Location: homeCliente.php?pg=$pg&msg=$msg");

}else{
    $pg = "pagamentoNegado";
    $msg = "<h5><span style='color: red; font-weight:bold ;'>Não foi possível efetuar o pagamento!</span></h5>";
    //header("Location: pagamento.php?pg=$pg&msg=$msg");
}

//----------------------------------------------------------------
 
//retorno para o JS
/* $retorno = ['ERR' => true, 'DADOS_RECEBIDOS' =>$xml, 'arrayDadosFormPagamento' => $arrayDadosFormPagamento];
header('Content-type: application/json');
echo json_encode($retorno);
 */

 //---------------------------------------------------------------
