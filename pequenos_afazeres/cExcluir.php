<?php
//1. RECUPERAR DADOS DO FORMULÁRIO
$idTarefa = $_POST['id'];

//2. VERIFICAR SE USUÁRIO ESTÁ LOGADO E CONECTAR AO SERVIDOR DE BANCO DE DADOS
include_once("logado.php");
include_once("conexao.php");

//3. CRIAR SCRIPT SQL QUE SERÁ EXECUTADO NO BANCO DE DADOS
$sql = "DELETE FROM tarefa";
$sql .= " WHERE id_tarefa = " . $idTarefa;

//4. EXECUTAR SCRIPT SQL
$resultado = mysqli_query($conexao, $sql);

//5. REALIZAR PROCESSAMENTOS NECESSÁRIOS
    if($resultado){
        header("Location: homeCliente.php");
    }else{
        echo "<p>Falha ao excluir tarefa. Verifique!</p>";
    }

?>