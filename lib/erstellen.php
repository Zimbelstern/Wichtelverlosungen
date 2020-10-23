<?php

// Set HTML title
$htmltitle = "Wichtelverlosung erstellen";

// Prepare field or demo notification
$passfield = '
                                <div class="control has-icons-left">
                                    <input class="input" type="password" name="serverpass" placeholder="Serverpasswort (beim Admin erfragen)" required pattern="^[a-zA-Z0-9äöüßÄÖÜ ]{1,36}$" maxlength="36">
                                    <span class="icon is-left"><i class="fas fa-key"></i></span>
                                </div>';
if (CONFIG['demo']) {
$passfield = '
                                <div class="button is-block is-static">
                                    <span class="icon is-left"><i class="fas fa-lock"></i></span> &nbsp; Demo-Modus (Testen für 5 Minuten)
                                </div>';
}

// Set messages and create formular
$msg1 = $htmltitle;
$msg2 = "Titel der Verlosung und Anzahl der Wichtel eintragen.";
$msg4 = '<div class="container max-500">
                    <div class="box">
                        <form action="?verlosung-erstellen" method="post">
                            <input type="hidden" name="session_id" value="' . session_id() . '"/>
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" type="text" name="titel" placeholder="Titel (Buchstaben, Ziffern, Leerzeichen)" required pattern="^[a-zA-Z0-9äöüßÄÖÜ ]{1,36}$" maxlength="36" autofocus>
                                    <span class="icon is-left"><i class="fas fa-gift"></i></span>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" type="number" name="anzahl" placeholder="Anzahl der Wichtel (3–100)" required pattern="^[3-9]$|^[1-9][0-9]$|^100$" maxlength="3">
                                    <span class="icon is-left"><i class="fas fa-users"></i></span>
                                </div>
                            </div>
                            <div class="field">'.$passfield.'
                            </div>
                            <button class="button is-block is-info is-fullwidth">Erstellen</button>
                        </form>
                    </div>
                </div>
';
$msg5 = "Übrigens: Hier muss ein Cookie angelegt werden.";

?>
