[![Slack](https://storecore-slack.herokuapp.com/badge.svg)](https://storecore-slack.herokuapp.com)
[![Build Status](https://app.snap-ci.com/storecore/core/branch/develop/build_image)](https://app.snap-ci.com/storecore/core/branch/develop)
[![Sauce Test Status](https://saucelabs.com/buildstatus/storecorebot)](https://saucelabs.com/u/storecorebot)


[![Sauce Test Status](https://saucelabs.com/browser-matrix/storecorebot.svg)](https://saucelabs.com/u/storecorebot)


# [StoreCore](http://storecore.io)

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

7. Run the StoreCore installation by accessing the URL in a web browser.  If
   StoreCore was not previously installed, you will be guided through the
   necessary steps to complete the installation.

### Installation Logs

All installation and configuration activities are logged to `.log` text files
in the `/logs/` directory.  If the StoreCore installation fails for any reason,
please first check these log files for possible errors, warnings or other
critical messages.


## Contributing

Please read through our [contributing guidelines].  Included are directions for
opening issues, posting feature requests, coding standards, and notes on
development.

[contributing guidelines]: https://github.com/storecore/core/blob/master/CONTRIBUTING.md "StoreCore Developer Guide"

Editor preferences are available in the [editor config] for easy use in common
text editors.  Read more and download plugins at <http://editorconfig.org>.

[editor config]: https://github.com/storecore/core/blob/master/.editorconfig "Editor configuration"


## Versioning

For transparency into our release cycle and in striving to maintain backward
compatibility, StoreCore is maintained under the [Semantic Versioning (SemVer) guidelines]
Sometimes we may screw up, but we’ll adhere to those rules whenever possible.

[Semantic Versioning (SemVer) guidelines]: http://semver.org/ "Semantic Versioning 2.0.0"


## Creators

**Ward van der Put**

- <https://github.com/wardvanderput>

**Tristan van Bokkem**

- <https://github.com/tvb>


## Copyright and License

Code copyright © 2015-2017 StoreCore™.
All code is released as **Free and Open-Source Software (FOSS)**
under the [GNU General Public License](https://github.com/storecore/core/blob/master/LICENSE.txt).
