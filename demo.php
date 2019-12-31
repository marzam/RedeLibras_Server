<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Rede Libras - UFRRJ </title>
  <meta name="description" content="Rede Libras - UFRRJ">
  <link rel="stylesheet" href="css/ficha-sty.css" type="text/css" />
  <meta name="author" content="UFRRJ">
  <meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1">


  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

</head>
<body onload="onload()">
<?php
  echo 'Olá <br>';
  $dataPOST = trim(file_get_contents('php://input'));
  $xmlData = simplexml_load_string($dataPOST);
  echo $xmlData->asXML();
  $handle = fopen("file.xml", "w");
  fwrite($handle,  $xmlData->asXML());
  fclose($handle);
/*
  print_r($xmlData);
  $dom = new DomDocument('1.0', 'UTF-8');
  $dom->formatOutput = true; // set the formatOutput attribute of domDocument to true
  $dom->loadXML($xmlData);
  $test1 = $dom->saveXML(); // put string in test1
  $dom->save('test1.xml'); // save as file

//Save XML as a file
*/
  echo 'End the game!';
?>
</body>
</html>
