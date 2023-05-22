<?php
declare(strict_types=1);

try {

} catch (Exception $e) {
    echo "<p class='error'>";
    echo "Något gick Jättefel!<br>";
    echo $e->getMessage();
    echo "</p>";
}
