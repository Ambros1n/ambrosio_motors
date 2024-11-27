<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'ambrosio_motors');

// Verifica a conexão
if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}

// Consulta para buscar todas as motos
$sql = "SELECT * FROM motos";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motos - Ambrosio Motors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .moto {
            background: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
        }
        .moto img {
            max-width: 200px;
            margin-right: 20px;
        }
        .moto h2 {
            margin: 0 0 10px;
        }
        .moto p {
            margin: 5px 0;
        }
        .moto .preco {
            color: #00bfff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Motos</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='moto'>
                    <img src='{$row['imagem']}' alt='{$row['nome']}'>
                    <div>
                        <h2>{$row['nome']} ({$row['ano']})</h2>
                        <p>Quilometragem: {$row['km']} km</p>
                        <p>{$row['descricao']}</p>
                        <p class='preco'>Preço: R$ " . number_format($row['preco'], 2, ',', '.') . "</p>
                    </div>
                </div>
                ";
            }
        } else {
            echo "<p>Nenhuma moto encontrada.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>