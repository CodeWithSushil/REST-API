<?php

$pages = ['get','post','update','delete','pagination','search','login','register'];

foreach ($pages as $page) {
  require_once("./$page.php");
}

function getPost($id){

}

