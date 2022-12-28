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
    <title>Tarefas</title>
    <link rel="shortcut icon" href="imagens/iconepag.ico">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>

    <div class="col-md-6" style="margin: 1%; ">
        <h2 class="d-flex justify-content-center">Editar Tarefa</h2>
        <form action="cEditar.php" method="POST">
            
        <div>            
            <label style="font-size: 30px ; font-weight:bold ; color:orange" class="form-label">Editando tarefa com o código: <?php echo $arResultado['id_tarefa']; ?></label>
            <input type="hidden" name="id" id="id" value=" <?php echo $arResultado['id_tarefa']; ?> "><br/>

            <div>
                <label style="font-size: 20px ; font-weight:bold ;" class="form-label">Selecione o novo tipo de tarefa:</label><br>

                <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoTarefa" id="entregar" value="Entregar">
                <label class="form-check-label">
                    Entregar
                </label>
            </div><br>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="tipoTarefa" id="Comprar" value="Buscar">
                <label class="form-check-label">
                    Buscar
                </label>
            </div><br>
            </div>

            <div>
                <label style="font-size: 20px ; font-weight:bold ;" class="form-label">Endereço de coleta:</label>
                <input type="text" class="form-control" name="enderecoColeta" id="enderecoColeta" placeholder="Digite o endereço de onde o pacote será coletado" value="<?php if(isset($arResultado['enderecoColeta'])){ echo $arResultado['enderecoColeta'];}else{echo "";}  ?>" maxlength="100" required>
            </div><br>

            <div>
                <label style="font-size: 20px ; font-weight:bold ;" class="form-label">Endereço de entrega:</label>
                <input type="text" class="form-control" name="enderecoEntrega" id="enderecoEntrega" placeholder="Digite o endereço de onde o pacote será entregue" value="<?php if(isset($arResultado['enderecoEntrega'])){ echo $arResultado['enderecoEntrega'];}else{echo "";}  ?>" maxlength="100" required>
            </div><br>

            <div>
                <label style="font-size: 20px ; font-weight:bold ;" class="form-label">Informe a data que será feita a tarefa:</label><br>
                <input type="date" name="dataTarefa" id="dataTarefa" value="<?php if(isset($arResultado['dataTarefa'])){ echo $arResultado['dataTarefa'];}else{echo "";}  ?>">
            </div><br>

            <div>
                <label style="font-size: 20px ; font-weight:bold ;" class="form-label">Informe a hora que será feita a tarefa:</label><br>
                <input type="time" name="horaTarefa" id="horaTarefa" value="<?php if(isset($arResultado['horaTarefa'])){ echo $arResultado['horaTarefa'];}else{echo "";}  ?>"><br>
                <small>Lembrando que caso deseje alterar ou cancelar, existe um prazo mínimo de 1 hora de antecedência ao horário selecionado</small>
            </div><br>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Editar</button>
                <button class="btn btn-primary" type="reset">Limpar campos</button>


            </div>
        </form>
        <br><br><a class="btn btn-primary" href="homeCliente.php" role="button">Cancelar Edição</a>
        
    </div>

</body>

</html>