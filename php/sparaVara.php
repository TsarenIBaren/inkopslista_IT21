<?php
declare (strict_types=1);

// Inkludera gemensamma
require_once "funktioner.php";

//läs indata och sanera
// Kontrollera metod
if ($_SERVER['REQUEST_METHOD']!=='POST') {
    $error=new stdClass();
    $error->meddelande=["Wrong method", "Sidan ska anropas med POST"];
    skickaJSON($error, 405);
}

// Läs indata
$vara=filter_input(INPUT_POST, 'vara', FILTER_SANITIZE_SPECIAL_CHARS);
if(!isset($vara) || mb_strlen($vara)>50) {
    $error=new stdClass();
    $error->meddelande=["bad input", "Parametern 'vara' saknas eller är för lång (max 50 tecken)"];
    skickaJSON($error, 400);
}
    
//koppla mot databas
$db=connectDB();

//Spara data
$sql="INSERT INTO varor (namn) VALUES (:vara)";
$stmt=$db->prepare($sql);

$stmt->execute(['vara'=>$vara]);
$id=$db->lastInsertId();


// Skicka tillbaka svar
skickaJSON(['id'=>$id]);