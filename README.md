# 🎄 Wichtelverlosungen
Dieses Programm stellt eine Web-Oberfläche zur Verfügung, auf der Verlosungen durchgeführt werden können, bei denen jeder teilnehmenden Person ([Wichtel](https://de.wikipedia.org/wiki/Wichteln)) geheim eine andere zugelost wird. Das Programm wurde in PHP und SQL geschrieben und basiert auf einem datenschutzfreundlichen, ausgeklügelten Prinzip, bei dem keine E-Mail-Adressen benötigt werden. Die Angabe des (Spitz-)Namens genügt.

## 📃 Anleitung

### 🦌 Wichtelverlosungen erstellen
Zum Erstellen von Verlosungen muss mit dem Browser in das Installationsverzeichnis navigiert werden. Nun müssen ein möglichst eindeutiger Titel und die genaue Anzahl der Wichtel festgelegt werden. Verlosungen mit nur drei Wichteln sind möglich, das Ergebnis einer solchen Verlosung ist allerdings aus logischen Gründen nie geheim.

Mit der Wichtelverlosung wird ein Link erstellt, der nun an alle Wichtel weitergegeben werden muss.

### 🎁 An Wichtelverlosungen teilnehmen
Alle Wichtel benötigen den Link, um zur Verlosung zu gelangen. Dort müssen sie zunächst nur ihren Namen eintragen, um im Lostopf zu landen. Anschließend erhalten sie einen Weihnachtscode (Passwort), der später benötigt wird, um das personalisierte, geheime Ergebnis der Verlosung einzusehen. Wenn sich *alle* Wichtel angemeldet haben, wird automatisch jedem Wichtel eine andere Person zugelost. Mit ihrem persönlichen Weihnachtscode können sich die Wichtel nun erneut einloggen, um zu sehen, wen sie beschenken werden.

## 📦 Installation
Auf dem Webserver muss PHP und die Bibliothek *php-sqlite3* installiert sein. Die Dateien müssen entpackt und auf dem Server abgelegt werden. Ein Hintergrundbild ist aus rechtlichen Gründen nicht in diesem Repository enthalten, muss separat [über pixabay.com](https://pixabay.com/photos/christmas-new-year-s-eve-postcard-1911637/) heruntergeladen und als background.jpg im Verzeichnis images abgelegt werden.


### ⚙ Konfiguration
Die Konfiguration kann in der Datei `lib/config.php` geändert werden. Nach der Installation läuft das Programm zunächst im Demo-Modus. Im Demo-Modus kann prinzipiell jeder Verlosungen erstellen, jedoch werden alle Verlosungen, die länger als fünf Minuten nicht mehr geändert wurden, gelöscht. Das Ändern des Wertes `"demo"` von `true` zu `false` deaktiviert den Demo-Modus. Das Erstellen von Verlosungen ist dann nur noch mit einem der Server-Passwörter in der Liste `"serverpasswords"` möglich; Verlosungen bleiben aber zeitlich unbegrenzt erhalten.
Beim Abschalten des Demo-Modus empfiehlt es sich zudem, ggf. vorhandene `.sql`-Dateien (*nicht* die `.htaccess`-Datei!) im games-Verzeichnis zu löschen. 
