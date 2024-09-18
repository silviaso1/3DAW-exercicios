<?php
    $num1 = $_GET['num1'] ?? '';
    $num2 = $_GET['num2'] ?? '';
    $opcao = $_GET['opcao'] ?? '';
    $resultado = '';

    function calcular($num1, $num2, $opcao)
    {
        switch ($opcao) {
            case 1:
                return $num1 + $num2; 
            case 2:
                return $num1 - $num2; 
            case 3:
                return $num1 * $num2;
            case 4:
                return $num2 != 0 ? $num1 / $num2 : "Erro: Divisão por zero";
            case 5:
                return $num1 ** $num2; 
            case 6:
                return sqrt($num1); 
            case 7:
                return $num1 * -1; 
            case 8:
                return $num1 != 0 ? 1 / $num1 : "Erro: Não é possível inverter zero"; 
            case 9:
                return sin($num1);
            case 10:
                return cos($num1); 
            case 11:
                return tan($num1);
            case 12:
                $fatorial = 1;
                for ($i = $num1; $i >= 1; $i--) {
                    $fatorial *= $i;
                }
                return $fatorial;
            default:
                return "Operação inválida"; 
        }
    }

    if ($num1 !== '' && $opcao !== '') {
        $resultado = calcular($num1, $num2, $opcao);
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: purple;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 80px pink;
            text-align: center;
            width: 300px;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"] {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100px;
        }
        button, select {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .resultado {
            margin-top: 20px;
            font-size: 1.2em;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Calculadora</h1>
        
        <form method="GET">
            <input type="text" name="num1" placeholder="Número 1">
            <input type="text" name="num2" placeholder="Número 2">
            
            <section>
                <select name="opcao">
                    <option value="1">Somar</option>
                    <option value="2">Subtrair</option>
                    <option value="3">Multiplicar</option>
                    <option value="4">Dividir</option>
                    <option value="5">Exponenciar</option>
                    <option value="6">Raiz Quadrada</option>
                    <option value="7">Inverter Sinal</option>
                    <option value="8">Inverter Número</option>
                    <option value="9">Seno</option>
                    <option value="10">Cosseno</option>
                    <option value="11">Tangente</option>
                    <option value="12">Fatorial</option>
                </select>
                <button type="submit">Calcular</button>
            </section>
        </form>

        <div class="resultado">
            <h2>Resultado: <?php echo $resultado; ?></h2>
        </div>
    </div>
</body>
</html>
