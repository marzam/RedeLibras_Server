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
?>
