<?php

// Set HTML title (fallback)
$htmltitle = "Die Wichtelverlosung wurde nicht erstellt";

// Set error messages (fallback)
$msg1 = "Die Wichtelverlosung wurde nicht erstellt.";
$msg2 = "Es ist folgender Fehler aufgetreten:";
$msg4 = '
                <div class="column is-4 is-offset-4">
                    <a class="arrow-left" href="?verlosung-erstellen"></a>
                </div>
';

// If strings are valid and game does not yet exist, create game
// Else set corresponding error messages
if (titleIsValid($_POST['titel'])) {
    if (numberIsValid($_POST['anzahl'])) {
        if (CONFIG['demo'] || serverpassIsValid($_POST['serverpass'])) {
            $dbtitle = $_POST['titel'];
            $dbname = str_replace(' ', '', strtolower(iconv("utf-8","ascii//TRANSLIT", $dbtitle)));
            $dbnum = intval($_POST['anzahl']);
            if (!gameExists($dbname)) {
                createGame($dbname, $dbtitle, $dbnum);
                $gamelink = getWichtelBaseUri($dbname);
                $htmltitle = "Die Wichtelverlosung wurde erstellt";
                $msg1 = "Die Wichtelverlosung wurde erstellt.";
                $msg2 = 'Die Verlosung findest du unter folgendem Link:<br/><a href="' . $gamelink . '">' . $gamelink .'</a>';
                $msg3 = "Gib diesen Link an alle Wichtel weiter.";
                $msg4 = "";
                if (CONFIG['demo']) {
                    $msg5 = "Demo-Modus: Die Verlosung wird nach fünf Minuten automatisch gelöscht!";
                }
                session_regenerate_id();
            }
            else {
                $msg3 = "Eine Verlosung mit ähnlichem Namen existiert schon.";
            }
        }
        else {
            $msg3 = "Das eingegebene Serverpasswort ist nicht gültig.";
        }
    }
    else if (intval($_POST['anzahl']) == 2) {
        $msg3 = "Zwei Wichtel? Bist du dir sicher, dass du das mit dem Wichteln verstanden hast?";
    }
    else {
        $msg3 = "Die Teilnehmeranzahl liegt nicht zwischen 3 und 100.";
    }
}
else {
    $msg3 = "Der Titel enthält ungültige Zeichen. Es sind nur deutsche Buchstaben, Zahlen und Leerzeichen erlaubt.";
}

?>
