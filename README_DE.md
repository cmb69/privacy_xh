# Privacy_XH

Privacy_XH ist dabei behilflich eine Website konform zu den
[DSGVO](https://dsgvo-gesetz.de/)
und ähnlichen Vorschriften bezüglich der Privatsphäre von Besuchern zu
machen.
Dazu wird auf jeder Seite ein Formular mit entsprechenden
Informationen angezeigt, welches dem Besucher die Möglichkeit bietet,
der Verwendung von Cookies ausdrücklich einzuwilligen, oder zu widersprechen.
Darüber hinaus ermöglicht es Privacy_XH, die Ausführung von
anderem Code, der Cookies setzt, die die Privatsphäre von Nutzern
verletzen könnten, zu schützen.

  - [Voraussetzungen](#voraussetzungen)
  - [Download](#download)
  - [Installation](#installation)
  - [Einstellungen](#einstellungen)
  - [Verwendung](#verwendung)
  - [Einschränkungen](#einschränkungen)
  - [Fehlerbehebung](#fehlerbehebung)
  - [Lizenz](#lizenz)
  - [Danksagung](#danksagung)

## Voraussetzungen

Privacy_XH ist ein Plugin für CMSimple_XH.
Es benötigt CMSimple_XH ≥ 1.7.0, und PHP ≥ 7.1.0.

## Download

Das [aktuelle Release](https://github.com/cmb69/privacy_xh/releases/latest)
kann von Github herunter geladen werden.

## Installation

Die Installation erfolgt wie bei vielen anderen CMSimple_XH-Plugins auch. Im
[CMSimple_XH-Wiki](https://wiki.cmsimple-xh.org/de/?fuer-anwender/arbeiten-mit-dem-cms/plugins)
finden Sie weitere Details.

1.  **Sichern Sie die Daten auf Ihrem Server.**
1.  Entpacken Sie die ZIP-Datei auf Ihrem Rechner.
1.  Laden Sie den gesamten Ordner `privacy/` auf Ihren Server in den
    `plugins/` Ordner von CMSimple_XH hoch.
1.  Machen sie die Unterordner `config/`, `css/` und
    `languages/` beschreibbar.
1.  Navigieren sie zu `Privacy` im Administrationbereich, um zu prüfen,
    ob alle Voraussetzungen erfüllt sind.

## Einstellungen

Die Plugin-Konfiguration erfolgt wie bei vielen anderen
CMSimple_XH-Plugins auch im Administrationsbereich der Website.
Wählen sie `Plugins` → `Privacy`.

Sie können die Voreinstellungen von Privacy_XH unter `Konfiguration`
ändern. Hinweise zu den Optionen werden beim Überfahren der Hilfe-Icons
mit der Maus angezeigt.

Die Lokalisierung wird unter `Sprache` vorgenommen. Sie können die
Sprachtexte in Ihre eigene Sprache übersetzen, falls keine
entsprechende Sprachdatei zur Verfügung steht, oder diese Ihren Wünschen
gemäß anpassen.

Das Aussehen von Privacy_XH kann unter `Stylesheet` angepasst werden.

## Verwendung

Um das Privatsphäre-Formular zu aktiveren, ist Folgendes an passender
Stelle im Template zu ergänzen:

    <?=privacy()?>

Die Meldung sollte unter `Sprache` den Bedürfnissen angepasst werden.
Allerdings akzeptieren Sprachtexte kein HTML, aber Sie möchten vermutlich
Links zum Impressum und der Datenschutzerklärung anzeigen; um dies tun zu
können, müssen Sie eine versteckte Seite anlegen, und ihren Seiten-Titel
unter `Konfiguration` → `Newsbox` eintragen.

Um zu verhindern, dass Cookies von anderen Plugins oder Erweiterungen
gesendet werden bevor der Nutzer eingewilligt hat, muss die Integration
dieser Erweiterungen angepasst werden. Befindet sich der Code im
Template, kann er, solange der Besucher noch nicht eingewilligt hat, wie
folgt vor der Ausführung geschützt werden:

    <?php if (privacy_agreed()):?>
    <!-- Code, der Einwilligung erfordert -->
    <?php endif?>

Wenn der zu schützende Code aus dem Inhalt einer Seite heraus aufgerufen
wird, wird statt dem Aufruf von:

    {{{func(1, 2, 3, 4, 5)}}}

einch folgendes aufgerufen:

    {{{privacy_guard('func', 1, 2, 3, 4, 5)}}}

Es ist zu beachten, dass `privacy_guard()` zusätzlich zum Funktionsnamen
eine beliebige Anzahl von Argumenten akzeptiert.

Welche Plugins und Erweiterung zu schützen sind, hängt von der
Rechtsprechung des Heimatlandes (oder vermutlich des Landes, in dem die
Website gehostet wird; ich bin kein Jurist) ab, und natürlich davon,
welche Informationen diese Erweiterungen in den Cookies speichern. Dies
sollte im Handbuch der Plugins dokumentiert sein;
andernfalls ist der Anbieter zu konsultieren.

**Es ist zu beachten, dass das Privatsphäre-Formular dem Administrator
niemals angezeigt wird.**

## Einschränkungen

Senden andere Plugins Cookies ohne explizit aufgerufen zu werden,
so verhindert Privacy_XH das Senden dieser Cookies **nicht**.

## Fehlerbehebung

Melden Sie Programmfehler und stellen Sie Supportanfragen entweder auf
[Github](https://github.com/cmb69/privacy_xh/issues) oder im
[CMSimple_XH Forum](https://cmsimpleforum.com/).

## Lizenz

Privacy_XH ist freie Software. Sie können es unter den Bedingungen der
GNU General Public License, wie von der Free Software Foundation
veröffentlicht, weitergeben und/oder modifizieren, entweder gemäß
Version 3 der Lizenz oder (nach Ihrer Option) jeder späteren Version.

Die Veröffentlichung von Privacy_XH erfolgt in der Hoffnung, daß es
Ihnen von Nutzen sein wird, aber ohne irgendeine Garantie, sogar ohne
die implizite Garantie der Marktreife oder der Verwendbarkeit für einen
bestimmten Zweck. Details finden Sie in der GNU General Public License.

Sie sollten ein Exemplar der GNU General Public License zusammen mit
Privacy_XH erhalten haben. Falls nicht, siehe <https://www.gnu.org/licenses/>.

Copyright © Christoph M. Becker

Tschechische Übersetzung © Josef Němec  
Niederländische Übersetzung © Rob Zeijen

## Danksagung

Privacy_XH wurde von *oldnema* angeregt, der mich auf die EU-Cookie-Richtlinie,
und die Nützlichkeit eines solchen Plugins hinwies. Vielen Dank!

Das Plugin-Logo wurde von Alexander Moore gestaltet.
Vielen Dank für die Veröffentlichung dieses Icons unter GPL.

Vielen Dank an die Community im
[CMSimple_XH-Forum](https://www.cmsimpleforum.com/) für Hinweise,
Anregungen und das Testen.

Und zu guter letzt vielen Dank an [Peter Harteg](https://www.harteg.dk/),
den „Vater“ von CMSimple, und allen Entwicklern von [CMSimple_XH](https://www.cmsimple-xh.org/de/)
ohne die es dieses phantastische CMS nicht gäbe.
