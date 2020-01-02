<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Rede Libras - UFRRJ </title>
  <meta name="description" content="Rede Libras - UFRRJ">
  <link rel="stylesheet" href="css/ficha-sty.css" type="text/css" />
  <meta name="author" content="UFRRJ">
  <meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1">

<!--[if IE]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <script type="text/javascript" src="lib/jquery-3.3.1.js"></script>
  <script type="text/javascript" src="lib/responsivemultimenu.js"></script>
  <script type="text/javascript" src="lib/redelibrasevents.js"></script>


  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

</head>

 <body onload="onload()">
<!-- Menu -->




<button id="id_hidebutton_userdata" type="button" onClick = "hideObject('id_userdata', 'id_hidebutton_userdata', 'id_showbutton_userdata');" style="float: left;" >-</button>
<button id="id_showbutton_userdata" type="button" onClick = "showObject('id_userdata', 'id_hidebutton_userdata', 'id_showbutton_userdata' );" style="float: left;">+ Dados pessoais</button>
<br>
<br>
<!-- Dados profissionais -->
  <fieldset id="id_userdata">
   <legend>Nome:</legend>
   <table cellspacing="10" border="0">
     <col width="15%">
     <col width="85%">
    <tr>
     <td align="right">
      <label for="nome" >Nome completo: </label>
     </td>
     <td align="left">
      <input readonly type="text" id="id_txtName" name="txtName" onkeyup="this.value = this.value.toUpperCase();">
     </td>

    </tr>
   </table>
   <input type="hidden" id="id_IDUSER" name="id_IDUSER" value="-1">
   <input type="hidden" id="id_user_update" name="id_user_update" value="0">

 </fieldset>

 <?php
    include 'redelibrasfunc.php';
    //$userID = $_COOKIE['redelibras-user'];
    $userID = $_GET['id_user'];

    $result = redeLibrasQuery("SELECT * FROM tbUsuario WHERE ID='". $userID . "';");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['nome'];
        echo '<script>document.getElementById("id_txtName").value = "'.$name.'" ; </script>';
        echo '<script>document.getElementById("id_IDUSER").value = "'.$userID.'" ; </script>';
    }else{
      echo 'ERROR!!!!';
    }
 ?>

 <!-- Dados Endereços -->
   <br>
   <button id="id_hidebutton_useraddr" type="button" onClick = "hideObject('id_useraddr', 'id_hidebutton_useraddr', 'id_showbutton_useraddr');" style="float: left;" >-</button>
   <button id="id_showbutton_useraddr" type="button" onClick = "showObject('id_useraddr', 'id_hidebutton_useraddr', 'id_showbutton_useraddr' );" style="float: left;">+ Endereços</button>
   <br>
   <br>

   <fieldset  id="id_useraddr">
     <legend>Dados de Endereço</legend>
        <div>
           <table cellspacing="10" border="0">
             <col width="15%">
             <col width="85%">

            <tr>
             <td align="right" >
              <label for="lblAddr">Endereço (Rua/Av.):</label>
             </td>
             <td align="left">Endereços
              <input readonly type="text" id="id_txtAddr" onkeyup="this.value = this.value.toUpperCase();">
             </td>

            </tr>
            <tr>
              <td align="right">
               <label for="lblAddrAdd">Complemento:</label>
              </td>
              <td align="left">
               <input readonly type="text" id="id_txtAddrAdd" onkeyup="this.value = this.value.toUpperCase();" >
              </td>
            </tr>
            <tr>
             <td align="right">
              <label for="lblNeighborhood">Bairro: </label>
             </td>
             <td align="left">
              <input readonly type="text" id="id_txtNeighborhood" onkeyup="this.value = this.value.toUpperCase();">
             </td>
            </tr>
            <tr>
             <td align="right">
              <label for="lblState">Estado:</label>
             </td>
             <td align="left">
               <input readonly type="text" id="id_txtState" onkeyup="this.value = this.value.toUpperCase();">
             </td>
            </tr>
            <tr>
             <td align="right">
              <label for="lblCity">Cidade: </label>
             </td>
             <td align="left">
              <input readonly type="text" id="id_txtCity" onkeyup="this.value = this.value.toUpperCase();">
             </td>
            </tr>

          </table>
        </div>
    <div>
      <table cellspacing="10" border="0">

       <tr>
        <td align="center">
<!--          <button type="button" id="id_btnPrevAddr" onClick="prevAddr()">Anterior</button> -->
          <button type="button" id="id_btnPrevAddr" onClick="prevAddr()">Anterior</button>
        </td>

        <td align="center">
          <button type="button" id="id_btnNextAddr" onClick="nextAddr()">Próximo</button>
        </td>



       </tr>
     </table>
     <input type="hidden" id="id_IDADDR" name="id_IDADDR" value="-1">
     <input type="hidden" id="id_addr_update" name="id_addr_update" value="0">

     <hr>



     <input type="hidden" id="id_numAddrs" name="numAddrs" value="0">
     <input type="hidden" id="id_curAddrs" name="curAddrs" value="0">
    </div>
  </fieldset>
<?php
   $result = redeLibrasQuery("SELECT t1.ID, t1.id_sprestador, t1.endereco, t1.complemento, t1.bairro, t2.nome_cidade, t3.sigla_estado FROM tbEndereco t1 INNER JOIN tbCidades t2 INNER JOIN tbEstados t3 ON t2.ID = t1.id_cidade AND t3.ID = t2.id_estado AND t1.id_sprestador ='". $userID . "';");
   $lastRecord = $result->num_rows;

   if ($lastRecord > 0) {
       while($row = $result->fetch_assoc()) {

         $addrID =  $row['ID'];
         $addr  = strtoupper($row['endereco']);
         $addrMore = strtoupper($row['complemento']);
         $neighborhood =  strtoupper($row['bairro']);
         $city = strtoupper($row['nome_cidade']);
         $state = strtoupper($row['sigla_estado']);
         echo '<script>document.getElementById("id_txtAddr").value = "'.$addr.'" ; </script>' . PHP_EOL;
         echo '<script>document.getElementById("id_txtAddrAdd").value = "'.$addrMore.'" ; </script>' . PHP_EOL;
         echo '<script>document.getElementById("id_txtNeighborhood").value = "'.$neighborhood.'" ; </script>' . PHP_EOL;
         echo '<script>document.getElementById("id_txtCity").value = "'.$city.'" ; </script>' . PHP_EOL;
         echo '<script>document.getElementById("id_IDADDR").value = "'.$addrID.'" ; </script>' . PHP_EOL;
         echo '<script>document.getElementById("id_txtState").value = "'.$state.'" ; </script>' . PHP_EOL;
         //echo '<script>setStateValue("'.$state.'") ; </script>' . PHP_EOL;
         echo '<script>confirmAddr();</script>'. PHP_EOL;
       }

       echo '<script>document.getElementById("id_curAddrs").value = "1" ; </script>' . PHP_EOL;
       echo '<script>loadCurrentAddr();</script>'. PHP_EOL;

   }else{
     echo 'ERROR!!!!';
   }
?>

<!-- Telefones e emails -->

<br>

<button id="id_hidebutton_userphone" type="button" onClick = "hideObject('id_userphone', 'id_hidebutton_userphone', 'id_showbutton_userphone');" style="float: left;" >-</button>
<button id="id_showbutton_userphone" type="button" onClick = "showObject('id_userphone', 'id_hidebutton_userphone', 'id_showbutton_userphone' );" style="float: left;">+ Telefones</button>
<br>
<br>
<fieldset  id="id_userphone">
 <legend>Telefones</legend>
    <div>


      <table cellspacing="10" border="0" id="id_userphonelist">
      <tr>
        <td> <input type="hidden" id="idPhone" value="-1"> </td>
        <td> <input readonly id="txtPhone" type="text"  ></td>

       </tr>

     </table>

    </div>

    <td> <input type="hidden" id="id_phone_update" name="id_phone_update" value="0"> </td>


</fieldset>

<?php



   $result = redeLibrasQuery("SELECT * FROM tbTelefone WHERE id_sprestador = '". $userID . "';");
   $lastRecord = $result->num_rows;
   $index = 0;
   if ($lastRecord > 0) {
       while($row = $result->fetch_assoc()) {
         if ($index > 0)
           echo '<script> insRow("id_userphonelist"); </script>'. PHP_EOL;

         $idPhoneValue   =  $row['ID'];
         $txtPhoneValue  = strtoupper($row['telefone']);

         $idPhone = "idPhone";
         $txtPhone = "txtPhone";

         if ($index > 0){
           $idPhone .= $index;
           $txtPhone .= $index;
         }
         echo '<script> document.getElementById("'. $idPhone .'").value =  "'. $idPhoneValue .'"; </script>'. PHP_EOL;
         echo '<script> document.getElementById("'. $txtPhone  .'").value =  "' . $txtPhoneValue .'"; </script>'. PHP_EOL;


         $index++;
       }
   }else{
     echo 'ERROR!!!!';
   }
?>

<!-- email -->
<br>
<button id="id_hidebutton_useremail" type="button" onClick = "hideObject('id_useremail', 'id_hidebutton_useremail', 'id_showbutton_useremail');" style="float: left;" >-</button>
<button id="id_showbutton_useremail" type="button" onClick = "showObject('id_useremail', 'id_hidebutton_useremail', 'id_showbutton_useremail' );" style="float: left;">+ E-mails </button>
<br>
<br>
<fieldset  id="id_useremail">
 <legend>E-mail</legend>
    <div>
      <table cellspacing="10" border="0" id="id_useremaillist">
      <tr>
        <td> <input type="hidden" id="idEmail" value="-1"> </td>
        <td> <input readonly id="txtemail" type="email"  ></td>
        <td> <input type="hidden" id="id_phone_update" name="id_email_update" value="0"> </td>

       </tr>
     </table>
    </div>
    <td> <input type="hidden" id="id_email_update" name="id_email_update" value="0"> </td>

</fieldset>
<?php
   $result = redeLibrasQuery("SELECT * FROM tbEmail WHERE id_sprestador = '". $userID . "';");
   $lastRecord = $result->num_rows;
   $index = 0;
   if ($lastRecord > 0) {
       while($row = $result->fetch_assoc()) {
         if ($index > 0)
           echo '<script> insRow("id_useremaillist"); </script>'. PHP_EOL;

         $idEmailValue   =  $row['ID'];
         $txtEmailValue  = strtolower($row['email']);

         $idEmail = "idEmail";
         $txtemail = "txtemail";

         if ($index > 0){
           $idEmail .= $index;
           $txtemail .= $index;
         }
         echo '<script> document.getElementById("'. $idEmail .'").value =  "'. $idEmailValue .'"; </script>'. PHP_EOL;
         echo '<script> document.getElementById("'. $txtemail  .'").value =  "' . $txtEmailValue .'"; </script>'. PHP_EOL;


         $index++;
       }
   }else{
     echo 'ERROR!!!!';
   }
?>
</body>

</html>
