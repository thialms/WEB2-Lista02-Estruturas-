<?php
session_start();

if (!isset($_SESSION['logado']) || !$_SESSION['logado']) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['sair'])) {
    session_destroy();
    setcookie('email_usuario', '', time() - 3600, '/'); 
    header('Location: login.php');
    exit;
}

function carregarProdutos()
{
    $url = 'https://fakestoreapi.com/products';
    $dados = file_get_contents($url);
    if ($dados === false) {
        echo "Erro ao carregar os produtos.";
        return [];
    }
    return json_decode($dados, true);
}

$produtos = carregarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #4F46E5; 
            --secondary-color: #6B7280; 
            --background-color: #F9FAFB; 
            --error-color: #EF4444; 
            --success-color: #10B981; 
        }
    </style>
</head>

<body class="bg-[var(--background-color)] min-h-screen">
    <header class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-[var(--primary-color)]">Bem-vindo, <?php echo htmlspecialchars($_SESSION['email_usuario']); ?>!</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="main.php" class="text-[var(--primary-color)] hover:underline">Mega-Sena</a>
                <a href="?sair=true" class="bg-[var(--error-color)] text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Sair</a>
            </div>
        </div>
    </header>

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center text-[var(--primary-color)] mb-8">Loja Online</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($produtos as $produto): ?>
                <div class="bg-white p-4 rounded-lg shadow-lg flex flex-col justify-between">
                    <img src="<?php echo htmlspecialchars($produto['image']); ?>" alt="<?php echo htmlspecialchars($produto['title']); ?>" class="w-full h-48 object-contain mb-4">
                    <h2 class="text-lg font-bold text-[var(--primary-color)] mb-2"><?php echo htmlspecialchars($produto['title']); ?></h2>
                    <p class="text-[var(--secondary-color)] mb-4"><?php echo htmlspecialchars(substr($produto['description'], 0, 100)) . '...'; ?></p>
                    <p class="text-lg font-bold text-[var(--success-color)] mb-4">R$ <?php echo number_format($produto['price'], 2, ',', '.'); ?></p>
                    <form method="POST" action="checkout.php">
                        <input type="hidden" name="produto" value="<?php echo htmlspecialchars($produto['title']); ?>">
                        <button type="submit" class="w-full bg-[var(--primary-color)] text-white py-2 rounded-lg hover:bg-indigo-600 transition">Comprar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>