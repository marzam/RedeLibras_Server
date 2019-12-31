<?php
  include 'redelibrasfunc.php';
  $login  = $_POST['login'];
  $passwd = $_POST['passwd'];

  $result = redeLibrasQuery("SELECT * FROM tbUsuario WHERE login='". $login. "' AND senha='". $passwd . "';");
  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      setcookie('redelibras-user',  $row['ID'] );
      echo $row['ID'] . '<br>';
      echo 'Bem vindo ' . $row['nome'] . ' <br>';
      echo 'Login realizado <br>';
      echo 'Cookie value is: ' . $_COOKIE['redelibras-user'] . '<br>';
      echo '<script>window.location.href = "user-data.php";</script>';
  }else{
    echo 'Error no login<br>';
    echo 'Login ou senha incorretos<br>';
  }


 ?>
