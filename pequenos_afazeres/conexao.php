<?php
/*
	mysqli_connect(
		SERVIDOR, 
		USUARIO DO BD, 
		SENHA DO USUARIO, 
		NOME DO BD);
	*/
	$conexao = mysqli_connect("localhost", "root", "",  "pequenos_afazeres");
    
	
	if(!$conexao){
		$msg  = "Falha_na_conexao_com_o_BD" . mysqli_connect_error();
		header("Location: index.php?m=$msg");
		exit();
	}
	
	// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}



    $host = "localhost";
	$user = "root";
	$password = "";
	$dbname = "pequenos_afazeres";

	try {
		//Conexão com a porta
		//$conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $password);

		//Conexão sem a porta
		$conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $password);
		//echo "Conexão com banco de dados realizado com sucesso!";
	} catch (PDOException $err) {
		echo "Erro: Conexão com banco de dados não realizado com sucesso. Erro gerado: " . $err->getMessage();
	}

?>