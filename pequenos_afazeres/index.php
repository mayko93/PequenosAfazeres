<?php

// CONECTAR AO BANCO DE DADOS
include_once("conexao.php");

// CRIAR SCRIPT SQL
$sql = "SELECT * FROM empresa";

// EXECUTAR SCRIPT SQL
$resultado = mysqli_query($conexao, $sql);

// TRATAR DADOS RECUPERADOS DO BANCO DE DADOS
$arResultado = mysqli_fetch_assoc($resultado);

// FECHAR CONEXÃO COM BANCO DE DADOS
mysqli_close($conexao);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="imagens/iconepag.ico">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <style>
    footer {
      width: 100%;
      padding: 30px 5%;
      margin-top: 30px;
      background: #412730;
      color: #fff;
      border-top: 5px solid #fff;
      box-shadow: 0 10px 20px #999;
      text-align: center;
      line-height: 35px;
    }
  </style>

  <title>Pequenos Afazeres</title>
</head>

<body>
  <header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-end">
        <div class="text-end">
          <a class="btn btn-outline-light me-2" href="login.php" style="background-color: #a70000 ; border-color: #412730;">Entrar</a>
          <a class="btn btn-outline-light" href="cadastrar.php" style="background-color: #a70000 ; border-color: #412730;">Cadastrar-se</a>
        </div>
      </div>
    </div>
  </header>

  <div class="align-items-center " style="max-width: 80%; margin-left: 10%; margin-right: 10%; margin-top: 3%;">
    <div class="card mb-12 align-items-center" style="max-width: 100%; margin-top: 2%;">
      <div class="row g-0">
        <div class="col-md-6 align-items-center">
          <img src="imagens/logomarca.png" class="img-fluid rounded-start" alt="..." style="margin-top: 15%;">
        </div>
        <div class="col-md-6 align-items-center">
          <div class="card-body">
            <h5 class="card-title">Solicite tarefas para todo<br />
              o Distrito Federal</h5>
            <p class="card-text">
              A Pequenos Afazeres é uma empresa de entregas,<br />
              buscas e compras que oferece o melhor serviço<br />
              para realizar aquelas tarefas das quais não<br />
              sobra tempo no dia-a-dia e do jeito que você precisa.<br />
              Ideal para quem trabalha em horário comercial<br />
              e não pode sair a qualquer instante e também<br />
              para empresas de todos os tamanhos. Solicite<br />
              quantas tarefas você precisar — seja um só<br />
              ou mais de mil.
              <br />
              Tudo isso sem sair do seu endereço e sem<br />
              pesar no seu bolso com uma taxa fixa de RS20,00.
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>

  <footer>
    <strong><?php echo $arResultado['razaoSocial']; ?><br>
      <span style="font-size: 12px;">Logística e Transportes</span><br>
    </strong>
    <p><?php echo "Endereço: " . $arResultado['enderecoEmpresa'] . ", " . $arResultado['cidade'] . ", " . $arResultado['UF']; ?></p>
    <p><?php echo "CEP: " . $arResultado['cep']; ?></p>
    <p><?php echo "Telefone: " . $arResultado['telefoneEmpresa']; ?></p>
    <p><?php echo "CNPJ: " . $arResultado['cnpj']; ?></p>

  </footer>

</body>

</html>