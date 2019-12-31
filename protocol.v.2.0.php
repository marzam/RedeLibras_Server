<?php
function asciitohex($inmsg){
   $msg = utf8_decode($inmsg);
   $outmsg = "";

   for ($i = 0; $i < strlen($msg); $i++){
     $byte = substr($msg, $i, 1);
     $outmsg .= dechex(ord($byte));

   }

   return $outmsg;
}
function getQueryUserData($my_state){
  $servername = "localhost";
  $username   = "localuser";
  $password   = "localuser";
  $conn = new mysqli($servername, $username, $password);
  $id_user_array = array("-1");
  $my_file = "cadastro.txt";
  $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

  if ($conn->connect_error) {
     return;
  }

  if (!$conn->set_charset("utf8")) {
      myLog("Error loading character set utf8:" . $conn->error);
  }

  $sql = "USE DBredelibras;";
  $conn->query($sql);

  $sql    = "select ID from tbEstados where sigla_estado='RJ';";
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
  fwrite($handle, "0x02H");
  for ($i = 1; $i < count($id_user_array); $i++){
    $id_user = $id_user_array[$i];
    $sql    = "SELECT * from tbUsuario WHERE tbUsuario.ID = '". $id_user . "' ;";
    $result_users = $conn->query($sql);
    //Tabela usuário
    if ($result_users->num_rows > 0) {
        while($row_users = $result_users->fetch_assoc()) {
          $line = asciitohex($row_users['ID'] . ";" . $row_users['nome'] . ";" . $row_users['rank'] . ";" .  $row_users['tipo'] . ";|");
          fwrite($handle, $line);
//            echo $row_users['ID'] . " " . $row_users['nome'] . " " . $row_users['rank'] . " " .  $row_users['tipo'] . PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
        }//end-while($row_user = $result_user->fetch_assoc()) {
    }//end-if ($result_user->num_rows > 0) {

  }//end-  for ($i = 1; $i < count($id_user_array); $i++){
  fwrite($handle, "0x03H0x02H");

//e-mail
  for ($i = 1; $i < count($id_user_array); $i++){
      $id_user = $id_user_array[$i];
      $sql    = "SELECT * from tbEmail WHERE tbEmail.id_sprestador = '". $id_user . "' ;";
      $result_users = $conn->query($sql);
      //Tabela usuário
      if ($result_users->num_rows > 0) {
          while($row_users = $result_users->fetch_assoc()) {
            $line = asciitohex($row_users['id_sprestador'] . ";" . $row_users['email'] .  ";|");
            fwrite($handle, $line);
              //echo $row_users['id_sprestador'] . " " . $row_users['email'] . " ". PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
          }//end-while($row_user = $result_user->fetch_assoc()) {
      }//end-if ($result_user->num_rows > 0) {
  }//end-  for ($i = 1; $i < count($id_user_array); $i++){
  fwrite($handle, "0x03H0x02H");
  //telefone
    for ($i = 1; $i < count($id_user_array); $i++){
        $id_user = $id_user_array[$i];
        $sql    = "SELECT * from tbTelefone WHERE tbTelefone.id_sprestador = '". $id_user . "' ;";
        $result_users = $conn->query($sql);
        //Tabela usuário
        if ($result_users->num_rows > 0) {
            while($row_users = $result_users->fetch_assoc()) {
              $line = asciitohex($row_users['id_sprestador'] . ";" . $row_users['telefone'] .  ";|");
              fwrite($handle, $line);
//                echo $row_users['id_sprestador'] . " " . $row_users['telefone'] . " ". PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
            }//end-while($row_user = $result_user->fetch_assoc()) {
        }//end-if ($result_user->num_rows > 0) {
    }//end-  for ($i = 1; $i < count($id_user_array); $i++){
    fwrite($handle, "0x03H0x02H");
    //endereco
    for ($i = 1; $i < count($id_user_array); $i++){
        $id_user = $id_user_array[$i];

        $sql    = "SELECT * from tbEndereco WHERE tbEndereco.id_sprestador = '". $id_user . "' ;";
        $result_users = $conn->query($sql);
        //Tabela usuário
        if ($result_users->num_rows > 0) {
            while($row_users = $result_users->fetch_assoc()) {
              $line = asciitohex($row_users['id_sprestador'] . ";" . $row_users['endereco'] . ";". $row_users['complemento'] . ";". $row_users['bairro'] . ";". $row_users['id_cidade'] . ";|");
              fwrite($handle, $line);
//                echo $row_users['id_sprestador'] . " " . $row_users['endereco'] . " ". $row_users['complemento'] . " ". $row_users['bairro'] . " ". $row_users['id_cidade'] . " ". PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
            }//end-while($row_user = $result_user->fetch_assoc()) {
        }//end-if ($result_user->num_rows > 0) {
    }//end-  for ($i = 1; $i < count($id_user_array); $i++){
    fwrite($handle, "0x03H0x02H");
    //Especialidades
    for ($i = 1; $i < count($id_user_array); $i++){
        $id_user = $id_user_array[$i];
        $sql    = "SELECT * from tbPEspecialidade WHERE tbPEspecialidade.id_sprestador = '". $id_user . "' ;";
        $result_users = $conn->query($sql);
        //Tabela usuário
        if ($result_users->num_rows > 0) {
            while($row_users = $result_users->fetch_assoc()) {
              $line = asciitohex($row_users['ID'] . " " . $row_users['id_sprestador'] . ";". $row_users['id_especialidade'] . ";". $row_users['descricao'] . ";|");
              fwrite($handle, $line);

//                echo $row_users['ID'] . " " . $row_users['id_sprestador'] . " ". $row_users['id_especialidade'] . " ". $row_users['descricao'] . PHP_EOL; //AQUI INCLUIR O CAMPO FOTO
            }//end-while($row_user = $result_user->fetch_assoc()) {
        }//end-if ($result_user->num_rows > 0) {
    }//end-  for ($i = 1; $i < count($id_user_array); $i++){
    fwrite($handle, "0x03H");
    fclose($handle);
     echo filesize($my_file);
  $conn->close();
}


//-----------------------------------------------------------------------------------------------
  $input = "RJ";
  getQueryUserData($input);

?>
