<?php

try{
    $conexao = new PDO("mysql:host=localhost; dbname=agendamaster", "usuario", "senha");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
}catch(PDOExcepetion $erro){
    echo "Erro na conexao: ".$erro->getMessage();

}
?>