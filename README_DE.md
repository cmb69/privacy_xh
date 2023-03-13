# Privacy\_XH

Privacy\_XH ist dabei behilflich eine Website konform zu den [EU
Cookie-Vorschriften](http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm)
und anderen Vorschriften bezüglich der Privatsphäre von Besuchern zu
machen. Dazu wird auf jeder Seite ein Formular mit entsprechenden
Informationen angezeigt, welches dem Besucher die Möglichkeit bietet,
der Verwendung von Cookies ausdrücklich einzuwilligen, oder zu widersprechen.
Darüber hinaus ermöglicht es Privacy\_XH, die Ausführung von
anderem Code, der Cookies setzt, die die Privatsphäre von Nutzern
verletzen könnte, zu bewachen.

  - [Voraussetzungen](#voraussetzungen)
  - [Download](#download)
  - [Installation](#installation)
  - [Einstellungen](#einstellungen)
  - [Verwendung](#verwendung)
  - [Beschränkungen](#beschränkungen)
  - [Fehlerbehebung](#fehlerbehebung)
  - [Lizenz](#lizenz)
  - [Danksagung](#danksagung)

## Voraussetzungen

Privacy\_XH ist ein Plugin für CMSimple\_XH ≥ 1.7.0. Es benötigt PHP ≥
7.1.0.

## Download

Das [aktuelle Release](https://github.com/cmb69/privacy_xh/releases/latest)
kann von Github herunter geladen werden.

## Installation

Die Installation erfolgt wie bei vielen anderen CMSimple_XH-Plugins
auch. Im
[CMSimple\_XH-Wiki](https://wiki.cmsimple-xh.org/doku.php/de:installation#plugins)
finden Sie weitere Details.

1.  **Sichern Sie die Daten auf Ihrem Server.**
2.  Entpacken Sie die ZIP-Datei auf Ihrem Rechner.
3.  Laden Sie das ganze Verzeichnis minicounter/ auf Ihren Server in das
    plugin/ Verzeichnis von CMSimple\_XH hoch.
4.  Machen sie die Unterverzeichnisse config/, css/ und
    languages/ beschreibbar.
5.  **Navigieren sie zu "Privacy" im Administrationbereich, um zu prüfen,
    ob alle Voraussetzungen erfüllt sind.**

## Einstellungen

Die Plugin-Konfiguration erfolgt wie bei vielen anderen
CMSimple\_XH-Plugins auch im Administrationsbereich der Website.  Wählen
sie "Plugins" → "Privacy".

Sie können die Voreinstellungen von Privacy\_XH unter "Konfiguration"
ändern. Hinweise zu den Optionen werden beim Überfahren der Hilfe-Icons
mit der Maus angezeigt.

Die Lokalisierung wird unter "Sprache" vorgenommen. Sie können die
Sprachtexte in Ihre eigene Sprache übersetzen, oder diese Ihren Wünschen
gemäß anpassen.

Das Aussehen von Privacy\_XH kann unter "Stylesheet" angepasst werden.

## Verwendung

Um das Privatsphäre-Formular zu aktiveren, ist Folgendes an prominenter
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
Template, kann er solange der Besucher noch nicht eingewilligt hat, wie
folgt vor der Ausführung geschützt werden:

    <?php if (privacy_agreed()):?>
    <!-- Code, der Einwilligung erfordert -->
    <?php endif?>

Wenn der zu schützende Code aus dem Inhalt einer Seite heraus aufgerufen
wird, wird statt dem Aufruf von:

    {{{func(1, 2, 3, 4, 5)}}}

einfach folgendes aufgerufen:

    {{{privacy_guard('func', 1, 2, 3, 4, 5)}}}

Es ist zu beachten, dass `privacy_guard()` zusätzlich zum Funktionsnamen
eine beliebige Anzahl von Argumenten akzeptiert.

Welche Plugins und Erweiterung zu schützen sind, hängt von der
Rechtsprechung des Heimatlandes (oder vermutlich des Landes, in dem die
Website gehostet wird; ich bin kein Jurist) ab, und natürlich davon,
welche Informationen diese Erweiterungen in den Cookies speichern. Dies
sollte im Handbuch des Plugins oder der Erweiterung dokumentiert sein;
andernfalls ist der Anbieter zu konsultieren.

**Es ist zu beachten, dass das Privatsphäre-Formular dem Administrator
niemals angezeigt wird.**

## Beschränkungen

Senden andere Plugins Cookies ohne explizit aufgerufen zu werden,
so verhindert Privacy\_XH das Senden dieser Cookies **nicht**.

## Fehlerbehebung

Melden Sie Programmfehler und stellen Sie Supportanfragen entweder auf
[Github](https://github.com/cmb69/privacy_xh/issues) oder im
[CMSimple_XH Forum](https://cmsimpleforum.com/).

## Lizenz

Privacy\_XH ist freie Software. Sie können es unter den Bedingungen der
GNU General Public License, wie von der Free Software Foundation
veröffentlicht, weitergeben und/oder modifizieren, entweder gemäß
Version 3 der Lizenz oder (nach Ihrer Option) jeder späteren Version.

Die Veröffentlichung von Privacy\_XH erfolgt in der Hoffnung, daß es
Ihnen von Nutzen sein wird, aber ohne irgendeine Garantie, sogar ohne
die implizite Garantie der Marktreife oder der Verwendbarkeit für einen
bestimmten Zweck. Details finden Sie in der GNU General Public License.

Sie sollten ein Exemplar der GNU General Public License zusammen mit
Privacy\_XH erhalten haben. Falls nicht, siehe
http://www.gnu.org/licenses/.

Copyright © Christoph M. Becker

Tschechische Übersetzung © Josef Němec  
Niederländische Übersetzung © Rob Zeijen

## Danksagung

Privacy\_XH wurde von *oldnema* angeregt, der mich auf die
EU-Cookie-Richtlinie, und die Nützlichkeit eines solchen Plugins
hinwies. Vielen Dank!

Das Plugin-Logo wurde von [Alexander Moore](http://www.famfamfam.com/)
gestaltet. Vielen Dank für die Veröffentlichung dieses Icons unter GPL.

Und zu guter letzt vielen Dank an [Peter Harteg](http://www.harteg.dk),
den "Vater" von CMSimple, und allen Entwicklern von
[CMSimple\_XH](http://www.cmsimple-xh.org) ohne die es dieses
phantastische CMS nicht gäbe.
