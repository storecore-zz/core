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
- [PSR-5 PHPDoc] (proposal) for PHPDoc and DocBlocks
- [Google HTML/CSS Style Guide] for HTML and CSS
- [Google XML Document Format Style Guide] for XML

[Semantic Versioning (SemVer)]: http://semver.org/ "Semantic Versioning 2.0.0"

[PSR-1 Basic Coding Standard]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md "PSR-1 Basic Coding Standard"

[PSR-2 Coding Style Guide]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md "PSR-2 Coding Style Guide"

[PSR-5 PHPDoc]: https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md "PSR-5 PHPDoc"

[Google HTML/CSS Style Guide]: https://google-styleguide.googlecode.com/svn/trunk/htmlcssguide.xml "Google HTML/CSS Style Guide"

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

Global constants mimic the StoreCore namespace and sub-namespaces with a prefix.
For example, the `StoreCore\Database` namespace uses constants with a
`STORECORE_DATABASE` prefix in constant names like `STORECORE_DATABASE_USERNAME`
and `STORECORE_DATABASE_PASSWORD`.


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

## 3.3. Shared Data

StoreCore data is shared through the [service locator design pattern].

[service locator design pattern]: https://en.wikipedia.org/wiki/Service_locator_pattern "Service locator pattern"

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


# 4. Performance

## 4.1. Do: Your Own Math

Letting the server recalculate a fixed value over and over again, is lazy.
Simply calculate the fixed value once yourself.  Add a comment if you would
like to clarify a given value.

Incorrect:

```php
setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->Server['HTTP_HOST']);
```

Correct:

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

Incorrect:

```
`date_added`  DATETIME  NOT NULL
```

Correct:

```
`date_added`  TIMESTAMP  NOT NULL  DEFAULT CURRENT_TIMESTAMP
```

Incorrect:

```
`date_modified`  DATETIME  NOT NULL
```

Correct:

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

Incorrect:

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

Correct:

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

## 4.5. Do Not: Close and Immediately Re-Open PHP Tags

Incorrect:

```php
<?php echo $header; ?><?php echo $column_left; ?>
```

Correct:

```php
<?php
echo $header;
echo $column_left;
?>
```


# 5. PHP Development Guidelines

## 5.1. Exceptions

Models and controllers SHOULD NOT terminate a script with an exit.  Use an
exception instead, so the application using the model or controller may respond
to the failure.  If the exception is not caught, it will result in a “Fatal
error: Uncaught exception.”

Incorrect:

```php
if (!file_exists($file)) {
    exit('Could not load file: ' . $file);
}
```

Correct:

```php
if (!file_exists($file)) {
    throw new \Exception('Could not load file: ' . $file);
}
```


# 6. Internationalization (I18N) and Localization (L13N)


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
 * @copyright Copyright (c) 2015 StoreCore
 * @copyright Portions copyright (c) 2009-2014 FooBar
 * @version   0.1.0
 */
```

Please note that documenting changes and proper attribution is REQUIRED by the
GNU General Public License (GPL):

*For the developers’ and authors’ protection, the GPL clearly explains that
there is no warranty for this free software.  For both users' and authors’
sake, the GPL requires that modified versions be marked as changed, so that
their problems will not be attributed erroneously to authors of previous
versions.)*
