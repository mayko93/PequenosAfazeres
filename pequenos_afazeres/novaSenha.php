<?php

include_once("conexao.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova senha</title>
    <link rel="shortcut icon" href="imagens/iconepag.ico">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>

    <?php

    $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);


    if (!empty($chave)) {
        //echo "<br><br>var_dump da chave: "; var_dump($chave);

        $query_usuario = "SELECT id_cliente 
                            FROM cliente 
                            WHERE recuperar_senha =:recuperar_senha  
                            LIMIT 1";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bindParam(':recuperar_senha', $chave, PDO::PARAM_STR);
        $result_usuario->execute();

        if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            //var_dump($dados);
            if (!empty($dados['atualizarSenha'])) {
                $senha = md5($dados['novaSenha']);
                $recuperar_senha = '';

                $query_up_usuario = "UPDATE cliente 
                        SET senha =:senha,
                        recuperar_senha =:recuperar_senha
                        WHERE id_cliente =:id_cliente 
                        LIMIT 1";
                $result_up_usuario = $conn->prepare($query_up_usuario);
                $result_up_usuario->bindParam(':senha', $senha, PDO::PARAM_STR);
                $result_up_usuario->bindParam(':recuperar_senha', $recuperar_senha);
                $result_up_usuario->bindParam(':id_cliente', $row_usuario['id_cliente'], PDO::PARAM_INT);

                if ($result_up_usuario->execute()) {
                    $msg = "<p style='color: green'>Senha atualizada com sucesso!</p>";
                    header("Location: login.php?m=$msg");
                } else {
                    $msg = "<p style='color: #ff0000'>Erro: Tente novamente!</p>";
                    header("Location: login.php?m=$msg");
                }
            }
        }
    }

    ?>

    <div style="margin: 10px">
        <h3>Atualizar senha do usuário</h3>
        <div style="margin: 10px">
            <form action="" method="POST">

                <?php
                if (isset($_GET['m'])) { //existe conteúdo na variável
                    echo $_GET['m'] . "<br>"; //imprimindo a msg de erro
                }

                ?>
                <?php
                $usuario = "";
                if (isset($dados['senha_usuario'])) {
                    $usuario = $dados['senha_usuario'];
                } ?>

                <div class="col-md-6">
                    <label class="form-label">Digite uma nova senha</label>
                    <input type="password" class="form-control" name="novaSenha" id="novaSenha" placeholder="Digite uma nova senha para login" maxlength="100" required>
                </div><br>

                <div class="col-12">
                    <input class="btn btn-primary" type="submit" name="atualizarSenha" id="atualizarSenha" value="Atualizar">
                    <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>