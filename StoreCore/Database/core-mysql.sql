--
-- MySQL Data Definition
--
-- @author    Ward van der Put <Ward.van.der.Put@gmail.com>
-- @copyright Copyright (c) 2014-2015 StoreCore
-- @license   http://www.gnu.org/licenses/gpl.html GPLv3
-- @version   0.0.1
--

--
-- Users and User Groups
--

CREATE TABLE IF NOT EXISTS sc_user_groups (
  user_group_id    TINYINT(3) UNSIGNED  NOT NULL,
  user_group_name  VARCHAR(255)         NOT NULL,
  PRIMARY KEY (user_group_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_user_groups (user_group_id, user_group_name) VALUES
  (  0, 'Access Denied'),
  (254, 'Administrators'),
  (255, 'Root');

CREATE TABLE IF NOT EXISTS sc_users (
  user_id         SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  user_group_id   TINYINT(3) UNSIGNED   NOT NULL  DEFAULT 0,
  password_reset  TIMESTAMP             NOT NULL  DEFAULT '0000-00-00 00:00:00'  COMMENT 'UTC',
  password_salt   CHAR(255)             NOT NULL,
  hash_algo       VARCHAR(255)          NOT NULL,
  username        VARCHAR(255)          NOT NULL,
  password_hash   VARCHAR(255)          NOT NULL,
  first_name      VARCHAR(255)          NOT NULL  DEFAULT '',
  last_name       VARCHAR(255)          NOT NULL  DEFAULT '',
  email_address   VARCHAR(255)          NOT NULL,
  email_token     VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY (user_id),
  FOREIGN KEY (user_group_id)
    REFERENCES sc_user_groups (user_group_id)
    ON DELETE CASCADE  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_user_agents (
  user_agent_id    CHAR(40)      NOT NULL  COMMENT 'SHA-1 hash',
  first_sighting   TIMESTAMP     NOT NULL  DEFAULT '0000-00-00 00:00:00',
  last_sighting    TIMESTAMP     NOT NULL  DEFAULT '0000-00-00 00:00:00',
  http_user_agent  VARCHAR(255)  NOT NULL  DEFAULT '',
  PRIMARY KEY (user_agent_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_login_attempts (
  attempt_id      BIGINT UNSIGNED       NOT NULL  AUTO_INCREMENT,
  successful      TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  attempted       TIMESTAMP             NOT NULL  DEFAULT '0000-00-00 00:00:00'  COMMENT 'UTC',
  remote_address  VARCHAR(255)          NULL  DEFAULT NULL,
  username        VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY (attempt_id),
  INDEX (attempted)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Robots Exclusion
--

CREATE TABLE IF NOT EXISTS sc_robots (
  robot_id    SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  user_agent  VARCHAR(255)          NOT NULL,
  PRIMARY KEY (robot_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_robot_disallows (
  path_id   SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  robot_id  SMALLINT(5) UNSIGNED  NOT NULL,
  disallow  VARCHAR(255)          NOT NULL  DEFAULT '',
  PRIMARY KEY (path_id),
  FOREIGN KEY (robot_id)
    REFERENCES sc_robots (robot_id)
    ON DELETE CASCADE  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_robots (robot_id, user_agent) VALUES
  (1, '*');

INSERT IGNORE INTO sc_robot_disallows (robot_id, disallow) VALUES
  (1, '/cgi-bin/');


--
-- Internationalization (I18N) and Localization (L10N)
--

CREATE TABLE IF NOT EXISTS sc_currencies (
  currency_id      SMALLINT(3) UNSIGNED  NOT NULL  COMMENT 'ISO 4217 currency number',
  currency_code    CHAR(3)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 4217 currency code',
  digits           SMALLINT(1) UNSIGNED  NOT NULL  DEFAULT 2,
  currency_symbol  VARCHAR(8)            NOT NULL  DEFAULT '¤',
  currency_name    VARCHAR(255)          NOT NULL  COMMENT 'Official ISO 4217 currency name',
  PRIMARY KEY (currency_id),
  UNIQUE KEY (currency_code)
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


CREATE TABLE IF NOT EXISTS sc_languages (
  language_id   SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT  COMMENT 'LCID',
  parent_id     SMALLINT(5) UNSIGNED  NOT NULL  DEFAULT 2057,
  status        TINYINT(1) UNSIGNED   NOT NULL,
  sort_order    SMALLINT(5) UNSIGNED  NOT NULL  DEFAULT 0,
  iso_code      CHAR(5)               NOT NULL  COMMENT 'ISO 639',
  english_name  VARCHAR(32)           NOT NULL,
  local_name    VARCHAR(32)           NOT NULL  DEFAULT '',
  PRIMARY KEY (language_id),
  KEY fk_parent_id (parent_id),
  UNIQUE (iso_code),
  KEY english_name (english_name),
  CONSTRAINT FOREIGN KEY (parent_id)
    REFERENCES sc_languages (language_id)
    ON DELETE RESTRICT  ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_languages (language_id, parent_id, iso_code, english_name, local_name, status) VALUES
  (1031, 1031, 'de-DE', 'German - Germany',         'Deutsch - Deutschland',    1),
  (1036, 1036, 'fr-FR', 'French - France',          'Français - France',        1),
  (1043, 1043, 'nl-NL', 'Dutch - Netherlands',      'Nederlands - Nederland',   1),
  (2057, 2057, 'en-GB', 'English - United Kingdom', 'English - United Kingdom', 1);

INSERT IGNORE INTO sc_languages (language_id, parent_id, iso_code, english_name, local_name, status) VALUES
  (1033, 2057, 'en-US', 'English - United States', 'English - United States', 0),
  (2055, 1031, 'de-CH', 'German - Switzerland',    'Deutsch - Schweiz',       0),
  (2060, 1036, 'fr-BE', 'French - Belgium',        'Français - Belgique',     0),
  (2067, 1043, 'nl-BE', 'Dutch - Belgium',         'Nederlands - België',     0),
  (3079, 1031, 'de-AT', 'German - Austria',        'Deutsch - Österreich',    0),
  (4103, 1031, 'de-LU', 'German - Luxembourg',     'Deutsch - Luxemburg',     0),
  (5127, 1031, 'de-LI', 'German - Liechtenstein',  'Deutsch - Liechtenstein', 0);

CREATE TABLE IF NOT EXISTS sc_translation_memory (
  translation_id  VARCHAR(255)          CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL,
  language_id     SMALLINT(5) UNSIGNED  NOT NULL  DEFAULT 2057,
  is_admin_only   TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  last_modified   TIMESTAMP             NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  translation     TEXT                  NULL,
  PRIMARY KEY pk_translation_id (translation_id, language_id),
  KEY language_id (language_id),
  CONSTRAINT FOREIGN KEY (language_id)
    REFERENCES sc_languages (language_id)
    ON DELETE CASCADE  ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_countries (
  country_id            SMALLINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  status                TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 1,
  postcode_required     TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  subdivision_required  TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  iso_alpha_two         CHAR(2)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 3166-1 alpha-2 code',
  iso_alpha_three       CHAR(3)               CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 3166-1 alpha-3 code',
  iso_number            SMALLINT(3) UNSIGNED  NOT NULL  COMMENT 'ISO 3166-1 numeric code',
  international_name    VARCHAR(128)          NOT NULL,
  PRIMARY KEY (country_id),
  UNIQUE KEY (iso_alpha_two),
  UNIQUE KEY (iso_alpha_three),
  UNIQUE KEY (iso_number)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_country_names (
  country_id    SMALLINT(3) UNSIGNED  NOT NULL,
  language_id   SMALLINT(5) UNSIGNED  NOT NULL,
  country_name  VARCHAR(128)          NOT NULL,
  PRIMARY KEY (country_id, language_id),
  CONSTRAINT FOREIGN KEY (country_id)
    REFERENCES sc_countries (country_id)
    ON DELETE CASCADE  ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (language_id)
    REFERENCES sc_languages (language_id)
    ON DELETE CASCADE  ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_country_subdivisions (
  iso_alpha_two     CHAR(2)       CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 3166-1',
  iso_suffix        VARCHAR(3)    CHARACTER SET ascii  COLLATE ascii_bin  NOT NULL  COMMENT 'ISO 3166-2 add-on',
  subdivision_name  VARCHAR(255)  NOT NULL,
  PRIMARY KEY (iso_alpha_two, iso_suffix),
  CONSTRAINT FOREIGN KEY (iso_alpha_two)
    REFERENCES sc_countries (iso_alpha_two)
    ON DELETE CASCADE  ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_countries (iso_number, international_name, iso_alpha_two, iso_alpha_three, postcode_required, status) VALUES
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


--
-- Stores
--

CREATE TABLE IF NOT EXISTS sc_stores (
  store_id    TINYINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  ssl_mode    TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0,
  store_name  VARCHAR(64)          NOT NULL,
  PRIMARY KEY (store_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_store_hosts (
  host_id        SMALLINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  store_id       TINYINT(3) UNSIGNED   NOT NULL,
  redirect_only  TINYINT(1) UNSIGNED   NOT NULL  DEFAULT 0,
  host_ip        INT(11) UNSIGNED      NULL  DEFAULT NULL,
  host_name      VARCHAR(255)          NULL  DEFAULT NULL,
  redirect_to    VARCHAR(255)          NULL  DEFAULT NULL,
  PRIMARY KEY (host_id),
  FOREIGN KEY (store_id)
    REFERENCES sc_stores (store_id)
    ON DELETE CASCADE  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


--
-- Customers and Order Management
--

CREATE TABLE IF NOT EXISTS sc_customer_groups (
  customer_group_id    TINYINT(3) UNSIGNED  NOT NULL,
  customer_group_name  VARCHAR(255)         NOT NULL,
  PRIMARY KEY (customer_group_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_customer_groups (customer_group_id, customer_group_name) VALUES
  (0, 'Default customer group');

CREATE TABLE IF NOT EXISTS sc_customers (
  customer_id        INT(11) UNSIGNED     NOT NULL  AUTO_INCREMENT,
  customer_group_id  TINYINT(3) UNSIGNED  NOT NULL  DEFAULT 0,
  store_id           TINYINT(3) UNSIGNED  NOT NULL,
  created            TIMESTAMP            NOT NULL  DEFAULT '0000-00-00 00:00:00',
  last_modified      TIMESTAMP            NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  gender             TINYINT(1) UNSIGNED  NOT NULL  DEFAULT 0  COMMENT 'ISO/IEC 5218',
  date_of_birth      DATE                 NOT NULL  DEFAULT '0000-00-00',
  first_name         VARCHAR(255)         NOT NULL  DEFAULT '',
  last_name          VARCHAR(255)         NOT NULL  DEFAULT '',
  full_name          VARCHAR(255)         NOT NULL  DEFAULT '',
  email_address      VARCHAR(255)         NOT NULL  DEFAULT '',
  phone_number       VARCHAR(64)          NULL  DEFAULT NULL,
  company_name       VARCHAR(255)         NULL  DEFAULT NULL,
  commerce_id        VARCHAR(255)         NULL  DEFAULT NULL,
  vat_id             VARCHAR(255)         NULL  DEFAULT NULL,
  PRIMARY KEY (customer_id),
  FOREIGN KEY (customer_group_id)
    REFERENCES sc_customer_groups (customer_group_id)
    ON DELETE NO ACTION  ON UPDATE CASCADE,
  FOREIGN KEY (store_id)
    REFERENCES sc_stores (store_id)
    ON DELETE NO ACTION  ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_customer_accounts (
  account_id     INT(11) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  customer_id    INT(11) UNSIGNED  NOT NULL,
  created        TIMESTAMP         NOT NULL  DEFAULT '0000-00-00 00:00:00',
  last_modified  TIMESTAMP         NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  password_salt  CHAR(255)         NOT NULL,
  email_address  VARCHAR(255)      NOT NULL,
  password_hash  VARCHAR(255)      NOT NULL,
  reset_token    CHAR(16)          CHARACTER SET ascii  COLLATE ascii_bin  NULL  DEFAULT NULL,
  PRIMARY KEY (account_id),
  FOREIGN KEY (customer_id)
    REFERENCES sc_customers (customer_id)
    ON DELETE NO ACTION  ON UPDATE CASCADE,
  INDEX (email_address)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_addresses (
  address_id           INT(11) UNSIGNED      NOT NULL  AUTO_INCREMENT,
  customer_id          INT(11) UNSIGNED      NOT NULL,
  country_id           SMALLINT(3) UNSIGNED  NOT NULL,
  postcode             VARCHAR(16)           NOT NULL  DEFAULT '',
  created              TIMESTAMP             NOT NULL  DEFAULT '0000-00-00 00:00:00',
  last_modified        TIMESTAMP             NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
  addressee            VARCHAR(255)          NOT NULL  DEFAULT '',
  extra_address_line   VARCHAR(255)          NOT NULL  DEFAULT '',
  street_name          VARCHAR(255)          NOT NULL  DEFAULT '',
  house_number         VARCHAR(16)           NOT NULL  DEFAULT '',
  house_number_suffix  VARCHAR(16)           NOT NULL  DEFAULT '',
  locality             VARCHAR(255)          NOT NULL  DEFAULT '',
  country_subdivision  VARCHAR(3)            NULL  DEFAULT NULL,
  deleted              TIMESTAMP             NULL  DEFAULT NULL,
  PRIMARY KEY (address_id),
  FOREIGN KEY (customer_id)
    REFERENCES sc_customers (customer_id)
    ON DELETE CASCADE  ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (country_id)
    REFERENCES sc_countries (country_id)
    ON DELETE CASCADE  ON UPDATE CASCADE,
  INDEX (postcode)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


-- 
-- Catalog
--

CREATE TABLE IF NOT EXISTS sc_brands (
  brand_id           SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  global_brand_name  VARCHAR(255)          NOT NULL,
  PRIMARY KEY (brand_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_brand_names (
  brand_id          SMALLINT(5) UNSIGNED  NOT NULL,
  language_id       SMALLINT(5) UNSIGNED  NOT NULL,
  local_brand_name  VARCHAR(255)          NOT NULL,
  PRIMARY KEY (brand_id,language_id),
  CONSTRAINT FOREIGN KEY (brand_id) REFERENCES sc_brands (brand_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS sc_categories (
  category_id  SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  parent_id    SMALLINT(5) UNSIGNED  NULL  DEFAULT NULL,
  PRIMARY KEY (category_id),
  CONSTRAINT FOREIGN KEY (parent_id) REFERENCES sc_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_category_names (
  category_id    SMALLINT(5) UNSIGNED  NOT NULL,
  language_id    SMALLINT(5) UNSIGNED  NOT NULL,
  category_name  VARCHAR(255)          NOT NULL,
  PRIMARY KEY (category_id,language_id),
  CONSTRAINT FOREIGN KEY (category_id) REFERENCES sc_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_store_categories (
  store_id     TINYINT(3) UNSIGNED   NOT NULL,
  category_id  SMALLINT(5) UNSIGNED  NOT NULL,
  PRIMARY KEY (store_id,category_id),
  CONSTRAINT FOREIGN KEY (store_id) REFERENCES sc_stores (store_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (category_id) REFERENCES sc_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_product_availability_types (
  availability_id    TINYINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  item_availability  VARCHAR(255)         NOT NULL  COMMENT 'Schema.org ItemAvailability',
  PRIMARY KEY (availability_id)
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

CREATE TABLE IF NOT EXISTS sc_products (
  product_id                    MEDIUMINT(8) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  availability_id               TINYINT(3) UNSIGNED    NOT NULL  DEFAULT 2,
  introduction_date             TIMESTAMP              NOT NULL  DEFAULT '0000-00-00 00:00:00',
  sales_discontinuation_date    TIMESTAMP              NOT NULL  DEFAULT '0000-00-00 00:00:00',
  support_discontinuation_date  TIMESTAMP              NOT NULL  DEFAULT '0000-00-00 00:00:00',
  global_product_name           VARCHAR(255)           NULL  DEFAULT NULL,
  PRIMARY KEY (product_id),
  CONSTRAINT FOREIGN KEY (availability_id) REFERENCES sc_product_availability_types (availability_id) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_product_identification_types (
  identification_type_id  TINYINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  abbreviation            VARCHAR(5)           NOT NULL,
  description             VARCHAR(255)         NOT NULL,
  PRIMARY KEY (identification_type_id),
  UNIQUE KEY (abbreviation)
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
  PRIMARY KEY (product_id,identification_type_id),
  CONSTRAINT FOREIGN KEY (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (identification_type_id) REFERENCES sc_product_identification_types (identification_type_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_product_descriptions (
  product_id          MEDIUMINT(8) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  language_id         SMALLINT(5) UNSIGNED   NOT NULL,
  local_product_name  VARCHAR(255)           NULL  DEFAULT NULL,
  keywords            VARCHAR(255)           NULL  DEFAULT NULL,
  summary             VARCHAR(255)           NULL  DEFAULT NULL  COMMENT 'Plain text',
  description         TEXT                   NULL  DEFAULT NULL  COMMENT 'Formatted HTML',
  PRIMARY KEY (product_id,language_id),
  CONSTRAINT FOREIGN KEY (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_product_price_components (
  price_component_id  TINYINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  description         VARCHAR(255)         NOT NULL,
  comments            VARCHAR(255)         NOT NULL  DEFAULT '',
  PRIMARY KEY (price_component_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

INSERT IGNORE INTO sc_product_price_components
    (price_component_id, description, comments)
  VALUE
    ( 1, 'Base price',                     'Default price if no other price components are set and price used in calculations.'),
    ( 2, 'Manufacturer’s suggested price', 'MSRP (Manufacturer’s Suggested Retail Price) or RRP (Recommended Retail Price).'),
    ( 3, 'Minimum advertised price',       'MAP (Minimum Advertised Price) from legal agreements.'),
    ( 4, 'Minimum price',                  'Lowerbound for price calculations.'),
    ( 5, 'Maximum price',                  'Upperbound for price calculations.'),
    ( 6, 'Low price',                      'The lowest price of all offers available.'),
    ( 7, 'Average price',                  'The average price of all offers available.'),
    ( 8, 'High price',                     'The highest price of all offers available.'),
    ( 9, 'Fixed surcharge',                'Absolute price component that adds to the base price of the product.'),
    (10, 'Variable surcharge',             'Percent price component that adds to the base price of the product.'),
    (11, 'Fixed discount',                 'Absolute price component that subtracts from the base price of the product.'),
    (12, 'Variable discount',              'Percent price component that subtracts from the base price of the product.');

CREATE TABLE IF NOT EXISTS sc_units_of_measure (
  uom_id        TINYINT(3) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  abbreviation  VARCHAR(5)           NOT NULL,
  description   VARCHAR(255)         NOT NULL,
  PRIMARY KEY (uom_id),
  UNIQUE KEY (abbreviation)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_units_of_measure_conversion (
  from_uom_id        TINYINT(3) UNSIGNED  NOT NULL,
  to_uom_id          TINYINT(3) UNSIGNED  NOT NULL,
  conversion_factor  DECIMAL(8,4)         NOT NULL  COMMENT 'Multiplier',
  PRIMARY KEY (from_uom_id,to_uom_id),
  CONSTRAINT FOREIGN KEY (from_uom_id) REFERENCES sc_units_of_measure (uom_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (to_uom_id)   REFERENCES sc_units_of_measure (uom_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS sc_brand_products (
  brand_id    SMALLINT(5) UNSIGNED   NOT NULL,
  product_id  MEDIUMINT(8) UNSIGNED  NOT NULL,
  PRIMARY KEY (brand_id,product_id),
  CONSTRAINT FOREIGN KEY (brand_id) REFERENCES sc_brands (brand_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_category_products (
  category_id   SMALLINT(5) UNSIGNED   NOT NULL,
  product_id    MEDIUMINT(8) UNSIGNED  NOT NULL,
  primary_flag  TINYINT(1) UNSIGNED    NOT NULL  DEFAULT 0,
  from_date     TIMESTAMP              NOT NULL  DEFAULT '0000-00-00 00:00:00',
  thru_date     TIMESTAMP              NOT NULL  DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (category_id,product_id),
  CONSTRAINT FOREIGN KEY (category_id) REFERENCES sc_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;


CREATE TABLE IF NOT EXISTS sc_tags (
  tag_id  SMALLINT(5) UNSIGNED  NOT NULL  AUTO_INCREMENT,
  PRIMARY KEY (tag_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_tag_keywords (
  tag_id       SMALLINT(5) UNSIGNED  NOT NULL,
  language_id  SMALLINT(5) UNSIGNED  NOT NULL,
  keyword      VARCHAR(255)          NOT NULL,
  PRIMARY KEY (tag_id,language_id),
  CONSTRAINT FOREIGN KEY (tag_id) REFERENCES sc_tags (tag_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (language_id) REFERENCES sc_languages (language_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS sc_product_tags (
  product_id  MEDIUMINT(8) UNSIGNED  NOT NULL,
  tag_id      SMALLINT(5) UNSIGNED   NOT NULL,
  PRIMARY KEY (product_id,tag_id),
  CONSTRAINT FOREIGN KEY (product_id) REFERENCES sc_products (product_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (tag_id) REFERENCES sc_tags (tag_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci;
