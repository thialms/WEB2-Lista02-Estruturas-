<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $usuarioValido = 'aluno@fatec.edu.br';
    $senhaValida = 'alunoweb2';

    if ($usuario === $usuarioValido && $senha === $senhaValida) {
        $_SESSION['logado'] = true;
        $_SESSION['email_usuario'] = $usuario;
        setcookie('email_usuario', $usuario, time() + (86400 * 7), "/");
        header('Location: main.php'); 
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #4F46E5; 
            --secondary-color: #6B7280; 
            --background-color: #F9FAFB; 
            --error-color: #EF4444; 
        }
    </style>
</head>
<body class="bg-[var(--background-color)] flex items-center justify-center h-screen">
    <div class="bg-white p-10 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-[var(--primary-color)] mb-6">Bem-vindo</h2>
        <p class="text-center text-[var(--secondary-color)] mb-6">Faça login para acessar sua conta</p>
        <?php if (!empty($erro)): ?>
            <p class="text-[var(--error-color)] text-center mb-4"><?php echo $erro; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="usuario" class="block text-[var(--secondary-color)] font-medium mb-2">Usuário</label>
                <input 
                    type="text" 
                    name="usuario" 
                    id="usuario" 
                    placeholder="Digite seu e-mail" 
                    required 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]"
                >
            </div>
            <div class="mb-6">
                <label for="senha" class="block text-[var(--secondary-color)] font-medium mb-2">Senha</label>
                <input 
                    type="password" 
                    name="senha" 
                    id="senha" 
                    placeholder="Digite sua senha" 
                    required 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]"
                >
            </div>
            <button 
                type="submit" 
                class="w-full bg-[var(--primary-color)] text-white p-3 rounded-lg hover:bg-indigo-600 transition"
            >
                Entrar
            </button>
        </form>
    </div>
</body>
</html>