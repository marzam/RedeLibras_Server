<?php
function redeLibrasQuery($mysql){
  $servername = "localhost";
  $username   = "localuser";
  $password   = "localuser";
  $conn = new mysqli($servername, $username, $password);
  if ($conn->connect_error) {
     myLog("Error loading character set utf8:" . $conn->error);
     return;
  }
  if (!$conn->set_charset("utf8")) {
      myLog("Error loading character set utf8:" . $conn->error);
      return;
  }

  $sql = "USE DBredelibras;";
  $conn->query($sql);

  $result = $conn->query($mysql);
  $conn->close();
  return $result;
}

function printUserInfor($result){
  while($data = $result->fetch_assoc()) {
      foreach($data as $key => $value) {
        if ($value == "") $value = '  ';
        echo "$value;";
      }
      echo PHP_EOL;
  }


  if ($result->num_rows == 0)
    echo '-1';


}

function sendUserData($userID){

  $result = redeLibrasQuery("SELECT nome,rank,tipo,login,senha FROM tbUsuario WHERE ID = '" . $userID . "' AND ativo = 'S';");
  printUserInfor($result);

}

function sendUserPhone($userID){

  $result = redeLibrasQuery("SELECT ID,telefone FROM tbTelefone WHERE id_sprestador = '" . $userID . "';");
  printUserInfor($result);

}


function sendUserEmail($userID){
  $result = redeLibrasQuery("SELECT ID,email from tbEmail WHERE id_sprestador = '" . $userID . "';");
  printUserInfor($result);

}

function sendUserServices($userID){
//SELECT t2.ID,t2.id_sprestador,t2.id_especialidade,t2.descricao FROM tbEspecialidades t1 INNER JOIN tbPEspecialidade t2 ON t1.ID = t2.id_especialidade WHERE t2.id_sprestador = '1';
  $result = redeLibrasQuery("SELECT t2.ID,t2.id_sprestador,t2.id_especialidade,t2.descricao FROM tbEspecialidades t1 INNER JOIN tbPEspecialidade t2 ON t1.ID = t2.id_especialidade WHERE t2.id_sprestador = '" . $userID . "';");
  printUserInfor($result);
}

function sendUserAddr($userID){
//ELECT t1.ID,endereco,complemento,bairro,id_cidade,id_estado,nome_cidade FROM tbEndereco t1 INNER JOIN tbCidades t2 ON t2.ID = t1.id_cidade WHERE t1.id_sprestador = '1';
  $result = redeLibrasQuery("SELECT t1.ID,endereco,complemento,bairro,id_cidade,id_estado,nome_cidade FROM tbEndereco t1 INNER JOIN tbCidades t2 ON t2.ID = t1.id_cidade WHERE t1.id_sprestador = '" . $userID . "';");
  printUserInfor($result);
}

function login($user, $passwd){
  $result = redeLibrasQuery("SELECT ID FROM tbUsuario WHERE login = '" . $user . "' AND senha = '" . $passwd . "'  AND ativo = 'S';");
  if ($result->num_rows > 0) {
      if ($row = $result->fetch_assoc()) {
            echo $row['ID'] ;
      }//if ($row = $result->fetch_assoc()) {
      else
        echo '-1';
  }//if ($result->num_rows > 0) {
  else
    echo '-2';
}
function disableUser($user){
  //UPDATE tbUsuario SET ativo = 'N' where ID='582';
  $result = redeLibrasQuery("UPDATE tbUsuario SET ativo  = 'N' WHERE ID='" . $user . "';");
  if ($result == null)
  echo '1';

}
function checkLoginAndCreate($user, $passwd){
  $result = redeLibrasQuery("SELECT ID FROM tbUsuario WHERE login = '" . $user . "';");
  if ($result->num_rows > 0){
    echo '-1';
    return;
  }

  $result = redeLibrasQuery("INSERT INTO tbUsuario (login, senha, rank, ativo) VALUES ('" . $user . "', '" . $passwd .  "', '0.0','S');");
  login($user, $passwd);

}

  $state = $_GET['state'];


  switch ($state) {
    case 1: login($_GET['id_user'], $_GET['id_passwd']); break;//https://192.168.1.11/protocol.php?state=1&id_user=achesongomesdemelo@gmail.com&id_passwd=achesongomesdemelo@gmail.com
    case 2: sendUserData($_GET['id_user']); break;//https://192.168.1.11/protocol.php?state=2&id_user=3
    case 3: sendUserPhone($_GET['id_user']); break;//https://192.168.1.11/protocol.php?state=2&id_user=3
    case 4: sendUserEmail($_GET['id_user']); break;//https://192.168.1.11/protocol.php?state=2&id_user=3
    case 5: sendUserServices($_GET['id_user']); break;//https://192.168.1.11/protocol.php?state=2&id_user=3
    case 6: sendUserAddr($_GET['id_user']); break;//https://192.168.1.11/protocol.php?state=2&id_user=3
    case 7: checkLoginAndCreate($_GET['id_user'], $_GET['id_passwd']); break;//https://192.168.1.11/protocol.php?state=2&id_user=3
    case 8: disableUser($_GET['id_user']); break;//https://192.168.1.11/protocol.php?state=8&id_user=582
   default:break;

  }

?>
