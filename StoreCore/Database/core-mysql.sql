--
-- MySQL Data Definition
--
-- @author    Ward van der Put <Ward.van.der.Put@gmail.com>
-- @copyright Copyright (c) 2014-2017 StoreCore
-- @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
-- @package   StoreCore\Database
-- @version   0.1.0
--

-- HMVC routing
CREATE TABLE IF NOT EXISTS sc_routes (
  route_id           INT(10) UNSIGNED     NOT NULL  AUTO_INCREMENT,
  dispatch_order     TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  route_path         VARCHAR(255)         NOT NULL,
  route_controller   VARCHAR(255)         NOT NULL,
  controller_method  VARCHAR(255)         NULL  DEFAULT NULL,
  method_parameters  VARCHAR(255)         NULL  DEFAULT NULL,
  PRIMARY KEY pk_route_id (route_id),
  INDEX ix_dispatch_order (dispatch_order ASC),
  INDEX ix_route_path (route_path)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Observer design pattern
CREATE TABLE IF NOT EXISTS sc_subjects (
  subject_id     SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  subject_class  VARCHAR(255)          NOT NULL,
  PRIMARY KEY pk_subject_id (subject_id),
  UNIQUE KEY uk_subject_class (subject_class)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_observers (
  observer_id     SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  subject_id      SMALLINT(5) UNSIGNED  NOT NULL,
  observer_class  VARCHAR(255)          NOT NULL,
  observer_name   VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY pk_observer_id (observer_id),
  FOREIGN KEY fk_subject_id (subject_id) REFERENCES sc_subjects (subject_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_subjects (subject_class) VALUES
  ('\\StoreCore\\Person'),
  ('\\StoreCore\\Session');

-- Languages
CREATE TABLE IF NOT EXISTS sc_languages (
  language_id   CHAR(5)              CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  parent_id     CHAR(5)              CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  DEFAULT 'en-GB',
  enabled_flag  TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  sort_order    TINYINT(3) UNSIGNED  NOT NULL  DEFAULT 0,
  english_name  VARCHAR(32)          NOT NULL,
  local_name    VARCHAR(32)          CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT NULL,
  PRIMARY KEY pk_language_id (language_id),
  FOREIGN KEY fk_language_id (parent_id) REFERENCES sc_languages (language_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  UNIQUE KEY uk_english_name (english_name)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Primary languages
INSERT IGNORE INTO sc_languages (language_id, english_name, local_name, enabled_flag) VALUES
  ('en-GB', 'English - United Kingdom', 'English - United Kingdom', 1),
  ('de-DE', 'German - Germany', 'Deutsch - Deutschland', 1),
  ('fr-FR', 'French - France', 'Français - France', 1),
  ('nl-NL', 'Dutch - Netherlands', 'Nederlands - Nederland', 1),

  -- World languages and languages with over 50 million native speakers
  ('zh-CN', 'Chinese (simplified) - China', '汉语', 0),
  ('zh-TW', 'Chinese (traditional) - Taiwan', '漢語', 0),
  ('es-ES', 'Spanish - Spain', 'Español - España', 0),
  ('hi-IN', 'Hindi - India', 'हिन्दी', 0),
  ('ar-SA', 'Arabic - Saudi Arabia', 'العَرَبِيةُ', 0),
  ('pt-PT', 'Portuguese - Portugal', 'Português - Portugal', 0),
  ('bn-BD', 'Bengali - Bangladesh', 'বাংলা ', 0),
  ('ru-RU', 'Russian - Russia', 'Русский - Россия', 0),
  ('ja-JP', 'Japanese - Japan', '日本語', 0),
  ('pa-IN', 'Punjabi - India', 'پنجابی', 0),
  ('tr-TR', 'Turkish - Turkey', 'Türkçe - Türkiye', 0),
  ('jv-ID', 'Javanese - Indonesia', 'ꦧꦱꦗꦮ', 0),
  ('ko-KR', 'Korean - Korea', '한국어/조선말', 0),
  ('vi-VN', 'Vietnamese - Vietnam', 'Tiếng Việt', 0),
  ('fa-IR', 'Farsi - Iran', 'فارسی', 0),
  ('ta-IN', 'Tamil - India', 'தமிழ்', 0),
  ('ur-PK', 'Urdu - Pakistan', 'اردو', 0),
  ('it-IT', 'Italian - Italy', 'Italiano - Italia', 0),
  ('ms-MY', 'Malay - Malaysia', 'بهاس ملايو‎', 0),
  ('id-ID', 'Indonesian - Indonesia', 'Bahasa Indonesia', 0),

  -- Official European languages with over 10 million native speakers
  ('pl-PL', 'Polish - Poland', 'Polski - Polska', 0),
  ('uk-UA', 'Ukrainian - Ukraine', 'українська мова', 0),
  ('az-AZ', 'Azerbaijani - Azerbaijan', 'آذربایجان دیلی', 0),
  ('ro-RO', 'Romanian - Romania', 'Română - România', 0),
  ('el-GR', 'Greek - Greece', 'Eλληνικά - Ελλάδα', 0),
  ('hu-HU', 'Hungarian - Hungary', 'Magyar - Magyarország', 0),
  ('cs-CZ', 'Czech - Czech Republic', 'Čeština - Česká republika', 0),
  ('ca-AD', 'Catalan - Andorra', 'Català - Andorra', 0),

  -- Official European languages with over 5 million native speakers
  ('bg-BG', 'Bulgarian - Bulgaria', 'Български - България', 0),
  ('da-DK', 'Danish - Denmark', 'Dansk - Danmark', 0),
  ('fi-FI', 'Finnish - Finland', 'Suomi - Suomi', 0),
  ('hy-AM', 'Armenian - Armenia', 'Հայերեն - Հայաստան', 0),
  ('hr-HR', 'Croatian - Croatia', 'Hrvatski - Hrvatska', 0),
  ('kk-KZ', 'Kazakh - Kazakhstan', 'қазақ тілі - Қазақстан', 0),
  ('nb-NO', 'Norwegian Bokmål - Norway', 'Bokmål - Norge', 0),
  ('nn-NO', 'Norwegian Nynorsk - Norway', 'Nynorsk - Noreg', 0),
  ('sk-SK', 'Slovak - Slovakia', 'Slovenčina - Slovensko', 0),
  ('sq-AL', 'Albanian - Albania', 'Shqip - Shqipëri', 0),
  ('sr-SP', 'Serbian - Serbia', 'Српски - Србија', 0),
  ('sv-SE', 'Swedish - Sweden', 'Svenska - Sverige', 0),

  -- Other languages
  ('af-ZA', 'Afrikaans - South Africa', 'Afrikaans - Suid-Afrika', 0),
  ('et-EE', 'Estonian - Estonia', 'Eesti', 0),
  ('eu-ES', 'Basque - Basque', 'Euskara', 0),
  ('gu-IN', 'Gujarati - India', 'ગુજરાતી', 0),
  ('he-IL', 'Hebrew - Israel', 'עברית', 0),
  ('is-IS', 'Icelandic - Iceland', 'Íslenska', 0),
  ('ka-GE', 'Georgian - Georgia', 'ქართული', 0),
  ('lb-LU', 'Luxembourgish - Luxembourg', 'Lëtzebuergesch', 0);

-- Secondary languages
INSERT IGNORE INTO sc_languages (language_id, parent_id, english_name, local_name, enabled_flag) VALUES
  ('de-AT', 'de-DE', 'German - Austria', 'Deutsch - Österreich', 0),
  ('de-CH', 'de-DE', 'German - Switzerland', 'Deutsch - Schweiz', 0),
  ('de-LI', 'de-DE', 'German - Liechtenstein', 'Deutsch - Liechtenstein', 0),
  ('de-LU', 'de-DE', 'German - Luxembourg', 'Deutsch - Luxemburg', 0),
  ('en-AU', 'en-GB', 'English - Australia', 'English - Australia', 0),
  ('en-CA', 'en-GB', 'English - Canada', 'English - Canada', 0),
  ('en-IE', 'en-GB', 'English - Ireland', 'English - Ireland', 0),
  ('en-NZ', 'en-GB', 'English - New Zealand', 'English - New Zealand', 0),
  ('en-US', 'en-GB', 'English - United States', 'English - United States', 1),
  ('es-MX', 'es-ES', 'Spanish - Mexico', 'Español mexicano - México', 0),
  ('fr-BE', 'fr-FR', 'French - Belgium', 'Français - Belgique', 0),
  ('fr-CA', 'fr-FR', 'French - Canada', 'Français - Canada', 0),
  ('fr-LU', 'fr-FR', 'French - Luxembourg', 'Français - Luxembourg', 0),
  ('fr-MC', 'fr-FR', 'French - Monaco', 'Français - Monaco', 0),
  ('it-CH', 'it-IT', 'Italian - Switzerland', 'Italiano - Svizzera', 0),
  ('nl-BE', 'nl-NL', 'Dutch - Belgium', 'Nederlands - België', 0),
  ('pt-BR', 'pt-BR', 'Portuguese - Brazil', 'Português - Brasil', 0),
  ('sv-FI', 'sv-SE', 'Swedish - Finland', 'Finlandssvenska - Finland', 0);

-- Organizations
CREATE TABLE IF NOT EXISTS sc_organizations (
  organization_id   MEDIUMINT(8) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  public_name       VARCHAR(255)  NULL  DEFAULT NULL,
  alternate_name    VARCHAR(255)  NULL  DEFAULT NULL,
  legal_name        VARCHAR(255)  NULL  DEFAULT NULL,
  email_address     VARCHAR(255)  NULL  DEFAULT NULL,
  telephone_number  VARCHAR(255)  NULL  DEFAULT NULL,
  fax_number        VARCHAR(255)  NULL  DEFAULT NULL,
  commerce_id       VARCHAR(255)  NULL  DEFAULT NULL,
  tax_id            VARCHAR(255)  NULL  DEFAULT NULL,
  vat_id            VARCHAR(255)  NULL  DEFAULT NULL,
  founding_date     DATE          NULL  DEFAULT NULL,
  dissolution_date  DATE          NULL  DEFAULT NULL,
  date_created      TIMESTAMP     NOT NULL  DEFAULT '1970-01-01 00:00:01',
  date_modified     TIMESTAMP     NULL  DEFAULT NULL,
  date_deleted      TIMESTAMP     NULL  DEFAULT NULL,
  PRIMARY KEY pk_organization_id (organization_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Persons
CREATE TABLE IF NOT EXISTS sc_persons (
  person_id             INT(10) UNSIGNED     NOT NULL  AUTO_INCREMENT,
  anonymized_flag       TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  deleted_flag          TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  date_modified         TIMESTAMP            NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  date_created          DATE                 NOT NULL,
  email_address         VARCHAR(255)         NULL  DEFAULT NULL,
  gender                TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0  COMMENT 'ISO/IEC 5218',
  honorific_prefix      VARCHAR(255)         NULL  DEFAULT NULL,
  given_name            VARCHAR(255)         NULL  DEFAULT NULL  COMMENT 'First name',
  additional_name       VARCHAR(255)         NULL  DEFAULT NULL  COMMENT 'Middle name',
  family_name           VARCHAR(255)         NULL  DEFAULT NULL  COMMENT 'Last name',
  honorific_suffix      VARCHAR(255)         NULL  DEFAULT NULL,
  full_name             VARCHAR(255)         NULL  DEFAULT NULL,
  given_name_initials   VARCHAR(255)         NULL  DEFAULT NULL,
  middle_name_initials  VARCHAR(255)         NULL  DEFAULT NULL,
  full_name_initials    VARCHAR(255)         NULL  DEFAULT NULL,
  telephone_number      VARCHAR(255)         NULL  DEFAULT NULL,
  nationality           CHAR(2)              NULL  DEFAULT NULL  COMMENT 'ISO 3166-1 alpha-2 country code',
  birth_date            DATE                 NULL  DEFAULT NULL,
  birth_place           VARCHAR(255)         NULL  DEFAULT NULL,
  death_date            DATE                 NULL  DEFAULT NULL,
  death_place           VARCHAR(255)         NULL  DEFAULT NULL,
  PRIMARY KEY pk_person_id (person_id),
  INDEX ix_date_modified (date_modified DESC),
  INDEX ix_date_created (date_created DESC),
  INDEX ix_email_address (email_address)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Organizations associated with a person
CREATE TABLE IF NOT EXISTS sc_person_organizations (
  person_id          INT(10) UNSIGNED       NOT NULL,
  organization_id    MEDIUMINT(8) UNSIGNED  NOT NULL,
  relation_type      ENUM('alumnus','employee','founder','funder','member','owner','sponsor')  NULL  DEFAULT NULL,
  job_title          VARCHAR(255)           NULL  DEFAULT NULL,
  email_address      VARCHAR(255)           NULL  DEFAULT NULL,
  telephone_number   VARCHAR(255)           NULL  DEFAULT NULL,
  fax_number         VARCHAR(255)           NULL  DEFAULT NULL,
  from_date          DATE                   NULL  DEFAULT NULL,
  thru_date          DATE                   NULL  DEFAULT NULL,
  PRIMARY KEY pk_id (person_id, organization_id),
  FOREIGN KEY fk_person_id (person_id) REFERENCES sc_persons (person_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_organization_id (organization_id) REFERENCES sc_organizations (organization_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- User groups
CREATE TABLE IF NOT EXISTS sc_user_groups (
  user_group_id    TINYINT(3) UNSIGNED  NOT NULL,
  user_group_name  VARCHAR(255)         NOT NULL,
  PRIMARY KEY pk_user_group_id (user_group_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_user_groups (user_group_id, user_group_name) VALUES
  (  0, 'Access Denied'),
  (254, 'Administrators'),
  (255, 'Root');

-- Users
CREATE TABLE IF NOT EXISTS sc_users (
  user_id         SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  user_group_id   TINYINT(3) UNSIGNED   NOT NULL  DEFAULT 0,
  language_id     CHAR(5)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  DEFAULT 'en-GB',
  person_id       INT(10) UNSIGNED      NULL  DEFAULT NULL,
  email_address   VARCHAR(255)          NOT NULL,
  password_reset  TIMESTAMP             NOT NULL  DEFAULT '1970-01-01 00:00:01',
  username        VARCHAR(255)          NOT NULL,
  password_salt   VARCHAR(255)          NOT NULL,
  hash_algo       VARCHAR(255)          NOT NULL,
  password_hash   VARCHAR(255)          NOT NULL,
  pin_code        VARCHAR(6)            NOT NULL  DEFAULT '0000',
  date_time_zone  VARCHAR(255)          NOT NULL  DEFAULT 'UTC'  COMMENT 'PHP DateTimeZone identifier',
  email_token     VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY pk_user_id (user_id),
  FOREIGN KEY fk_user_group_id (user_group_id) REFERENCES sc_user_groups (user_group_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY fk_person_id (person_id) REFERENCES sc_persons (person_id) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY uk_email_address (email_address),
  INDEX ix_username (username)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- User password archive
CREATE TABLE IF NOT EXISTS sc_users_password_history (
  user_id        SMALLINT(5)          UNSIGNED  NOT NULL,
  from_date      TIMESTAMP            NOT NULL  DEFAULT '1970-01-01 00:00:01',
  thru_date      TIMESTAMP            NOT NULL  DEFAULT '1970-01-01 00:00:01',
  checked_flag   TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  password_salt  VARCHAR(255)         NOT NULL,
  password_hash  VARCHAR(255)         NOT NULL,
  PRIMARY KEY pk_id (user_id, from_date),
  FOREIGN KEY fk_user_id (user_id) REFERENCES sc_users (user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Browsers and other user agents
CREATE TABLE IF NOT EXISTS sc_user_agents (
  user_agent_id    BINARY(20)  NOT NULL  COMMENT 'Binary SHA-1 hash',
  first_sighting   TIMESTAMP   NOT NULL  DEFAULT '1970-01-01 00:00:01',
  last_sighting    TIMESTAMP   NOT NULL  DEFAULT '1970-01-01 00:00:01',
  http_user_agent  TEXT        NOT NULL,
  PRIMARY KEY pk_user_agent_id (user_agent_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Successful and/or failed login attempts
CREATE TABLE IF NOT EXISTS sc_login_attempts (
  attempt_id      BIGINT UNSIGNED       NOT NULL  AUTO_INCREMENT,
  successful      TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  attempted       TIMESTAMP             NOT NULL  DEFAULT '1970-01-01 00:00:01',
  remote_address  VARCHAR(255)          NULL  DEFAULT NULL,
  username        VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY pk_attempt_id (attempt_id),
  INDEX ix_attempted (attempted DESC),
  INDEX ix_remote_address (remote_address)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- IP blacklist
CREATE TABLE IF NOT EXISTS sc_ip_blacklist (
  ip_address  VARCHAR(255)  NOT NULL,
  from_date   TIMESTAMP     NOT NULL  DEFAULT '1970-01-01 00:00:01',
  thru_date   TIMESTAMP     NULL  DEFAULT NULL,
  PRIMARY KEY pk_ip_address (ip_address),
  INDEX ix_from_date (from_date),
  INDEX ix_thru_date (thru_date)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Optional IP blacklist comments (without a foreign key to archive records)
CREATE TABLE IF NOT EXISTS sc_ip_blacklist_comments (
  ip_address     VARCHAR(255)  NOT NULL,
  date_modified  TIMESTAMP     NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  comments       VARCHAR(255)  NULL  DEFAULT NULL  COMMENT 'Reason, source or other internal memo',
  PRIMARY KEY pk_ip_blacklist_comment_id (ip_address, date_modified),
  INDEX ix_date_modified (date_modified DESC)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- IP whitelist for administrators and API consumers
CREATE TABLE IF NOT EXISTS sc_ip_whitelist (
  ip_address  VARCHAR(255)         NOT NULL,
  admin_flag  TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  api_flag    TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  from_date   TIMESTAMP            NOT NULL  DEFAULT '1970-01-01 00:00:01',
  thru_date   TIMESTAMP            NULL  DEFAULT NULL,
  PRIMARY KEY pk_ip_address (ip_address),
  INDEX ix_date_range (from_date, thru_date)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Robots exclusion robots.txt
CREATE TABLE IF NOT EXISTS sc_robots (
  robot_id    SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  user_agent  VARCHAR(255)          NOT NULL,
  PRIMARY KEY pk_robot_id (robot_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_robot_disallows (
  path_id   SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  robot_id  SMALLINT(5) UNSIGNED  NOT NULL,
  disallow  VARCHAR(255)          NOT NULL  DEFAULT '',
  PRIMARY KEY pk_path_id (path_id),
  FOREIGN KEY fk_robot_id (robot_id) REFERENCES sc_robots (robot_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_robots (robot_id, user_agent) VALUES
  (1, '*');

INSERT IGNORE INTO sc_robot_disallows (robot_id, disallow) VALUES
  (1, '/cgi-bin/');

-- Cronjobs
CREATE TABLE IF NOT EXISTS sc_cron_routes (
  route_id     BIGINT UNSIGNED  NOT NULL  AUTO_INCREMENT,
  description  VARCHAR(255)     NOT NULL,
  schedule     VARCHAR(255)     NOT NULL  DEFAULT '* * * * *',
  route        TEXT             NOT NULL,
  PRIMARY KEY pk_route_id (route_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_cron_events (
  route_id   BIGINT UNSIGNED  NOT NULL,
  scheduled  TIMESTAMP        NOT NULL  DEFAULT '1970-01-01 00:00:01',
  executed   TIMESTAMP        NULL  DEFAULT NULL,
  PRIMARY KEY pk_id (route_id, scheduled),
  FOREIGN KEY fk_route_id (route_id) REFERENCES sc_cron_routes (route_id) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX ix_executed (executed)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Currencies
CREATE TABLE IF NOT EXISTS sc_currencies (
  currency_id      SMALLINT(3) UNSIGNED  NOT NULL  COMMENT 'ISO 4217 currency number',
  currency_code    CHAR(3)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 4217 currency code',
  digits           SMALLINT(1) UNSIGNED  NOT NULL  DEFAULT 2,
  currency_symbol  VARCHAR(8)            NOT NULL  DEFAULT '¤',
  currency_name    VARCHAR(255)          NOT NULL  COMMENT 'Official ISO 4217 currency name',
  PRIMARY KEY pk_currency_id (currency_id),
  UNIQUE KEY uk_currency_code (currency_code)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_currencies
    (currency_code, currency_id, digits, currency_name)
  VALUES
    ('AED', 784, 2, 'United Arab Emirates dirham'),
    ('AFN', 971, 2, 'Afghan afghani'),
    ('ALL',   8, 2, 'Albanian lek'),
    ('AMD',  51, 2, 'Armenian dram'),
    ('ANG', 532, 2, 'Netherlands Antillean guilder'),
    ('AOA', 973, 2, 'Angolan kwanza'),
    ('ARS',  32, 2, 'Argentine peso'),
    ('AUD',  36, 2, 'Australian dollar'),
    ('AWG', 533, 2, 'Aruban florin'),
    ('AZN', 944, 2, 'Azerbaijani manat'),
    ('BAM', 977, 2, 'Bosnia and Herzegovina convertible mark'),
    ('BBD',  52, 2, 'Barbados dollar'),
    ('BDT',  50, 2, 'Bangladeshi taka'),
    ('BGN', 975, 2, 'Bulgarian lev'),
    ('BHD',  48, 3, 'Bahraini dinar'),
    ('BIF', 108, 0, 'Burundian franc'),
    ('BMD',  60, 2, 'Bermudian dollar'),
    ('BND',  96, 2, 'Brunei dollar'),
    ('BOB',  68, 2, 'Boliviano'),
    ('BRL', 986, 2, 'Brazilian real'),
    ('BSD',  44, 2, 'Bahamian dollar'),
    ('BTN',  64, 2, 'Bhutanese ngultrum'),
    ('BWP',  72, 2, 'Botswana pula'),
    ('BYR', 974, 0, 'Belarusian ruble'),
    ('BZD',  84, 2, 'Belize dollar'),
    ('CAD', 124, 2, 'Canadian dollar'),
    ('CDF', 976, 2, 'Congolese franc'),
    ('CHF', 756, 2, 'Swiss franc'),
    ('CLP', 152, 0, 'Chilean peso'),
    ('CNY', 156, 2, 'Chinese yuan'),
    ('COP', 170, 2, 'Colombian peso'),
    ('CRC', 188, 2, 'Costa Rican colon'),
    ('CUC', 931, 2, 'Cuban convertible peso'),
    ('CUP', 192, 2, 'Cuban peso'),
    ('CVE', 132, 0, 'Cape Verde escudo'),
    ('CZK', 203, 2, 'Czech koruna'),
    ('DJF', 262, 0, 'Djiboutian franc'),
    ('DKK', 208, 2, 'Danish krone'),
    ('DOP', 214, 2, 'Dominican peso'),
    ('DZD',  12, 2, 'Algerian dinar'),
    ('EGP', 818, 2, 'Egyptian pound'),
    ('ERN', 232, 2, 'Eritrean nakfa'),
    ('ETB', 230, 2, 'Ethiopian birr'),
    ('EUR', 978, 2, 'Euro'),
    ('FJD', 242, 2, 'Fiji dollar'),
    ('FKP', 238, 2, 'Falkland Islands pound'),
    ('GBP', 826, 2, 'Pound sterling'),
    ('GEL', 981, 2, 'Georgian lari'),
    ('GHS', 936, 2, 'Ghanaian cedi'),
    ('GIP', 292, 2, 'Gibraltar pound'),
    ('GMD', 270, 2, 'Gambian dalasi'),
    ('GNF', 324, 0, 'Guinean franc'),
    ('GTQ', 320, 2, 'Guatemalan quetzal'),
    ('GYD', 328, 2, 'Guyanese dollar'),
    ('HKD', 344, 2, 'Hong Kong dollar'),
    ('HNL', 340, 2, 'Honduran lempira'),
    ('HRK', 191, 2, 'Croatian kuna'),
    ('HTG', 332, 2, 'Haitian gourde'),
    ('HUF', 348, 2, 'Hungarian forint'),
    ('IDR', 360, 2, 'Indonesian rupiah'),
    ('ILS', 376, 2, 'Israeli new shekel'),
    ('INR', 356, 2, 'Indian rupee'),
    ('IQD', 368, 3, 'Iraqi dinar'),
    ('IRR', 364, 2, 'Iranian rial'),
    ('ISK', 352, 0, 'Icelandic króna'),
    ('JMD', 388, 2, 'Jamaican dollar'),
    ('JOD', 400, 3, 'Jordanian dinar'),
    ('JPY', 392, 0, 'Japanese yen'),
    ('KES', 404, 2, 'Kenyan shilling'),
    ('KGS', 417, 2, 'Kyrgyzstani som'),
    ('KHR', 116, 2, 'Cambodian riel'),
    ('KMF', 174, 0, 'Comoro franc'),
    ('KPW', 408, 2, 'North Korean won'),
    ('KRW', 410, 0, 'South Korean won'),
    ('KWD', 414, 3, 'Kuwaiti dinar'),
    ('KYD', 136, 2, 'Cayman Islands dollar'),
    ('KZT', 398, 2, 'Kazakhstani tenge'),
    ('LAK', 418, 2, 'Lao kip'),
    ('LBP', 422, 2, 'Lebanese pound'),
    ('LKR', 144, 2, 'Sri Lankan rupee'),
    ('LRD', 430, 2, 'Liberian dollar'),
    ('LSL', 426, 2, 'Lesotho loti'),
    ('LYD', 434, 3, 'Libyan dinar'),
    ('MAD', 504, 2, 'Moroccan dirham'),
    ('MDL', 498, 2, 'Moldovan leu'),
    ('MGA', 969, 1, 'Malagasy ariary'),
    ('MKD', 807, 2, 'Macedonian denar'),
    ('MMK', 104, 2, 'Myanmar kyat'),
    ('MNT', 496, 2, 'Mongolian tugrik'),
    ('MOP', 446, 2, 'Macanese pataca'),
    ('MRO', 478, 1, 'Mauritanian ouguiya'),
    ('MUR', 480, 2, 'Mauritian rupee'),
    ('MVR', 462, 2, 'Maldivian rufiyaa'),
    ('MWK', 454, 2, 'Malawian kwacha'),
    ('MXN', 484, 2, 'Mexican peso'),
    ('MYR', 458, 2, 'Malaysian ringgit'),
    ('MZN', 943, 2, 'Mozambican metical'),
    ('NAD', 516, 2, 'Namibian dollar'),
    ('NGN', 566, 2, 'Nigerian naira'),
    ('NIO', 558, 2, 'Nicaraguan córdoba'),
    ('NOK', 578, 2, 'Norwegian krone'),
    ('NPR', 524, 2, 'Nepalese rupee'),
    ('NZD', 554, 2, 'New Zealand dollar'),
    ('OMR', 512, 3, 'Omani rial'),
    ('PAB', 590, 2, 'Panamanian balboa'),
    ('PEN', 604, 2, 'Peruvian nuevo sol'),
    ('PGK', 598, 2, 'Papua New Guinean kina'),
    ('PHP', 608, 2, 'Philippine peso'),
    ('PKR', 586, 2, 'Pakistani rupee'),
    ('PLN', 985, 2, 'Polish złoty'),
    ('PYG', 600, 0, 'Paraguayan guaraní'),
    ('QAR', 634, 2, 'Qatari riyal'),
    ('RON', 946, 2, 'Romanian new leu'),
    ('RSD', 941, 2, 'Serbian dinar'),
    ('RUB', 643, 2, 'Russian ruble'),
    ('RWF', 646, 0, 'Rwandan franc'),
    ('SAR', 682, 2, 'Saudi riyal'),
    ('SBD',  90, 2, 'Solomon Islands dollar'),
    ('SCR', 690, 2, 'Seychelles rupee'),
    ('SDG', 938, 2, 'Sudanese pound'),
    ('SEK', 752, 2, 'Swedish krona/kronor'),
    ('SGD', 702, 2, 'Singapore dollar'),
    ('SHP', 654, 2, 'Saint Helena pound'),
    ('SLL', 694, 2, 'Sierra Leonean leone'),
    ('SOS', 706, 2, 'Somali shilling'),
    ('SRD', 968, 2, 'Surinamese dollar'),
    ('SSP', 728, 2, 'South Sudanese pound'),
    ('STD', 678, 2, 'São Tomé and Príncipe dobra'),
    ('SYP', 760, 2, 'Syrian pound'),
    ('SZL', 748, 2, 'Swazi lilangeni'),
    ('THB', 764, 2, 'Thai baht'),
    ('TJS', 972, 2, 'Tajikistani somoni'),
    ('TMT', 934, 2, 'Turkmenistani manat'),
    ('TND', 788, 3, 'Tunisian dinar'),
    ('TOP', 776, 2, 'Tongan paʻanga'),
    ('TRY', 949, 2, 'Turkish lira'),
    ('TTD', 780, 2, 'Trinidad and Tobago dollar'),
    ('TWD', 901, 2, 'New Taiwan dollar'),
    ('TZS', 834, 2, 'Tanzanian shilling'),
    ('UAH', 980, 2, 'Ukrainian hryvnia'),
    ('UGX', 800, 0, 'Ugandan shilling'),
    ('USD', 840, 2, 'United States dollar'),
    ('UYU', 858, 2, 'Uruguayan peso'),
    ('UZS', 860, 2, 'Uzbekistan som'),
    ('VEF', 937, 2, 'Venezuelan bolívar'),
    ('VND', 704, 0, 'Vietnamese dong'),
    ('VUV', 548, 0, 'Vanuatu vatu'),
    ('WST', 882, 2, 'Samoan tala'),
    ('XAF', 950, 0, 'CFA franc BEAC'),
    ('XCD', 951, 2, 'East Caribbean dollar'),
    ('XOF', 952, 0, 'CFA franc BCEAO'),
    ('XPF', 953, 0, 'CFP franc (franc Pacifique)'),
    ('XTS', 963, 2, 'Code reserved for testing purposes'),
    ('XXX', 999, 0, 'No currency'),
    ('YER', 886, 2, 'Yemeni rial'),
    ('ZAR', 710, 2, 'South African rand'),
    ('ZMW', 967, 2, 'Zambian kwacha'),
    ('ZWL', 932, 2, 'Zimbabwean dollar');

-- Dollar
UPDATE sc_currencies SET currency_symbol = '$'
  WHERE currency_code IN ('ARS','AUD','BSD','BBD','BMD','BND','CAD','CLP','COP','FJD','GYD','HKD','KYD','LRD','MXN','NAD','NZD','SBD','SGD','SHP','SRD','SVC','TVD','USD','XCD')
  AND currency_symbol = '¤';

-- Guilder or florin
UPDATE sc_currencies SET currency_symbol = 'ƒ'
  WHERE currency_code IN ('ANG','AWG')
  AND currency_symbol = '¤';

-- Krona or krone
UPDATE sc_currencies SET currency_symbol = 'kr'
  WHERE currency_code IN ('DKK','EEK','ISK','NOK','SEK')
  AND currency_symbol = '¤';

-- Pound
UPDATE sc_currencies SET currency_symbol = '£'
  WHERE currency_code IN ('EGP','FKP','GBP','GGP','GIP','IMP','JEP','LBP','SYP')
  AND currency_symbol = '¤';

-- Rial or riyal
UPDATE sc_currencies SET currency_symbol = '﷼'
  WHERE currency_code IN ('IRR','OMR','QAR','SAR','YER')
  AND currency_symbol = '¤';

-- Rupee
UPDATE sc_currencies SET currency_symbol = '₨'
  WHERE currency_code IN ('LKR','MUR','NPR','PKR','SCR')
  AND currency_symbol = '¤';

-- Other currency symbols
UPDATE sc_currencies SET currency_symbol = 'د.إ' WHERE currency_code = 'AED' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Lek' WHERE currency_code = 'ALL' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '؋' WHERE currency_code = 'AFN' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '֏' WHERE currency_code = 'AMD' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Kz' WHERE currency_code = 'AOA' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'ман' WHERE currency_code = 'AZN' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'KM' WHERE currency_code = 'BAM' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '৳' WHERE currency_code = 'BDT' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'лв' WHERE currency_code = 'BGN' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '.د.ب' WHERE currency_code = 'BHD' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'FBu' WHERE currency_code = 'BIF' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '$b' WHERE currency_code = 'BOB' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Nu.' WHERE currency_code = 'BTN' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'P' WHERE currency_code = 'BWP' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'p.' WHERE currency_code = 'BYR' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'BZ$' WHERE currency_code = 'BZD' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'R$' WHERE currency_code = 'BRL' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'FC' WHERE currency_code = 'CDF' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'CHF' WHERE currency_code = 'CHF' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '¥' WHERE currency_code = 'CNY' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₱' WHERE currency_code = 'CUP' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₡' WHERE currency_code = 'CRC' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Kč' WHERE currency_code = 'CZK' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'RD$' WHERE currency_code = 'DOP' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '€' WHERE currency_code = 'EUR' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '¢' WHERE currency_code = 'GHC' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Q' WHERE currency_code = 'GTQ' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'L' WHERE currency_code = 'HNL' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'kn' WHERE currency_code = 'HRK' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Ft' WHERE currency_code = 'HUF' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Rp' WHERE currency_code = 'IDR' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₪' WHERE currency_code = 'ILS' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₹' WHERE currency_code = 'INR' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'J$' WHERE currency_code = 'JMD' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '¥' WHERE currency_code = 'JPY' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'лв' WHERE currency_code = 'KGS' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '៛' WHERE currency_code = 'KHR' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₩' WHERE currency_code = 'KPW' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₩' WHERE currency_code = 'KRW' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'лв' WHERE currency_code = 'KZT' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₭' WHERE currency_code = 'LAK' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Ls' WHERE currency_code = 'LVL' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Lt' WHERE currency_code = 'LTL' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'ден' WHERE currency_code = 'MKD' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₮' WHERE currency_code = 'MNT' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'RM' WHERE currency_code = 'MYR' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'MT' WHERE currency_code = 'MZN' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'C$' WHERE currency_code = 'NIO' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₦' WHERE currency_code = 'NGN' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'B/.' WHERE currency_code = 'PAB' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Gs' WHERE currency_code = 'PYG' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'S/.' WHERE currency_code = 'PEN' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₱' WHERE currency_code = 'PHP' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'zł' WHERE currency_code = 'PLN' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'lei' WHERE currency_code = 'RON' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'руб' WHERE currency_code = 'RUB' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Дин.' WHERE currency_code = 'RSD' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'S' WHERE currency_code = 'SOS' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '฿' WHERE currency_code = 'THB' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₤' WHERE currency_code = 'TRL' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₺' WHERE currency_code = 'TRY' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'TT$' WHERE currency_code = 'TTD' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'NT$' WHERE currency_code = 'TWD' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₴' WHERE currency_code = 'UAH' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '$U' WHERE currency_code = 'UYU' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'лв' WHERE currency_code = 'UZS' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Bs' WHERE currency_code = 'VEF' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = '₫' WHERE currency_code = 'VND' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'R' WHERE currency_code = 'ZAR' AND currency_symbol = '¤';
UPDATE sc_currencies SET currency_symbol = 'Z$' WHERE currency_code = 'ZWD' AND currency_symbol = '¤';

-- Translation Memory (TM)
CREATE TABLE IF NOT EXISTS sc_translation_memory (
  translation_id   VARCHAR(128)          CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  language_id      CHAR(5)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  DEFAULT 'en-GB',
  admin_only_flag  TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  date_modified    TIMESTAMP             NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  translation      TEXT                  NULL,
  PRIMARY KEY pk_id (translation_id, language_id),
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

-- Countries and ISO country codes
CREATE TABLE IF NOT EXISTS sc_countries (
  country_id            SMALLINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  status                TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 1,
  postal_code_required  TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  subdivision_required  TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  iso_alpha_two         CHAR(2)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 3166-1 alpha-2 code',
  iso_alpha_three       CHAR(3)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 3166-1 alpha-3 code',
  iso_number            SMALLINT(3) UNSIGNED  NOT NULL  COMMENT 'ISO 3166-1 numeric code',
  global_country_name   VARCHAR(128)          NOT NULL,
  PRIMARY KEY pk_country_id (country_id),
  UNIQUE KEY uk_iso_alpha_two (iso_alpha_two),
  UNIQUE KEY uk_iso_alpha_three (iso_alpha_three),
  UNIQUE KEY uk_iso_number (iso_number)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Localized country names
CREATE TABLE IF NOT EXISTS sc_country_names (
  country_id          SMALLINT(3) UNSIGNED  NOT NULL,
  language_id         CHAR(5)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  local_country_name  VARCHAR(128)          NOT NULL,
  PRIMARY KEY pk_id (country_id, language_id),
  FOREIGN KEY fk_country_id (country_id) REFERENCES sc_countries (country_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

-- Country states, provinces, regions, and other subdivisions
CREATE TABLE IF NOT EXISTS sc_country_subdivisions (
  iso_alpha_two     CHAR(2)       CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 3166-1',
  iso_suffix        VARCHAR(3)    CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 3166-2 add-on',
  subdivision_name  VARCHAR(255)  NOT NULL,
  PRIMARY KEY pk_id (iso_alpha_two, iso_suffix),
  FOREIGN KEY fk_iso_alpha_two (iso_alpha_two) REFERENCES sc_countries (iso_alpha_two) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX ix_subdivision_name (subdivision_name)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

-- ISO country data
INSERT IGNORE INTO sc_countries (iso_number, global_country_name, iso_alpha_two, iso_alpha_three, postal_code_required, status) VALUES
  (  4, 'Afghanistan', 'AF', 'AFG',  0, 1),
  (248, 'Åland Islands', 'AX', 'ALA',  0, 1),
  (  8, 'Albania', 'AL', 'ALB',  0, 1),
  ( 12, 'Algeria', 'DZ', 'DZA',  0, 1),
  ( 16, 'American Samoa', 'AS', 'ASM',  0, 1),
  ( 20, 'Andorra', 'AD', 'AND',  0, 1),
  ( 24, 'Angola', 'AO', 'AGO',  0, 1),
  (660, 'Anguilla', 'AI', 'AIA',  0, 1),
  ( 10, 'Antarctica', 'AQ', 'ATA',  0, 1),
  ( 28, 'Antigua and Barbuda', 'AG', 'ATG',  0, 1),
  ( 32, 'Argentina', 'AR', 'ARG',  0, 1),
  ( 51, 'Armenia', 'AM', 'ARM',  0, 1),
  (533, 'Aruba', 'AW', 'ABW',  0, 1),
  ( 36, 'Australia', 'AU', 'AUS',  0, 1),
  ( 40, 'Austria', 'AT', 'AUT',  0, 1),
  ( 31, 'Azerbaijan', 'AZ', 'AZE',  0, 1),
  ( 44, 'Bahamas', 'BS', 'BHS',  0, 1),
  ( 48, 'Bahrain', 'BH', 'BHR',  0, 1),
  ( 50, 'Bangladesh', 'BD', 'BGD',  0, 1),
  ( 52, 'Barbados', 'BB', 'BRB',  0, 1),
  (112, 'Belarus', 'BY', 'BLR',  0, 1),
  ( 56, 'Belgium', 'BE', 'BEL', 0, 1),
  ( 84, 'Belize', 'BZ', 'BLZ',  0, 1),
  (204, 'Benin', 'BJ', 'BEN',  0, 1),
  ( 60, 'Bermuda', 'BM', 'BMU',  0, 1),
  ( 64, 'Bhutan', 'BT', 'BTN',  0, 1),
  ( 68, 'Bolivia', 'BO', 'BOL',  0, 1),
  (535, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES',  0, 1),
  ( 70, 'Bosnia and Herzegovina', 'BA', 'BIH',  0, 1),
  ( 72, 'Botswana', 'BW', 'BWA',  0, 1),
  ( 74, 'Bouvet Island', 'BV', 'BVT',  0, 1),
  ( 76, 'Brazil', 'BR', 'BRA',  0, 1),
  ( 86, 'British Indian Ocean Territory', 'IO', 'IOT',  0, 1),
  ( 96, 'Brunei Darussalam', 'BN', 'BRN',  0, 1),
  (100, 'Bulgaria', 'BG', 'BGR',  0, 1),
  (854, 'Burkina Faso', 'BF', 'BFA',  0, 1),
  (108, 'Burundi', 'BI', 'BDI',  0, 1),
  (116, 'Cambodia', 'KH', 'KHM',  0, 1),
  (120, 'Cameroon', 'CM', 'CMR',  0, 1),
  (124, 'Canada', 'CA', 'CAN',  0, 1),
  (132, 'Cabo Verde', 'CV', 'CPV',  0, 1),
  (136, 'Cayman Islands', 'KY', 'CYM',  0, 1),
  (140, 'Central African Republic', 'CF', 'CAF',  0, 1),
  (148, 'Chad', 'TD', 'TCD',  0, 1),
  (152, 'Chile', 'CL', 'CHL',  0, 1),
  (156, 'China', 'CN', 'CHN',  0, 1),
  (162, 'Christmas Island', 'CX', 'CXR',  0, 1),
  (166, 'Cocos (Keeling) Islands', 'CC', 'CCK',  0, 1),
  (170, 'Colombia', 'CO', 'COL',  0, 1),
  (174, 'Comoros', 'KM', 'COM',  0, 1),
  (178, 'Congo', 'CG', 'COG',  0, 1),
  (180, 'Congo, Democratic Republic of the', 'CD', 'COD',  0, 1),
  (184, 'Cook Islands', 'CK', 'COK',  0, 1),
  (188, 'Costa Rica', 'CR', 'CRI',  0, 1),
  (384, 'Côte D’Ivoire', 'CI', 'CIV',  0, 1),
  (191, 'Croatia', 'HR', 'HRV',  0, 1),
  (192, 'Cuba', 'CU', 'CUB',  0, 1),
  (531, 'Curaçao', 'CW', 'CUW',  0, 1),
  (196, 'Cyprus', 'CY', 'CYP',  0, 1),
  (203, 'Czech Republic', 'CZ', 'CZE',  0, 1),
  (208, 'Denmark', 'DK', 'DNK',  0, 1),
  (262, 'Djibouti', 'DJ', 'DJI',  0, 1),
  (212, 'Dominica', 'DM', 'DMA',  0, 1),
  (214, 'Dominican Republic', 'DO', 'DOM',  0, 1),
  (218, 'Ecuador', 'EC', 'ECU',  0, 1),
  (818, 'Egypt', 'EG', 'EGY',  0, 1),
  (222, 'El Salvador', 'SV', 'SLV',  0, 1),
  (226, 'Equatorial Guinea', 'GQ', 'GNQ',  0, 1),
  (232, 'Eritrea', 'ER', 'ERI',  0, 1),
  (233, 'Estonia', 'EE', 'EST',  0, 1),
  (231, 'Ethiopia', 'ET', 'ETH',  0, 1),
  (238, 'Falkland Islands (Malvinas)', 'FK', 'FLK',  0, 1),
  (234, 'Faroe Islands', 'FO', 'FRO',  0, 1),
  (242, 'Fiji', 'FJ', 'FJI',  0, 1),
  (246, 'Finland', 'FI', 'FIN',  0, 1),
  (250, 'France', 'FR', 'FRA', 1, 1),
  (254, 'French Guiana', 'GF', 'GUF',  0, 1),
  (258, 'French Polynesia', 'PF', 'PYF',  0, 1),
  (260, 'French Southern Territories', 'TF', 'ATF',  0, 1),
  (266, 'Gabon', 'GA', 'GAB',  0, 1),
  (270, 'Gambia', 'GM', 'GMB',  0, 1),
  (268, 'Georgia', 'GE', 'GEO',  0, 1),
  (276, 'Germany', 'DE', 'DEU', 1, 1),
  (288, 'Ghana', 'GH', 'GHA',  0, 1),
  (292, 'Gibraltar', 'GI', 'GIB',  0, 1),
  (300, 'Greece', 'GR', 'GRC',  0, 1),
  (304, 'Greenland', 'GL', 'GRL',  0, 1),
  (308, 'Grenada', 'GD', 'GRD',  0, 1),
  (312, 'Guadeloupe', 'GP', 'GLP',  0, 1),
  (316, 'Guam', 'GU', 'GUM',  0, 1),
  (320, 'Guatemala', 'GT', 'GTM',  0, 1),
  (831, 'Guernsey', 'GG', 'GGY',  0, 1),
  (324, 'Guinea', 'GN', 'GIN',  0, 1),
  (624, 'Guinea-Bissau', 'GW', 'GNB',  0, 1),
  (328, 'Guyana', 'GY', 'GUY',  0, 1),
  (332, 'Haiti', 'HT', 'HTI',  0, 1),
  (334, 'Heard Island and McDonald Islands', 'HM', 'HMD',  0, 1),
  (336, 'Holy See', 'VA', 'VAT',  0, 1),
  (340, 'Honduras', 'HN', 'HND',  0, 1),
  (344, 'Hong Kong', 'HK', 'HKG',  0, 1),
  (348, 'Hungary', 'HU', 'HUN',  0, 1),
  (352, 'Iceland', 'IS', 'ISL',  0, 1),
  (356, 'India', 'IN', 'IND',  0, 1),
  (360, 'Indonesia', 'ID', 'IDN',  0, 1),
  (364, 'Iran (Islamic Republic of)', 'IR', 'IRN',  0, 1),
  (368, 'Iraq', 'IQ', 'IRQ',  0, 1),
  (372, 'Ireland', 'IE', 'IRL',  0, 1),
  (833, 'Isle of Man', 'IM', 'IMN',  0, 1),
  (376, 'Israel', 'IL', 'ISR',  0, 1),
  (380, 'Italy', 'IT', 'ITA',  0, 1),
  (388, 'Jamaica', 'JM', 'JAM',  0, 1),
  (392, 'Japan', 'JP', 'JPN',  0, 1),
  (832, 'Jersey', 'JE', 'JEY',  0, 1),
  (400, 'Jordan', 'JO', 'JOR',  0, 1),
  (398, 'Kazakhstan', 'KZ', 'KAZ',  0, 1),
  (404, 'Kenya', 'KE', 'KEN',  0, 1),
  (296, 'Kiribati', 'KI', 'KIR',  0, 1),
  (408, 'Korea (Democratic People’s Republic of)', 'KP', 'PRK',  0, 1),
  (410, 'Korea (Republic of)', 'KR', 'KOR',  0, 1),
  (414, 'Kuwait', 'KW', 'KWT',  0, 1),
  (417, 'Kyrgyzstan', 'KG', 'KGZ',  0, 1),
  (418, 'Lao People’s Democratic Republic', 'LA', 'LAO',  0, 1),
  (428, 'Latvia', 'LV', 'LVA',  0, 1),
  (422, 'Lebanon', 'LB', 'LBN',  0, 1),
  (426, 'Lesotho', 'LS', 'LSO',  0, 1),
  (430, 'Liberia', 'LR', 'LBR',  0, 1),
  (434, 'Libya', 'LY', 'LBY',  0, 1),
  (438, 'Liechtenstein', 'LI', 'LIE',  0, 1),
  (440, 'Lithuania', 'LT', 'LTU',  0, 1),
  (442, 'Luxembourg', 'LU', 'LUX',  0, 1),
  (446, 'Macao', 'MO', 'MAC',  0, 1),
  (807, 'Macedonia', 'MK', 'MKD',  0, 1),
  (450, 'Madagascar', 'MG', 'MDG',  0, 1),
  (454, 'Malawi', 'MW', 'MWI',  0, 1),
  (458, 'Malaysia', 'MY', 'MYS',  0, 1),
  (462, 'Maldives', 'MV', 'MDV',  0, 1),
  (466, 'Mali', 'ML', 'MLI',  0, 1),
  (470, 'Malta', 'MT', 'MLT',  0, 1),
  (584, 'Marshall Islands', 'MH', 'MHL',  0, 1),
  (474, 'Martinique', 'MQ', 'MTQ',  0, 1),
  (478, 'Mauritania', 'MR', 'MRT',  0, 1),
  (480, 'Mauritius', 'MU', 'MUS',  0, 1),
  (175, 'Mayotte', 'YT', 'MYT',  0, 1),
  (484, 'Mexico', 'MX', 'MEX',  0, 1),
  (583, 'Micronesia', 'FM', 'FSM',  0, 1),
  (498, 'Moldova', 'MD', 'MDA',  0, 1),
  (492, 'Monaco', 'MC', 'MCO',  0, 1),
  (496, 'Mongolia', 'MN', 'MNG',  0, 1),
  (499, 'Montenegro', 'ME', 'MNE',  0, 1),
  (500, 'Montserrat', 'MS', 'MSR',  0, 1),
  (504, 'Morocco', 'MA', 'MAR',  0, 1),
  (508, 'Mozambique', 'MZ', 'MOZ',  0, 1),
  (104, 'Myanmar', 'MM', 'MMR',  0, 1),
  (516, 'Namibia', 'NA', 'NAM',  0, 1),
  (520, 'Nauru', 'NR', 'NRU',  0, 1),
  (524, 'Nepal', 'NP', 'NPL',  0, 1),
  (528, 'Netherlands', 'NL', 'NLD',  0, 1),
  (540, 'New Caledonia', 'NC', 'NCL',  0, 1),
  (554, 'New Zealand', 'NZ', 'NZL',  0, 1),
  (558, 'Nicaragua', 'NI', 'NIC',  0, 1),
  (562, 'Niger', 'NE', 'NER',  0, 1),
  (566, 'Nigeria', 'NG', 'NGA',  0, 1),
  (570, 'Niue', 'NU', 'NIU',  0, 1),
  (574, 'Norfolk Island', 'NF', 'NFK',  0, 1),
  (580, 'Northern Mariana Islands', 'MP', 'MNP',  0, 1),
  (578, 'Norway', 'NO', 'NOR',  0, 1),
  (512, 'Oman', 'OM', 'OMN',  0, 1),
  (586, 'Pakistan', 'PK', 'PAK',  0, 1),
  (585, 'Palau', 'PW', 'PLW',  0, 1),
  (275, 'Palestine', 'PS', 'PSE',  0, 1),
  (591, 'Panama', 'PA', 'PAN',  0, 1),
  (598, 'Papua New Guinea', 'PG', 'PNG',  0, 1),
  (600, 'Paraguay', 'PY', 'PRY',  0, 1),
  (604, 'Peru', 'PE', 'PER',  0, 1),
  (608, 'Philippines', 'PH', 'PHL',  0, 1),
  (612, 'Pitcairn', 'PN', 'PCN',  0, 1),
  (616, 'Poland', 'PL', 'POL',  0, 1),
  (620, 'Portugal', 'PT', 'PRT',  0, 1),
  (630, 'Puerto Rico', 'PR', 'PRI',  0, 1),
  (634, 'Qatar', 'QA', 'QAT',  0, 1),
  (638, 'Reunion', 'RE', 'REU',  0, 1),
  (642, 'Romania', 'RO', 'ROM',  0, 1),
  (643, 'Russian Federation', 'RU', 'RUS',  0, 1),
  (646, 'Rwanda', 'RW', 'RWA',  0, 1),
  (652, 'Saint Barthélemy', 'BL', 'BLM',  0, 1),
  (654, 'Saint Helena, Ascension and Tristan da Cunha', 'SH', 'SHN',  0, 1),
  (659, 'Saint Kitts and Nevis', 'KN', 'KNA',  0, 1),
  (662, 'Saint Lucia', 'LC', 'LCA',  0, 1),
  (663, 'Saint Martin', 'MF', 'MAF',  0, 1),
  (666, 'Saint Pierre and Miquelon', 'PM', 'SPM',  0, 1),
  (670, 'Saint Vincent and the Grenadines', 'VC', 'VCT',  0, 1),
  (882, 'Samoa', 'WS', 'WSM',  0, 1),
  (674, 'San Marino', 'SM', 'SMR',  0, 1),
  (678, 'Sao Tome and Principe', 'ST', 'STP',  0, 1),
  (682, 'Saudi Arabia', 'SA', 'SAU',  0, 1),
  (686, 'Senegal', 'SN', 'SEN',  0, 1),
  (688, 'Serbia', 'RS', 'SRB',  0, 1),
  (690, 'Seychelles', 'SC', 'SYC',  0, 1),
  (694, 'Sierra Leone', 'SL', 'SLE',  0, 1),
  (702, 'Singapore', 'SG', 'SGP',  0, 1),
  (534, 'Sint Maarten', 'SX', 'SXM',  0, 1),
  (703, 'Slovakia', 'SK', 'SVK', 0, 1),
  (705, 'Slovenia', 'SI', 'SVN',  0, 1),
  ( 90, 'Solomon Islands', 'SB', 'SLB',  0, 1),
  (706, 'Somalia', 'SO', 'SOM',  0, 1),
  (710, 'South Africa', 'ZA', 'ZAF',  0, 1),
  (239, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS',  0, 1),
  (728, 'South Sudan', 'SS', 'SSD',  0, 1),
  (724, 'Spain', 'ES', 'ESP',  0, 1),
  (144, 'Sri Lanka', 'LK', 'LKA',  0, 1),
  (729, 'Sudan', 'SD', 'SDN',  0, 1),
  (740, 'Suriname', 'SR', 'SUR',  0, 1),
  (744, 'Svalbard and Jan Mayen', 'SJ', 'SJM',  0, 1),
  (748, 'Swaziland', 'SZ', 'SWZ',  0, 1),
  (752, 'Sweden', 'SE', 'SWE', 1, 1),
  (756, 'Switzerland', 'CH', 'CHE',  0, 1),
  (760, 'Syrian Arab Republic', 'SY', 'SYR',  0, 1),
  (158, 'Taiwan', 'TW', 'TWN',  0, 1),
  (762, 'Tajikistan', 'TJ', 'TJK',  0, 1),
  (834, 'Tanzania', 'TZ', 'TZA',  0, 1),
  (764, 'Thailand', 'TH', 'THA',  0, 1),
  (626, 'Timor-Leste', 'TL', 'TLS',  0, 1),
  (768, 'Togo', 'TG', 'TGO',  0, 1),
  (772, 'Tokelau', 'TK', 'TKL',  0, 1),
  (776, 'Tonga', 'TO', 'TON',  0, 1),
  (780, 'Trinidad and Tobago', 'TT', 'TTO',  0, 1),
  (788, 'Tunisia', 'TN', 'TUN',  0, 1),
  (792, 'Turkey', 'TR', 'TUR',  0, 1),
  (795, 'Turkmenistan', 'TM', 'TKM',  0, 1),
  (796, 'Turks and Caicos Islands', 'TC', 'TCA',  0, 1),
  (798, 'Tuvalu', 'TV', 'TUV',  0, 1),
  (800, 'Uganda', 'UG', 'UGA',  0, 1),
  (804, 'Ukraine', 'UA', 'UKR',  0, 1),
  (784, 'United Arab Emirates', 'AE', 'ARE',  0, 1),
  (826, 'United Kingdom', 'GB', 'GBR', 1, 1),
  (840, 'United States of America', 'US', 'USA', 0, 1),
  (581, 'United States Minor Outlying Islands', 'UM', 'UMI',  0, 1),
  (858, 'Uruguay', 'UY', 'URY',  0, 1),
  (860, 'Uzbekistan', 'UZ', 'UZB',  0, 1),
  (548, 'Vanuatu', 'VU', 'VUT',  0, 1),
  (862, 'Venezuela', 'VE', 'VEN',  0, 1),
  (704, 'Viet Nam', 'VN', 'VNM',  0, 1),
  ( 92, 'Virgin Islands (British)', 'VG', 'VGB',  0, 1),
  (850, 'Virgin Islands (U.S.)', 'VI', 'VIR',  0, 1),
  (876, 'Wallis and Futuna', 'WF', 'WLF',  0, 1),
  (732, 'Western Sahara', 'EH', 'ESH',  0, 1),
  (887, 'Yemen', 'YE', 'YEM',  0, 1),
  (894, 'Zambia', 'ZM', 'ZMB',  0, 1),
  (716, 'Zimbabwe', 'ZW', 'ZWE',  0, 1);

--
-- ISO 3166-2:US
--
-- @see https://en.wikipedia.org/wiki/ISO_3166-2:US
-- @see https://www.iso.org/obp/ui/#iso:code:3166:US
--
INSERT IGNORE INTO sc_country_subdivisions VALUES
  ('US', 'AL', 'Alabama'),
  ('US', 'AK', 'Alaska'),
  ('US', 'AZ', 'Arizona'),
  ('US', 'AR', 'Arkansas'),
  ('US', 'CA', 'California'),
  ('US', 'CO', 'Colorado'),
  ('US', 'CT', 'Connecticut'),
  ('US', 'DE', 'Delaware'),
  ('US', 'DC', 'District of Columbia'),
  ('US', 'FL', 'Florida'),
  ('US', 'GA', 'Georgia'),
  ('US', 'HI', 'Hawaii'),
  ('US', 'ID', 'Idaho'),
  ('US', 'IL', 'Illinois'),
  ('US', 'IN', 'Indiana'),
  ('US', 'IA', 'Iowa'),
  ('US', 'KS', 'Kansas'),
  ('US', 'KY', 'Kentucky'),
  ('US', 'LA', 'Louisiana'),
  ('US', 'ME', 'Maine'),
  ('US', 'MD', 'Maryland'),
  ('US', 'MA', 'Massachusetts'),
  ('US', 'MI', 'Michigan'),
  ('US', 'MN', 'Minnesota'),
  ('US', 'MS', 'Mississippi'),
  ('US', 'MO', 'Missouri'),
  ('US', 'MT', 'Montana'),
  ('US', 'NE', 'Nebraska'),
  ('US', 'NV', 'Nevada'),
  ('US', 'NH', 'New Hampshire'),
  ('US', 'NJ', 'New Jersey'),
  ('US', 'NM', 'New Mexico'),
  ('US', 'NY', 'New York'),
  ('US', 'NC', 'North Carolina'),
  ('US', 'ND', 'North Dakota'),
  ('US', 'OH', 'Ohio'),
  ('US', 'OK', 'Oklahoma'),
  ('US', 'OR', 'Oregon'),
  ('US', 'PA', 'Pennsylvania'),
  ('US', 'RI', 'Rhode Island'),
  ('US', 'SC', 'South Carolina'),
  ('US', 'SD', 'South Dakota'),
  ('US', 'TN', 'Tennessee'),
  ('US', 'TX', 'Texas'),
  ('US', 'UT', 'Utah'),
  ('US', 'VT', 'Vermont'),
  ('US', 'VA', 'Virginia'),
  ('US', 'WA', 'Washington'),
  ('US', 'WV', 'West Virginia'),
  ('US', 'WI', 'Wisconsin'),
  ('US', 'WY', 'Wyoming');

UPDATE sc_countries SET subdivision_required = 1 WHERE iso_alpha_two = 'US';

-- Stores
CREATE TABLE IF NOT EXISTS sc_stores (
  store_id    TINYINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  ssl_mode    TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  store_name  VARCHAR(64)          NOT NULL,
  PRIMARY KEY pk_store_id (store_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Store hosts
CREATE TABLE IF NOT EXISTS sc_store_hosts (
  host_id        SMALLINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  store_id       TINYINT(3) UNSIGNED   NOT NULL,
  redirect_flag  TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  host_ip        INT(10) UNSIGNED      NULL  DEFAULT NULL,
  host_name      VARCHAR(255)          NULL  DEFAULT NULL,
  redirect_to    VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY pk_host_id (host_id),
  FOREIGN KEY fk_store_id (store_id) REFERENCES sc_stores (store_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Store languages
CREATE TABLE IF NOT EXISTS sc_store_languages (
  store_id      TINYINT(3) UNSIGNED  NOT NULL,
  language_id   CHAR(5)              CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  DEFAULT 'en-GB',
  default_flag  TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  PRIMARY KEY pk_store_language_id (store_id, language_id),
  FOREIGN KEY fk_store_id (store_id) REFERENCES sc_stores (store_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Customer groups
CREATE TABLE IF NOT EXISTS sc_customer_groups (
  customer_group_id    TINYINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  customer_group_name  VARCHAR(255)         NOT NULL,
  PRIMARY KEY pk_customer_group_id (customer_group_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_customer_groups (customer_group_id, customer_group_name) VALUES
  (1, 'Default customer group');

-- Customers
CREATE TABLE IF NOT EXISTS sc_customers (
  customer_id        INT(10) UNSIGNED     NOT NULL  AUTO_INCREMENT,
  customer_group_id  TINYINT(3) UNSIGNED  NOT NULL  DEFAULT 1,
  store_id           TINYINT(3) UNSIGNED  NOT NULL,
  date_created       TIMESTAMP            NOT NULL  DEFAULT '1970-01-01 00:00:01',
  date_modified      TIMESTAMP            NULL  DEFAULT NULL,
  date_deleted       TIMESTAMP            NULL  DEFAULT NULL,
  PRIMARY KEY pk_customer_id (customer_id),
  FOREIGN KEY fk_customer_group_id (customer_group_id) REFERENCES sc_customer_groups (customer_group_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  FOREIGN KEY fk_store_id (store_id) REFERENCES sc_stores (store_id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Personal customer data
CREATE TABLE IF NOT EXISTS sc_customer_persons (
  customer_id  INT(10) UNSIGNED  NOT NULL,
  person_id    INT(10) UNSIGNED  NOT NULL,
  PRIMARY KEY pk_id (customer_id, person_id),
  FOREIGN KEY fk_customer_id (customer_id) REFERENCES sc_customers (customer_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_person_id (person_id) REFERENCES sc_persons (person_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Customer accounts
CREATE TABLE IF NOT EXISTS sc_customer_accounts (
  account_id     INT(10) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  customer_id    INT(10) UNSIGNED  NOT NULL,
  email_address  VARCHAR(255)      NOT NULL,
  date_created   TIMESTAMP         NOT NULL  DEFAULT '1970-01-01 00:00:01',
  date_modified  TIMESTAMP         NULL  DEFAULT NULL,
  password_salt  VARCHAR(255)      NOT NULL,
  password_hash  VARCHAR(255)      NOT NULL,
  reset_token    CHAR(16)          CHARACTER SET ascii  COLLATE ascii_bin  NULL  DEFAULT NULL,
  PRIMARY KEY pk_account_id (account_id),
  FOREIGN KEY fk_customer_id (customer_id) REFERENCES sc_customers (customer_id) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX ix_email_address (email_address)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Customer and shipping addresses
CREATE TABLE IF NOT EXISTS sc_addresses (
  address_id              INT(10) UNSIGNED      NOT NULL  AUTO_INCREMENT,
  country_id              SMALLINT(3) UNSIGNED  NOT NULL,
  postal_code             VARCHAR(16)           NOT NULL  DEFAULT '',
  global_location_number  CHAR(13)              NULL  DEFAULT NULL  COMMENT 'GLN',
  date_created            TIMESTAMP             NOT NULL  DEFAULT '1970-01-01 00:00:01',
  date_modified           TIMESTAMP             NULL  DEFAULT NULL,
  date_validated          TIMESTAMP             NULL  DEFAULT NULL,
  date_deleted            TIMESTAMP             NULL  DEFAULT NULL,
  addressee               VARCHAR(255)          NULL  DEFAULT NULL,
  extra_address_line      VARCHAR(255)          NULL  DEFAULT NULL,
  street_name             VARCHAR(255)          NULL  DEFAULT NULL,
  house_number            VARCHAR(16)           NULL  DEFAULT NULL,
  house_number_suffix     VARCHAR(16)           NULL  DEFAULT NULL,
  locality                VARCHAR(255)          NULL  DEFAULT NULL,
  country_subdivision     VARCHAR(3)            NULL  DEFAULT NULL,
  latitude                DECIMAL(10, 8)        NULL  DEFAULT NULL,
  longitude               DECIMAL(11, 8)        NULL  DEFAULT NULL,
  formatted_address       TEXT                  NULL  DEFAULT NULL,
  PRIMARY KEY pk_address_id (address_id),
  FOREIGN KEY fk_country_id (country_id) REFERENCES sc_countries (country_id) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX ix_postal_code (postal_code),
  UNIQUE KEY uk_global_location_number (global_location_number)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_addresses_eav (
  address_id            INT(10) UNSIGNED     NOT NULL,
  vendor_prefix         VARCHAR(32)          NOT NULL,
  attribute_name        VARCHAR(64)          NOT NULL,
  date_modified         TIMESTAMP            NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  attribute_bool_value  TINYINT(1) UNSIGNED  NULL  DEFAULT NULL,
  attribute_int_value   INT(11) SIGNED       NULL  DEFAULT NULL,
  attribute_str_value   VARCHAR(255)         NULL  DEFAULT NULL,
  PRIMARY KEY pk_entity_id (address_id, vendor_prefix, attribute_name),
  FOREIGN KEY fk_address_id (address_id) REFERENCES sc_addresses (address_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_organization_addresses (
  organization_id  MEDIUMINT(8) UNSIGNED  NOT NULL,
  address_id       INT(10) UNSIGNED       NOT NULL,
  PRIMARY KEY pk_id (organization_id, address_id),
  FOREIGN KEY fk_organization_id (organization_id) REFERENCES sc_organizations (organization_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_address_id (address_id) REFERENCES sc_addresses (address_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_person_addresses (
  person_id   INT(10) UNSIGNED  NOT NULL,
  address_id  INT(10) UNSIGNED  NOT NULL,
  PRIMARY KEY pk_id (person_id, address_id),
  FOREIGN KEY fk_person_id (person_id) REFERENCES sc_persons (person_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_address_id (address_id) REFERENCES sc_addresses (address_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Brands and global brand names
CREATE TABLE IF NOT EXISTS sc_brands (
  brand_id           SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  global_brand_name  VARCHAR(255)          NOT NULL,
  PRIMARY KEY pk_brand_id (brand_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Optional localized brand names
CREATE TABLE IF NOT EXISTS sc_brand_names (
  brand_id          SMALLINT(5) UNSIGNED  NOT NULL,
  language_id       CHAR(5)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  local_brand_name  VARCHAR(255)          NOT NULL,
  PRIMARY KEY pk_brand_name_id (brand_id, language_id),
  FOREIGN KEY fk_brand_id (brand_id) REFERENCES sc_brands (brand_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


--
-- Google product taxonomy
--
-- @see https://support.google.com/merchants/answer/188494?hl=en
--      Products Feed Specification - Google Merchant Center Help
--
-- @see https://support.google.com/merchants/answer/1705911?hl=en
--      The Google product taxonomy - Google Merchant Center Help
--
CREATE TABLE IF NOT EXISTS sc_product_taxonomy (
  taxonomy_id  MEDIUMINT(8) UNSIGNED  NOT NULL,
  language_id  CHAR(5)                CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  DEFAULT 'en-US',
  full_path    VARCHAR(255)           NOT NULL,
  PRIMARY KEY pk_id (taxonomy_id, language_id),
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE,
  INDEX ix_full_path (full_path ASC)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


-- Product categories
CREATE TABLE IF NOT EXISTS sc_categories (
  category_id  SMALLINT(5) UNSIGNED   NOT NULL  AUTO_INCREMENT,
  parent_id    SMALLINT(5) UNSIGNED   NULL  DEFAULT NULL,
  taxonomy_id  MEDIUMINT(8) UNSIGNED  NULL  DEFAULT NULL,
  PRIMARY KEY pk_category_id (category_id),
  FOREIGN KEY fk_parent_id (parent_id) REFERENCES sc_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Localized category names
CREATE TABLE IF NOT EXISTS sc_category_names (
  category_id    SMALLINT(5) UNSIGNED  NOT NULL,
  language_id    CHAR(5)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  category_name  VARCHAR(255)          NOT NULL,
  PRIMARY KEY pk_id (category_id, language_id),
  FOREIGN KEY fk_category_id (category_id) REFERENCES sc_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Categories per store
CREATE TABLE IF NOT EXISTS sc_store_categories (
  store_id     TINYINT(3) UNSIGNED   NOT NULL,
  category_id  SMALLINT(5) UNSIGNED  NOT NULL,
  PRIMARY KEY pk_id (store_id,category_id),
  FOREIGN KEY fk_store_id (store_id) REFERENCES sc_stores (store_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_category_id (category_id) REFERENCES sc_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Schema.org item availability attributes
CREATE TABLE IF NOT EXISTS sc_product_availability_types (
  availability_id    TINYINT(3) UNSIGNED  NOT NULL,
  item_availability  VARCHAR(255)         NOT NULL  COMMENT 'Schema.org ItemAvailability',
  PRIMARY KEY pk_availability_id (availability_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_product_availability_types
    (availability_id, item_availability)
  VALUES
    (1, 'Discontinued'),
    (2, 'InStock'),
    (3, 'InStoreOnly'),
    (4, 'LimitedAvailability'),
    (5, 'OnlineOnly'),
    (6, 'OutOfStock'),
    (7, 'PreOrder'),
    (8, 'SoldOut');

-- Products
CREATE TABLE IF NOT EXISTS sc_products (
  product_id                    MEDIUMINT(8) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  availability_id               TINYINT(3) UNSIGNED    NOT NULL  DEFAULT 2,
  introduction_date             TIMESTAMP              NOT NULL  DEFAULT '1970-01-01 00:00:01',
  taxonomy_id                   MEDIUMINT(8) UNSIGNED  NULL  DEFAULT NULL,
  sales_discontinuation_date    TIMESTAMP              NULL  DEFAULT NULL,
  support_discontinuation_date  TIMESTAMP              NULL  DEFAULT NULL,
  global_product_name           VARCHAR(255)           NULL  DEFAULT NULL,
  PRIMARY KEY pk_product_id (product_id),
  FOREIGN KEY fk_availability_id (availability_id) REFERENCES sc_product_availability_types (availability_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  INDEX ix_introduction_date (introduction_date DESC)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Product barcodes and other product IDs
CREATE TABLE IF NOT EXISTS sc_product_identification_types (
  identification_type_id  TINYINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  abbreviation            VARCHAR(5)           NOT NULL,
  description             VARCHAR(255)         NOT NULL,
  PRIMARY KEY pk_identification_type_id (identification_type_id),
  UNIQUE KEY uk_abbreviation (abbreviation)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_product_identification_types
    (abbreviation, description)
  VALUES
    ('EAN', 'International Article Number'),
    ('UPC', 'Universal Product Code'),
    ('JAN', 'Japanese Article Number'),
    ('MPN', 'Manufacturer Part Number'),
    ('SKU', 'Stock Keeping Unit');

CREATE TABLE IF NOT EXISTS sc_product_identification_codes (
  product_id              MEDIUMINT(8) UNSIGNED  NOT NULL,
  identification_type_id  TINYINT(3) UNSIGNED    NOT NULL,
  identification_code     VARCHAR(255)           NOT NULL,
  PRIMARY KEY pk_id (product_id,identification_type_id),
  FOREIGN KEY fk_product_id (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_identification_type_id (identification_type_id) REFERENCES sc_product_identification_types (identification_type_id) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY uk_identification_code (identification_code)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Product names and product descriptions
CREATE TABLE IF NOT EXISTS sc_product_descriptions (
  product_id          MEDIUMINT(8) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  language_id         CHAR(5)                CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  local_product_name  VARCHAR(255)           NULL  DEFAULT NULL,
  keywords            VARCHAR(255)           NULL  DEFAULT NULL,
  summary             VARCHAR(255)           NULL  DEFAULT NULL  COMMENT 'Plain text',
  description         TEXT                   NULL  DEFAULT NULL  COMMENT 'Formatted HTML',
  PRIMARY KEY pk_product_description_id (product_id, language_id),
  FOREIGN KEY fk_product_id (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Product pricing
CREATE TABLE IF NOT EXISTS sc_product_price_components (
  price_component_id  TINYINT(3) UNSIGNED  NOT NULL,
  description         VARCHAR(255)         NOT NULL,
  comments            VARCHAR(255)         NOT NULL  DEFAULT '',
  PRIMARY KEY pk_price_component_id (price_component_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_product_price_components
    (price_component_id, description, comments)
  VALUES
    (0, 'Base price',                      'Default list price if no other price components are set and price used in calculations.'),
    (1, 'Manufacturer’s suggested price',  'MSRP (Manufacturer’s Suggested Retail Price) or RRP (Recommended Retail Price).'),
    (2, 'Minimum advertised price',        'MAP (Minimum Advertised Price) from legal agreements.'),

    (10, 'Minimum price',                  'Lowerbound for price calculations.'),
    (11, 'Maximum price',                  'Upperbound for price calculations.'),
    (12, 'Fixed surcharge',                'Absolute price component that adds to the base price of the product.'),
    (13, 'Variable surcharge',             'Percent price component that adds to the base price of the product.'),
    (14, 'Fixed discount',                 'Absolute price component that subtracts from the base price of the product.'),
    (15, 'Variable discount',              'Percent price component that subtracts from the base price of the product.'),

    (20, 'Lowest price',                   'Lowest price of all offers available.'),
    (21, 'Average price',                  'Average price of all offers available.'),
    (22, 'Median price',                   'Median price of all offers available.'),
    (23, 'Highest price',                  'Highest price of all offers available.'),
    (28, 'All-time low',                   'Lowest price ever recorded.'),
    (29, 'All-time high',                  'Highest price ever recorded.'),

    (30, 'Price for 2 years',              'Subscription price per two years.'),
    (31, 'Price for 1 year',               'Subscription price per year.'),
    (32, 'Price for 3 months',             'Subscription price per three months.'),
    (33, 'Price for 2 months',             'Subscription price per two months.'),
    (34, 'Price for 1 month',              'Subscription price per month.'),
    (35, 'Price for 2 weeks',              'Subscription price per two weeks.'),
    (36, 'Price for 1 week',               'Subscription price per week.'),
    (37, 'Price for 1 day',                'Subscription price per day.'),
    (38, 'Fixed welcome discount',         'Fixed subscription welcome discount.'),
    (39, 'Variable welcome discount',      'Variable subscription welcome discount.'),

    (240, 'Fixed sale discount',           'Absolute temporary on sale discount.'),
    (241, 'Variable sale discount',        'Percent temporary on sale discount.'),

    (254, 'List price',                    'Calculated, cached list price.'),
    (255, 'Sale price',                    'Calculated, cached sale price.');

CREATE TABLE IF NOT EXISTS sc_product_prices (
  product_id          MEDIUMINT(8) UNSIGNED  NOT NULL,
  price_component_id  TINYINT(3) UNSIGNED    NOT NULL  DEFAULT 0,
  currency_id         SMALLINT(3) UNSIGNED   NOT NULL  DEFAULT 978,
  from_date           TIMESTAMP              NOT NULL  DEFAULT '1970-01-01 00:00:01',
  thru_date           TIMESTAMP              NULL  DEFAULT NULL,
  store_id            TINYINT(3) UNSIGNED    NULL  DEFAULT NULL  COMMENT 'Optional filter',
  customer_group_id   TINYINT(3) UNSIGNED    NULL  DEFAULT NULL  COMMENT 'Optional filter',
  price_or_factor     DECIMAL(15,4)          NOT NULL,
  comments            VARCHAR(255)           NULL  DEFAULT NULL,
  PRIMARY KEY pk_id (product_id,price_component_id,currency_id,from_date),
  FOREIGN KEY fk_product_id (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_currency_id (currency_id) REFERENCES sc_currencies (currency_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_store_id (store_id) REFERENCES sc_stores (store_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_customer_group_id (customer_group_id) REFERENCES sc_customer_groups (customer_group_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Units of measure (UOM)
CREATE TABLE IF NOT EXISTS sc_units_of_measure (
  uom_id        TINYINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  abbreviation  VARCHAR(5)           NOT NULL,
  description   VARCHAR(255)         NOT NULL,
  PRIMARY KEY pk_uom_id (uom_id),
  UNIQUE KEY uk_abbreviation (abbreviation)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_units_of_measure_conversion (
  from_uom_id        TINYINT(3) UNSIGNED  NOT NULL,
  to_uom_id          TINYINT(3) UNSIGNED  NOT NULL,
  conversion_factor  DECIMAL(18,9)        NOT NULL  COMMENT 'Multiplier',
  PRIMARY KEY pk_uom_conversion_id (from_uom_id, to_uom_id),
  FOREIGN KEY fk_from_uom_id (from_uom_id) REFERENCES sc_units_of_measure (uom_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_to_uom_id (to_uom_id) REFERENCES sc_units_of_measure (uom_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_units_of_measure
    (uom_id, abbreviation, description)
  VALUES
    (1, '',    'one unit'),

    (2, 'm',   'metre'),
    (3, 'kg',  'kilogram'),
    (4, 's',   'second'),
    (5, 'A',   'ampere'),
    (6, 'K',   'kelvin'),
    (7, 'mol', 'mole'),
    (8, 'cd',  'candela'),

    (9, 'g', 'gram'),
    (10, 'mg', 'milligram'),
    (11, 't', 'metric ton');

INSERT IGNORE INTO sc_units_of_measure_conversion
    (from_uom_id, to_uom_id, conversion_factor)
  VALUES
    (9, 3, 1000),
    (10, 3, 1000000),
    (11, 3, 0.001);

-- Optional product weights
CREATE TABLE IF NOT EXISTS sc_product_weights (
  product_id  MEDIUMINT(8) UNSIGNED  NOT NULL,
  uom_id      TINYINT(3) UNSIGNED    NOT NULL  DEFAULT 3,
  weight      DECIMAL(18,9)          NOT NULL,
  FOREIGN KEY fk_product_id (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_uom_id (uom_id) REFERENCES sc_units_of_measure (uom_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Products per brand
CREATE TABLE IF NOT EXISTS sc_brand_products (
  brand_id    SMALLINT(5) UNSIGNED   NOT NULL,
  product_id  MEDIUMINT(8) UNSIGNED  NOT NULL,
  PRIMARY KEY pk_id (brand_id,product_id),
  FOREIGN KEY fk_brand_id (brand_id) REFERENCES sc_brands (brand_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_product_id (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Products to categories
CREATE TABLE IF NOT EXISTS sc_category_products (
  category_id   SMALLINT(5) UNSIGNED   NOT NULL,
  product_id    MEDIUMINT(8) UNSIGNED  NOT NULL,
  primary_flag  TINYINT(1) UNSIGNED    NOT NULL  DEFAULT 0,
  from_date     TIMESTAMP              NOT NULL  DEFAULT '1970-01-01 00:00:01',
  thru_date     TIMESTAMP              NULL  DEFAULT NULL,
  PRIMARY KEY pk_id (category_id,product_id),
  FOREIGN KEY fk_category_id (category_id) REFERENCES sc_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_product_id (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Tags or labels
CREATE TABLE IF NOT EXISTS sc_tags (
  tag_id        SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  enabled_flag  TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 1,
  PRIMARY KEY pk_tag_id (tag_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_tag_keywords (
  tag_id       SMALLINT(5) UNSIGNED  NOT NULL,
  language_id  CHAR(5)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  keyword      VARCHAR(255)          NOT NULL,
  PRIMARY KEY pk_id (tag_id,language_id),
  FOREIGN KEY fk_tag_id (tag_id) REFERENCES sc_tags (tag_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_product_tags (
  product_id  MEDIUMINT(8) UNSIGNED  NOT NULL,
  tag_id      SMALLINT(5) UNSIGNED   NOT NULL,
  PRIMARY KEY pk_id (product_id, tag_id),
  FOREIGN KEY fk_product_id (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_tag_id (tag_id) REFERENCES sc_tags (tag_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Product attributes
CREATE TABLE IF NOT EXISTS sc_attributes (
  attribute_id  MEDIUMINT(8) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  uom_id        TINYINT(3) UNSIGNED    NOT NULL  DEFAULT 1,
  enabled_flag  TINYINT(1) UNSIGNED    NOT NULL  DEFAULT 1,
  PRIMARY KEY pk_attribute_id (attribute_id),
  FOREIGN KEY fk_uom_id (uom_id) REFERENCES sc_units_of_measure (uom_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_attribute_descriptions (
  attribute_id  MEDIUMINT(8) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  language_id   CHAR(5)                CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  description   VARCHAR(255)           NOT NULL,
  PRIMARY KEY pk_id (attribute_id,language_id),
  FOREIGN KEY fk_attribute_id (attribute_id) REFERENCES sc_attributes (attribute_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_product_attributes (
  product_id    MEDIUMINT(8) UNSIGNED  NOT NULL,
  attribute_id  MEDIUMINT(8) UNSIGNED  NOT NULL,
  from_date     TIMESTAMP              NOT NULL  DEFAULT '1970-01-01 00:00:01',
  thru_date     TIMESTAMP              NULL  DEFAULT NULL,
  num_value     DECIMAL(18,9)          NULL  DEFAULT NULL,
  str_value     DECIMAL(18,9)          NULL  DEFAULT NULL,
  PRIMARY KEY pk_id (product_id, attribute_id),
  FOREIGN KEY fk_product_id (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_attribute_id (attribute_id) REFERENCES sc_attributes (attribute_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_category_attributes (
  category_id     SMALLINT(5) UNSIGNED   NOT NULL,
  attribute_id    MEDIUMINT(8) UNSIGNED  NOT NULL,
  shared_flag     TINYINT(1)  UNSIGNED   NOT NULL  DEFAULT 0,
  mandatory_flag  TINYINT(1)  UNSIGNED   NOT NULL  DEFAULT 0,
  common_flag     TINYINT(1)  UNSIGNED   NOT NULL  DEFAULT 0,
  PRIMARY KEY pk_id (category_id, attribute_id),
  FOREIGN KEY fk_category_id (category_id) REFERENCES sc_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_attribute_id (attribute_id) REFERENCES sc_attributes (attribute_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Attribute groups and attribute filters
CREATE TABLE IF NOT EXISTS sc_attribute_groups (
  attribute_group_id  SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  group_name          VARCHAR(255)          NOT NULL,
  group_description   VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY pk_attribute_group_id (attribute_group_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_attribute_group_attributes (
  attribute_group_id  SMALLINT(5) UNSIGNED   NOT NULL,
  attribute_id        MEDIUMINT(8) UNSIGNED  NOT NULL,
  from_date           TIMESTAMP              NOT NULL  DEFAULT '1970-01-01 00:00:01',
  thru_date           TIMESTAMP              NULL  DEFAULT NULL,
  PRIMARY KEY pk_id (attribute_group_id,attribute_id),
  FOREIGN KEY fk_attribute_group_id (attribute_group_id) REFERENCES sc_attribute_groups (attribute_group_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_attribute_id (attribute_id) REFERENCES sc_attributes (attribute_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_attribute_filters (
  attribute_group_id  SMALLINT(5) UNSIGNED  NOT NULL,
  enabled_flag        TINYINT(1) UNSIGNED   DEFAULT 1,
  filter_position     TINYINT(3) UNSIGNED   DEFAULT 0,
  PRIMARY KEY pk_attribute_group_id (attribute_group_id),
  FOREIGN KEY fk_attribute_group_id (attribute_group_id) REFERENCES sc_attribute_groups (attribute_group_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_attribute_filter_descriptions (
  attribute_group_id  SMALLINT(5) UNSIGNED  NOT NULL,
  language_id         CHAR(5)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  description         VARCHAR(255)          NOT NULL,
  PRIMARY KEY pk_id (attribute_group_id,language_id),
  FOREIGN KEY fk_attribute_group_id (attribute_group_id) REFERENCES sc_attribute_filters (attribute_group_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

-- Order Management
CREATE TABLE IF NOT EXISTS sc_orders (
  order_id        INT(10) UNSIGNED     NOT NULL,
  store_id        TINYINT(3) UNSIGNED  NOT NULL  DEFAULT 1,
  customer_id     INT(10) UNSIGNED     NULL  DEFAULT NULL,
  backorder_flag  TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  cart_uuid       CHAR(36)             NOT NULL,
  cart_rand       CHAR(192)            NOT NULL,
  date_created    TIMESTAMP            NOT NULL  DEFAULT '1970-01-01 00:00:01',
  date_modified   TIMESTAMP            NULL  DEFAULT NULL,
  date_confirmed  TIMESTAMP            NULL  DEFAULT NULL,
  date_cancelled  TIMESTAMP            NULL  DEFAULT NULL,
  PRIMARY KEY pk_order_id (order_id),
  FOREIGN KEY fk_store_id (store_id) REFERENCES sc_stores (store_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  FOREIGN KEY fk_customer_id (customer_id) REFERENCES sc_customers (customer_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  INDEX ix_cart (cart_uuid, cart_rand),
  INDEX ix_date_confirmed (date_confirmed DESC),
  INDEX ix_date_created (date_created ASC)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii  COLLATE=ascii_bin;

CREATE TABLE IF NOT EXISTS sc_order_products (
  order_id       INT(10) UNSIGNED       NOT NULL,
  product_id     MEDIUMINT(8) UNSIGNED  NOT NULL,
  units          SMALLINT(5) UNSIGNED   NOT NULL  DEFAULT 1,
  unit_price     DECIMAL(18,9)          NOT NULL  DEFAULT 0,
  date_added     TIMESTAMP              NOT NULL  DEFAULT '1970-01-01 00:00:01',
  date_modified  TIMESTAMP              NULL  DEFAULT NULL,
  PRIMARY KEY pk_id (order_id,product_id),
  FOREIGN KEY fk_order_id (order_id) REFERENCES sc_orders (order_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_product_id (product_id) REFERENCES sc_products (product_id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii  COLLATE=ascii_bin;

CREATE TABLE IF NOT EXISTS sc_shipping_carriers (
  carrier_id           SMALLINT(5)   UNSIGNED  NOT NULL  AUTO_INCREMENT,
  global_carrier_name  VARCHAR(255)  NOT NULL  DEFAULT '',
  from_date            TIMESTAMP     NOT NULL  DEFAULT '1970-01-01 00:00:01',
  thru_date            TIMESTAMP     NULL  DEFAULT NULL,
  PRIMARY KEY pk_carrier_id (carrier_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_shipping_carrier_descriptions (
  carrier_id          SMALLINT(5) UNSIGNED  NOT NULL,
  language_id         CHAR(5)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  local_carrier_name  VARCHAR(255)          NOT NULL  DEFAULT '',
  description         VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY pk_id (carrier_id, language_id),
  FOREIGN KEY fk_carrier_id (carrier_id) REFERENCES sc_shipping_carriers (carrier_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_shipments (
  shipment_id     INT(10) UNSIGNED      NOT NULL  AUTO_INCREMENT,
  address_id      INT(10) UNSIGNED      NOT NULL,
  carrier_id      SMALLINT(5) UNSIGNED  NULL  DEFAULT NULL,
  date_created    TIMESTAMP             NOT NULL  DEFAULT '1970-01-01 00:00:01',
  date_notified   TIMESTAMP             NULL  DEFAULT NULL,
  date_picked     TIMESTAMP             NULL  DEFAULT NULL,
  date_packed     TIMESTAMP             NULL  DEFAULT NULL,
  date_shipped    TIMESTAMP             NULL  DEFAULT NULL,
  date_delivered  TIMESTAMP             NULL  DEFAULT NULL,
  tracking_code   VARCHAR(255)          NULL  DEFAULT NULL,
  tracking_uri    VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY pk_shipment_id (shipment_id),
  FOREIGN KEY fk_address_id (address_id) REFERENCES sc_addresses (address_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  FOREIGN KEY fk_carrier_id (carrier_id) REFERENCES sc_shipping_carriers (carrier_id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_order_shipments (
  order_id       INT(10) UNSIGNED  NOT NULL,
  shipment_id    INT(10) UNSIGNED  NOT NULL,
  PRIMARY KEY pk_id (order_id, shipment_id),
  FOREIGN KEY fk_order_id (order_id) REFERENCES sc_orders (order_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_shipment_id (shipment_id) REFERENCES sc_shipments (shipment_id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_invoices (
  invoice_id    INT(10) UNSIGNED       NOT NULL  AUTO_INCREMENT,
  currency_id   SMALLINT(3) UNSIGNED   NOT NULL  DEFAULT 978,
  invoice_date  DATE                   NOT NULL  DEFAULT '1000-01-01',
  terms_days    TINYINT(2) UNSIGNED    NOT NULL  DEFAULT 14,
  subtotal      DECIMAL(18,3)          NOT NULL,
  total         DECIMAL(18,3)          NOT NULL,
  amount_due    DECIMAL(18,3)          NOT NULL,
  PRIMARY KEY pk_invoice_id (invoice_id),
  FOREIGN KEY fk_currency_id (currency_id) REFERENCES sc_currencies (currency_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  INDEX ix_invoice_date (invoice_date DESC)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_invoice_orders (
  invoice_id  INT(10) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  order_id    INT(10) UNSIGNED  NOT NULL,
  PRIMARY KEY pk_invoice_order_id (invoice_id, order_id),
  FOREIGN KEY fk_invoice_id (invoice_id) REFERENCES sc_invoices (invoice_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_order_id (order_id) REFERENCES sc_orders (order_id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_payment_service_providers (
  payment_service_provider_id  SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  global_provider_name         VARCHAR(255)          NOT NULL  DEFAULT '',
  PRIMARY KEY pk_payment_service_provider_id (payment_service_provider_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_payment_services (
  payment_service_id           SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  payment_service_provider_id  SMALLINT(5) UNSIGNED  NULL  DEFAULT NULL,
  global_service_name          VARCHAR(255)          NOT NULL  DEFAULT '',
  from_date                    TIMESTAMP             NOT NULL  DEFAULT '1970-01-01 00:00:01',
  thru_date                    TIMESTAMP             NULL  DEFAULT NULL,
  PRIMARY KEY pk_payment_service_id (payment_service_id),
  FOREIGN KEY fk_payment_service_provider_id (payment_service_provider_id) REFERENCES sc_payment_service_providers (payment_service_provider_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_payment_service_descriptions (
  payment_service_id  SMALLINT(5) UNSIGNED  NOT NULL,
  language_id         CHAR(5)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  local_service_name  VARCHAR(255)          NOT NULL  DEFAULT '',
  description         VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY pk_id (payment_service_id, language_id),
  FOREIGN KEY fk_payment_service_id (payment_service_id) REFERENCES sc_payment_services (payment_service_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_language_id (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_payments (
  payment_id          INT(10) UNSIGNED      NOT NULL  AUTO_INCREMENT,
  currency_id         SMALLINT(3) UNSIGNED  NOT NULL,
  payment_service_id  SMALLINT(5) UNSIGNED  NULL  DEFAULT NULL,
  credit_flag         TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0  COMMENT 'Debit (0) or credit (1)',
  transaction_id      VARCHAR(255)          NULL  DEFAULT NULL,
  transaction_date    DATE                  NOT NULL  DEFAULT '1000-01-01',
  amount              DECIMAL(18,3)         NOT NULL,
  attributes          TEXT                  NULL  DEFAULT NULL,
  PRIMARY KEY pk_payment_id (payment_id),
  FOREIGN KEY fk_currency_id (currency_id) REFERENCES sc_currencies (currency_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  FOREIGN KEY fk_payment_service_id (payment_service_id) REFERENCES sc_payment_services (payment_service_id) ON DELETE NO ACTION ON UPDATE CASCADE,
  INDEX ix_transaction_id (transaction_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_order_payments (
  order_id    INT(10) UNSIGNED  NOT NULL,
  payment_id  INT(10) UNSIGNED  NOT NULL,
  PRIMARY KEY pk_order_payment_id (order_id, payment_id),
  FOREIGN KEY fk_order_id (order_id) REFERENCES sc_orders (order_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_payment_id (payment_id) REFERENCES sc_payments (payment_id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_invoice_payments (
  invoice_id  INT(10) UNSIGNED  NOT NULL,
  payment_id  INT(10) UNSIGNED  NOT NULL,
  PRIMARY KEY pk_invoice_payment_id (invoice_id, payment_id),
  FOREIGN KEY fk_invoice_id (invoice_id) REFERENCES sc_invoices (invoice_id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY fk_payment_id (payment_id) REFERENCES sc_payments (payment_id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;
