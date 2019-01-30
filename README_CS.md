# Privacy\_XH

Privacy\_XH zajišťuje, aby webové stránky vyhovovaly požadavkům zákona
[EU cookie regulations](http://ec.europa.eu/ipg/basics/legal/cookies/index_cs.htm) a dalším právním předpisům
ohledně soukromí návštěvníků. Po odsouhlasení vypne formulář na každé
stránce se základními a informace a dá návštěvníkovi možnost explicitně
zvolit souhlas. Pokud návštěvník souhlasil, je nastaven příslušný cookie
a zpráva nebude příště zobrazena. Privacy\_XH také usnadňuje kontrolu
běhu jiného kódu, který ukládá cookies, které mohou být v rozporu se
soukromím uživatelů.

  - [Požadavky](#požadavky)
  - [Download](#download)
  - [Instalace](#instalace)
  - [Konfigurace](#konfigurace)
  - [Použití](#použití)
  - [Limitations](#limitations)
  - [Troubleshooting](#troubleshooting)
  - [Licence](#licence)
  - [Vývojáři](#vývojáři)

## Požadavky

Privacy\_XH is a plugin for CMSimple\_XH ≥ 1.6.3. It requires PHP ≥
5.4.0.

## Download

The [lastest release](https://github.com/cmb69/privacy_xh/releases/latest) is available for download on Github.

## Instalace

Instalace se provádí stejně jako u mnoha dalších CMSimple\_XH pluginů.
Viz [CMSimple\_XH
wiki](https://wiki.cmsimple-xh.org/doku.php/installation#plugins)
pro více informací.

1.  **Zálohujte data z vašeho serveru.**
2.  Rozbalte distribuční balíček do vašeho PC.
3.  Nahrajte celý adresář na server do adresáře pluginy CMSimple\_XH
4.  Nastavte oprávnění k zápisu do podadresáře config/, css/ a
    languages/.
5.  **V aministračním rozhraní zkontrolujte, jestli jsou všechny
    požadavky splněny.**

## Konfigurace

Konfigurace se provádí stejně jako u mnoha dalších CMSimple\_XH pluginů
v administraci. Vyberte "Privacy" ve složce "Pluginy".

Tipy pro volby se zobrazí při najetí myší nad nápovědu ikony.

Lokalizace se provádí v "Language". Můžete přeložit řetězce znaků
ve vašem vlastním jazyce, nebo je upravit podle vašich potřeb.

Vzhled Privacy\_XH lze přizpůsobit v "Stylesheet".

## Použití

Chcete-li aktivovat formulář ochrany osobních údajů, přidejte do šablony
na nápadném místě:

    <?=privacy()?>

Měli byste upravit text v "jazyk" podle vašich potřeb. Chcete-li
rozsáhlé informace, měli byste připravit skrytou CMSimple\_XH stránku s
informacemi o ochraně osobních údajů.

Aby se zabránilo ukládání cookie z jiných pluginů nebo rozšíření dříve,
než uživatel povolil, budete muset udělat některé změny. Pokud je kód v
šabloně, můžete hlídání provést následujícím způsobem:

    <?php if (isset($_COOKIE['privacy_agreed'])):?>
    <!-- code that requires opt in -->
    <?php endif?>

Pokud kód, který má být kontrolován je v obsahu, vlejte ho např.:

    {{{func(1, 2, 3, 4, 5)}}}

stačí zavolat:

    {{{privacy_guard('func', 1, 2, 3, 4, 5)}}}

Pamatujte, že `privacy_guard()` akceptuje libovolný počet argumentů kromě
názvu funkce.

Které pluginy a rozšíření musí být kontrolovány, závisí na omezení ve
vaší zemi (nebo na zemi, kde jsou umístěny na internetové stránky), a
samozřejmě to, které informace jsou tyto pluginy ukládají v cookies. To
by mělo být dokumentováno v pluginech nebo rozšířeních v dokuentaci.
Jinak požádejte dodavatele pluginu.

**Vezměte prosím na vědomí, že "privacy form" není nikdy zobrazen, když
jste přihlášeni jako adminstrator.**

## Limitations

If other plugins send cookies without being called explicitly,
Privacy\_XH does **not** prevent these cookies to be sent.

## Troubleshooting

Report bugs and ask for support either on [Github](https://github.com/cmb69/privacy_xh/issues)
or in the [CMSimple_XH Forum](https://cmsimpleforum.com/).

## Licence

Privacy\_XH is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Privacy\_XH is distributed in the hope that it will be useful,
but *without any warranty*; without even the implied warranty of
*merchantibility* or *fitness for a particular purpose*. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Privacy\_XH.  If not, see <http://www.gnu.org/licenses/>.

Copyright © Christoph M. Becker

České překlady © Josef Němec  
Dutch translation © Rob Zeijen

## Vývojáři

Privacy\_XH je inspirován *Oldnema*, který poukázal na práva cookie EU a
užitečnosti takového pluginu. Děkuji\!

Ikona pluginu je od [Alexander Moore](http://www.famfamfam.com/). Velký
dík za zveřejnění této ikony pod GPL.

A v neposlední řadě děkuji [Peter Harteg](http://www.harteg.dk), "otci"
CMSimple a všem vývojářům z [CMSimple\_XH](http://www.cmsimple-xh.org)
bez kterých by tento úžasný CMS neexistoval.
