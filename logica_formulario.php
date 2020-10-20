<?php
//VERIFICACAO POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = (isset($_POST["id"]) && $_POST["id"] !=null) ? $_POST["id"] : "";
    $nome= (isset($_POST["nome"]) && $_POST["nome"] !=null) ? $_POST["nome"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
    $cpf = (isset($_POST["cpf"])&& $_POST["cpf"] !=null) ? $_POST["cpf"] : "";
    $telefone = (isset($_POST["telefone"]) && $_POST["telefone"] != null) ? $_POST["telefone"] : "";
} else if (!isset($id)){
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = null;
    $email = null;
    $cpf = null;
    $telefone = null;
     
}?>
<?php
include "conexao.php";
?>
<?php
// CREATE E UPDATE
if(isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome !=""){
    try{
        if($id != "") {
            $stmt = $conexao->prepare("UPDATE agendamaster SET nome=?, email=?, cpf=?, telefone=?
            WHERE id = ?");
            $stmt->bindParam(5, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO agendamaster (nome, email, cpf, telefone) VALUES (?, ?, ?, ?)");
        }
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $cpf);
        $stmt->bindParam(4, $telefone);

        if($stmt->execute()) {
            if($stmt->rowcount() > 0) {
                echo "Dados cadastrados Com sucesso";
                $id = null;
                $nome = null;
                $email = null;
                $cpf= null;
                $telefone = null;
            } else {
                echo "Erro ao tentar efetivar cadastro";
            }
        } else {
            throw new PDOException("Erro: Nao foi possivel executar a declaracao sql");
        }    
    }catch (PDOException $erro) {
        echo " Erro" .$erro->getMessage();
    }
}


// RECUPERACAO_UPDATE

if(isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    try {

        $stmt = $conexao->prepare("SELECT * FROM agendamaster WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $nome = $rs->nome;
            $email =$rs->email;
            $cpf = $rs->cpf;
            $telefone = $rs->telefone;
        } else {
            throw new PDOException("Erro: Nao foi possivel executar a declaracao sql");
        }
        } catch(PDOException $erro) {
            echo "Erro: " .$erro->getMessage();
    }
}

//Bloco delete

if(isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != ""){
    try{
        $stmt = $conexao->prepare("DELETE FROM agendamaster WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Registro foi excluid com exito";
            $id = null;
        }else {
            throw new PDOException ("Erro: Nao foi possivel executar a declaracao SQL");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

?>

<!-- Formulario de Cadastro -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agenda de contatos</title>
    </head>
    <body>
        <form action="?act=save" method="POST" name="form1" >
          <h1>Agenda de contatos</h1>
          <hr>
          <input type="hidden" name="id" <?php
          // Preenche o id no campo id com um valor "value"
          if (isset($id) && $id != null || $id !=""){
              echo "value=\"{$id}\""; 
          }
          ?>/>
          Nome:
          <input type="text" name="nome" <?php
          // Preenche o nome no campo nome com um valor "value"
          if (isset($nome) && $nome != null || $nome !=""){
              echo "value=\"{$nome}\""; 
          }
          ?>/>
          E-mail:
          <input type="text" name="email"<?php 
          // Preenche o email no campo email com um valor "value"
          if (isset($email) && $email != null || $email !=""){
              echo "value=\"{$email}\"";          
        }   
         ?>/>
          Cpf:
         <input type="text" name="cpf" <?php
          // Preenche o celular no campo celular
          if (isset($cpf) && $cpf != null || $cpf !=""){
              echo "value=\"{$cpf}\"";
          }
         ?>/>
         Telefone:
         <input type="text" name="telefone" <?php
          // Preenche o celular no campo celular
          if (isset($telefone) && $telefone != null || $telefone !=""){
              echo "value=\"{$telefone}\"";
          }
          ?>>

         <input type="submit" value="salvar" />
         <input type="reset" value="Novo" />
         <hr>
       </form>
    </body>
</html>
