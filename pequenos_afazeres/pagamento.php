<?php
//VERIFICAR SE O USUÁRIO ESTÁ LOGADO
//include_once("logado.php");

//RECUPERA O ID DA TAREFA SELECIONADA
$idTarefa = $_GET['id'];

//ARQUIVO DE CONFIGURAÇÃO DO PARA O PAGSEGURO
include("configuracao.php");

//CONECTAR AO BANCO DE DADOS
include_once("conexao.php");

//CRIAR SCRIPT SQL QUE SERÁ EXECUTADO NO SERVIDOR DE BD
//"SELECT * FROM tarefa WHERE id_tarefa = id da Tarefa";
$sql = "SELECT * FROM cliente";
$sql .= " WHERE cpf = " . $_SESSION['user'];

// 4. EXECUTAR SCRIPT SQL
$resultado = mysqli_query($conexao, $sql);

// 5. TRATAR DADOS RECUPERADOS DO BANCO DE DADOS
$arResultado = mysqli_fetch_assoc($resultado);

/* echo "<br>POST resultado: <br>";
var_dump($_POST);
echo "<br>GET resultado: <br>";
var_dump($_GET); */


// 6. FECHAR CONEXÃO COM BANCO DE DADOS 
mysqli_close($conexao);

?>

<!DOCTYPE html>
<html>

<head>
	<title>Pagamento</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="imagens/iconepag.ico">
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<style>
		.selecionarQtdParcelas {
			display: none;
		}
		#aguarde{
			display: none;
		}
	</style>
</head>

<body>
	<div style="margin: 10px">
		<?php
		if (isset($_GET['msg'])) { //existe conteúdo na variável
			echo $_GET['msg'] . "<br>"; //imprimindo a msg de erro
		}
		?>
		<h3>Cadastrar Cartão de Crédito</h3>
		<div style="margin: 10px">
			<form name="formPagamento" id="formPagamento" action="" method="POST">
				<div class="col-md-6">

					<label class="creditCard" style="font-weight:bold ;">Número do cartão</label>
					<br>
					<div class="bandeiraCartao">
						<input type="hidden" name="nomeBandeiraCartao" id="nomeBandeiraCartao">
					</div><span id="msgCartaoInvalido"></span>
					<input type="text" class="form-control" name="numCartao" id="numCartao" minlength="16" maxlength="16" placeholder="Insira o número do cartão">

					<label class="creditCard" style="font-weight:bold ;">Nome do cartão</label>
					<input type="text" class="form-control" name="senderName" id="senderName" maxlength="16" placeholder="Insira o nome conforme está no cartão" value="Mayko Mayko Mayko">

					<label class="creditCard" style="font-weight:bold ;">Mês de Validade:</label>
					<input type="text" name="mesValidade" id="mesValidade" maxlength="2" class="form-control creditCard" placeholder="Insira o mês de validade do cartão" value="12">

					<label class="creditCard" style="font-weight:bold ;">Ano de Validade:</label>
					<input type="text" name="anoValidade" id="anoValidade" maxlength="4" class="form-control creditCard" placeholder="Insira o ano de validade do cartão" value="2030">

					<label class="creditCard" style="font-weight:bold ;">Código de segurança</label>
					<input type="text" class="form-control" name="cvc" id="cvc" maxlength="3" placeholder="Insira o código de segurança" value="123"><br>

					<div class="creditCard col-md-5">
						<select class="form-select selecionarQtdParcelas" name="selectQtdParcelas" id="selectQtdParcelas">
							<option value="">Selecione a quantidade de parcelas</option>
						</select>
					</div>

					<div class="spinner-border text-warning" role="status" name="aguarde" id="aguarde">
					</div>

				</div><br>

				<div>
					<!-- <label>Valor das parcelas </label><br> -->
					<input type="hidden" name="valorParcelas" id="valorParcelas">
				</div>

				<div>
					<!-- <label>quantidade de parcelas sem juros</label><br> -->
					<input type="hidden" name="noInterestInstallmentQuantity" id="noInterestInstallmentQuantity" value="2">
				</div>

				<div>
					<!-- <label>Metodo de pagamento</label><br> -->
					<input type="hidden" name="paymentMethod" id="paymentMethod" value="creditCard">
				</div>

				<div>
					<!-- <label>email loja</label><br> -->
					<input type="hidden" name="receiverEmail" id="receiverEmail" value="<?php echo EMAIL_ESTABELECIMENTO; ?>">
				</div>

				<div>
					<!-- <label>moeda utilizada para pagamento</label><br> -->
					<input type="hidden" name="currency" id="currency" value="<?php echo MOEDA_UTILIZADA; ?>">
				</div>

				<div>
					<!-- <label>taxa extra ou desconto</label><br> -->
					<input type="hidden" name="extraAmount" id="extraAmount" value="">
				</div>

				<div>
					<!-- <label>numero do item</label><br> -->
					<input type="hidden" name="itemId1" id="itemId1" value="0001">
				</div>

				<div>
					<!-- <label>descricao do item</label><br> -->
					<input type="hidden" name="itemDescription1" id="itemDescription1" value="Tarefa solicitada em Pequenos Afazeres">
				</div>

				<div>
					<!-- <label>valor do item</label><br> -->
					<input type="hidden" name="itemAmount1" id="itemAmount1" value="20.00">
				</div>

				<div>
					<!-- <label>valor da compra</label><br> -->
					<input type="hidden" name="amount" id="amount" value="20.00">
				</div>

				<div>
					<!-- <label>quantidade de itens</label><br> -->
					<input type="hidden" name="itemQuantity1" id="itemQuantity1" value="1">
				</div>

				<div>
					<!-- <label>url de notificacao</label><br> -->
					<input type="hidden" name="notificationURL" id="notificationURL" value="<?php echo URL_NOTIFICACAO; ?>">
				</div>

				<div>
					<!-- <label>codigo de referencia</label><br> -->
					<input type="hidden" name="reference" id="reference" value="<?php echo $idTarefa; ?>">
				</div>

				<div>
					<!-- <label>data de nascimento</label><br> -->
					<input type="hidden" name="creditCardHolderBirthDate" id="creditCardHolderBirthDate" value="30/04/1993<?php //echo $arResultado['dataNascimento']; 
																															?>">
				</div>

				<div>
					<!-- <label>CPF (enviar o cpf tambem para creditCardHolderCPF)</label><br> -->
					<input type="hidden" name="senderCPF" id="senderCPF" value="04840096139<?php //echo $arResultado['cpf']; 
																							?>">
				</div>

				<div>
					<!-- <label>DDD</label><br> -->
					<!-- <input type="hidden" name="senderAreaCode" id="senderAreaCode" value="< ? php echo $arResultado['ddd']; ?>"> -->
					<input type="hidden" name="senderAreaCode" id="senderAreaCode" value="61">
				</div>

				<div>
					<!-- <label>telefone</label><br> -->
					<!-- <input type="hidden" name="senderPhone" id="senderPhone" value="< ? php echo $arResultado['telefone']; ?>"> -->
					<input type="hidden" name="senderPhone" id="senderPhone" value="984128814">
				</div>

				<div>
					<!-- <label>email comprador</label><br> -->
					<input type="hidden" name="senderEmail" id="senderEmail" value="c04725188927741019914@sandbox.pagseguro.com.br<?php //echo $arResultado['email']; 
																																	?>">
				</div>

				<div id="urlServidor">
					<!-- <label> url servidor</label><br> -->
					<input type="hidden" name="enderecoServidor" id="enderecoServidor" value="<?php echo URL_SERVIDOR; ?>">
				</div>

				<div id="valorTokenCartao">
					<!-- <label>token cartao</label><br> -->
					<input type="hidden" name="tokenCartao" id="tokenCartao">
				</div>

				<div id="valorHashCartao">
					<!-- <label>hash cartao</label><br> -->
					<input type="hidden" name="hashCartao" id="hashCartao">
				</div>

				<!--endereco-->
				<input type="hidden" name="billingAddressPostalCode" id="billingAddressPostalCode" value="01452002">

				<input type="hidden" name="billingAddressState" id="billingAddressState" value="DF">

				<input type="hidden" name="billingAddressCity" id="billingAddressCity" value="Brasilia">

				<input type="hidden" name="billingAddressDistrict" id="billingAddressDistrict" value="Guara">

				<input type="hidden" name="billingAddressComplement" id="billingAddressComplement" value="Lucio Costa">

				<input type="hidden" name="billingAddressNumber" id="billingAddressNumber" value="30">

				<input type="hidden" name="billingAddressStreet" id="billingAddressStreet" value="Avenida X">

				<input type="hidden" name="billingAddressCountry" id="billingAddressCountry" value="Brasil">

				<!--DIV com os botoes-->
				<div class="col-12">
					<button class="btn btn-primary" name="btnConfirmar" id="btnConfirmar" type="submit">Confirmar</button>
					<button class="btn btn-primary" type="reset">Limpar campos</button>
					<a class="btn btn-primary" href="homeCliente.php" role="button">Voltar</a>
				</div><br>

				<div id="bandeirasDisponiveis">
					<h4>Bandeiras Disponíveis</h4>
					<div class="meio-pagamento"></div>
				</div>

			</form>

			<br>
		</div>
	</div>

	<script src="js/jquery-3.6.1.min.js"></script>
	<script type="text/javascript" src="<?php echo SCRIPT_PAGSEGURO; ?>"></script>
	<script src="js/funcoesProc.js"></script>

</body>

</html>