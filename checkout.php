<?php
session_start();

if (!isset($_SESSION['logado']) || !$_SESSION['logado']) {
    header('Location: login.php');
    exit;
}

if (!isset($_POST['produto']) && !isset($_SESSION['produto'])) {
    header('Location: loja.php');
    exit;
}

if (isset($_POST['produto'])) {
    $_SESSION['produto'] = htmlspecialchars($_POST['produto']);
}

$produto = $_SESSION['produto'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cep'], $_POST['endereco'], $_POST['metodo_pagamento'])) {
    $cep = htmlspecialchars($_POST['cep']);
    $endereco = htmlspecialchars($_POST['endereco']);
    $metodo_pagamento = htmlspecialchars($_POST['metodo_pagamento']);

    header('Location: loja.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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

<body class="bg-[var(--background-color)] min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold text-center text-[var(--primary-color)] mb-6">Finalizar Compra</h1>
        <p class="text-center text-[var(--secondary-color)] mb-6">Você está comprando: <strong><?php echo $produto; ?></strong></p>
        <form method="POST" action="" class="space-y-4">
            <div>
                <label for="cep" class="block text-[var(--secondary-color)] font-medium mb-2">CEP</label>
                <input type="text" name="cep" id="cep" placeholder="Digite seu CEP" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]">
            </div>

            <div>
                <label for="endereco" class="block text-[var(--secondary-color)] font-medium mb-2">Endereço</label>
                <input type="text" name="endereco" id="endereco" placeholder="Digite seu endereço completo" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]">
            </div>

            <div>
                <label class="block text-[var(--secondary-color)] font-medium mb-2">Método de Pagamento</label>
                <div class="space-y-2">
                    <div>
                        <input type="radio" name="metodo_pagamento" id="cartao_credito" value="Cartão de Crédito" required>
                        <label for="cartao_credito" class="text-[var(--secondary-color)]">Cartão de Crédito</label>
                    </div>
                    <div>
                        <input type="radio" name="metodo_pagamento" id="boleto" value="Boleto Bancário">
                        <label for="boleto" class="text-[var(--secondary-color)]">Boleto Bancário</label>
                    </div>
                    <div>
                        <input type="radio" name="metodo_pagamento" id="pix" value="PIX">
                        <label for="pix" class="text-[var(--secondary-color)]">PIX</label>
                    </div>
                </div>
            </div>

            <input type="hidden" name="produto" value="<?php echo $produto; ?>">

            <button type="submit" class="w-full bg-[var(--primary-color)] text-white py-3 rounded-lg hover:bg-indigo-600 transition">Finalizar Compra</button>
        </form>
    </div>
</body>

</html>