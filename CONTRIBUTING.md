StoreCore Developer Guide
=========================

# 1. Introduction

#### Key Words to Indicate Requirement Levels (RFC 2119)

The key words “MUST”, “MUST NOT”, “REQUIRED”, “SHALL”, “SHALL NOT”, “SHOULD”,
“SHOULD NOT”, “RECOMMENDED”,  “MAY”, and “OPTIONAL” in this document are to be
interpreted as described in [RFC 2119](https://www.ietf.org/rfc/rfc2119.txt).

#### Pardon Our Dunglish

As native speakers of Dutch, we sometimes write *Dunglish:* a portmanteau of
*Dutch and English* or *Dutch English.*  Please do feel free to correct our
mistakes.  Simply fork this Developer Guide on GitHub and submit a pull request
that fixes the mistake.


# 2. Developer Policies

## 2.1. Normative References

**Don’t reinvent the wheel.** Please refer to the following standards and
recommendations for the current best practices.

- [Semantic Versioning (SemVer)] for version IDs
- [PSR-1 Basic Coding Standard] for PHP
- [PSR-2 Coding Style Guide] for PHP
- [PSR-3 Logger Interface] for logging
- [PSR-5 PHPDoc (proposal)] for PHPDoc and DocBlocks
- [PSR-6 Cache] for cache item and cache pool interfaces
- [Google HTML/CSS Style Guide] for HTML and CSS
- [Google JSON Style Guide] for JSON
- [Google XML Document Format Style Guide] for XML

[Semantic Versioning (SemVer)]: http://semver.org/ "Semantic Versioning 2.0.0"

[PSR-1 Basic Coding Standard]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md "PSR-1 Basic Coding Standard"

[PSR-2 Coding Style Guide]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md "PSR-2 Coding Style Guide"

[PSR-3 Logger Interface]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md "PSR-3 Logger Interface"

[PSR-5 PHPDoc (proposal)]: https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md "PSR-5 PHPDoc"

[PSR-6 Cache]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-6-cache.md "PSR-6 Cache"

[Google HTML/CSS Style Guide]: https://google-styleguide.googlecode.com/svn/trunk/htmlcssguide.xml "Google HTML/CSS Style Guide"

[Google JSON Style Guide]: https://google.github.io/styleguide/jsoncstyleguide.xml "Google JSON Style Guide"

[Google XML Document Format Style Guide]: https://google-styleguide.googlecode.com/svn/trunk/xmlstyle.html "Google XML Document Format Style Guide"

## 2.2. PHP Namespaces and FQCN’s

The global namespace `StoreCore` is used for all system files that are critical
to the core.  StoreCore projects are subsequently added in their own
`StoreCore\<project_name>` sub-namespace, for example `StoreCore\Database`
for databases and `StoreCore\Cache` for components related to caching
features.  This is an implementation of *fully qualified class names* (FQCN’s)
from the [PSR-4 Autoloader] recommendation:

- The fully qualified class name MUST have a top-level namespace name, also
  known as a “vendor namespace”.

- The fully qualified class name MAY have one or more sub-namespace names.

[PSR-4 Autoloader]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

## 2.3. Global Constants

Global constants match the StoreCore namespace and sub-namespace prefixes.
For example, the `StoreCore\Database` namespace uses constants with a
`StoreCore\Database` prefix in constant names like `StoreCore\Database\DEFAULT_USERNAME`
and `StoreCore\Database\DEFAULT_PASSWORD`.

## 2.4. Packages

There are three packages dedicated to the core:

- `@package StoreCore\Core` for core system files and core services;
- `@package StoreCore\I18N` for internationalization (I18N) and localization (L10N);
- `@package StoreCore\Security` for everything related to security.

Furthermore, there are four packages for functional areas:

- `@package StoreCore\BI` for Business Intelligence (BI);
- `@package StoreCore\CMS` for the Content Management System (CMS);
- `@package StoreCore\CRM` for Customer Relationship Management (CRM);
- `@package StoreCore\OML` for Operations Management and Logistics (OML).


# 3. Security

## 3.1. Protected Configuration Files

All files with a `config` filename are inaccessible.  These include common
filenames like `config.ini` and `config.php`.

This file protection is configured in the default `.htaccess` Apache system
file:

```
<Files "config.*">
  Deny from all
</Files>
```

## 3.2. Protected File Types

The following file extensions are inaccessible:

* `.bak` and `.tmp` for backup or temporary files
* `.inc` and `.ssi` for server-side includes
* `.ini` for initialization and configuration files
* `.log` for log files
* `.md` for Markdown text files
* `.phps` for PHP script output
* `.phtml` and `.tpl` for template files
* `.sql` for SQL database files

## 3.3. Protected Directories

There are three directories that MUST NOT be accessed publicly:

* `/cache/` for cache files
* `/logs/` for log files
* `/StoreCore/` for the code library

Access to these directories is denied in `.htaccess`, so for example logs are
inaccessible through a URL like `http://www.example.com/logs/`.  It is however
RECOMMENDED to move these directories out of the web root entirely.  If a
directory is moved, the path can be set by uncommenting one of the directives
in the `File System` section of the `config.ini` configuration file:

```
[File System]
;storecore_filesystem.cache = ''
;storecore_filesystem.library_root = ''
;storecore_filesystem.logs = ''
```

| Directory  | Directive                           |
| ---------- | ----------------------------------- |
| /cache     | `storecore_filesystem.cache`        |
| /logs      | `storecore_filesystem.logs`         |
| /StoreCore | `storecore_filesystem.library_root` |

## 3.4. Logging

By default, StoreCore logs errors, warnings, and noticeable events to `.log`
files in the StoreCore file system.  Logging MAY be switched off by enabling
the null logger in the global `config.ini` configuration file.

```
storecore.null_logger = On
```

However, disabling the default logging mechanism is NOT RECOMMENDED, as all
important events will go unnoticed.  If there is sufficient disk space and the
logging does not have noticeable performance side-effects at the file system
level, the null logger should be disabled.  This is the default configuration
setting:

```
storecore.null_logger = Off
```

## 3.5. SSL Modes

StoreCore supports four SSL modes per store.  This `ssl_mode` is a 4 bit value
stored as a decimal integer in the core `sc_stores` table.  The binary bitmask
is outlined below.

| Bin  | Dec | SSL Secured Information                   |
| ---- | --: | ----------------------------------------- |
| 0000 |   0 | Off: no SSL support                       |
| 0001 |   1 | Payment transactions                      |
| 0010 |   2 | Personally identifiable information (PII) |
| 0100 |   4 | Company and legal information             |
| 1000 |   8 | General information                       |
| 1111 |  15 | On: full SSL support                      |

In most use cases, the SSL mode can simply be set to 15 (on) or 0 (off).
The other two supported modes are 1 (0001) for payment transactions only and
3 (0011) for payment transactions plus personally identifiable information
(PII).


# 4. Performance

This chapter contains several do’s and don’ts on performance.

## 4.1. Do: Your Own Math

Letting the server recalculate a fixed value over and over again, is lazy.
Simply calculate the fixed value once yourself.  Add a comment if you would
like to clarify a given value.

###### Incorrect:

```php
setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->Server['HTTP_HOST']);
```

###### Correct:

```php
setcookie('language', $code, time() + 2592000, '/', $request->Server['HTTP_HOST']);
```

With a comment. Even better!

```php
// Cookie expires in 60 seconds * 60 minutes * 24 hours * 30 days = 2592000 seconds
setcookie('language', $code, time() + 2592000, '/', $request->Server['HTTP_HOST']);
```

## 4.2. Do: Order Database Table Columns for Performance

In some databases, it is more efficient to order the columns in a specific
manner because of the way the disk access is performed.  The optimal order of
columns in a MySQL InnoDB table is:

- Primary key
- Combined primary keys as defined in the `KEY` order
- Foreign keys used in `JOIN` queries
- Columns with an `INDEX` used in `WHERE` conditions or `ORDER BY` statements
- Others columns used in `WHERE` conditions
- Others columns used in `ORDER BY` statements
- `VARCHAR` columns with a variable length
- Large `TEXT` and `BLOB` columns

When there are many `VARCHAR` columns (with variable length) in a MySQL table,
the column order MAY affect the performance of queries.  The less close a
column is to the beginning of the row, the more preceding columns the InnoDB
engine should examine to find out the offset of a given one.  Columns that are
closer to the beginning of the table are therefore selected faster.

## 4.3. Do: Store DateTimes as UTC Timestamps

Times and dates with times SHOULD be stored in Coordinated Universal Time
(UTC).

###### Incorrect:

```
`date_added`  DATETIME  NOT NULL
```

###### Correct:

```
`date_added`  TIMESTAMP  NOT NULL  DEFAULT CURRENT_TIMESTAMP
```

###### Incorrect:

```
`date_modified`  DATETIME  NOT NULL
```

###### Correct:

```
`date_modified`  TIMESTAMP  NOT NULL  ON UPDATE CURRENT_TIMESTAMP
```

When there are two timestamps, the logical thing to do is setting `date_added`
to `DEFAULT CURRENT_TIMESTAMP` for the initial `INSERT` query and
`date_modified` to `ON UPDATE CURRENT_TIMESTAMP` for subsequent `UPDATE`
queries:

```
`date_added`     TIMESTAMP  NOT NULL  DEFAULT CURRENT_TIMESTAMP
`date_modified`  TIMESTAMP  NOT NULL  DEFAULT '0000-00-00 00:00:00'  ON UPDATE CURRENT_TIMESTAMP
```

This, however, only works in MySQL 5.6+.  Older versions of MySQL will report
an error: “Incorrect table definition; there can be only one TIMESTAMP column
with CURRENT_TIMESTAMP in DEFAULT or ON UPDATE clause”.

The workaround currently implemented is to set the `DEFAULT` value for the
initial `INSERT` timestamp to `'0000-00-00 00:00:00'`:

```
`date_added`     TIMESTAMP  NOT NULL  DEFAULT '0000-00-00 00:00:00',
`date_modified`  TIMESTAMP  NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
```

## 4.4. Don’t: Cast MySQL Integers to Strings

String equality comparisons are much more expensive than integer compares.
If a database value is an integer, it MUST NOT be treated as a numeric string.
This holds especially true for primary keys and foreign keys.

###### Incorrect:

```php
$sql = "
    UPDATE sc_addresses
    SET customer_id = '" . (int)$customer_id . "'
    WHERE address_id = '" . (int)$address_id . "'";
```

```sql
UPDATE sc_addresses
   SET customer_id = '54321'
 WHERE address_id  = '67890';
```

###### Correct:

```php
$sql = '
    UPDATE sc_addresses
    SET customer_id = ' . (int)$customer_id . '
    WHERE address_id = ' . (int)$address_id;
```

```sql
UPDATE sc_addresses
   SET customer_id = 54321
 WHERE address_id  = 67890;
```

## 4.5. Don’t: Close and Immediately Re-Open PHP Tags

###### Incorrect:

```php
<?php echo $header; ?><?php echo $menu; ?>
```

###### Incorrect:

```php
<?php echo $header; ?>
<?php echo $menu; ?>
```

###### Correct:

```php
<?php
echo $header;
echo $menu;
?>
```

## 4.6. Do: Return Early

Once the outcome of a PHP method or procedure has been established, it SHOULD
be returned.  The examples below demonstrate this may save memory and
computations.

###### Incorrect:

```php
public function hasDownload()
{
    $download = false;

    foreach ($this->getProducts() as $product) {
        if ($product['download']) {
            $download = true;
            break;
        }
    }

    return $download;
}
```

###### Correct:

```php
public function hasDownload()
{
    foreach ($this->getProducts() as $product) {
        if ($product['download']) {
            return true;
        }
    }

    return false;
}
```


# 5. PHP Development Guidelines

## 5.1. Exceptions

Models and controllers SHOULD NOT terminate a script with an exit.  Use an
exception instead, so the application using the model or controller may respond
to the failure.  If the exception is not caught, it will result in a “Fatal
error: Uncaught exception.”

###### Incorrect:

```php
if (!file_exists($file)) {
    exit('Could not load file: ' . $file);
}
```

###### Correct:

```php
if (!file_exists($file)) {
    throw new \Exception('Could not load file: ' . $file);
}
```

In many cases it is RECOMMENDED to throw a more specific [Standard PHP Library
(SPL) exception], for example a [runtime exception] if a file only exists after
it was saved by an application.

###### Correct:

```php
if (!file_exists($file)) {
    throw new \RuntimeException('Could not load file: ' . $file);
}
```

[Standard PHP Library (SPL) exception]: http://php.net/manual/en/spl.exceptions.php
[runtime exception]: http://php.net/manual/en/class.runtimeexception.php

## 5.2. Shared Data

StoreCore data is shared through the [service locator design pattern].
The centralized registry is the only link between applications and controllers.

At any given time there should be only one single instance of the registry.
The StoreCore registry is therefore implemented using the [singleton design
pattern].  Because the registry implements a `SingletonInterface`, it cannot be
instantiated.  Instead you should call the static `getInstance()` method.

###### Incorrect:

```php
$registry = new \StoreCore\Registry();
```

###### Correct:

```php
$registry = \StoreCore\Registry::getInstance();
```

[service locator design pattern]: https://en.wikipedia.org/wiki/Service_locator_pattern "Service locator pattern"

[singleton design pattern]: https://en.wikipedia.org/wiki/Singleton_pattern "Singleton pattern"

### 5.2.1. MVC Models and Controllers

Framework MVC controllers SHOULD extend the abstract core class
`AbstractController`.  Likewise MVC models MAY extend the abstract class
`AbstractModel`:

```php
class FooController extends AbstractController
{
    // <...>
}

class FooModel extends AbstractModel
{
    // <...>
}
```

If a model needs access to the database, it MAY extend the `AbstractModel`
from the `StoreCore\Database` namespace.  Therefore there a two abstract
prototypes for models available, one without and one with a database
connection:

```php
class FooModel extends \StoreCore\AbstractModel
{
    // <...>
}

class BarModel extends \StoreCore\Database\AbstractModel
{
    // <...>
}
```

The StoreCore abstract DAO (Data Access Object) provides a CRUD interface to
Create, Read, Update, and Delete database records.  It executes the four basic
SQL data manipulation operations: `INSERT`, `SELECT`, `UPDATE`, and `DELETE`.
Model classes that extend the abstract DAO MUST provide two class constants for
late static bindings: a `TABLE_NAME` with the database table name the model
operates on and a `PRIMARY_KEY` for the primary key column of this table.

### 5.2.2. Shared Core Services

| Service    | Class                          |
| ---------- | ------------------------------ |
| Connection | \StoreCore\Database\Connection |
| Logger     | \StoreCore\FileSystem\Logger   |
| Request    | \StoreCore\Request             |
| Response   | \StoreCore\Response            |
| Session    | \StoreCore\Session             |

### 5.2.3. MVC Class Synopses

#### Models

```php
\StoreCore\Registry implements SingletonInterface {
    public mixed get ( string $key )
    public static self getInstance ( void )
    public bool has ( string $key )
    public void set ( string $key, mixed $value )
}

\StoreCore\AbstractModel {
    public __construct ( \StoreCore\Registry $registry )
    public mixed __get ( string $key )
    public void __set ( string $key , mixed $value )
}

\StoreCore\Database\AbstractModel extends \StoreCore\AbstractModel {
    public __construct ( \StoreCore\Registry $registry )
    public mixed __get ( string $key )
    public void __set ( string $key , mixed $value )
}

\StoreCore\Database\AbstractDataAccessObject extends \StoreCore\Database\AbstractModel {
    public int create ( array $keyed_data )
    public int delete ( mixed $value [, string|int $key = null ] )
    public array read ( mixed $value [, string|int $key = null ] )
    public int update ( array $keyed_data )
}

\StoreCore\Session {
    public __construct ( [ int $idle_timeout ] )
    public void destroy ( void )
    public mixed|null get ( string $key )
    public string getSessionID ( void )
    public bool has ( string $key )
    public void regenerate ( void )
    public void set ( string $key , mixed $value )
}
```

#### Views

```php
\StoreCore\View {
    public __construct ( [ string $template ] )
    public $this setTemplate ( string $template )
    public $this setValues ( array $values )
    public string render ( void )
}
```

#### Controllers

```php
\StoreCore\AbstractController {
    public __construct ( \StoreCore\Registry $registry )
    public mixed __get ( string $key )
    public void __set ( string $key , mixed $value )
}
```

### 5.2.4. Reserved Session Variables

There are three session variable names that SHOULD NOT be used.  These are
reserved for internal use by the core `Session` class.  If one of these
reserved names is used, the `Session::set()` method will throw an invalid
argument exception:

- `string $_SESSION['HTTPS']`
- `string $_SESSION['HTTP_USER_AGENT']`
- `array $_SESSION['SESSION_OBJECT_POOL']`

The reserved `$_SESSION['HTTPS']` and `$_SESSION['HTTP_USER_AGENT']` session
variables contain copies of the global `$_SERVER['HTTPS']` and
`$_SERVER['HTTP_USER_AGENT']` server variables.  The `$_SESSION['HTTPS']` is
used to regenerate the session ID if the client connection switches from
plain HTTP to HTTP Secure (HTTP/S) and back.  The `$_SESSION['HTTP_USER_AGENT']`
variable is used to notice any changes of the HTTP client or the client
configuration.

### 5.2.5. Global Session Objects and Variables

| Name     | Type   | Class or Method                             |
| -------- | ------ | ------------------------------------------- |
| Language | string | `\StoreCore\I18N\Locale::load()`            |
| Token    | string | `\StoreCore\Types\FormToken::getInstance()` |
| User     | object | `\StoreCore\User`                           |


# 6. Internationalization (I18N) and Localization (L13N)

## 6.1. Limitations of MVC-L

From the outset we decided multilingual support of [European languages]
SHOULD be a key feature of an open-source e-commerce community operating from
Europe.  Support of multiple languages would no longer be an option, but
a MUST.  For companies operating in bilingual and multilingual European
countries like Belgium, Luxembourg, Finland, and Switzerland this may of
course be an critical key feature too.

[European languages]: https://en.wikipedia.org/wiki/Languages_of_Europe "Languages of Europe"

The traditional MVC-L (model-view-controller-language) application structure
adds severe limitations to performance, maintenance, and scalability.
For example, a single language adds over 350 files in about 40 directories to
an OpenCart install.  If the [OpenCart MVC-L implementation] is expanded to
four or even more languages, file management becomes a dreadful task.

There are performance side-effects if a single MVC view consists of not only
one template file, but also several language files for all supported languages.

Furthermore, *consistency* within one language is difficult to maintain if
terms are spread out over dozens of language files.  For example, if the store
manager wants to change *shopping cart* to *shopping basket*, a developer will
have go over several files.  A more centralized approach with an end-user
interface for editing seems a much wiser choice.

[OpenCart MVC-L implementation]: http://docs.opencart.com/display/opencart/Introduction+to+MVC-L

## 6.2. Translation Memory (TM)

StoreCore uses a [translation memory (TM)] to handle and maintain all language
strings.  The translation memory database table is defined in the main SQL DDL
(Data Definition Language) file `core-mysql.sql` for MySQL.  The translations
are in a separate SQL DML (Data Manipulation Language) file called
`i18n-dml.sql`.

[translation memory (TM)]: https://en.wikipedia.org/wiki/Translation_memory "Translation memory (TM)"

### 6.2.1. Root: Core or Master Languages

*Core languages*, or *masters*, are root-level language packs.  They SHOULD NOT
be deleted, which is prevented by a foreign key constraint `fk_language_id` on
the self-referencing key `parent_id`.  If the `language_id` is equal to the
`parent_id`, a language has no parent and is therefore a core language located
at the root of the language family tree.

Currently, the core supports four European master languages.  These are defined
in the `SUPPORTED_LANGUAGES` constant of the `Locale` class:

- `de-DE` for German
- `en-GB` for English
- `fr-FR` for French
- `nl-NL` for Dutch

If no language match is found, StoreCore defaults to `en-GB` for British
English.

Master languages cannot be deleted; they can only be disabled.  If you do try
to delete a master language from the database, the `DELETE` query fails on a
foreign key constraint.

###### Incorrect:

```sql
DELETE FROM sc_languages
      WHERE iso_code = 'de-DE';
```

###### Correct:

```sql
UPDATE sc_languages
   SET status = 0
 WHERE iso_code = 'de-DE';
```

### 6.2.2. Tree and Branches: Secondary Languages

*Secondary languages* are derived from the core/master languages.  They only
contain differences with the master language.  For example, the “English -
United States” (en-US) language pack only contains the differences between
American English and British English in its “English - United Kingdom”
(en-GB) master.  This allows for global localization while maintaining language
consistency and a concise dictionary.

## 6.3. Content Language Negotiation

StoreCore uses the HTTP `Accept-Language` header to determine which content
language is preferred by visitors, customers, users, and client applications.
The current language can be found by supplying an array of supported languages
to the `Language::negotiate()` method.

###### Class Synopsis

```php
Language {
    public string negotiate ( array $supported [, string $default = 'en-GB'] )
}
```

The `$supported` parameter must be an associative array of ISO language codes
that evaluate to `true`.  For example, if an application supports both English
and French, the supported languages may be defined as:

```php
$supported = array(
    'en-GB' => true,
    'fr-FR' => true,
);
```

This data structure allows you to temporarily disable a supported language,
without fully dropping it:

```php
$supported = array(
    'en-GB' => true,
    'fr-FR' => false,
);
```

## 6.4. Translation Guidelines

### 6.4.1. Language Components

The translations memory contains seven components, divided into two groups.
These groups are namespaced with an uppercase prefix.  The first group contains
basic language constructs in plain text, without any formatting:

- `ADJECTIVE` for adjectives
- `NOUN` for nouns and names
- `VERB` for verbs.

The second group is used in user interfaces and MAY contain formatting,
usually HTML5:

- `COMMAND` for menu commands and command buttons
- `ERROR` for error messages
- `HEADING` for headings and form labels
- `TEXT` for anything else.

### 6.4.2. Compound Nouns

Compound nouns are handled as single nouns.  For example, *shopping cart* is
not stored as two terms like `NOUN_SHOPPING` plus `NOUN_CART`, but as a single
segment like `NOUN_SHOPPING_CART`.

### 6.4.3. Names as Nouns

Names are treated as nouns.  Therefore they contain the default `NOUN` prefix,
for example `NOUN_PAYPAL` for *PayPal* and `NOUN_MYSQL` for *MySQL*.

### 6.4.4. Verbs to Commands

Commands, menu commands and command buttons usually indicate an activity.
Therefore commands SHOULD be derived from verbs.  The translation memory SQL
file contains an example of this business logic.  The general verb *print*
in lowercase becomes the command **Print…** with an uppercase first letter and
three dots in user interfaces.

```sql
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('VERB_PRINT',   0, 'print'),
    ('VERB_PRINT',   1, 'printen'),
    ('VERB_PRINT',   2, 'drucken'),
    ('VERB_PRINT',   3, 'imprimer');

INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('COMMAND_PRINT',   0, 'Print…'),
    ('COMMAND_PRINT',   1, 'Printen…'),
    ('COMMAND_PRINT',   2, 'Drucken…'),
    ('COMMAND_PRINT',   3, 'Imprimer…');
```

In some cases verbs are included in the translation memory for reference
purposes and consistency.  For example, the verb *to print* may in Dutch be
translated as *printen*, *afdrukken*, or *drukken*.  The definition `afdrukken`
of `VERB_PRINT` thus indicates the preferred translation.

### 6.4.5. Errors and Exceptions

Error messages and exception message strings currently are not translated as
these are intended primarily for developers and server administrators.


# 7. Documentation

## 7.1. Copyright and Version DocBlock

If a file is brought in from another open-source project, a DocBlock MUST be
added that clearly names the origin in the `@copyright` tag.

Example:

```
/**
 * @copyright Copyright (c) 2009-2014 FooBar
 */
```

If a component of the FooBar project is refactored, the unchanged code
establishes a baseline.  If this component does not use SemVer versioning, the
unchanged baseline MUST be denoted as `@version 0.0.0` for reference purposes:

```
/**
 * @copyright Copyright (c) 2009-2014 FooBar
 * @version   0.0.0
 */
```

Once the file is changed, copyright (or, actually, copyleft) is extended to
the StoreCore framework:

```
/**
 * @copyright Copyright (c) 2016 StoreCore
 * @copyright Portions copyright (c) 2009-2015 FooBar
 * @version   0.1.0
 */
```

Please note that documenting changes and proper attribution is REQUIRED by the
GNU General Public License (GPL):

*For the developers’ and authors’ protection, the GPL clearly explains that
there is no warranty for this free software.  For both users’ and authors’
sake, the GPL requires that modified versions be marked as changed, so that
their problems will not be attributed erroneously to authors of previous
versions.)*

## 7.2. Class Versions

All abstract classes and classes MUST include a `VERSION` constant.  Because
class constants are always accessible outside the class scope, this allows for
updates and possibly handling future compatibility issues.  For reference
purposes the `const` definition is usually included on the first line in the
`class` definition:

```php
<?php
class FooBar
{
    const VERSION = '0.1.0-alpha.1';

    // <...>
}
```

If the class file contains an initial DocBlock, the PHPDoc `@version` tag MUST
be set to the currently defined `VERSION`:

```php
<?php
/**
 * Foo Bar
 *
 * @version 0.1.0-alpha.1
 */
class FooBar
{
    const VERSION = '0.1.0-alpha.1';

    // <...>
}
```

The `SetupInterface` interface in the `StoreCore\Modules` namespace additionally
prescribes the implementation a `getVersion()` method.  This formalizes an
important reminder: classes and modules MUST include a publicly accessible
version ID.

```php
<?php
namespace StoreCore\Modules;

interface SetupInterface
{
    public function getVersion();
    public function install();
    public function uninstall();
}
```
