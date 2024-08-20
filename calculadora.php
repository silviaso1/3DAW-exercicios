<?php
    $a = $_GET['a'];
    $b = $_GET['b'];
    $button = $_GET['button'];
    $resultado = '';

    if ($button == "soma") {
        $resultado = $a + $b;
    } elseif ($button == "diminui") {
        $resultado = $a - $b;
    } elseif ($button == "multiplica") {
        $resultado = $a * $b;
    } elseif ($button == "divide") {
        $resultado = $a / $b;
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
            background-color: black;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            width: 50%;
            margin-left:25%;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px purple;
            text-align: center;
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

        button {
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
            <input type="text" name="a" placeholder="Número 1" value="<?php echo htmlspecialchars($a); ?>">
            <input type="text" name="b" placeholder="Número 2" value="<?php echo htmlspecialchars($b); ?>">
            
            <section>
                <select name="button">
                    <option value="soma">Somar</option>
                    <option value="diminui">Subtrair</option>
                    <option value="multiplica">Multiplicar</option>
                    <option value="divide">Dividir</option>
                </select>
                <button type="submit">Calcular</button>
            </section>
        </form>

        <div class="resultado">
            <h2>Resultado: <?php echo htmlspecialchars($resultado); ?></h2>
        </div>
    </div>
</body>
</html>