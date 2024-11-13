<?php

include 'config.php';
session_start();


if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}


$sql = "SELECT * FROM produtos";


$result = $conn->query($sql); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> 
    <title>Sistema de Estoque de Produtos</title> 
    <link rel="stylesheet" href="styles.css"> 

    <script>
        function confirmDelete(id) {
            if (confirm("Deseja realmente excluir este arquivo?")) {
                window.location.href = "delete_product.php?id=" + id;
            }
        }
    </script>
</head>
<body>

    <header>
        <h1>Sistema de Estoque de Produtos</h1> 
    </header>
    <nav>
        <a href="index.php">Home</a> 
        <a href="add_product.php">Cadastro de Produto</a> 
        <a href="pesquisa.php">Pesquisa</a> 
        <a href="logout.php">Sair</a>
    </nav>

    <main>
        <h2>Lista de Produtos</h2> 
        <table>
            <tr>
                <th>ID</th>
                <th>Produto</th> 
                <th>Fabricante</th>
                <th>Valor</th> 
                <th>Quantidade</th> 
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
            <?php
            if ($result->num_rows > 0) { 
                while($row = $result->fetch_assoc()) { 
                    
                    echo "<tr>
                        <td>{$row['id']}</td> <!-- Exibe o ID do produto. -->
                        <td>{$row['produto']}</td> <!-- Exibe o nome do produto. -->
                        <td>{$row['fabricante']}</td> <!-- Exibe o fabricante do produto. -->
                        <td>{$row['valor']}</td> <!-- Exibe o valor do produto. -->
                        <td>{$row['quantidade']}</td> <!-- Exibe a quantidade em estoque do produto. -->
                        <td>{$row['descricao']}</td> <!-- Exibe a descrição do produto. -->
                        <td>
                            <a href='edit_product.php?id={$row['id']}'>Editar</a> | <!-- Link para editar o produto, passando o ID como parâmetro. -->
                            <a href='#' onclick='confirmDelete({$row['id']})'>Excluir</a> <!-- Link para excluir o produto, passando o ID como parâmetro. -->
                        </td>
                    </tr>";
                }
            } else {
               
                echo "<tr><td colspan='7'>Nenhum produto encontrado</td></tr>";
            }
            ?>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Estoque de Produtos. Todos os direitos reservados.</p> 
    </footer>
</body>
</html>

<?php $conn->close(); ?> 