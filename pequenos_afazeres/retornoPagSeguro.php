<?php

//CONECTAR AO BANCO DE DADOS
include_once("conexao.php");

//ARQUIVO DE CONFIGURACOES DO SISTEMA
include_once("configuracao.php");

$notificationType = $_POST['notificationType'];
$notificationCode = $_POST['notificationCode'];

//INSERINDO NOTIFICACAO SOBRE ALTERACOES DA TRANSACAO NO BANCO DE DADOS
 if ($notificationCode != "") {
    $sql1 = " INSERT INTO retornoNotificacao (codigoNotificacao, tipoNotificacao) values('$notificationCode', '$notificationType');";
    //EXECUTAR SCRIPT SQL
    $resultado = mysqli_query($conexao, $sql1);
} else {
    echo "<h4>Nenhum retorno de notificação recebido</h4>";
}

//CONSULTA STATUS DO PAGAMENTO E RETORNA PARA O BANCO DE DADOS DO SISTEMA



//https://ws.pagseguro.uol.com.br/v3/transactions/notifications/{{codigo-notificacao}}?{{credenciais}}
$urlConsulta = URL_CONSULTA_TRANSACAO . $notificationCode . "?email=" . EMAIL_PAGSEGURO . "&token=" . TOKEN_PAGSEGURO;

$curl = curl_init($urlConsulta);

curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));

//curl_setopt($curl, CURLOPT_HTTPGET, 1);

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$retorno = curl_exec($curl);

curl_close($curl);

$xml = simplexml_load_string($retorno);

//-------------------------------------------
$statusPagamento = $xml->status;
$idTarefa = $xml->reference;

if(isset($xml->code)) {

$sql2 .= " UPDATE
pagamento
SET
statusPagamento = '$statusPagamento'
WHERE
idTarefa_FK = '$idTarefa';";

$sql3 .= " UPDATE
tarefa
SET
statusTarefa = '$statusPagamento'
WHERE
id_tarefa = '$idTarefa';";

    //EXECUTAR SCRIPT SQL
    $resultado = mysqli_query($conexao, $sql2);
    $resultado = mysqli_query($conexao, $sql3);

} else {
    echo "<h4>Nenhuma alteração na transação</h4>";
}