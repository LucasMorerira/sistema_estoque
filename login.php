<?php
include'config.php';
session_start();

if(isset($_SESSION['username'])) {
    header('Location:index.php');
    exit();
}

$error='';

if($_SERVER['REQUEST_METHOD']==='POST') {
    $username= $_POST['username'];
    $passoword= $_POST['passoword'];

    $stmt=$conn->prepare("SELECT passoword FROM usuario WHERE username=?");
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($store_passowrd);

    if($stmt->num_rows===1){
        $stmt->fetch();
        if($passoword === $store_passowrd){
            $_SESSION['username']=$username;
            header('Location:index.php');
            exit();
        } else {
            $error='usuário ou Senha Incorretos.';
        }
    }else{
        $error='Usuário não encontrado.';
    }

    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Estoque de Produtos</title>
    <link rel="stylesheet" href="loginstyles.css">
</head>
<body>
    <main>
        <header>
            <img src="LOGOlegal.webp" alt="LOGO" style="width: 100px; height: auto;">
            <h1>Sistema de Estoque de Produtos</h1>
        </header>
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Entrar</button>
        </form>
        <p><a href="cadastro_usuario.php">Crie seu cadastro</a></p>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Estoque de Produtos. Todos os direitos reservados.</p>
    </footer>
</body>
</html>