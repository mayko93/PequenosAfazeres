<?php
//VERIFICAR SE O USUÁRIO ESTÁ LOGADO
include_once("logado.php");

//1. RECUPERAR DADOS DO FORMULÁRIO
    $cpfTarefa = $_POST['cpfTarefa'];
    $tipoTarefa = $_POST['tipoTarefa'];
    $enderecoColeta = $_POST['enderecoColeta'];
    $enderecoEntrega = $_POST['enderecoEntrega'];
    $dataTarefa = $_POST['dataTarefa'];
    $horaTarefa = $_POST['horaTarefa'];
 //1.1 VERIFICAR SE OS CAMPOS FORAM PREENCHIDOS 
if($cpfTarefa == "" || $tipoTarefa == "" || $enderecoColeta == "" || $enderecoEntrega == "" || $dataTarefa == "" || $horaTarefa == ""){
    $msg = "<br> <h4 style='color: red; font-weight:bold ;'> Campos vazios! Preencha e tente novamente. </h4>";
    header("Location: novaTarefa.php?m=$msg");
}
    
//2. CONECTAR AO SERVIDOR DE BANCO DE DADOS
    include_once("conexao.php");

//3. CRIAR SCRIPT SQL QUE SERÁ EXECUTADO NO BANCO DE DADOS
    $sql = " INSERT INTO tarefa (cpfTarefa, tipoTarefa, enderecoColeta, enderecoEntrega, dataTarefa, horaTarefa)";
    $sql .= " VALUES ('$cpfTarefa', '$tipoTarefa', '$enderecoColeta', '$enderecoEntrega', '$dataTarefa', '$horaTarefa')";

//4. EXECUTAR SCRIPT SQL
    $resultado = mysqli_query($conexao, $sql) ;

//5. REALIZAR PRCESSAMENTOS NECESSÁRIOS
    if($resultado){
        header("Location: homeCliente.php");
        echo "<h4> Nova tarefa solicitada com sucesso </h4>";
    }else{
        echo "<h3>Falha ao solicitar tarefa. Verifique!</h3>";
    }
