# Privacy\_XH

Privacy\_XH helps to make a website conforming to the [EU cookie
regulations](http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm) and other regulations regarding the
privacy of visitors. It does so by emitting a form on every page with
relevant information giving the visitor the possibility to explicitely
opt in. After the visitor opted in, a respective cookie is set, and the
message won't be shown again. In addition Privacy\_XH facilitates to
guard the execution of other code that sets cookies which might violate
the privacy of users.

  - [Requirements](#requirements)
  - [Download](#download)
  - [Installation](#installation)
  - [Settings](#settings)
  - [Usage](#usage)
  - [Troubleshooting](#troubleshooting)
  - [License](#license)
  - [Credits](#credits)

## Requirements

Privacy\_XH is a plugin for CMSimple\_XH ≥ 1.6.3. It requires PHP ≥
5.4.0.

## Download

The [lastest release](https://github.com/cmb69/privacy_xh/releases/latest) is available for download on Github.

## Installation

The installation is done as with many other CMSimple\_XH plugins. See
the [CMSimple\_XH
wiki](https://wiki.cmsimple-xh.org/doku.php/installation#plugins)
for further details.

1.  **Backup the data on your server.**
2.  Unzip the distribution on your computer.
3.  Upload the whole directory privacy/ to your server into
    CMSimple\_XH's plugins directory.
4.  Set write permissions to the subdirectories config/, css/ and
    languages/.
5.  **Switch to "Privacy" in the back-end to check if all requirements
    are fulfilled.**

## Settings

The plugin's configuration is done as with many other CMSimple\_XH
plugins in the website's back-end. Select "Privacy" from "Plugins".

You can change the default settings of Privacy\_XH under "Config".
Hints for the options will be displayed when hovering over the help
icons with your mouse.

Localization is done under "Language". You can translate the
character strings to your own language, or customize them according to
your needs.

The look of the Privacy\_XH can be customized under "Stylesheet".

## Usage

To activate the privacy form, add the following to your template in a
prominent place:

    <?=privacy()?>

You should adapt the message in "Language" according to your
needs. To make extensive information available you should prepare a
hidden CMSimple page with the privacy notice, and link to it from the
message.

To avoid cookies being sent from other plugins or extensions before the
user has opted in, you have to make some changes to the way these
extensions are integrated. If the code is in the template, you can guard
it from being executed before the visitor has opted in by encapsulating
it the following way:

    <?php if (isset($_COOKIE['privacy_agreed'])):?>
    <!-- code that requires opt in -->
    <?php endif?>

If the code that has to be guarded is called from the content, instead
of e.g. calling:

    {{{func(1, 2, 3, 4, 5)}}}

just call:

    {{{privacy_guard('func', 1, 2, 3, 4, 5)}}}

Note, that privacy\_guard() accepts any number of arguments in addition
to the function name

Which plugins and extensions have to be guarded depends on the
jurisdiction of your country (or probably the country where the website
is hosted; I am not a lawyer), and of course on which information these extensions
are storing in the cookies. This should be documented in the plugin's or
extension's manual; otherwise ask the vendor.

**Please note that the privacy form is never shown when you're logged in
as adminstrator.**

## Troubleshooting

Report bugs and ask for support either on [Github](https://github.com/cmb69/privacy_xh/issues)
or in the [CMSimple_XH Forum](https://cmsimpleforum.com/).

## License

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

Czech translation © Josef Němec  
Dutch translation © Rob Zeijen

## Credits

Privacy\_XH is inspired by *oldnema*, who pointed me to the EU cookie law,
and the usefulness of such a plugin. Thank you\!

The plugin icon is designed by [Alexander
Moore](http://www.famfamfam.com/). Many thanks for publishing this icon
under GPL.

And last but not least many thanks to [Peter
Harteg](http://www.harteg.dk), the "father" of CMSimple, and all
developers of [CMSimple\_XH](http://www.cmsimple-xh.com) without whom
this amazing CMS wouldn't exist.
