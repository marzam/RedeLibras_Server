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

function logQuery($result, $tableName){
  return;
  if ($result == null)
    return;

  if ($result->error)
    return;

  $data = $result->fetch_assoc() or die($result->error);;

//  if ($data == null)
  //  return;

  echo "Hello";
  return;
  $file =  fopen("logs/queries.txt", "a+") or die("Unable to open file!");
  fwrite($file, "");
  $line = "";
  echo "[" . $tableName . "]\n";
  $data = $result->fetch_assoc();
  //while()
  //{
      foreach($data as $key => $value) {
        if ($value == "") $value = '  ';
        echo $value . ";";
        $line = $line . $value . ";";
      }
      $line .= "\n";
  //}
  echo $line . "<br>";
  fwrite($file, $line);
  fclose($file);

}

function deleteEmail($userID){
  $result = redeLibrasQuery("SELECT * FROM tbEmail WHERE tbEmail.id_sprestador = '" . $userID . "';");
  logQuery($result, 'tbEmail');
  $result = redeLibrasQuery("DELETE FROM tbEmail WHERE tbEmail.id_sprestador =  '" . $userID . "';");
}

function deletePhone($userID){
  $result = redeLibrasQuery("SELECT * FROM tbTelefone WHERE tbTelefone.id_sprestador = '" . $userID . "';");
  logQuery($result, 'tbTelefone');
  $result = redeLibrasQuery("DELETE FROM tbTelefone WHERE tbTelefone.id_sprestador =  '" . $userID . "';");

}

function deleteService($userID){
  $result = redeLibrasQuery("SELECT * FROM tbPEspecialidade WHERE tbPEspecialidade.id_sprestador = '" . $userID . "';");
  logQuery($result, 'tbPEspecialidade');
  $result = redeLibrasQuery("DELETE FROM tbPEspecialidade WHERE tbPEspecialidade.id_sprestador =  '" . $userID . "';");
}

function deleteAddr($userID){
  $result = redeLibrasQuery("SELECT * FROM tbEndereco WHERE tbEndereco.id_sprestador =  '" . $userID . "';");
  logQuery($result, 'tbEndereco');
  $result = redeLibrasQuery("DELETE FROM tbEndereco WHERE tbEndereco.id_sprestador = '" . $userID . "';");
}//  $userID = 2; //$_GET['id_user'];

function deleteUser($userID){
  deleteEmail($userID);
  deletePhone($userID);
  deleteService($userID);
  deleteAddr($userID);

  $result = redeLibrasQuery("SELECT * FROM tbUsuario WHERE tbUsuario.ID = '" . $userID . "';");
  logQuery($result, 'tbUsuario');
  $result = redeLibrasQuery("DELETE FROM tbUsuario WHERE tbUsuario.ID =  '" . $userID . "';");


}

  $state  = $_GET['state']
  $userID = $_GET['id_user'];

  switch ($state){
    case 1:deleteUser($userID);break;
    case 2:deleteEmail($userID);break;
    case 3:deletePhone($userID);break;
    case 4:deleteService($userID);break;
    case 5:deleteAddr($userID);break;
  }










?>
