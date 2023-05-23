<?php
declare(strict_types=1);
require_once "../php/functioner.php";

try {
    // Skapa handle till curl för att läsa svaret
    $ch = curl_init('http://localhost/inkopslista/php/sparaVara.php');

    // Se till att vi får svaret som en sträng
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Anropen till sidan som ska testas

    // Fel anrop (GET)
    echo "<p class='info'>Test av fel anropsmetod</p>";
    felMetod($ch);

    // Vara saknas
    echo "<p class='info'>Test av fel anropsmetod</p>";
    varaSaknas($ch);

    // Vara är >50 tecken
    echo "<p class='info'>Test vara längre än 50 tecken</p>";
    varaForLangtNamn($ch);

    // Vara är OK!
    echo "<p class='info'>Test vara ok</p>";
    varaOK($ch);

} catch (Exception $e) {
    echo "<p class='error'>";
    echo "Något gick Jättefel!<br>";
    echo $e->getMessage();
    echo "</p>";
} finally {
    //stäng handle till curl
    curl_close($ch);

}

function varaOK($curlHandle)
{
    // Koppla databas och sätt möjlighet att ångra förändringar
    $db = connectDB();
    // Sätt anrop till POST
    curl_setopt($curlHandle, CURLOPT_POST, true);

    // Lägg till vara med långt namn
    $data=['vara'=>'Bra varunamn'];
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

    // Gör anrop och ta hand om retursträng
    $jsonSvar = curl_exec($curlHandle);

    // Läs status för anropet
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    // SKriv ut resultatet
    if ($status===400) {
        echo "<p class='ok'>Förväntat svar 400</p>";
        $svar = json_decode($jsonSvar);
        $id = $svar->id;
        echo "id=$id";
    } else {
        echo "<p class='error'>Fick status=$status istället för förväntat 405</p>";
    }

}

function varaSaknas($curlHandle){
    // Sätt anrop till POST
    curl_setopt($curlHandle, CURLOPT_POST, true);

    // Lägg till vara med långt namn
    $data=['vara'=>'Ett jättelångt namn med mssor av bokstäver som gör att det här är alldeles för långt för att få plats'];
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);

    // Gör anrop och ta hand om retursträng
    $jsonSvar = curl_exec($curlHandle);

    // Läs status för anropet
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    // SKriv ut resultatet
    if ($status===400) {
        echo "<p class='ok'>Förväntat svar 400</p>";
        $svar = json_decode($jsonSvar);
        $id = $svar->id;
        $db->exec("DELETE FROM varor WHERE id=$id");
    } else {
        echo "<p class='error'>Fick status=$status istället för förväntat 405</p>";
    }
}

function felMetod($curlHandle) 
{
    // Gör anrop och ta hand om retursträngen
    $jsonSvar = curl_exec(curlHandle);
    //Hämta status för anropet
    $status = curl_getinfo($curlHandle, CURLINFO_RESPONSE_CODE);

    if($status === 405) {
        echo "<p class='ok'>Svar 405 stämmer med förväntat svar</p>";
    } else {
        echo "<p class='error'>Fick status=$status istället för förväntat 405</p>";
    }
}

