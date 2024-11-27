<?php
// Configuração do banco de dados
$host = 'localhost'; // Endereço do servidor do banco de dados
$user = 'root'; // Usuário do banco de dados
$pass = ''; // Senha do banco de dados (deixe em branco se não houver senha)
$dbname = 'ambrosio_motors'; // Nome do banco de dados

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coletar os dados enviados pelo formulário
    $nome = $conn->real_escape_string(trim($_POST['nome']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $telefone = $conn->real_escape_string(trim($_POST['telefone']));
    $modelo = $conn->real_escape_string(trim($_POST['modelo']));
    $mensagem = $conn->real_escape_string(trim($_POST['mensagem']));

    // Validação básica no PHP (opcional, já está no JavaScript)
    if (empty($nome) || empty($email) || empty($telefone) || empty($modelo)) {
        echo "<p>Todos os campos obrigatórios devem ser preenchidos.</p>";
        exit;
    }

    // Inserir os dados no banco de dados
    $sql = "INSERT INTO clientes (nome, email, telefone, modelo, mensagem) 
            VALUES ('$nome', '$email', '$telefone', '$modelo', '$mensagem')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Cadastro realizado com sucesso! Em breve entraremos em contato.</p>";
        echo "<a href='index.html'>Voltar para o início</a>";
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }
}

// Fechar a conexão com o banco de dados
$conn->close();
?>