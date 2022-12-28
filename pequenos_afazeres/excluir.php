<?php
//1. VERIFICAR SE O USUÁRIO ESTÁ LOGADO
include_once("logado.php");
//1.1 RECUPERA E TRÁS O ID SELECIONADO
$id = $_GET['id'];

// 2. CONECTAR AO BANCO DE DADOS
include_once("conexao.php");

// 3. CRIAR SCRIPT SQL
$sql = "SELECT * FROM tarefa";
$sql .= " WHERE id_tarefa = " . $id;

// 4. EXECUTAR SCRIPT SQL
$resultado = mysqli_query($conexao, $sql);

// 5. TRATAR DADOS RECUPERADOS DO BANCO DE DADOS
$arResultado = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Excluir Tarefa</title>
  <link rel="shortcut icon" href="imagens/iconepag.ico">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
  <div style="margin: 1%;" class="col-md-8">
    <div>
      <h3>Excluir Tarefa</h3>
    </div>
    <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
        <use xlink:href="#exclamation-triangle-fill" />
      </svg>
      <div>
        <h4>Deseja Realmente excluir esta tarefa?</h4>
      </div>
    </div>

    <div>
      <form action="cExcluir.php" method="POST">
        <div class="col-md-6">

          <label class="form-label fs-5 "><b>Código da tarefa:</b> <?php echo $arResultado['id_tarefa']; ?> </label>
          <input type="hidden" class="form-control " name="id" id="id" value="<?php echo $arResultado['id_tarefa']; ?>"><br />

          <label class="form-label fs-5 " ><b>Tipo da tarefa:</b> <?php echo $arResultado['tipoTarefa']; ?></label>
          <input type="hidden" class="form-control " name="tarefa" id="tarefa" value="<?php echo $arResultado['tipoTarefa']; ?>"><br/>

          <label class="form-label fs-5 " ><b>Data da tarefa:</b> <?php echo $arResultado['dataTarefa']; ?></label>
          <input type="hidden" class="form-control " name="dataTarefa" id="dataTarefa" value="<?php echo $arResultado['dataTarefa']; ?>"><br>

          <label class="form-label fs-5 " ><b>Hora da tarefa:</b> <?php echo $arResultado['horaTarefa']; ?></label>
          <input type="hidden" class="form-control " name="horaTarefa" id="horaTarefa" value="<?php echo $arResultado['horaTarefa']; ?>">

        </div><br>

        <div class="col-12">
          <button class="btn btn-primary" type="submit">Sim, excluir</button>
          <br><br><a class="btn btn-primary" href="homeCliente.php" role="button">Voltar</a>
        </div>
      </form>
    </div>
  </div>



</body>

</html>