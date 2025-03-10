<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Mega-Sena</title>
</head>

<body>


    <div class="container mx-auto p-4" style="max-width: 700px;
    margin: 0 auto;">
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_Bms8sE8hsAMHuNT_UlMOx71n1B4v8S4J2g&s" alt="" class="w-full h-auto mb-4">
            <p class="text-center">Escolha 6 números de 1 a 60!</p>
            <form method="POST" action="" class="space-y-4 flex flex-col">
                <label for="" class="text-2xl block mb-2 text-center m-5">Faça sua Aposta:</label>
                <div class="flex space-x-10 justify-center mt-5">
                    <input type="text" name="num1" class="border-2 border-gray-300 p-2 rounded-lg w-16">
                    <input type="text" name="num2" class="border-2 border-gray-300 p-2 rounded-lg w-16">
                    <input type="text" name="num3" class="border-2 border-gray-300 p-2 rounded-lg w-16">
                    <input type="text" name="num4" class="border-2 border-gray-300 p-2 rounded-lg w-16">
                    <input type="text" name="num5" class="border-2 border-gray-300 p-2 rounded-lg w-16">
                    <input type="text" name="num6" class="border-2 border-gray-300 p-2 rounded-lg w-16">
                </div>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5">Apostar</button>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $numsCorretos = array();
                    
                    while(count($numsCorretos) < 6) {
                        $num = rand(1, 60);
                        if (!in_array($num, $numsCorretos)) {
                            $numsCorretos[] = $num;
                        }
                    }
                    sort($numsCorretos);

                    $nums = array();
                    $nums[0] = $_POST['num1'];
                    $nums[1] = $_POST['num2'];
                    $nums[2] = $_POST['num3'];
                    $nums[3] = $_POST['num4'];
                    $nums[4] = $_POST['num5'];
                    $nums[5] = $_POST['num6'];
                    sort($nums);

                    $message = "";
                    if ($nums[0] == $numsCorretos[0] && $nums[1] == $numsCorretos[1] && $nums[2] == $numsCorretos[2] && $nums[3] == $numsCorretos[3] && $nums[4] == $numsCorretos[4] && $nums[5] == $numsCorretos[5]) {
                        echo "<h1 class='text-center text-green-500 text-xl'>Parabéns, você ganhou na Mega Sena!</h1>";
                    } elseif ($nums[0] == $numsCorretos[0] && $nums[1] == $numsCorretos[1] && $nums[2] == $numsCorretos[2] && $nums[3] == $numsCorretos[3] && $nums[4] == $numsCorretos[4]) {
                        echo "<h1 class='text-center text-green-500 text-xl'>Quase lá, você acertou na Quina!</h1>";
                    } elseif ($nums[0] == $numsCorretos[0] && $nums[1] == $numsCorretos[1] && $nums[2] == $numsCorretos[2] && $nums[3] == $numsCorretos[3]) {
                        echo "<h1 class='text-center text-green-500 text-xl'>Legal, você fez uma Quadra!</h1>";
                    } else {
                        echo "<h1 class='text-center text-red-500 text-xl'>Não foi dessa vez, tente novamente!</h1>";
                    }

                     echo "<p class='text-center'>Sua Aposta: " . implode(" - ", $nums) . "</p>";
                     echo "<p class='text-center'>Você acertou: " . count(array_intersect($nums, $numsCorretos)) . " números</p>";

                    
                }
                ?>
            </form>
        </div>
    </div>

</body>

</html>

