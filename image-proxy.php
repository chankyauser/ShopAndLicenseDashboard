<?php
// proxy.php?url=encoded_url
$url = $_GET['url'];
header('Content-Type: image/jpeg');
echo file_get_contents($url);
?>
