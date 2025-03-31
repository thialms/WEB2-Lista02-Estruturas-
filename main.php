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
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mega-Sena</title>
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
                <a href="loja.php" class="text-[var(--primary-color)] hover:underline">Acesse nossa Loja</a>
                <a href="?sair=true" class="bg-[var(--error-color)] text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Sair</a>
            </div>
        </div>
    </header>

    <div class="container mx-auto p-6 max-w-3xl">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <img src="https://imagens.ebc.com.br/CkkvHQJcrBZoLvGaJjEKFvSegUI=/1170x700/smart/https://agenciabrasil.ebc.com.br/sites/default/files/thumbnails/image/20230622_183248.jpg?itok=rmu5rSoe" alt="Mega-Sena" class="w-full h-auto mb-6 rounded-lg">
            <h1 class="text-3xl font-bold text-center text-[var(--primary-color)] mb-4">Mega-Sena</h1>
            <p class="text-center text-[var(--secondary-color)] mb-6">Escolha 6 números de 1 a 60 e teste sua sorte!</p>
            <form method="POST" action="" class="space-y-6">
                <div class="grid grid-cols-3 gap-4 justify-center">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <input type="number" name="num<?php echo $i; ?>" min="1" max="60" placeholder="<?php echo $i; ?>" class="border-2 border-gray-300 p-3 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]">
                    <?php endfor; ?>
                </div>
                <button class="w-full bg-[var(--primary-color)] text-white font-bold py-3 rounded-lg hover:bg-indigo-600 transition">Apostar</button>
            </form>

            <?php
            $dir = 'apostas';
            if (!is_dir($dir)) {
                mkdir($dir); 
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir'])) {
                $arquivoExcluir = $_POST['excluir'];
                if (file_exists($arquivoExcluir)) {
                    unlink($arquivoExcluir);
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['excluir'])) {
                $nums = [];
                $repetidos = false;

                for ($i = 1; $i <= 6; $i++) {
                    $num = $_POST["num$i"];
                    if (in_array($num, $nums)) {
                        $repetidos = true;
                        break;
                    }
                    $nums[] = $num;
                }

                if ($repetidos) {
                    echo "<div class='mt-6 text-center'>";
                    echo "<h2 class='text-[var(--error-color)] text-2xl font-bold'>Erro: Não é permitido repetir números na mesma aposta!</h2>";
                    echo "</div>";
                } else {
                    sort($nums);

                    $numsCorretos = [];
                    while (count($numsCorretos) < 6) {
                        $num = rand(1, 60);
                        if (!in_array($num, $numsCorretos)) {
                            $numsCorretos[] = $num;
                        }
                    }
                    sort($numsCorretos);

                    $acertos = count(array_intersect($nums, $numsCorretos));
                    $resultado = $acertos === 6 ? "Ganhou na Mega-Sena" : ($acertos === 5 ? "Acertou na Quina" : ($acertos === 4 ? "Fez uma Quadra" : "Não ganhou"));

                    $dataHora = date('Y-m-d H:i:s');
                    $conteudo = "Data/Hora: $dataHora\nAposta: " . implode(", ", $nums) . "\nSorteados: " . implode(", ", $numsCorretos) . "\nAcertos: $acertos\nResultado: $resultado\n\n";
                    $arquivo = "$dir/aposta_" . time() . ".txt";
                    file_put_contents($arquivo, $conteudo);

                    echo "<div class='mt-6 text-center'>";
                    echo "<h2 class='text-[var(--success-color)] text-2xl font-bold'>$resultado</h2>";
                    echo "<p class='text-[var(--secondary-color)] mt-4'>Sua Aposta: " . implode(" - ", $nums) . "</p>";
                    echo "<p class='text-[var(--secondary-color)]'>Números Sorteados: " . implode(" - ", $numsCorretos) . "</p>";
                    echo "<p class='text-[var(--secondary-color)]'>Você acertou: $acertos números</p>";
                    echo "</div>";
                }
            }

            echo "<div class='mt-10'>";
            echo "<h2 class='text-2xl font-bold text-center text-[var(--primary-color)] mb-6'>Histórico de Apostas</h2>";
            $arquivos = glob("$dir/*.txt");
            if ($arquivos) {
                foreach ($arquivos as $arquivo) {
                    echo "<div class='bg-gray-100 p-4 rounded-lg shadow mb-4'>";
                    echo "<pre class='text-[var(--secondary-color)]'>" . file_get_contents($arquivo) . "</pre>";
                    echo "<form method='POST' action='' class='text-right'>";
                    echo "<input type='hidden' name='excluir' value='$arquivo'>";
                    echo "<button type='submit' class='text-[var(--error-color)] hover:underline'>Excluir</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center text-[var(--secondary-color)]'>Nenhuma aposta realizada.</p>";
            }
            echo "</div>";
            ?>
        </div>
    </div>
</body>

</html>