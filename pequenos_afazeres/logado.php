<?php

session_start();
if (!$_SESSION['LOGADO'] == true) {
    $msg = "<span style='font-size: 30px ; font-weight:bold ; color:red'>Para_acessar_esta_página,_é_necessário_estar_logado</span>";
    header("Location: login.php?m=$msg");
    exit();
}
?>