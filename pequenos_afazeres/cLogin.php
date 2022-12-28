<?php
// 1. RECUPERAR DADOS DO FORMULÁRIO
$cpf = $_POST['user'];
$senha = md5($_POST['senha']);

// 2. CONECTAR AO BANCO DE DADOS
include_once("conexao.php");

// 3. CRIAR SCRIPT SQL
$sql = "SELECT cpf, senha FROM cliente";
$sql .= " WHERE cpf = '$cpf' ";

// 4. EXECUTAR SCRIPT SQL
$resultado = mysqli_query($conexao, $sql);

// 5. TRATAR DADOS RECUPERADOS DO BANCO DE DADOS
$arResultado = mysqli_fetch_assoc($resultado);
// 5.1 DADOS CADASTRADOS NO BANCO DE DADOS
$cpfCadastrado = $arResultado['cpf'];
$senhaCadastrado = $arResultado['senha'];
$perfilCadastrado = $arResultado['perfil'];
// 6. REALIZAR OS PROCESSAMENTOS NECESSÁRIOS

if ($senha == $senhaCadastrado) {
    // 6.1 - CASO DE SUCESSO
    session_start(); //INÍCIO DE SESSÃO
    //CONTROLE DE USUÁRIO LOGADO
    $_SESSION['LOGADO'] = true;
    $_SESSION['perfil'] = $perfilCadastrado;
    $_SESSION['user'] = $arResultado['cpf']; 
    
    $msg = "Seja bem vindo";
    header("Location: homeCliente.php?m=$msg");
    exit;
} else {
    //6.2 CASO DE FALHA
    $msg = "<h4><span style='color: red; font-weight:bold ;'>Dados inválidos</span></h4>";
    header("Location: login.php?m=$msg");
    exit;
}
// 7. FECHAR CONEXÃO COM BANCO DE DADOS
mysqli_close($conexao);
