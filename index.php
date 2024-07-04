<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receba os dados do formulário de login (substitua com os dados reais do formulário)
    $user_name = $_POST['user_name'];
    $senha = $_POST['password'];

    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "cpphp_ex";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Verifique a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }
 
    // Consulta para verificar as credenciais do usuário
    $sql = "SELECT * FROM utilizadores WHERE user_name = '$user_name' AND senha = '$senha'"; 
    
    $result = $conn->query($sql);

    if (!$result) {
        die("Erro na consulta SQL: " . $conn->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id']; // Defina a variável de sessão após a autenticação bem-sucedida

        if ($row['user_type'] === 'utilizador') {
            header("Location: perfil_utilizador.php"); // Redireciona para o perfil do utilizador
        } elseif ($row['user_type'] === 'administrador') {
            header("Location: perfil_admin.php"); // Redireciona para o perfil do administrador
        } else {
            $login_error = "Papel desconhecido.";
        }

        exit();
    } else {
        $login_error = "Nome de usuário ou senha incorretos.";
    }

    $conn->close();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Sistema de login e registo de utilizadores</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&family=Oswald&display=swap');

    * {
      box-sizing: border-box;
      }

    [class*="col-"] {
      float: left;
      /* padding: 15px; */
    }  
    
    .row::after {
      content: "";
      clear: both;
      display: table;
    } 
    
    .row>* {
    padding-right: 0;
    padding-left: 0;
}


body {
    font-family: 'Montserrat', sans-serif;
    background-color: #30404A;
}

h1 {
  color: #30404A;
  font-family: 'Oswald', sans-serif;  
  font-size: 96px;
}

h4 {
  color: #30404A;
  font-family: 'Montserrat', sans-serif;
  font-size: 32px;
}

.caixa1 {
  background-color: #fff;
}

.col-6{width:50%;}

h2 {
    color: #ffffff;
    font-family: 'Oswald', sans-serif;
}

h4 {
    color: #30404A;
    font-family: 'Montserrat', sans-serif;
    font-size: 32px;
}


.error-message {
    color: #ACD7F2;
    font-size: 24px;
    margin-top: 25px;
}
label {
    color: #ffffff;
font-size:14px;
}
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 3px;
}
input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
input[type="submit"]:hover {
    background-color: #0056b3;
}
#conta {
  color: #3E4C59;
margin-top: 25px;}

form {
  /* width:50%; */
  margin: auto;
  /* background-color: #80A7BF; */
  /* padding: 50px;
  border-radius: 25px; */
  /* margin-top: 25px; */
}

button.btn.btn-primary.meu-botao {
  background-color: #FEB07D;
  border: none;
  border-radius: 10px;
  color:#000000;
  position: relative;
  margin-left:77%;
}

a#registo{
  color: #3E4C59;
  font-weight: bold;
}

.caixa1.row {
  width:60%;
  margin:auto;
  margin-top: 5%;
  border-radius:50px;
}

.col-6.area-welcome{
  padding-left:2%;
  padding-right:2%;

}



    </style>
  </head>
  <body class="p-3 m-0 border-0 bd-example m-0 border-0">

  <div class="caixa1 row">


  <div class="col-6">


  <img src="imagens/foto1.jpeg" alt="welcome" width="100%" height="auto" style="border-radius:50px 0px 0px 50px;">
</div>

<div class="col-6 area-welcome">

  <h1 style="margin-top: 20%">ola</h1>

  <h4>Sign in to continue</h4>

      <?php
      if (isset($login_error)) {
          echo '<p class="error-message">' . $login_error . '</p>';
      }
      ?>

      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      
      <div class="mb-3">
        <input type="text" class="user-name" id="user-name" name="user_name" required aria-describedby="emailHelp" placeholder="Username">
      </div>
      <div class="mb-3">
        <input type="password" class="password" id="password" name="password" required placeholder="Password">
      </div>

      <button type="submit" class="btn btn-primary meu-botao">Sign in</button>

      <p id="conta">Don't have an account? <a id="registo" href="pagina_de_registro.html" style="font-weight:bold">Register</a></p>

      <p id="conta" style="text-align:right;margin-top:20%"><a id="registo" href="homepage.php">Continue without login 
      <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 256 512">
      <path d="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z"/>
      </svg></a></p>


    </form>
    </div>

</div>
  </body>
</html>