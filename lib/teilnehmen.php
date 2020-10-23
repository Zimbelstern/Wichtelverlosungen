<?php

// Get database filename from query string
$dbname = $_SERVER['QUERY_STRING'];

// Create game object
$game = new wichtelDB("games/{$dbname}.db");

// Get game title
$gametitle = $game->getTitle();

// Set HTML title
$htmltitle = $gametitle . " – Wichtelverlosung";

// Set messages
$msg1 = $htmltitle;
$msg2 = "Namen eintragen, Weihnachtscode erhalten und wiederkommen, wenn alle angemeldet sind.";
$msg4 = '<div class="container max-500">
                    <div class="box">
                        <form action="?' . $dbname . '" method="post">
                            <input type="hidden" name="game" value="' . $dbname . '"/>
                            <input type="hidden" name="session_id" value="' . session_id() . '"/>
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" type="text" name="name" placeholder="Name" required pattern="^[a-zA-ZäöüßÄÖÜ]+$" maxlength="24" autofocus="">
                                <span class="icon is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" type="password"  name="code" placeholder="(Weihnachtscode – ab zweiter Anmeldung)" pattern="^[a-zA-ZäöüßÄÖÜ]+$" maxlength="24">
                                    <span class="icon is-left">
                                        <i class="fas fa-candy-cane"></i>
                                    </span>
                                </div>
                            </div>
                            <button class="button is-block is-info is-fullwidth">Teilnehmen</button>
                        </form>
                    </div>
                </div>
';
$msg5 = "Übrigens: Hier muss ein Cookie angelegt werden.";

?>
