[![Slack](https://storecore-slack.herokuapp.com/badge.svg)](https://storecore-slack.herokuapp.com)
[![Build Status](https://travis-ci.org/storecore/core.svg?branch=develop)](https://travis-ci.org/storecore/core)
[![codecov](https://codecov.io/gh/storecore/core/branch/develop/graph/badge.svg)](https://codecov.io/gh/storecore/core)


# [StoreCore™](https://www.storecore.io/)

## Table of Contents

- [Installing StoreCore](#installing-storecore)
- [Contributing](#contributing)
- [Versioning](#versioning)
- [Creators](#creators)
- [Copyright and License](#copyright-and-license)


## Installing StoreCore

### Installation Quickstart Guide

1. Download the latest edition of the StoreCore files from the GitHub
   repository if you haven’t already.  Always download or fork the
   `master` branch for production purposes.

2. Create a new MySQL database for StoreCore on your web server.  Do not use
   the default MySQL `test` database or a database name with the `test_`
   prefix.

3. Add a MySQL user who has all privileges for accessing and modifying the
   StoreCore database.

4. Find the `config.php` configuration file, then edit the file and add your
   database information in the `Database` section.

5. *Optional.*  If configured correctly, StoreCore is able to install the
   database by itself.  However, the installation MAY run faster and smoother
   if you install the database manually with a database administration tool
   like MySQL Workbench, phpMyAdmin, or a MySQL command line interface.  First
   run the SQL file `core-mysql.sql` to create all tables; next run the
   `i18n-dml.sql` file to add all language pack data.  Both SQL files are
   located in the `/StoreCore/Database/` folder.

6. Upload the StoreCore files to the desired location on your web server.  This
   usually is a folder called `public_html` for a domain or `www` for a
   subdomain like `www.example.com`.  Do not upload the `/tests/` folder to a
   production server (or delete it afterwards): this folder contains PHP unit
   tests for development purposes.

7. Run the StoreCore installation by accessing the `/install/` folder in a web
   browser.  For example, if StoreCore was uploaded for the `www.example.com`
   host name, then point your browser to the URL `https://www.example.com/install/`.
   If StoreCore was not previously installed, you will be guided through the
   necessary steps to complete the installation.

### Installation Logs

All installation and configuration activities are logged to `.log` text files
in the `/logs/` directory.  If the StoreCore installation fails for any reason,
please first check these log files for possible errors, warnings or other
critical messages.

The location of the `/logs/` directory is defined in the global constant
`STORECORE_FILESYSTEM_LOGS_DIR` in the [`config.php` configuration file].  If
this global constant is undefined (or the `config.php` file was not loaded),
log files MAY be saved in different directories.  This usually is the current
working directory for the main PHP application, for example the `/install/`
directory when you are executing the `/install/index.php` application.

[`config.php` configuration file]: https://github.com/storecore/core/blob/develop/config.php


## Contributing

Please read through our [contributing guidelines].  Included are directions for
opening issues, posting feature requests, coding standards, and notes on
development.

[contributing guidelines]: https://github.com/storecore/core/blob/develop/CONTRIBUTING.md "StoreCore Developer Guide"

Editor preferences are available in the [editor config] for easy use in common
text editors.  Read more and download plugins at <http://editorconfig.org>.

[editor config]: https://github.com/storecore/core/blob/develop/.editorconfig "Editor configuration"


## Versioning

For transparency into our release cycle and in striving to maintain backward
compatibility, StoreCore is maintained under the [Semantic Versioning (SemVer) guidelines]
Sometimes we may screw up, but we’ll adhere to those rules whenever possible.

[Semantic Versioning (SemVer) guidelines]: https://semver.org/ "Semantic Versioning 2.0.0"


## Creators

**Ward van der Put**

- <https://github.com/wardvanderput>

**Tristan van Bokkem**

- <https://github.com/tvb>


## Copyright and License

Code copyright © 2015–2019 StoreCore™.
All code is released as **Free and Open-Source Software (FOSS)**
under the [GNU General Public License](https://www.gnu.org/licenses/gpl.html).
