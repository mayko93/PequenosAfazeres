<?php



?>

<!DOCTYPE html>
<html>

<head>
	<title>USUÁRIO</title>
	<link rel="shortcut icon" href="imagens/iconepag.ico">
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
	<div style="margin: 10px">
		<h3>Cadastrar Usuário</h3>

		<?php
		if (isset($_GET['m'])) { //existe conteúdo na variável
			echo $_GET['m'] . "<br>"; //imprimindo a msg de erro
		}

		?>

		<div style="margin: 10px">
			<form action="cCadastrar.php" method="POST">
				<div class="col-md-6">

					<label class="form-label">Nome</label>
					<input type="text" name="nome" id="nome" placeholder="Digite seu nome completo" class="form-control" required>

					<label class="form-label">CPF</label>
					<input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite seu CPF" maxlength="11" minlength="11" required>

					<label class="form-label">Data de nascimento</label>
					<input type="date" name="dataNascimento" id="dataNascimento" required>

					<input type="hidden" name="ddd" id="ddd" value="61">

					<label class="form-label">Telefone</label>
					<input type="text" class="form-control" name="telefone" id="telefone" placeholder="Somente números" minlength="9" maxlength="9" required>

					<label class="form-label">Endereço</label>
					<input type="text" class="form-control" name="endereco" id="endereco" placeholder="Digite seu Endereço" required>

					<label class="form-label">E-mail</label>
					<input type="email" class="form-control" name="email" id="email" placeholder="Digite um E-mail válido" required>
					<small>ATENÇÃO! Este será o email ultilizado para recuperar senha.</small>

					<label class="form-label">Senha</label>
					<input type="password" class="form-control" name="senha" id="senha" placeholder="Crie uma senha" required>

					<label class="form-label">Confirme a senha</label>
					<input type="password" class="form-control" name="cSenha" id="cSenha" placeholder="Digite a senha novamente" required><br><br>
				</div><br>

				<div class="col-12">
					<button class="btn btn-primary" type="submit">Cadastrar</button>
					<button class="btn btn-primary" type="reset">Limpar campos</button>

				</div>

				<div>
					<input type="hidden" name="perfilUsuario" id="perfilUsuario" value="USU">
				</div>
			</form>
			<br>
			<label class="form-label"><b>Já é cadastrado?</b></label><br>
			<a class="btn btn-warning" href="login.php">Fazer login</a>
		</div>
	</div>
</body>

</html>