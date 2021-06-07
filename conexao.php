<?php
Class Dados{
    public $msgErro = "";

    public function conectar($nomedb, $host, $usuario, $senhadb){
        global $pdo;
        global $msgErro;

        try{
            $pdo = new PDO("mysql:dbname=".$nomedb.";host=".$host, $usuario, $senhadb);
        } catch (PDOException $e){
            $msgErro = $e->getMessage();
            throw new PDOException($e);
        }
    }
}
?>

<html>
<head>
<title>Rubiana Perucci</title>
</head>
<body>
<?php
$u = new Dados();
$u->conectar("teste","_____","_____","_____"); //Substituir os underlines pelos respectivos Host Name, User Name e Senha
    if($u->msgErro == ""){
        $sql = $pdo->prepare("SELECT usuarios.nome as 'Nome', grupos.nome as 'Grupo' FROM grupos INNER JOIN (usuarios INNER JOIN usuarios_grupos ON usuarios.id = usuarios_grupos.usuario_id) ON grupos.id = usuarios_grupos.grupo_id");
        $sql->execute(); 

        if($sql->rowCount() > 0) {
            ?><table>
                <thead>
                    <tr>
                    <th>Nome</th>
                    <th>Grupo</th>
                    </tr>
                </thead><tr><?php ;
            while ( $row = $sql->fetch(PDO::FETCH_ASSOC)):            
                ?> <tr> <?php ;
                ?> <td><?php echo $row['Nome'] ?></td><?php ;
                ?> <td><?php echo $row['Grupo'] ?></td><?php ;
                ?> </tr><?php ;
            endwhile;
            ?></table><?php ;
        }
    }else{
        echo $msgErro;
    }
?>
<style>
* {
    margin: 0px;
    padding: 0px;
    font-family: Arial, Helvetica, sans-serif;
}

table {
    width: 70%;
    margin: 3% auto;
    text-align: left;
}

table,
th,
td {
    border: thin solid #c4c4c4;
    border-collapse: collapse;
}

th,
td {
    padding: 1%;
}

tr {
    display: grid;
    grid-template-columns: 1fr 2fr;
}

tr:nth-child(odd) {
    background-color: #f2f2f2;
}   
</style>

</body>
</html>
