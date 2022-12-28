<?php

define("URL_SERVIDOR","URL_do_servidor_onde_a_aplicação_está_hospedada");

$sandbox = true;
if ($sandbox) {
    define("EMAIL_PAGSEGURO", "seuEmail@gmail.com");
    define("TOKEN_PAGSEGURO", "seuTokenDoPagSeguro");
    define("URL_PAGSEGURO", "https://ws.sandbox.pagseguro.uol.com.br/v2/");
    define("SCRIPT_PAGSEGURO","https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
    define("EMAIL_ESTABELECIMENTO", "seuEmail@gmail.com");
    define("MOEDA_UTILIZADA", "BRL");
    define("URL_NOTIFICACAO", "https://Link_da_pagina_para_onde_o_PagSeguro_irá_retornar_alterações_na_transação");
    define("URL_CONSULTA_TRANSACAO", "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/");
} else {
    define("EMAIL_PAGSEGURO", "seuEmail@gmail.com");
    define("TOKEN_PAGSEGURO", "seuTokenDoPagSeguro");
    define("URL_PAGSEGURO", "https://ws.pagseguro.uol.com.br/v2/");
    define("SCRIPT_PAGSEGURO","https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
    define("EMAIL_ESTABELECIMENTO", "seuEmail@gmail.com");
    define("MOEDA_UTILIZADA", "BRL");
    define("URL_NOTIFICACAO", "https://Link_da_pagina_para_onde_o_PagSeguro_irá_retornar_alterações_na_transação");
    define("URL_CONSULTA_TRANSACAO", "https://ws.pagseguro.uol.com.br/v3/transactions/notifications/");
}

?>