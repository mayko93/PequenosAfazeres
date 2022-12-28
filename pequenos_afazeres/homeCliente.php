<?php
//VERIFICAR SE O USUÁRIO ESTÁ LOGADO
include_once("logado.php");

// 2. CONECTAR AO BANCO DE DADOS
include_once("conexao.php");

// 3. CRIAR SCRIPT SQL
$sql = "SELECT * FROM tarefa";

if ($_SESSION['perfil'] != "ADM") {
    $sql .= " WHERE cpfTarefa = '" . $_SESSION['user'] . "'; ";
}

// 4. EXECUTAR SCRIPT SQL
$resultado = mysqli_query($conexao, $sql);

// 5. TRATAR DADOS RECUPERADOS DO BANCO DE DADOS
$arResultado = mysqli_fetch_assoc($resultado);

// 6. FECHAR CONEXÃO COM BANCO DE DADOS
mysqli_close($conexao);

/* echo "<br>POST resultado: <br>";
var_dump($_POST);
echo "<br>GET resultado: <br>";
var_dump($_GET); */
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Cliente</title>
    <link rel="shortcut icon" href="imagens/iconepag.ico">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Página inicial</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Trocar de usuário</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="novaTarefa.php">Nova tarefa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Sair</a>
                        </li>
                    </ul>

                </div>
        </nav>
    </div>

    <div class="col-md-12 " style="margin: 1% ;">
        <div class="d-flex justify-content-center"><br />
            <h3>Minhas Tarefas</h3>
        </div>
        <table class="table table-striped table-hover border-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Código da Tarefa</th>
                    <th scope="col">Tarefa</th>
                    <th scope="col">Local de coleta</th>
                    <th scope="col">Local de entrega</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Status Pagamento</th>
                    <th scope="col" colspan="2">Açoes</th>
                    <!--
                    NOVA TAREFA COM ICONE +    
                    <th><a class="nav-link" href="novaTarefa.php">Nova tarefa <img src="imagens/mais.jpg" class="img-fluid rounded-start" alt="..."></a></th>-->
                </tr>
            </thead>

            <?php

            do {

            ?>

                <tbody>
                    <tr scope="row"><?php //if(isset($arResultado['id_tarefa'])){ echo $arResultado['id_tarefa'];}else{echo "Ops! Solicite uma tarefa.";}  
                                    ?>
                        <td scope="row"><?php if (isset($arResultado['id_tarefa'])) {
                                            echo $arResultado['id_tarefa'];
                                        } else {
                                            echo "Ops! Solicite uma tarefa.";
                                        }  ?></td>

                        <td><?php if (isset($arResultado['tipoTarefa'])) {
                                echo $arResultado['tipoTarefa'];
                            } else {
                                echo "Tipo de tarefa não cadastrado";
                            }  ?></td>

                        <td><?php if (isset($arResultado['enderecoColeta'])) {
                                echo $arResultado['enderecoColeta'];
                            } else {
                                echo "Endereço de coleta não cadastrado";
                            }  ?></td>

                        <td><?php if (isset($arResultado['enderecoEntrega'])) {
                                echo $arResultado['enderecoEntrega'];
                            } else {
                                echo "Endereço de entrega não cadastrado";
                            }  ?></td>

                        <td><?php if (isset($arResultado['dataTarefa'])) {
                                $dataNascimento = $arResultado['dataTarefa'];
                                $result = explode('-', $dataNascimento);
                                $ano = $result[0];
                                $mes = $result[1];
                                $dia = $result[2];
                                echo $dia . "/" . $mes . "/" . $ano;
                            } else {
                                echo "Data não cadastrada";
                            }  ?></td>

                        <td><?php if (isset($arResultado['horaTarefa'])) {
                                echo $arResultado['horaTarefa'];
                            } else {
                                echo "Horário não cadastrado";
                            }  ?></td>

                        <td><?php
                            if (isset($arResultado['id_tarefa'])) {
                                $idTarefa = $arResultado['id_tarefa'];
                            }
                            if (isset($arResultado['statusTarefa'])) {
                                if (($arResultado['statusTarefa']) == "") {
                                    echo " <a class='btn btn-outline-light' style='background-color: #a70000 ; border-color: #412730;' href='pagamento.php?id=$idTarefa'>Pagar</a>";
                                } else if (($arResultado['statusTarefa']) == "1") {
                                    echo "<span style='color: red; font-weight:bold ;'>Aguardando pagamento</span>";
                                } else if (($arResultado['statusTarefa']) == "2") {
                                    echo "<span style='color: red; font-weight:bold ;'>Em análise</span>";
                                } else if (($arResultado['statusTarefa']) == "3") {
                                    echo "<span style='color: green; font-weight:bold ;'>Paga</span>";
                                } else if (($arResultado['statusTarefa']) == "4") {
                                    echo "<span style='color: red; font-weight:bold ;'>Disponível</span>";
                                } else if (($arResultado['statusTarefa']) == "5") {
                                    echo "<span style='color: red; font-weight:bold ;'>Em disputa</span>";
                                } else if (($arResultado['statusTarefa']) == "6") {
                                    echo "<span style='color: red; font-weight:bold ;'>Devolvida</span>";
                                } else if (($arResultado['statusTarefa']) == "7") {
                                    echo "<span style='color: red; font-weight:bold ;'>Cancelada</span>";
                                } else if (($arResultado['statusTarefa']) == "8") {
                                    echo "<span style='color: red; font-weight:bold ;'>Debitado</span>";
                                } else if (($arResultado['statusTarefa']) == "9") {
                                    echo "<span style='color: red; font-weight:bold ;'>Retenção temporária</span>";
                                }
                            } ?></td>

                        <td>
                            <a href="editar.php?id=<?php echo $arResultado['id_tarefa']; ?>">Editar</a>
                        </td>

                        <td>
                            <a href="excluir.php?id=<?php echo $arResultado['id_tarefa'] ?>">Excluir

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                </svg>

                            </a>
                        </td>
                    </tr>
                </tbody>

            <?php
            } while ($arResultado = mysqli_fetch_assoc($resultado));
            ?>
        </table>

    </div>

</body>

</html>