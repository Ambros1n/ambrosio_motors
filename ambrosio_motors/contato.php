<?php
// Ativa a exibição de erros para facilitar a depuração durante o desenvolvimento
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Exibe todos os tipos de erros e avisos

// Mensagem de verificação inicial para confirmar que o script está sendo executado
echo "Início do script contato.php<br>";

// Configuração do banco de dados
$host = 'localhost'; // Endereço do servidor de banco de dados
$user = 'root'; // Nome de usuário para conexão com o banco de dados
$pass = ''; // Senha para conexão com o banco de dados
$dbname = 'ambrosio_motors'; // Nome do banco de dados

// Conectar ao banco de dados usando a classe mysqli
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se a conexão falhar, exibe a mensagem de erro e interrompe a execução do script
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Mensagem de depuração para confirmar que a conexão foi estabelecida
echo "Conexão com o banco de dados estabelecida.<br>";

// Verificar se o formulário foi enviado (verifica se o método de requisição é POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mensagem de depuração para indicar que o formulário foi enviado
    echo "Formulário enviado.<br>";

    // Coletar os dados do formulário e remover espaços em branco ao redor
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $modelo = trim($_POST['modelo']);
    $mensagem = trim($_POST['mensagem']);

    // Mensagem de depuração para exibir os dados recebidos
    echo "<p>Dados recebidos:</p>";
    echo "<p>Nome: $nome</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Telefone: $telefone</p>";
    echo "<p>Modelo: $modelo</p>";
    echo "<p>Mensagem: $mensagem</p>";

    // Verificação de campos obrigatórios
    if (empty($nome) || empty($email) || empty($telefone) || empty($modelo)) {
        // Se algum campo obrigatório estiver vazio, exibe uma mensagem de erro
        echo "<p style='color: red;'>Todos os campos obrigatórios devem ser preenchidos.</p>";
    } else {
        // Preparar a consulta SQL para inserir os dados na tabela 'clientes'
        $stmt = $conn->prepare("INSERT INTO clientes (nome, email, telefone, modelo, mensagem) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt) {
            // Liga as variáveis PHP aos parâmetros da consulta preparada
            $stmt->bind_param("sssss", $nome, $email, $telefone, $modelo, $mensagem);
            
            // Executa a consulta SQL
            if ($stmt->execute()) {
                // Mensagem de sucesso se a inserção for realizada com êxito
                echo "<p style='color: green;'>Cadastro realizado com sucesso!</p>";
            } else {
                // Mensagem de erro se a execução falhar
                echo "<p style='color: red;'>Erro ao cadastrar: " . $stmt->error . "</p>";
            }
            // Fecha a instrução preparada
            $stmt->close();
        } else {
            // Mensagem de erro se a consulta preparada falhar
            echo "<p style='color: red;'>Erro ao preparar a consulta: " . $conn->error . "</p>";
        }
    }
}

// Fecha a conexão com o banco de dados
$conn->close();

// Mensagem de fim do script para confirmar a execução
echo "Fim do script contato.php";
?>
