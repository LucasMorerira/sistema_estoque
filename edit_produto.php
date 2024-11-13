<?php

include 'config.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto = $_POST['produto'];
    $fabricante = $_POST['fabricante'];
    $valor = $_POST['valor'];
    $quantidade = $_POST['quantidade'];
    $descricao = $_POST['descricao'];

    $sql = "UPDATE produtos SET produto='$produto', fabricante='$fabricante', valor='$valor', quantidade='$quantidade', descricao='$descricao' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit(); 
    } else {
        echo "Erro: " . $conn->error;
    }
}

$sql = "SELECT * FROM produtos WHERE id=$id";
$result = $conn->query($sql);
$produto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="styles.css">
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
    <h2>Editar Produto</h2>

      <form method="post" action="">
        <label for="produto">Produto:</label><br>
        <input type="text" name="produto" value="<?php echo $produto['produto']; ?>" required><br><br>
        <label for="fabricante">Fabricante:</label><br>
        <input type="text" name="fabricante" value="<?php echo $produto['fabricante']; ?>" required><br><br>
        <label for="valor">Valor:</label><br>
        <input type="text" name="valor" value="<?php echo $produto['valor']; ?>" required><br><br>
        <label for="quantidade">Quantidade:</label><br>
        <input type="number" name="quantidade" value="<?php echo $produto['quantidade']; ?>" required><br><br>
        <label for="descricao">Descrição:</label><br>
        <textarea name="descricao"><?php echo $produto['descricao']; ?></textarea><br><br>
        <input type="submit" value="Atualizar Produto"><br><br>
    </form>
</main>
<footer>
    <p>&copy; 2024 Sistema de Estoque de Produtos. Todos os direitos reservados.</p>
</footer>
</body>
</html>

<?php
$conn->close();
?>