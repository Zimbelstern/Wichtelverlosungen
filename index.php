<?php
// Start session
session_start();

// Import libraries
require_once("lib/wichtelDB.php");
include_once("lib/getBaseUri.php"); 

// In demo mode, delete games older than 5 minutes.
if (CONFIG['demo']) {
    cleanGameFiles();
}

// URL query string
$query = $_SERVER['QUERY_STRING'];

// Declare messages presented to the user
$htmltitle = "Wichtelverlosung";
$msg1 = "";
$msg2 = "";
$msg3 = "";
$msg4 = "";
$msg5 = "";

// If no query string, show start page
if (empty($_SERVER['QUERY_STRING'])) {
    $msg1 = 'Wichteln?';
    $msg2 = '<span class="icon"><i class="fas fa-arrow-circle-right"></i></span>
                    <a href="?verlosung-erstellen">Hier kann man eine Wichtelverlosung erstellen.</a>
                    <span class="icon"><i class="fas fa-arrow-circle-left"></i></span>';
    $msg3 = 'Zur Teilnahme an einer Verlosung braucht man einen speziellen Link.';
}

// Pages for game creation
else if ($_SERVER['QUERY_STRING'] == "verlosung-erstellen"){
    if (isset($_POST['session_id'])) {
        // Include response for new game request
        if ($_POST['session_id'] == session_id()) {
            include("lib/erstellt.php");
        }
        // Redirect to prevent processing a request twice
        else {
            header('Location: ?verlosung-erstellen');
            exit();
        }
    }
    // Include page to create a game
    else {
        include("lib/erstellen.php");
    }
}

else if (file_exists("games/{$query}.db")) {
    if (isset($_POST['session_id'])) {
        // Include logged-in page
        if ($_POST['session_id'] == session_id()) {
            include("lib/teilgenommen.php");
        }
        // Redirect to prevent processing a request twice
        else {
            header('Location: ?' . $query);
            exit();
        }
    }
    // Include login page
    else {
        include("lib/teilnehmen.php");
    }
}

// If query string is nonsense, show error page
else {
    http_response_code(404);
    $htmltitle = 'Fehler 404: Verlosung nicht gefunden – Wichtelverlosung';
    $msg1 = 'Diese Verlosung wurde hier nicht gefunden.';
    $msg2 = '<span class="icon"><i class="fas fa-arrow-circle-right"></i></span>
                    <a href="' . getBaseUri() . '">Hier geht es zur Startseite</a>
                    <span class="icon"><i class="fas fa-arrow-circle-left"></i></span>';
    $msg3 = 'Oder ist nur ein Tippfehler im Link?';
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo $htmltitle; ?></title>
    <base href="<?php echo getBaseUri(); ?>"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="apple-touch-icon-precomposed" href="favicon-152.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="style/wichteln.css"/>
  </head>
  <body>
    <section class="hero is-success is-fullheight">
        <div class="hero-head">
        </div>
        <div class="hero-body">
            <div class="container has-text-centered">
                <h3 class="title">
                    <?php echo $msg1; ?>

                </h3>
                <p class="subtitle">
                    <?php echo $msg2; ?>

                </p>
                <p class="subsubtitle">
                    <?php echo $msg3; ?>

                </p>
                <?php echo $msg4; ?>

                <p class="subsubsubtitle">
                    <?php echo $msg5; ?>

                </p>
            </div>
        </div>
        <div class="hero-foot">
            <div class="container">
                <div class="content has-text-centered foot-content">
                    <span class="icon"><i class="fas fa-gifts"></i></span>
                    Ein Projekt von <a href="https://www.walfriedschneider.de">Walfried Schneider</a>.<br/>
                    <span class="icon"><i class="fas fa-sleigh"></i></span>
                    Geschrieben in PHP, SQL, HTML und CSS.
                </div>
            </div>
        </div>
    </section>
  </body>
</html>
