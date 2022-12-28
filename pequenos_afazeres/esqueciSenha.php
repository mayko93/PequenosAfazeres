<?php
//CONEXÃO COM O BANCO DE DADOS
include_once("conexao.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci a senha</title>
    <link rel="shortcut icon" href="imagens/iconepag.ico">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    
    <div style="margin: 10px">
        <h3>Redefinir senha do usuário</h3>
        <div style="margin: 10px">
            <form action="cEsqueciSenha.php" method="POST">

                <div class="col-md-6">

                    <label class="form-label">Digite seu E-mail para redefinir a senha</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Digite o E-mail cadastrado" maxlength="100" required><br><br>

                    <?php
                    if (isset($_GET['m'])) { //existe conteúdo na variável
                        echo $_GET['m']; //imprimindo a msg de erro
                    }

                    ?>

                </div><br>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit" name="recuperarSenha" id="recuperarSenha">Enviar</button>
                    <a class="btn btn-primary" href="login.php" role="button">Voltar</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>