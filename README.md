# Privacy_XH

Privacy_XH helps to make a website conform to the
[GDPR](https://gdpr.eu/)
and similar regulations regarding the privacy of visitors.
It does so by emitting a form on every page with relevant information
giving the visitor the possibility to explicitly
opt in to or refuse the usage of cookies.
In addition Privacy_XH facilitates to guard the execution of other code
that sets cookies which might violate the privacy of users.

  - [Requirements](#requirements)
  - [Download](#download)
  - [Installation](#installation)
  - [Settings](#settings)
  - [Usage](#usage)
  - [Limitations](#limitations)
  - [Troubleshooting](#troubleshooting)
  - [License](#license)
  - [Credits](#credits)

## Requirements

Privacy_XH is a plugin for CMSimple_XH.
It requires CMSimple_XH ≥ 1.7.0, and PHP ≥ 7.1.0.

## Download

The [lastest release](https://github.com/cmb69/privacy_xh/releases/latest)
is available for download on Github.

## Installation

The installation is done as with many other CMSimple_XH plugins. See the
[CMSimple_XH Wiki](https://wiki.cmsimple-xh.org/?for-users/working-with-the-cms/plugins#id3_install-plugin)
for further details.

1.  **Backup the data on your server.**
1.  Unzip the distribution on your computer.
1.  Upload the whole folder `privacy/` to your server into the `plugins/`
    folder of CMSimple_XH.
1.  Set write permissions for the subfolders `config/`, `css/` and
    `languages/`.
1.  Switch to `Privacy` in the back-end of the Website
    to check if all requirements are fulfilled.

## Settings

The configuration of the plugin is done as with many other CMSimple_XH
plugins in the back-end of the Website. Select `Plugins` → `Privacy`.

You can change the default settings of Privacy_XH under `Config`.
Hints for the options will be displayed when hovering over the help
icons with your mouse.

Localization is done under `Language`. You can translate the
character strings to your own language if there is no appropriate
language file available, or customize them according to
your needs.

The look of the Privacy_XH can be customized under `Stylesheet`.

## Usage

To activate the privacy form, add the following to your template in a
suitable place:

    <?=privacy()?>

You should adapt the message in `Language` according to your
needs. However, language texts do not accept any HTML markup, but you likely
want to add links to the imprint and privacy policy pages; to be able to do
that, you need to prepare a hidden page, and enter its page heading in
`Config` → `Newsbox`.

To avoid cookies being sent from other plugins or extensions before the
user has opted in, you have to make some changes to the way these
extensions are integrated. If the code is in the template, you can guard
it from being executed before the visitor has opted in by encapsulating
it the following way:

    <?php if (privacy_agreed()):?>
    <!-- code that requires opt in -->
    <?php endif?>

If the code that has to be guarded is called from the content, instead
of e.g. calling:

    {{{func(1, 2, 3, 4, 5)}}}

call the following instead:

    {{{privacy_guard('func', 1, 2, 3, 4, 5)}}}

Note, that `privacy_guard()` accepts any number of arguments in addition
to the function name.

Which plugins and extensions have to be guarded depends on the
jurisdiction of your country (or probably the country where the Website
is hosted; I am not a lawyer), and of course on which information these extensions
are storing in the cookies. This should be documented in the user manuals
of the plugins; otherwise ask the vendor.

**Please note that the privacy form is never shown when you are logged in
as adminstrator.**

## Limitations

If other plugins send cookies without being called explicitly,
Privacy_XH does **not** prevent these cookies to be sent.

## Troubleshooting

Report bugs and ask for support either on [Github](https://github.com/cmb69/privacy_xh/issues)
or in the [CMSimple_XH Forum](https://cmsimpleforum.com/).

## License

Privacy_XH is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Privacy_XH is distributed in the hope that it will be useful,
but *without any warranty*; without even the implied warranty of
*merchantibility* or *fitness for a particular purpose*. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Privacy_XH.  If not, see <https://www.gnu.org/licenses/>.

Copyright © Christoph M. Becker

Czech translation © Josef Němec  
Dutch translation © Rob Zeijen

## Credits

Privacy_XH is inspired by *oldnema*, who pointed me to the EU cookie law,
and the usefulness of such a plugin. Thank you!

The plugin logo is designed by Alexander Moore.
Many thanks for publishing this icon under GPL.

Many thanks to the community at the
[CMSimple_XH Forum](https://www.cmsimpleforum.com/) for tips, suggestions
and testing.

And last but not least many thanks to [Peter Harteg](httsp://www.harteg.dk),
the “father” of CMSimple,
and all developers of [CMSimple_XH](https://www.cmsimple-xh.org)
without whom this amazing CMS would not exist.
