<?php


function sendFile($type){
  switch ($type){
    case 1:  $my_file = "tmp/" . getRealIpAddr() . ".services.txt"; break;
    case 2:  $my_file = "tmp/" . getRealIpAddr() . ".lastupdate.txt"; ;break;
    case 3:  $my_file = "tmp/" . getRealIpAddr() . ".cities.txt";break;
    case 4:  $my_file = "tmp/" . getRealIpAddr() . ".user.txt";  break;
    case 5:  $my_file = "tmp/" . getRealIpAddr() . ".pictures.txt";  break;
  }

  $handle = fopen($my_file, 'r') or die('Cannot open file:  '.$my_file);
  $data = fread($handle,filesize($my_file));
  echo $data;
  fclose($my_file);
//  unlink($my_file);
}

function saveUsersPicture($my_state){
  $servername = "localhost";
  $username   = "localuser";
  $password   = "localuser";
  $conn = new mysqli($servername, $username, $password);
  $id_user_array = array("-1");
  $my_file = "tmp/" . getRealIpAddr() . ".pictures.txt";
  $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

  if ($conn->connect_error) {
     return;
  }

  if (!$conn->set_charset("utf8")) {
      myLog("Error loading character set utf8:" . $conn->error);
  }

  $sql = "USE DBredelibras;";
  $conn->query($sql);

  $sql    = "select ID from tbEstados where sigla_estado='" . $my_state . "';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
          $id_estado = $row['ID'];
          $sql    = "SELECT tbUsuario.ID AS ID FROM tbUsuario, tbEspecialidades, tbPEspecialidade, tbEndereco, tbCidades, tbEstados WHERE tbUsuario.ID = tbPEspecialidade.id_sprestador AND tbEspecialidades.ID = tbPEspecialidade.id_especialidade AND tbPEspecialidade.id_especialidade IS NOT NULL AND tbUsuario.ID = tbEndereco.id_sprestador AND tbEndereco.id_cidade = tbCidades.ID AND tbCidades.id_estado = tbEstados.ID AND tbEstados.ID = '". $id_estado. "' GROUP BY tbUsuario.ID;";
          $result_user = $conn->query($sql);
          if ($result_user->num_rows > 0) {

              while($row_user = $result_user->fetch_assoc()) {
                $id_user = $row_user['ID'];
                array_push($id_user_array, $id_user);
              }//end-while($row_user = $result_user->fetch_assoc()) {
          }//end-if ($result_user->num_rows > 0) {
    }//end-if($row = $result->fetch_assoc()) {

  }//end-if ($result->num_rows > 0) {

//Cadastro
//  fwrite($handle, "0x02H");
  for ($i = 1; $i < count($id_user_array); $i++){
    $id_user = $id_user_array[$i];
    $sql    = "SELECT ID,largura,altura,foto from tbUsuario WHERE tbUsuario.ID = '". $id_user . "' ;";
    $result_users = $conn->query($sql);
    //Tabela usuário
    if ($result_users->num_rows > 0) {
        while($row_users = $result_users->fetch_assoc()) {
	        $line = ($row_users['ID'] . ";" . $row_users['largura'] . ";" . $row_users['altura'] . ";" . $row_users['foto'] . ";" );
           fwrite($handle, $line);
//            echo $row_users['ID'] . " " . $row_users['nome'] . " " . $row_users['rank'] . " " .  $row_users['tipo'] . PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
        }//end-while($row_user = $result_user->fetch_assoc()) {
    }//end-if ($result_user->num_rows > 0) {

  }//end-  for ($i = 1; $i < count($id_user_array); $i++){
  fclose($handle);
  $conn->close();
  sendFile(5);
}





function saveUsersData($my_state){
  $servername = "localhost";
  $username   = "localuser";
  $password   = "localuser";
  $conn = new mysqli($servername, $username, $password);
  $id_user_array = array("-1");
  $my_file = "tmp/" . getRealIpAddr() . ".user.txt";
  $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

  if ($conn->connect_error) {
     return;
  }

  if (!$conn->set_charset("utf8")) {
      myLog("Error loading character set utf8:" . $conn->error);
  }

  $sql = "USE DBredelibras;";
  $conn->query($sql);

  $sql    = "select ID from tbEstados where sigla_estado='" . $my_state . "';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
          $id_estado = $row['ID'];
          $sql    = "SELECT tbUsuario.ID AS ID FROM tbUsuario, tbEspecialidades, tbPEspecialidade, tbEndereco, tbCidades, tbEstados WHERE tbUsuario.ID = tbPEspecialidade.id_sprestador AND tbEspecialidades.ID = tbPEspecialidade.id_especialidade AND tbPEspecialidade.id_especialidade IS NOT NULL AND tbUsuario.ID = tbEndereco.id_sprestador AND tbEndereco.id_cidade = tbCidades.ID AND tbCidades.id_estado = tbEstados.ID AND tbEstados.ID = '". $id_estado. "' GROUP BY tbUsuario.ID;";
          $result_user = $conn->query($sql);
          if ($result_user->num_rows > 0) {

              while($row_user = $result_user->fetch_assoc()) {
                $id_user = $row_user['ID'];
                array_push($id_user_array, $id_user);
              }//end-while($row_user = $result_user->fetch_assoc()) {
          }//end-if ($result_user->num_rows > 0) {
    }//end-if($row = $result->fetch_assoc()) {

  }//end-if ($result->num_rows > 0) {

//Cadastro
//  fwrite($handle, "0x02H");
  for ($i = 1; $i < count($id_user_array); $i++){
    $id_user = $id_user_array[$i];
    $sql    = "SELECT * from tbUsuario WHERE tbUsuario.ID = '". $id_user . "' ;";
    $result_users = $conn->query($sql);
    //Tabela usuário
    if ($result_users->num_rows > 0) {
        while($row_users = $result_users->fetch_assoc()) {
          $line = ($row_users['ID'] . ";" . $row_users['nome'] . ";" . $row_users['rank'] . ";" .  $row_users['tipo'] .  ";|");
          fwrite($handle, $line);
//            echo $row_users['ID'] . " " . $row_users['nome'] . " " . $row_users['rank'] . " " .  $row_users['tipo'] . PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
        }//end-while($row_user = $result_user->fetch_assoc()) {
    }//end-if ($result_user->num_rows > 0) {

  }//end-  for ($i = 1; $i < count($id_user_array); $i++){
  fwrite($handle, "0x03H");

//e-mail
  for ($i = 1; $i < count($id_user_array); $i++){
      $id_user = $id_user_array[$i];
      $sql    = "SELECT * from tbEmail WHERE tbEmail.id_sprestador = '". $id_user . "' ;";
      $result_users = $conn->query($sql);
      //Tabela usuário
      if ($result_users->num_rows > 0) {
          while($row_users = $result_users->fetch_assoc()) {
            $line = ($row_users['id_sprestador'] . ";" . $row_users['email'] .  ";|");
            fwrite($handle, $line);
              //echo $row_users['id_sprestador'] . " " . $row_users['email'] . " ". PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
          }//end-while($row_user = $result_user->fetch_assoc()) {
      }//end-if ($result_user->num_rows > 0) {
  }//end-  for ($i = 1; $i < count($id_user_array); $i++){
  fwrite($handle, "0x03H");
  //telefone
    for ($i = 1; $i < count($id_user_array); $i++){
        $id_user = $id_user_array[$i];
        $sql    = "SELECT * from tbTelefone WHERE tbTelefone.id_sprestador = '". $id_user . "' ;";
        $result_users = $conn->query($sql);
        //Tabela usuário
        if ($result_users->num_rows > 0) {
            while($row_users = $result_users->fetch_assoc()) {
              $line = ($row_users['id_sprestador'] . ";" . $row_users['telefone'] .  ";|");
              fwrite($handle, $line);
//                echo $row_users['id_sprestador'] . " " . $row_users['telefone'] . " ". PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
            }//end-while($row_user = $result_user->fetch_assoc()) {
        }//end-if ($result_user->num_rows > 0) {
    }//end-  for ($i = 1; $i < count($id_user_array); $i++){
    fwrite($handle, "0x03H");
    //endereco
    for ($i = 1; $i < count($id_user_array); $i++){
        $id_user = $id_user_array[$i];

        $sql    = "SELECT * from tbEndereco WHERE tbEndereco.id_sprestador = '". $id_user . "' ;";
        $result_users = $conn->query($sql);
        //Tabela usuário
        if ($result_users->num_rows > 0) {
            while($row_users = $result_users->fetch_assoc()) {
              $line = ($row_users['id_sprestador'] . ";" . $row_users['endereco'] . ";". $row_users['complemento'] . ";". $row_users['bairro'] . ";". $row_users['id_cidade'] . ";|");
              fwrite($handle, $line);
//                echo $row_users['id_sprestador'] . " " . $row_users['endereco'] . " ". $row_users['complemento'] . " ". $row_users['bairro'] . " ". $row_users['id_cidade'] . " ". PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
            }//end-while($row_user = $result_user->fetch_assoc()) {
        }//end-if ($result_user->num_rows > 0) {
    }//end-  for ($i = 1; $i < count($id_user_array); $i++){
    fwrite($handle, "0x03H");
    //Especialidades
    for ($i = 1; $i < count($id_user_array); $i++){
        $id_user = $id_user_array[$i];
        $sql    = "SELECT * from tbPEspecialidade WHERE tbPEspecialidade.id_sprestador = '". $id_user . "' ;";
        $result_users = $conn->query($sql);
        //Tabela usuário
        if ($result_users->num_rows > 0) {
            while($row_users = $result_users->fetch_assoc()) {
              $line = ($row_users['ID'] . " " . $row_users['id_sprestador'] . ";". $row_users['id_especialidade'] . ";". $row_users['descricao'] . ";|");
              fwrite($handle, $line);

//                echo $row_users['ID'] . " " . $row_users['id_sprestador'] . " ". $row_users['id_especialidade'] . " ". $row_users['descricao'] . PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
            }//end-while($row_user = $result_user->fetch_assoc()) {
        }//end-if ($result_user->num_rows > 0) {
    }//end-  for ($i = 1; $i < count($id_user_array); $i++){
    fwrite($handle, "0x03H");
    fclose($handle);
//     echo filesize($my_file);
    $conn->close();
    sendFile(4);
}



function saveCities($my_state){

   $servername = "localhost";
   $username   = "localuser";
   $password   = "localuser";
   $conn = new mysqli($servername, $username, $password);

   if ($conn->connect_error) {
      return;
   }

   if (!$conn->set_charset("utf8")) {
       myLog("Error loading character set utf8:" . $conn->error);
   }

   $my_file = "tmp/" . getRealIpAddr() . ".cities.txt";
   $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);


   $sql = "USE DBredelibras;";
   $conn->query($sql);

   $sql    = "select * from tbCidades where id_estado='" . $my_state . "' order by nome_cidade;";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
//          echo  $row["ID"] . " " . $row["nome_cidade"] .  ";". "<br>";
	  $line =  strtolower(($row["ID"] . ";" . $row["id_estado"] .  ";" . $row["nome_cidade"] . ";|"));

          fwrite($handle, $line);
       }
   }

   $conn->close();
   fclose($handle);
//   echo filesize($my_file);
   sendFile(3);
}




function saveLastUpdate(){

   $servername = "localhost";
   $username   = "localuser";
   $password   = "localuser";
   $conn = new mysqli($servername, $username, $password);

   if ($conn->connect_error) {
      return;
   }

   if (!$conn->set_charset("utf8")) {
       myLog("Error loading character set utf8:" . $conn->error);
   }

   $my_file = "tmp/" . getRealIpAddr() . ".lastupdate.txt";
   $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);


   $sql = "USE DBredelibras;";
   $conn->query($sql);

   $sql    = "select * from tbLastUpdate;";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
//          echo  $row["ID"] . ";" . $row["MYDATE"] .  ";"  . $row["MYTABLE"] .  ";". "<br>";
            $line =  strtolower(($row["MYDATE"] . ";" ));

       // $line =  $row["ID"] . ";" . $row["MYDATE"] . ";" . $row["MYTABLE"] .  ";\n";
	  fwrite($handle, $line);
       }
   }

   $conn->close();
   fclose($handle);
//   echo filesize($my_file);
   sendFile(2);
}

function myLog($smg){

   $my_file = "tmp/mylog.txt";
   $handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
   fwrite($handle, $smg . "\n");
   fclose($handle);

}



function saveServices(){

   $servername = "localhost";
   $username   = "localuser";
   $password   = "localuser";
   $conn = new mysqli($servername, $username, $password);

   if ($conn->connect_error) {
      return;
   }

   if (!$conn->set_charset("utf8")) {
       myLog("Error loading character set utf8:" . $conn->error);
   }

   $my_file = "tmp/" . getRealIpAddr() . ".services.txt";
   $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);


   $sql = "USE DBredelibras;";
   $conn->query($sql);

   $sql    = "select * from tbEspecialidades;";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
//          echo  $row["ID"] . ";" . $row["especialidade"] .  ";". "<br>";
          $line =  strtoupper(($row["ID"] . ";" . $row["especialidade"] .  ";|"));
//	  $line =  $row["ID"] . ";" . $row["especialidade"] .  ";\n";
	  fwrite($handle, $line);
       }
   }

   $conn->close();
   fclose($handle);
   //echo filesize($my_file);
   sendFile(1);
}



function request($app){
   if (strcmp($app,"RedeLibras") == 0){
   	echo "Hello";

   }else
	echo "olleH";
}


function login ($userDB, $passwdDB){
   $servername = "localhost";
   $username   = "localuser";
   $password   = "localuser";
   $conn = new mysqli($servername, $username, $password);

   if ($conn->connect_error) {
      return;
   }



   $sql = "USE DBredelibras;";
   $conn->query($sql);

   $sql    = "select ID,senha,nome from tbUsuario where login='" . $userDB . "';";
   $result = $conn->query($sql);
   $row    = $result->fetch_assoc();

   if ($row["senha"] == $passwdDB){
      echo $row["ID"] . ";" . $row["nome"];
   }else if ($row["senha"] == NULL){
      echo "-1;passwordunkown";
   }else{
     echo "-2;unkown";
   }

   $conn->close();

}

function getRealIpAddr(){
   return "localuser";
}



//-----------------------------------------------------------------------------------------------

   $state = $_GET['state'];


   switch ($state) {
               case 1:
            	   request($_GET['app']);
            	   break;
               case 2:
            	   login($_GET['user'], $_GET['passwd']);
            	   break;
               case 3:
            	   saveServices();
            	   break;
               case 4: //sendServices();
                  saveLastUpdate();
            	  break;
               case 5: //sendLastUpdate();
            	   saveCities($_GET['selected_state']);
            	   break;
               case 6://  sendCities();
                 saveUsersData($_GET['selected_state']);
                 break;
               case 7:
		 saveUsersPicture($_GET['selected_state']);     
                 break;
               default:
            	   break;

   }

?>
