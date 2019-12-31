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


<div>
  <div class="rmm style">
    <ul>
      <li>
        <a id="id_login" href="#">Login</a>
      </li>
      <script type="text/javascript">  $('a#id_login').click(function(){ login(); }) </script>

      <li>
        <a id="id_logout" href="#">Logout</a>
      </li>
      <script type="text/javascript">  $('a#id_logout').click(function(){ logout(); }) </script>

      <li>
        <a id="id_record" href="#">Cadastro</a>
      </li>
      <script type="text/javascript">  $('a#id_record').click(function(){ record(); }) </script>

      <li>
        <a id="id_services" href="#">Serviços</a>
      </li>
      <script type="text/javascript">  $('a#id_services').click(function(){ services(); }) </script>
    </ul>
  </div>
</div>

<button id="id_hidebutton_userdata" type="button" onClick = "hideObject('id_userdata', 'id_hidebutton_userdata', 'id_showbutton_userdata');" style="float: left;" >-</button>
<button id="id_showbutton_userdata" type="button" onClick = "showObject('id_userdata', 'id_hidebutton_userdata', 'id_showbutton_userdata' );" style="float: left;">+ Dados pessoais</button>
<br>
<br>
<!-- Dados profissionais -->
  <fieldset id="id_userdata">
   <legend>Dados Pessoais</legend>
   <table cellspacing="10" border="0">
     <col width="15%">
     <col width="85%">
    <tr>
     <td align="right">
      <label for="nome">Nome completo: </label>
     </td>
     <td align="left">
      <input type="text" id="id_txtName" name="txtName" onkeyup="this.value = this.value.toUpperCase();">
     </td>

    </tr>
    <tr>
     <td align="right">
      <label>Login: </label>
     </td>
     <td align="left">
        <input type="text" id="id_txtLogin" name="txtLogin" maxlength="24" readonly="readonly" >
     </td>
    </tr>
    <tr>
      <td align="right">
       <label>Senha: </label>
      </td>
      <td align="left">
         <input type="password" id="id_Txtpasswd" name="txtSenha" maxlength="24">
      </td>
    </tr>
   </table>
   <input type="hidden" id="id_IDUSER" name="id_IDUSER" value="-1">
   <input type="hidden" id="id_user_update" name="id_user_update" value="0">
   <hr>
   <button id="id_user_data_confirm" type="button" onClick = "document.getElementById('id_user_update').value = '1'" style="float: center;" > Confirma </button>

 </fieldset>

 <?php
    include 'redelibrasfunc.php';
    $userID = $_COOKIE['redelibras-user'];

    $result = redeLibrasQuery("SELECT * FROM tbUsuario WHERE ID='". $userID . "';");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['nome'];
        $login = $row['login'];
        $passwd = $row['senha'];
        echo '<script>document.getElementById("id_txtName").value = "'.$name.'" ; </script>';
        echo '<script>document.getElementById("id_txtLogin").value = "'.$login.'" ; </script>';
        echo '<script>document.getElementById("id_Txtpasswd").value = "'.$passwd.'" ; </script>';
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
              <input type="text" id="id_txtAddr" onkeyup="this.value = this.value.toUpperCase();">
             </td>

            </tr>
            <tr>
              <td align="right">
               <label for="lblAddrAdd">Complemento:</label>
              </td>
              <td align="left">
               <input type="text" id="id_txtAddrAdd" onkeyup="this.value = this.value.toUpperCase();" >
              </td>
            </tr>
            <tr>
             <td align="right">
              <label for="lblNeighborhood">Bairro: </label>
             </td>
             <td align="left">
              <input type="text" id="id_txtNeighborhood" onkeyup="this.value = this.value.toUpperCase();">
             </td>
            </tr>
            <tr>
             <td align="right">
              <label for="lblState">Estado:</label>
             </td>
             <td align="left">
              <select id="id_selState">
              <option value="AC">Acre</option>
              <option value="AL">Alagoas</option>
              <option value="AM">Amazonas</option>
              <option value="AP">Amapá</option>
              <option value="BA">Bahia</option>
              <option value="CE">Ceará</option>
              <option value="DF">Distrito Federal</option>
              <option value="ES">Espírito Santo</option>
              <option value="GO">Goiás</option>
              <option value="MA">Maranhão</option>
              <option value="MT">Mato Grosso</option>
              <option value="MS">Mato Grosso do Sul</option>
              <option value="MG">Minas Gerais</option>
              <option value="PA">Pará</option>
              <option value="PB">Paraíba</option>
              <option value="PR">Paraná</option>
              <option value="PE">Pernambuco</option>
              <option value="PI">Piauí</option>
              <option value="RJ">Rio de Janeiro</option>
              <option value="RN">Rio Grande do Norte</option>
              <option value="RO">Rondônia</option>
              <option value="RS">Rio Grande do Sul</option>
              <option value="RR">Roraima</option>
              <option value="SC">Santa Catarina</option>
              <option value="SE">Sergipe</option>
              <option value="SP">São Paulo</option>
              <option value="TO">Tocantins</option>
             </select>
             </td>
            </tr>
            <tr>
             <td align="right">
              <label for="lblCity">Cidade: </label>
             </td>
             <td align="left">
              <input type="text" id="id_txtCity" onkeyup="this.value = this.value.toUpperCase();">
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
          <button type="button" id="id_btnAddAddr" onClick="addAddr()">Adicionar</button>
        </td>
        <td align="center">
          <button type="button" id="id_btnDelAddr" onClick="delAddr()">Apagar</button>
        </td>
        <td align="center">
          <button type="button" id="id_btnNextAddr" onClick="nextAddr()">Próximo</button>
        </td>

        <td align="center">
          <button type="button" id="id_btnOKAddr" onClick="confirmAddr()">Confirma</button>
        </td>

        <td align="center">
          <button type="button" id="id_btnCancelAddr" onClick="cancelAddr()">Cancela</button>
        </td>

       </tr>
     </table>
     <input type="hidden" id="id_IDADDR" name="id_IDADDR" value="-1">
     <input type="hidden" id="id_addr_update" name="id_addr_update" value="0">

     <hr>
     <button id="id_addr_data_confirm" type="button" onClick = "document.getElementById('id_addr_update').value = '1'" style="float: center;" > Confirma </button>


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
         //echo '<script>document.getElementById("id_numAddrs").value = "'.$curRecord.'" ; </script>' . PHP_EOL;
         //echo '<script>document.getElementById("id_curAddrs").value = "1" ; </script>' . PHP_EOL;
         echo '<script>setStateValue("'.$state.'") ; </script>' . PHP_EOL;
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
        <td> <input  id="txtPhone" type="text"  ></td>
        <td> <button id="addPhone" type="button" onclick="insRow('id_userphonelist');" >+</button> </td>
        <td> <button id="remPhone" type="button" onclick="delRow(this, 'id_userphonelist');">-</button> </td>
       </tr>

     </table>

    </div>

    <td> <input type="hidden" id="id_phone_update" name="id_phone_update" value="0"> </td>
    <hr>
    <button id="id_phone_data_confirm" type="button" onClick = "document.getElementById('id_phone_update').value = '1'" style="float: center;" > Confirma </button>

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
        <td> <input  id="txtemail" type="email"  ></td>
        <td> <input type="hidden" id="id_phone_update" name="id_email_update" value="0"> </td>
        <td> <button id="addemail" type="button" onclick="insRow('id_useremaillist');" >+</button> </td>
        <td> <button id="rememail" type="button" onclick="delRow(this, 'id_useremaillist');">-</button> </td>
       </tr>
     </table>
    </div>
    <td> <input type="hidden" id="id_email_update" name="id_email_update" value="0"> </td>
    <hr>
    <button id="id_email_data_confirm" type="button" onClick = "document.getElementById('id_email_update').value = '1'" style="float: center;" > Confirma </button>

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

<br><br>
<div>
  <button id="id_save" type="button" onclick="sendXML();" >Gravar dados</button>
</div>

</body>

</html>
