<?php
//1. RECUPERAR DADOS DO FORMULÁRIO
$email = $_POST['email'];
$recuperarSenha = $_POST['recuperarSenha'];

//2. CONECTAR AO SERVIDOR DE BANCO DE DADOS
include_once("conexao.php");

include_once("configuracao.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './lib/vendor/autoload.php';
$mail = new PHPMailer(true);


$dados = filter_input_array
(INPUT_POST, FILTER_DEFAULT);
if (!empty($dados['email'])) {
    var_dump($dados);

    // CRIAR SCRIPT SQL QUE SERÁ EXECUTADO NO BANCO DE DADOS
    $sql = "SELECT id_cliente, nome, email 
                FROM cliente 
                WHERE email =:email  
                LIMIT 1";
    $resultado = $conn->prepare($sql);
    $resultado->bindParam(':email', $dados['email'], PDO::PARAM_STR);
    $resultado->execute();

    if (($resultado) and ($resultado->rowCount() != 0)) {
        $row_usuario = $resultado->fetch(PDO::FETCH_ASSOC);
        $chave_recuperar_senha = password_hash($row_usuario['id_cliente'], PASSWORD_DEFAULT);
        echo "Chave $chave_recuperar_senha <br>";

        $query_up_usuario = "UPDATE cliente 
                    SET recuperar_senha =:recuperar_senha 
                    WHERE id_cliente =:id_cliente 
                    LIMIT 1";
        $result_up_usuario = $conn->prepare($query_up_usuario);
        $result_up_usuario->bindParam(':recuperar_senha', $chave_recuperar_senha, PDO::PARAM_STR);
        $result_up_usuario->bindParam(':id_cliente', $row_usuario['id_cliente'], PDO::PARAM_INT);

        if ($result_up_usuario->execute()) {
            $link = URL_SERVIDOR . "novaSenha.php?chave=$chave_recuperar_senha";

            try {
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->CharSet = 'UTF-8';
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'pequenosafazeres@gmail.com';
                $mail->Password   = 'jsodrtwhhkontuvo';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('pequenosafazeres@gmail.com');
                $mail->addAddress($row_usuario['email'], $row_usuario['nome']);

                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Recuperar senha';
                $mail->Body    = 'Prezado(a) ' . $row_usuario['nome'] . ".<br><br>Você solicitou alteração de senha.<br><br>Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: <br><br><a href='" . $link . "'>" . $link . "</a><br><br>Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";
                $mail->AltBody = 'Prezado(a) ' . $row_usuario['nome'] . "\n\nVocê solicitou alteração de senha.\n\nPara continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: \n\n" . $link . "\n\nSe você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.\n\n";

                $mail->send();

                $msg = "<p style='color: green'>Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</p>";
                header("Location: login.php");
            } catch (Exception $e) {
                echo "Erro: E-mail não enviado sucesso. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo  "<p style='color: #ff0000'>Erro: Tente novamente!</p>";
        }
    } else {
        echo "<p style='color: #ff0000'>Erro: Usuário não encontrado!</p>";
    }
}