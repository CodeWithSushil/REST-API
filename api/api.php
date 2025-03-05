<?php
$data = json_decode(file_get_contents('php://input'), true);
print_r($data);
exit;
$pages = ['get','post','update','delete','pagination','search','login','register'];

foreach ($pages as $page) {
  require_once("./$page.php");
}

function getPost($id){

}

