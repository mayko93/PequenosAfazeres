<!DOCTYPE html>
<html>

<head>
	<title>Login</title>
	<link rel="shortcut icon" href="imagens/iconepag.ico">
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
	<div style="margin: 10px">
		<h3>Login de Usuário</h3>
		<div style="margin: 10px">
			<form action="cLogin.php" method="POST">
				<div class="col-md-6">

					<label class="form-label">CPF</label>
					<input type="text" class="form-control" name="user" id="cpf" placeholder="Digite seu CPF" minlength="11" maxlength="11" required>

					<label class="form-label">Senha</label>
					<input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha" required>

				</div><br>

				<?php
				if (isset($_GET['m'])) { //existe conteúdo na variável
					echo $_GET['m'] . "<br>"; //imprimindo a msg de erro
				}

				?>


				<div class="col-12">
					<button class="btn btn-primary" type="submit">Login</button>
					<button class="btn btn-primary" type="reset">Limpar campos</button>
				</div>
			</form>
			<label class="form-label"><b>Esqueceu a senha?</b></label><br>
			<a class="btn btn-danger" href="esqueciSenha.php">Recuperar senha</a>
			<br>

			<br>
			<label class="form-label"><b>Ainda não é cadastrado?</b></label><br>
			<a class="btn btn-warning" href="cadastrar.php">Fazer cadastro</a>
		</div>
	</div>
</body>

</html>