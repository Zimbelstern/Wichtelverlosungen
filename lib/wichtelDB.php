<?php

include("lib/config.php");

class WichtelDB extends SQLITE3 {

    public function getTitle() {
        $result = $this->querySingle("SELECT wert FROM config WHERE schluessel = 'titel';");
        return $result;
    }

    public function createUser($name, $pass) {
        $this->exec("INSERT INTO spieler (name, passwort, erhalten) VALUES ('{$name}', '{$pass}', '0');");
    }

    function userExists($name) {
        $result = $this->querySingle("SELECT COUNT(*) FROM spieler WHERE name = '{$name}';");
        return $result;
    }

    public function passValid($name, $pass) {
        $result = $this->querySingle("SELECT COUNT(*) FROM spieler WHERE name = '{$name}' AND passwort = '{$pass}';");
        return $result;
    }

    public function getPass($name) {
    $result = $this->querySingle("SELECT passwort FROM spieler WHERE name = '{$name}';");
    return $result;
    }

    public function doMapping() {
        $maxnum = $this->getMaxUserNum();
        $array = range(1,$maxnum);
        shuffle($array);
        for ($i = 1; $i <= $maxnum; $i++) {
            while ($array[0] == $i or ($i+1 == $maxnum and $array[1] == $maxnum)) {
                array_push($array, array_shift($array));            
            }
            $element = array_shift($array);
            $this->exec("UPDATE spieler SET beschenkt = '{$element}'  WHERE ROWID = '{$i}'");
        }
    }

    public function getMappedName($name) {
        $this->exec("UPDATE spieler SET erhalten = '1' WHERE name = '{$name}';");
        $result = $this->querySingle("SELECT B.name FROM spieler A, spieler B WHERE A.beschenkt = B.ROWID AND A.name = '{$name}';");
        return $result;
    }
    
    public function hasReceivedName($name) {
        $result = $this->querySingle("SELECT erhalten FROM spieler WHERE name = '{$name}';");
        return $result;    
    }

    public function getMaxUserNum() {
        $result = $this->querySingle("SELECT wert FROM config WHERE schluessel = 'spieleranzahl';");
        return $result;
    }
    
    public function getUserNum() {
        $result = $this->querySingle("SELECT COUNT(*) FROM spieler;");
        return $result;
    }

    public function getWaitingNum() {
        $intnum = $this->getMaxUserNum() - $this->getUserNum();
        $numwords = file("res/zahlwoerter", FILE_IGNORE_NEW_LINES); 
        return ($intnum > 0 && $intnum < 13) ? $numwords[$intnum - 1] : $intnum;
    }
}

function titleIsValid($str) {
    return !preg_match('/[^a-zA-Z0-9äöüßÄÖÜ \\-$]/', $str);
}

function numberIsValid($str) {
    return !preg_match('/[^0-9\\-$]/', $str) && intval($str) > 2 && intval($str) < 101;
}

function serverpassIsValid($str) {
    return in_array($str, CONFIG['serverpasswords']);
}

function nameIsValid($str) {
    return !preg_match('/[^a-zA-ZäöüßÄÖÜ\\-$]/', $str);
}

function gameExists($db_name) {
    return file_exists("games/{$db_name}.db");
}

function createGame($dbname, $dbtitle, $dbnum) {
    $db = new SQLite3("games/{$dbname}.db");
    $db->exec("CREATE TABLE config (schluessel char(255), wert int(255));");
    $db->exec("INSERT INTO config VALUES ('titel', '{$dbtitle}');");
    $db->exec("INSERT INTO config VALUES ('spieleranzahl', '{$dbnum}');");
    $db->exec("CREATE TABLE spieler (name varchar(255), passwort varchar(255), beschenkt int(255), erhalten bool);");
    return true;
}

function getWichtelBaseUri($dbname) {
    require_once("getBaseUri.php");
    $baseUri = getExtendedBaseUri();
    $wichtelBaseUri = substr($baseUri, 0, strrpos($baseUri, '/')) . "?" . $dbname;
    return $wichtelBaseUri;
}

function cleanGameFiles() {
    foreach(glob("games/*.db") as $file) {
        if (is_file($file) && (time() - filemtime($file) > 300)) {
            unlink($file);
        }
    }
}

?>
