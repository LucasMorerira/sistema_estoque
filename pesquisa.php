<?php
include 'config.php';


$search = isset($_POST['search']) ? $_POST['search'] : '';
$searchType = isset($_POST['search_type']) ? $_POST['search_type'] : '';


$sql = "SELECT * FROM produtos";


if ($searchType === 'all') {
    $search = ''; 
    $searchType = ''; 
} elseif ($search !== '') {
    $search = $conn->real_escape_string($search); 
    if ($searchType === 'id') {
        $sql .= " WHERE id = $search";
    } else {
        $sql .= " WHERE produto LIKE '%$search%'";
    }
}


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> 
    <title>Sistema de Estoque de Produtos</title> 
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
        <h2>Lista de Produtos</h2>

        
        <form method="POST" action="">
            <select name="search_type">
                <option value="name" <?php echo $searchType === 'name' ? 'selected' : ''; ?>>Pesquisar por Nome</option>
                <option value="id" <?php echo $searchType === 'id' ? 'selected' : ''; ?>>Pesquisar por Código (ID)</option>
            </select>
            <input type="text" name="search" placeholder="Digite o valor da pesquisa" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Pesquisar</button>
            <button type="submit" name="search_type" value="all">Mostrar Todos</button>
        </form>

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
                        <td>{$row['id']}</td>
                        <td>{$row['produto']}</td>
                        <td>{$row['fabricante']}</td>
                        <td>{$row['valor']}</td>
                        <td>{$row['quantidade']}</td>
                        <td>{$row['descricao']}</td>
                        <td>
                            <a href='edit_product.php?id={$row['id']}'>Editar</a> | 
                            <a href='#' onclick='confirmDelete({$row['id']})'>Excluir</a>
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

    <script>
        function confirmDelete(id) {
            const userConfirmed = confirm("Deseja realmente excluir este arquivo?");
            if (userConfirmed) {
                window.location.href = "delete_product.php?id=" + id;
            }
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>