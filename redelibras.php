<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Rede Libras - UFRRJ </title>
  <meta name="description" content="Rede Libras - UFRRJ">
  <link rel="stylesheet" href="style.css" type="text/css" />


</head>
<body>
<?php
/*
SELECT tbEspecialidades.ID,tbEspecialidades.especialidade FROM
tbEspecialidades,tbPEspecialidade,tbUsuario,tbEndereco,tbCidades WHERE
tbEspecialidades.ID = tbPEspecialidade.id_especialidade AND
tbPEspecialidade.id_sprestador = tbUsuario.ID AND
tbEndereco.id_sprestador = tbUsuario.ID AND
tbEndereco.id_cidade = tbCidades.ID AND
tbCidades.id_estado = '18' GROUP BY
tbEspecialidades.especialidade ORDER BY
tbEspecialidades.especialidade;

SELECT tbEspecialidades.ID,tbEspecialidades.especialidade
FROM
tbEspecialidades,tbPEspecialidade,tbUsuario,tbEndereco,tbCidades
WHERE
tbEspecialidades.ID = tbPEspecialidade.id_especialidade AND
tbPEspecialidade.id_sprestador = tbUsuario.ID AND
tbEndereco.id_sprestador = tbUsuario.ID AND
tbEndereco.id_cidade = '2780'
GROUP BY tbEspecialidades.especialidade ORDER BY tbEspecialidades.especialidade;

SELECT tbUsuario.nome, tbEspecialidades.especialidade, tbEndereco.endereco FROM tbUsuario, tbEndereco, tbCidades, tbPEspecialidade, tbEspecialidades WHERE tbUsuario.ID = tbEndereco.id_sprestador AND tbEndereco.id_cidade = tbCidades.ID AND tbUsuario.ID = tbPEspecialidade.id_sprestador AND tbPEspecialidade.id_especialidade = 5 AND tbCidades.id_estado = 18

*/
include 'redelibrasfunc.php';
//-----------------------------------------------------------------------------------------------
function states_maps(){
  echo '<script>';
  echo 'function onClick_states_maps(opt) {';
      echo 'JSReceiver.onClick_states_maps(opt);';
  echo '}';
  echo '</script>';

  $result = redeLibrasQuery("select * from tbEstados order by nome_estado");
  if ($result->num_rows > 0) {
        echo '<table style="width:100%">' ;

            while($row = $result->fetch_assoc()) {
              echo '<tr>';
              echo '<th> <button class="link" onclick="onClick_states_maps(' . $row['ID'] . ')"> <img src="img/mapa_' .  strtolower($row['sigla_estado']) . '.jpg" width="96" height="96" ALIGN="center" > </button> </th>';
              echo '<th> &nbsp;&nbsp; </th>';
              echo '<th>';
                  echo '<p>';
                      echo '<h2> <button class="link" onclick="onClick_states_maps(' . $row['ID'] . ')">' . $row['nome_estado'] . '</button> </h2>';
                      echo '<h2> <button class="link" onclick="onClick_states_maps(' . $row['ID'] . ')">' . $row['sigla_estado']. '</button> </h2>';
                  echo '</p>';
              echo '</th>';
              echo '</tr>';
            }//end-while($row = $result->fetch_assoc()) {


        echo '</table>' ;

  }//end-if ($result->num_rows > 0) {

}

//-----------------------------------------------------------------------------------------------
function cities($id_state){
  $result = redeLibrasQuery("select * from tbCidades where id_estado='" . $id_state ." order by nome_cidade';");
  
  echo '<script>';
  echo 'function onClick_select_city(opt) {';
      echo 'JSReceiver.onClick_select_city(opt);';
  echo '}';
  echo '</script>';


//  echo 'Cidades: <br>';
  if ($result->num_rows > 0) {
      echo '<table style="width:100%">';

      while($row = $result->fetch_assoc()) {
         echo '<tr>';
         echo '<td> <button class="link" onclick="onClick_select_city(' . $row['ID'] .')"> ' . $row['nome_cidade'] . '</td>';
	 
//      echo '<td>' . $row['nome_cidade'] . '</td> <td> ' . $row['ID'] . '</td>';
//  echo '<th> <button class="link" onclick="onClick_states_maps(' . $row['ID'] . ')"> <img src="img/mapa_' .  strtolower($row['sigla_estado']) . '.jpg" width="96" height="96" ALIGN="center" > </button> </th>';
 
	 echo '</tr>';
      }//end-if($row = $result->fetch_assoc()) {

      echo '</table>';
  }//end-if ($result->num_rows > 0) {

}
//-----------------------------------------------------------------------------------------------
function services_in_state($id_state){
  echo '<script>';
  echo 'function onClick_services_in_state(opt) {';
      echo 'JSReceiver.onClick_services_in_state(opt);';
  echo '}';
  echo '</script>';

  //$result = redeLibrasQuery("SELECT tbEspecialidades.ID,tbEspecialidades.especialidade FROM tbEspecialidades,tbPEspecialidade,tbUsuario,tbEndereco,tbCidades WHERE tbEspecialidades.ID = tbPEspecialidade.id_especialidade AND tbPEspecialidade.id_sprestador = tbUsuario.ID AND tbEndereco.id_sprestador = tbUsuario.ID AND tbEndereco.id_cidade = tbCidades.ID AND tbCidades.id_estado = '" . $id_state . "' GROUP BY tbEspecialidades.especialidade ORDER BY tbEspecialidades.especialidade;");
  $result = redeLibrasQuery("SELECT t1.ID,t1.especialidade FROM tbEspecialidades t1 INNER JOIN tbPEspecialidade t2 ON t1.ID = t2.id_especialidade INNER JOIN tbEndereco t3 ON t2.id_sprestador = t3.id_sprestador INNER JOIN tbCidades t4 ON t3.id_cidade = t4.ID INNER JOIN tbEstados t5 ON t4.id_estado = t5.ID AND t5.ID = '" . $id_state . "' GROUP BY t1.especialidade ORDER BY t1.especialidade;");

  if ($result->num_rows > 0) {
      echo '<table style="width:100%">';

      while($row = $result->fetch_assoc()) {
        echo '<tr>';

        echo '<td> <button class="link" onclick="onClick_services_in_state(' . $row['ID'] . ')">' . $row['especialidade'] . '</button> </td>';
        //echo '<td>' . $mapName . '</td> <td>' . $row['nome_estado'] . '</td> <td> ' . $row['sigla_estado'] . '</td> <td> ' . $row['ID'] . '</td>';

        echo '</tr>';
      }//end-if($row = $result->fetch_assoc()) {

      echo '</table>';
  }//end-if ($result->num_rows > 0) {



}

//-----------------------------------------------------------------------------------------------
function services_in_city($id_city){
  $result = redeLibrasQuery("SELECT t1.ID,t1.especialidade FROM tbEspecialidades t1 INNER JOIN tbPEspecialidade t2 ON t1.ID = t2.id_especialidade INNER JOIN tbEndereco t3 ON t2.id_sprestador = t3.id_sprestador INNER JOIN tbCidades t4 ON t3.id_cidade = t4.ID AND t4.ID = '". $id_city . "' GROUP BY t1.especialidade ORDER BY t1.especialidade;");
  
  echo '<script>';
  echo 'function onClick_select_service_in_city(opt) {';
      echo 'JSReceiver.onClick_select_service_in_city(opt);';
  echo '}';
  echo '</script>';


//  echo 'Especialidades: <br>';
  if ($result->num_rows > 0) {
      echo '<table style="width:100%">';

      while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td> <button class="link" onclick="onClick_select_service_in_city('. $row['ID']  .')">' . $row['especialidade'] . '</button> </td>';	
//       echo '<td>' . $row['ID'] . '</td> <td> ' . $row['especialidade'] . '</td>';

        echo '</tr>';
      }//end-if($row = $result->fetch_assoc()) {

      echo '</table>';
  }//end-if ($result->num_rows > 0) {

}
//-----------------------------------------------------------------------------------------------
function list_of_workers_in_city_selected_service($id_service, $id_city){
      
	$result = redeLibrasQuery("SELECT t1.nome as name, t1.ID as ID FROM tbUsuario AS t1 INNER JOIN tbEndereco AS t2 INNER JOIN tbPEspecialidade AS t3 ON t1.ID = t2.id_sprestador AND t1.ID = t3.id_sprestador WHERE t2.id_cidade = '". $id_service  ."' AND t3.id = '". $id_city  ."' ORDER BY t1.nome;");
  
  echo '<script>';
  echo 'function onClick_select_worker(opt) {';
      echo 'JSReceiver.onClick_select_worker(opt);';
  echo '}';
  echo '</script>';


//  echo 'Especialidades: <br>';
  if ($result->num_rows > 0) {
      echo '<table style="width:100%">';

      while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td> <button class="link" onclick="onClick_select_workers('. $row['ID']  .')">' . $row['name'] . '</button> </td>';	
//       echo '<td>' . $row['ID'] . '</td> <td> ' . $row['especialidade'] . '</td>';

        echo '</tr>';
      }//end-if($row = $result->fetch_assoc()) {

      echo '</table>';
  }//end-if ($result->num_rows > 0) {

}



//-----------------------------------------------------------------------------------------------
/*
SELECT tbUsuario.ID,tbUsuario.nome,tbEspecialidades.especialidade FROM
tbUsuario, tbEndereco, tbPEspecialidade, tbEspecialidades, tbCidades WHERE
tbCidades.id_estado = 18 AND
tbEndereco.id_cidade = tbCidades.ID AND
tbPEspecialidade.id_especialidade = 5 AND
tbUsuario.ID = tbPEspecialidade.id_sprestador AND
tbUsuario.ID =  tbEndereco.id_sprestador
ORDER BY tbUsuario.nome;

*/
function workers_by_service_and_state($id_service, $id_state){
  echo '<script>';
  echo 'function onClick_workers_by_service_and_state(opt) {';
      echo 'JSReceiver.onClick_workers_by_service_and_state(opt);';
  echo '}';
  echo '</script>';

  $sql = "SELECT t1.ID,t1.nome, t3.nome_cidade FROM tbUsuario t1 INNER JOIN tbEndereco t2 ON t1.ID = t2.id_sprestador INNER JOIN tbCidades t3 ON t2.id_cidade = t3.ID INNER JOIN tbEstados t4 ON t3.id_estado = t4.ID AND t4.ID =  '" . $id_state . "'  INNER JOIN tbPEspecialidade t5 ON t1.ID = t5.id_sprestador INNER JOIN tbEspecialidades t6 ON t5.id_especialidade = t6.ID AND t6.ID = '" . $id_service .  "' GROUP BY t1.nome ORDER BY t1.nome;";
  //$sql = "SELECT t1.ID,t1.nome,t3.nome_cidade FROM tbUsuario t1 INNER JOIN tbEndereco t2 ON t1.ID = t2.id_sprestador INNER JOIN tbCidades t3 ON t2.id_cidade = t3.ID INNER JOIN tbEstados t4 ON t3.id_estado = t4.ID AND t4.ID = '" . $id_state . "' INNER JOIN tbPEspecialidade t5 ON t1.ID = t5.id_sprestador INNER JOIN tbEspecialidades t6 ON t5.id_especialidade = t6.ID AND t6.ID = '" . $id_service .  "' ORDER BY t1.nome;";
  $result_user = redeLibrasQuery($sql);

  if ($result_user->num_rows > 0) {

      echo '<table style="width:100%">';

      while($row = $result_user->fetch_assoc()) {
        echo '<tr>';
          echo '<td>';
              //echo  $row['ID'] . "</br>";
              //echo  strtoupper($row['nome']) . "</br>";
              echo '<button class="link" onclick="onClick_workers_by_service_and_state(' . $row['ID'] . ')">' . strtoupper($row['nome']) . '</button>';
              //echo "<p> <h1>". strtoupper($row['nome']) . " </h1> </p>" ;
              //echo  "CIDADE: ". strtoupper($row['nome_cidade']);

              $sql = "SELECT * FROM tbEmail t1 WHERE t1.id_sprestador = '" . $row['ID'] . "';";
              $result_email = redeLibrasQuery($sql);
              if ($result_email->num_rows > 0){
                  while($row_email = $result_email->fetch_assoc()) {
                      echo "<p>";
                      echo '<img src="img/e-mail.jpg" width="24" height="24" > ';
//                      echo "<h2>" . $row_email['email'] . " </h2> ";
                      echo $row_email['email'] ;
                      echo "</p><br>";
                  }
              }//edn-if ($result_email->num_rows > 0){

              $sql = "SELECT * FROM tbTelefone t1 WHERE t1.id_sprestador = '" . $row['ID'] . "';";
              $result_telefone = redeLibrasQuery($sql);
              if ($result_telefone->num_rows > 0){

                  //echo "TELEFONE: </br>";
                  while($row_telefone = $result_telefone->fetch_assoc()) {
                    echo "<p>";
                    echo '<img src="img/phone.jpg" width="32" height="32" > ';
                    echo '<img src="img/whatsapp.jpg" width="24" height="24" > ';
//                      echo "<h2>" . $row_email['email'] . " </h2> ";
                    echo  $row_telefone['telefone'] ;
                    echo "</p><br>";


                  }
              }//edn-if ($result_email->num_rows > 0){

              echo "<hr>";
          echo '</td>';
        echo '</tr>';
      }//end-if($row = $result->fetch_assoc()) {

      echo '</table>';
  }//end-if ($result->num_rows > 0) {

}


function worker_full_info($id_user){
/*
<h2>align="left":</h2>
<p>This is some text. <img src="smiley.gif" alt="Smiley face" width="42" height="42" align="left"> This is some text.</p>
*/

  $sql = "SELECT * FROM tbUsuario t1 WHERE t1.ID = '" . $id_user . "';";
  $result_user = redeLibrasQuery($sql);
  //echo '<button class="link">Clicky</button>';
  if ($result_user->num_rows > 0) {
      $row_user = $result_user->fetch_assoc();

      //echo '<p>' . $row_user['nome'] . $row_user['rank'] . ' <img src="anonymous_m.jpg" alt="Girl in a jacket" width="96" height="96"></br> </p>';

      //echo "<img src="mapas/anonymous_m.png" />";
      echo '<table class="record">' ;
        echo '<col width="20%">';
        echo '<col width="80%">';
      echo '<tr class="record" ALIGN="center">';
          echo '<th class="record"> <img  class="record" src="img/anonymous_m.jpg"> </th>';

          echo '<th class="record">';
              //echo '<p>';
                  echo '<h2  class="record" >' . strtoupper($row_user['nome']) . '</h2>';
                  echo '<h2  class="record" >ID:' . $row_user['ID'] . '</h2>';
                  echo '<h2  class="record" >Pontuação:' . $row_user['rank'] . '</h2>';

          echo '</th>';
      echo '</tr>';
      echo '</table>' ;
//Exibe telefone, email e os serviços
/*
      echo '<table>' ;
      echo '<tr>';
          echo '<th>';
            echo '<h2  ALIGN="left">Telefone: </h2>';
          echo '</th>';
          echo '<th>';
            echo '&nbsp;';
          echo '</th>';
          echo '<th>';
            echo '<h2  ALIGN="left">e-mail: </h2>';
          echo '</th>';
      echo '</tr>';
      echo '<tr>';

          echo '<th>';
                $sql = "SELECT * FROM tbTelefone t1 WHERE t1.id_sprestador = '" . $row_user['ID'] . "';";
                $result_telefone = redeLibrasQuery($sql);
                if ($result_telefone->num_rows > 0){
                    while($row_telefone = $result_telefone->fetch_assoc()) {
                        echo '<h3 ALIGN="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row_telefone['telefone'] . ' </h3>';
                    }
                }//edn-if ($result_email->num_rows > 0){
          echo '</th>';
          echo '<th> &nbsp;&nbsp; </th>';

          echo '<th>';
              $sql = "SELECT * FROM tbEmail t1 WHERE t1.id_sprestador = '" . $row_user['ID'] . "';";
              $result_email = redeLibrasQuery($sql);
              if ($result_email->num_rows > 0){
                  while($row_email = $result_email->fetch_assoc()) {
                      echo '<h3 ALIGN="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row_email['email'] . ' </h3>';
                  }
              }//edn-if ($result_email->num_rows > 0){
          echo '</th>';
      echo '</tr>';
      echo '</table>' ;

//Exibe Endereços completos
      $sql = "SELECT t1.endereco,t1.complemento,t1.bairro,t2.nome_cidade,t3.sigla_estado FROM tbEndereco t1 INNER JOIN tbCidades t2 ON t1.id_cidade = t2.ID INNER JOIN tbEstados t3 ON t2.id_estado = t3.ID WHERE t1.id_sprestador = '" . $row_user['ID'] . "'";
      $result_addr = redeLibrasQuery($sql);

      echo '<table>' ;
      echo '<tr ALIGN="left">';
          echo '<th> Rua/Av. </th>';
          echo '<th> Complemento </th>';
          echo '<th> Bairro </th>';
          echo '<th> Cidade </th>';
          echo '<th> Estado </th>';
      echo '</tr>';
      echo '<tr ALIGN="left">';

      if ($result_addr->num_rows > 0) {
          while($row_addr = $result_addr->fetch_assoc()){
            echo '<th>' . strtoupper($row_addr['endereco']) . '</th>';
            echo '<th>' . strtoupper($row_addr['complemento']) . '</th>';
            echo '<th>' . strtoupper($row_addr['bairro']) . '</th>';
            echo '<th>' . strtoupper($row_addr['nome_cidade']) . '</th>';
            echo '<th>' . strtoupper($row_addr['sigla_estado']) . '</th>';
          }//end-while($row_adrr = $result_addr->fetch_assoc()){
      }//end-if ($result_addr->num_rows > 0) {

      echo '</tr>';

      echo '</table>' ;
*/
      //SELECT t1.endereco,t1.complemento,t1.bairro,t2.nome_cidade,t3.sigla_estado FROM tbEndereco t1 INNER JOIN tbCidades t2 ON t1.id_cidade = t2.ID INNER JOIN tbEstados t3 ON t2.id_estado = t3.ID WHERE t1.id_sprestador = '85'




  }//end-if ($result_user->num_rows > 0) {
}
//-----------------------------------------------------------------------------------------------
   $state = $_GET['state'];


   switch ($state) {
       case 1: states_maps(); break;//https://192.168.1.11/redelibras.php?state=1
       case 2: cities($_GET['id_state']); break;//https://192.168.1.11/redelibras.php?state=2&id_state=18
       case 3: services_in_state($_GET['id_state']); break; //https://192.168.1.11/redelibras.php?state=3&id_state=18
       case 4: services_in_city($_GET['id_city']); break; //https://192.168.1.11/redelibras.php?state=4&id_city=2780
       case 5: list_of_workers_in_city_selected_service($_GET['id_service'], $_GET['id_city']); break; //https://192.168.1.11/redelibras.php?state=5&id_state=18&id_service=5
       
//     case 5: workers_by_service_and_state($_GET['id_service'], $_GET['id_state']); break; //https://192.168.1.11/redelibras.php?state=5&id_state=18&id_service=5
       case 6: worker_full_info($_GET['id_user']);break; //https://192.168.1.11/redelibras.php?state=6&id_user=85
       case 7: login($_GET['id_user'], $_GET['id_passwd']);break;
       default:break;

   }
?>


</body>

</html>
