<?php
// session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cpphp_ex";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter dados do formulário
$nome = $_POST['nome'];
$apelido = $_POST['apelido'];
$user_name = $_POST['user_name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta para inserir um novo registro na tabela utilizadores
$sql = "INSERT INTO utilizadores (nome, apelido, user_name, email, password, user_type) VALUES ('$nome', '$apelido', '$user_name', '$email', '$password', 'utilizador')";

if ($conn->query($sql) === TRUE) {
    // Redireciona para a página de login após o registro bem-sucedido
    header("Location: login1.php");
    exit(); // Certifica-se de que o script seja encerrado após o redirecionamento
} else {
    if ($conn->errno === 1062) {
        echo "Erro: O endereço de e-mail já está em uso. Por favor, escolha outro.";
    } else {
        echo "Erro ao registar: " . $conn->error;
    }
}

$conn->close();
?>
