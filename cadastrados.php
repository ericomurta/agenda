<?php
    include "conexao.php";
?>

<h1>Usuarios Cadastrados</h1>

<table border= "1" width="100%">
    <tr>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Cpf</th>
        <th>Telefone</th>
        <th>Acoes</th>
    </tr>
    <?php
    try {

        $stmt = $conexao->prepare("SELECT * FROM agendamaster");

            if($stmt->execute()){
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    echo "<td>". $rs->nome."</td><td>". $rs->email."</td><td>" . $rs->cpf ."</td><td>". $rs->telefone
                                ."</td><td><center><a href=\"?act=upd&id=" . $rs->id . "\">[Alterar]</a>"
                                ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                ."<a href=\"?act=del&id=" . $rs->id ."\">[Excluir]</a></center></td>";
                    echo "</tr>";    
                }
            } else {
                echo "Erro: Nao foi possivel recuperar os dados do banco de dados";
            }

    }catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
    ?>
</table>