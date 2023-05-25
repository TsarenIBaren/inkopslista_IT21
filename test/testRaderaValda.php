<?php
declare(strict_types=1);
require_once "../php/funktioner.php";

try {
   // Skapa handle till curl för att läsa svaret
   $ch = curl_init('http://localhost/inkopslista/php/raderaValda.php'); 

   // Se till att vi får svaret som en sträng
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   // Anropen till sidan som ska testas
   // Fel metod
   echo "<p class='info'>Test fel metod</p>";
   felMetod($ch);

   // Test ok
    echo "<p class='info'>Test radera alla OK </p>";
    raderaValda($ch);
} catch (Exception $e) {
    echo "<p class='error'>";
    echo "Något gick Jättefel!<br>";
    echo $e->getMessage();
    echo "</p>";
}

function raderaValda($curlHandle) {
    // Kopplar databas
    $db=connectDB();

    // Läs in alla varor (För att återställa senare)
    $varor=hamtaAllaVaror();
    
    // Kryssa in alla varor
    foreach ($varor as $key => $value) {
        kryssaVara($value ['id']);
    }

    // Anropa sidan
    curl_setopt($curlHandle, CURLOPT_POST, true);
    $jsonSvar= curl_exec($curlHandle);
    $status=curl_getInfo($curlHandle, CURLINFO_RESPONSE_CODE);

    // Kontrollera svaret
    if($status===200) {
        echo "<p class='ok'>Radera valda varor fungerade</p>";
    } else {
        echo "<p class='error'>Radera valda varor fungerade inte, status=$status istället för 200</p>";
    }
    // Återställ alla varor
    aterstallDB($varor);

}