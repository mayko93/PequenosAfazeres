<?php
//VERIFICAR SE O USUÁRIO ESTÁ LOGADO
include_once("logado.php");
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
        <h2 class="d-flex justify-content-center">Nova Tarefa</h2>

        <?php
        if (isset($_GET['m'])) { //existe conteúdo na variável
            echo $_GET['m'] . "<br>"; //imprimindo a msg de erro
        }

        ?>

        <form action="cNovaTarefa.php" method="POST">
            <h3 style="color: red;">** As tarefas tem o valor fixo de R$20,00 independente do tipo **</h3>
            <div>
                <label class="form-label" style="font-size: 20px ; font-weight:bold ;">CPF:</label>
                <input type="text" class="form-control" name="cpfTarefa" id="cpfTarefa" minlength="11" maxlength="11" placeholder="Digite seu CPF" required>

            </div><br>

            <div>
                <label style="font-size: 20px ; font-weight:bold ;" class="form-label">Selecione o tipo de tarefa desejada:</label><br>

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
                <input type="text" class="form-control" name="enderecoColeta" id="enderecoColeta" placeholder="Digite o endereço de onde o pacote será coletado" maxlength="100" required>
            </div><br>

            <div>
                <label style="font-size: 20px ; font-weight:bold ;" class="form-label">Endereço de entrega:</label>
                <input type="text" class="form-control" name="enderecoEntrega" id="enderecoEntrega" placeholder="Digite o endereço de onde o pacote será entregue" maxlength="100" required>
            </div><br>

            <div>
                <label style="font-size: 20px ; font-weight:bold ;" class="form-label">Informe a data que será feita a tarefa:</label><br>
                <input type="date" name="dataTarefa" id="dataTarefa">
            </div><br>

            <div>
                <label style="font-size: 20px ; font-weight:bold ;" class="form-label">Informe a hora que será feita a tarefa:</label><br>
                <input type="time" name="horaTarefa" id="horaTarefa"><br>
                <small>Lembrando que caso deseje alterar ou cancelar, existe um prazo mínimo de 1 hora de antecedência ao horário selecionado</small>
            </div><br>

            <div>
                <input type="hidden" name="statusTarefa" id="statusTarefa" value="pendente">
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Solicitar</button>
                <button class="btn btn-primary" type="reset">Limpar campos</button>
            </div>

        </form>
        <br><br><a class="btn btn-primary" href="homeCliente.php" role="button">Cancelar Solicitação</a>

    </div>

</body>

</html>