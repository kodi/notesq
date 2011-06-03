<?php

include('lib.php');

$what = isset($_GET['what']) ? $_GET['what'] : $_POST['what'];
$id = $_GET['id'];

$data = new Data();

if ($what == "titles"){
    
    $data->getTitles();
    
}


if ($what == "content"){
    
    $data->getContent($id);
    
}

if ($what == "save"){
    
    $data->save($_POST['content'], $_POST['id']);
    
}

if ($what == "newdocument"){
    $data->newDoc($_POST['name'], $_POST['group']);
}

if ($what == "newgroup"){
    $data->newGroup($_POST['name']);
}

if ($what == "newuser" ){
    $data->newUser($_POST['username'], $_POST['password'], $_POST['password2'], $_POST['email']);
}