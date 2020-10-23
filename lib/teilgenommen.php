<?php

// Get variables from formular
$dbname = $_POST['game'];
$username = $_POST['name'];
$code = $_POST['code'];

// Create database object
$wdb = new WichtelDB("games/{$dbname}.db");

// Get game title and set HTML title
$gametitle = $wdb->getTitle();
$htmltitle = $gametitle . " – Wichtelverlosung";

// Prevent log-in twice
session_regenerate_id();

// Big condition block
if (nameIsValid($username)) {
    if (empty($code)) {
        if (!$wdb->userExists($username)) {
            if ($wdb->getWaitingNum()) {
                $codes = file("res/weihnachtscodes", FILE_IGNORE_NEW_LINES); 
                $newcode = $codes[rand(0, count($codes) - 1)];
                $wdb->createUser($username, $newcode);
                $msg1 = "Hallo, {$username}!";
                if ($wdb->getWaitingNum()) {
                    $msg2 = "Dein Weihnachtscode lautet:<br /><strong class=\"largebold\">{$newcode}</strong><br />Bitte merke ihn dir gut, du brauchst ihn zum Einloggen.";
                    $msg3 = "Wir müssen noch auf " . $wdb->getWaitingNum() . " Wichtel warten. Dann wird ausgelost.";
                }
                else {
                    $wdb->doMapping();
                    $beschenkt = $wdb->getMappedName($username);
                    $msg2 = "Du bist der letzte Wichtel, der sich angemeldet hat.<br/>Bitte gib den anderen Bescheid, dass die Wichtel gemischt wurden.<br /><br />Du beschenkst:<br /><strong class=\"largebold\">{$beschenkt}</strong><br />Hast du schon eine Idee, worüber sich {$beschenkt} freuen würde?<br /><br />Dein Weihnachtscode ist <strong>{$newcode}</strong>.<br />Merke ihn dir, falls du dich später noch mal einloggen möchtest.";
                }
            }
            else {
                $msg1 = "Es sind schon alle Teilnehmer angemeldet.";
                $msg2 = "Tut mir leid, du bist wohl nicht dabei.";
            }
        }
        else {
            $msg1 = "Dieser Name wurde schon registriert.";
            $msg2 = "Wenn du dich schon angemeldet hast, verwende deinen Weihnachtscode, um dich einzuloggen.";
        }
    }
    else {
        if ($wdb->userExists($username)) {
            if (nameIsValid($code) && $wdb->passValid($username, $code)) {
                $msg1 = "Hallo, {$username}!";
                if ($wdb->getWaitingNum()) {
                    $msg2 = "Wir müssen noch auf " . $wdb->getWaitingNum() . " Wichtel warten. Dann wird ausgelost.";
                }
                else {
                    if (!$wdb->hasReceivedName($username)) {
                        $msg3 = "Hast du schon eine Idee, worüber sich "  . $wdb->getMappedName($username) . " freuen würde?";
                    }
                    else {
                        $msgs = array("Schon vergessen?", "Sorry, daran können wir jetzt auch nichts mehr ändern.", "Nicht zufrieden?");
                        $msg3 = $msgs[rand(0, count($msgs) - 1)];
                    }
                    $msg2 = "Du beschenkst:<br /><strong class=\"largebold\">" . $wdb->getMappedName($username) . "</strong>";
                }
            }
            else {
                $correctcode = substr($wdb->getPass($username), 0, 1);
                $msg1 = "Der Weihnachtscode ist falsch.";
                $msg2 = "Du solltest dir diesen Code doch merken!";
                $msg3 = "Kleiner Tipp: Dein Weihnachtscode fängt mit {$correctcode}... an.";
            }
        }
        else {
            $msg1 = "Dieser Name wurde noch nicht registriert.";
            $msg2 = "Lass bei der ersten Anmeldung das Feld für den Weihnachtscode frei.";
        }
    }
}
else {
    $msg1 = "Dein Name erhält ungültige Zeichen.";
    $msg2 = "Kommst du mit dem deutschen Alphabet nicht aus?<br />Dann transkribiere deinen Namen bitte.";
}

$msg4 = '
                <div class="column is-4 is-offset-4">
                    <a class="arrow-left" href="?' . $dbname . '"></a>
                </div>
';

?>
