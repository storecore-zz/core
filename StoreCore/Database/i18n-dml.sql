--
-- Translation Memory (TM)
--
--              +------------+------------+-----------------------+
--              | Prefix     | en         | nl                    |
-- +------------+------------+------------+-----------------------+
-- |            | ADJECTIVE  | Adjective  | Bijvoeglijk naamwoord |
-- | Plain text | NOUN       | Noun       | Zelfstandig naamwoord |
-- |            | VERB       | Verb       | Werkwoord             |
-- +------------+------------+------------+-----------------------+
-- |            | COMMAND    | Command    | Opdracht              |
-- | Formatted  | ERROR      | Error      | Fout                  |
-- | HTML5      | HEADING    | Heading    | Kop                   |
-- |            | TEXT       | Text       | Tekst                 |
-- +------------+------------+------------+-----------------------+
--
-- @author    Ward van der Put <Ward.van.der.Put@gmail.com>
-- @copyright Copyright (c) 2014-2015 StoreCore
-- @license   http://www.gnu.org/licenses/gpl.html GNU General Public License
-- @version   0.0.4
--

--
-- Adjectives
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('ADJECTIVE_BOLD',   0, 'bold'),
    ('ADJECTIVE_BOLD',   1, 'vet'),
    ('ADJECTIVE_BOLD',   2, 'fett'),
    ('ADJECTIVE_BOLD',   3, 'gras'),

    ('ADJECTIVE_DEFAULT',   0, 'default'),
    ('ADJECTIVE_DEFAULT',   1, 'standaard'),
    ('ADJECTIVE_DEFAULT',   2, 'standard'),
    ('ADJECTIVE_DEFAULT',   3, 'par défaut');


--
-- Nouns that are not translated, usually proper nouns and proper names
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, translation, admin_only_flag)
  VALUES
    ('NOUN_MYSQL', 'MySQL', 1),
    ('NOUN_PAYPAL', 'PayPal', 0),
    ('NOUN_PHP', 'PHP', 1);

--
-- Nouns
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('NOUN_DATABASE',   0, 'database'),
    ('NOUN_DATABASE',   1, 'database'),
    ('NOUN_DATABASE',   2, 'Datenbank'),
    ('NOUN_DATABASE',   3, 'base de données'),

    ('NOUN_DUTCH',   0, 'Dutch'),
    ('NOUN_DUTCH',   1, 'Nederlands'),
    ('NOUN_DUTCH',   2, 'Holländisch'),
    ('NOUN_DUTCH',   3, 'néerlandais'),

    ('NOUN_ENGLISH',   0, 'English'),
    ('NOUN_ENGLISH',   1, 'Engels'),
    ('NOUN_ENGLISH',   2, 'Englisch'),
    ('NOUN_ENGLISH',   3, 'anglais'),

    ('NOUN_FRENCH',   0, 'French'),
    ('NOUN_FRENCH',   1, 'Frans'),
    ('NOUN_FRENCH',   2, 'Französisch'),
    ('NOUN_FRENCH',   3, 'français'),

    ('NOUN_GERMAN',   0, 'German'),
    ('NOUN_GERMAN',   1, 'Duits'),
    ('NOUN_GERMAN',   2, 'Deutsch'),
    ('NOUN_GERMAN',   3, 'allemand'),

    ('NOUN_PASSWORD',   2, 'Kennwort'),
    ('NOUN_PASSWORD',   3, 'mot de passe'),
    ('NOUN_PASSWORD',   1, 'wachtwoord'),
    ('NOUN_PASSWORD',   0, 'password'),

    ('NOUN_USER',   0, 'user'),
    ('NOUN_USER',   1, 'gebruiker'),
    ('NOUN_USER',   2, 'Benutzer'),
    ('NOUN_USER',   3, 'utilisateur'),

    ('NOUN_USERS',   0, 'users'),
    ('NOUN_USERS',   1, 'gebruikers'),
    ('NOUN_USERS',   2, 'Benutzer'),
    ('NOUN_USERS',   3, 'utilisateurs');


--
-- Verbs
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('VERB_CANCEL',   0, 'cancel'),
    ('VERB_CANCEL',   1, 'annuleren'),
    ('VERB_CANCEL',   2, 'abbrechen'),
    ('VERB_CANCEL',   3, 'annuler'),

    ('VERB_PRINT',   0, 'print'),
    ('VERB_PRINT',   1, 'printen'),
    ('VERB_PRINT',   2, 'drucken'),
    ('VERB_PRINT',   3, 'imprimer'),

    ('VERB_SAVE',   0, 'save'),
    ('VERB_SAVE',   1, 'opslaan'),
    ('VERB_SAVE',   2, 'speichern'),
    ('VERB_SAVE',   3, 'enregistrer');


--
-- User Interface (UI)
--

--
-- Commands, used for command buttons and menu commands,
-- usually derived from verbs with the VERB_ prefix.
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('COMMAND_PRINT',   0, 'Print…'),
    ('COMMAND_PRINT',   1, 'Printen…'),
    ('COMMAND_PRINT',   2, 'Drucken…'),
    ('COMMAND_PRINT',   3, 'Imprimer…'),

    ('COMMAND_SAVE',   0, 'Save'),
    ('COMMAND_SAVE',   1, 'Opslaan'),
    ('COMMAND_SAVE',   2, 'Speichern'),
    ('COMMAND_SAVE',   3, 'Enregistrer'),

    ('COMMAND_SIGN_IN',   0, 'Sign in'),
    ('COMMAND_SIGN_IN',   1, 'Inloggen'),
    ('COMMAND_SIGN_IN',   2, 'Anmelden'),
    ('COMMAND_SIGN_IN',   3, 'Se connecter'),

    ('COMMAND_SIGN_OUT',   0, 'Sign out'),
    ('COMMAND_SIGN_OUT',   1, 'Uitloggen'),
    ('COMMAND_SIGN_OUT',   2, 'Abmelden'),
    ('COMMAND_SIGN_OUT',   3, 'Se déconnecter'),

    ('COMMAND_UNLOCK',   0, 'Unlock…'),
    ('COMMAND_UNLOCK',   1, 'Ontgrendelen…'),
    ('COMMAND_UNLOCK',   2, 'Entsperren…'),
    ('COMMAND_UNLOCK',   3, 'Déverrouiller…');

--
-- Errors
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('ERROR_PASSWORD_CHARACTERS',   0, 'The password must contain both numbers and letters.'),
    ('ERROR_PASSWORD_CHARACTERS',   1, 'Het wachtwoord moet cijfers en letters bevatten.'),
    ('ERROR_PASSWORD_CHARACTERS',   2, 'Das Kennwort muss sowohl Zahlen als auch Buchstaben enthalten.'),
    ('ERROR_PASSWORD_CHARACTERS',   3, 'Le mot de passe doit contenir des chiffres et des lettres.'),

    ('ERROR_PASSWORD_MIN_LENGTH',   0, 'The password must be at least 7 characters long.'),
    ('ERROR_PASSWORD_MIN_LENGTH',   1, 'Het wachtwoord moet minimaal 7 tekens bevatten.'),
    ('ERROR_PASSWORD_MIN_LENGTH',   2, 'Das Kennwort muss aus mindestens 7 Zeichen bestehen.'),
    ('ERROR_PASSWORD_MIN_LENGTH',   3, 'Le mot de passe doit être composé d’au moins 7 caractères.'),

    ('ERROR_PASSWORD_TOO_COMMON',   0, 'The password is too common.'),
    ('ERROR_PASSWORD_TOO_COMMON',   1, 'Het wachtwoord komt te vaak voor.'),
    ('ERROR_PASSWORD_TOO_COMMON',   2, 'Das Kennwort ist zu allgemein.'),
    ('ERROR_PASSWORD_TOO_COMMON',   3, 'Le mot de passe est trop commun.');

--
-- Headings
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('HEADING_CONFIRM_PASSWORD',   0, 'Confirm password'),
    ('HEADING_CONFIRM_PASSWORD',   1, 'Wachtwoord bevestigen'),
    ('HEADING_CONFIRM_PASSWORD',   2, 'Kennwort bestätigen'),
    ('HEADING_CONFIRM_PASSWORD',   3, 'Confirmer le mot de passe'),

    ('HEADING_EMAIL_ADDRESS',   0, 'E-mail address'),
    ('HEADING_EMAIL_ADDRESS',   1, 'E-mailadres'),
    ('HEADING_EMAIL_ADDRESS',   2, 'E-Mail-Adresse'),
    ('HEADING_EMAIL_ADDRESS',   3, 'Adresse de messagerie'),

    ('HEADING_FIRST_NAME',   0, 'First name'),
    ('HEADING_FIRST_NAME',   1, 'Voornaam'),
    ('HEADING_FIRST_NAME',   2, 'Vorname'),
    ('HEADING_FIRST_NAME',   3, 'Prénom'),

    ('HEADING_LAST_NAME',   0, 'Last name'),
    ('HEADING_LAST_NAME',   1, 'Achternaam'),
    ('HEADING_LAST_NAME',   2, 'Nachname'),
    ('HEADING_LAST_NAME',   3, 'Nom'),

    ('HEADING_PASSWORD',   0, 'Password'),
    ('HEADING_PASSWORD',   1, 'Wachtwoord'),
    ('HEADING_PASSWORD',   2, 'Kennwort'),
    ('HEADING_PASSWORD',   3, 'Mot de passe'),

    ('HEADING_USER_ACCOUNT',   0, 'User account'),
    ('HEADING_USER_ACCOUNT',   1, 'Gebruikersaccount'),
    ('HEADING_USER_ACCOUNT',   2, 'Benutzerkonto'),
    ('HEADING_USER_ACCOUNT',   3, 'Compte d’utilisateur'),

    ('HEADING_USERNAME',   0, 'Username'),
    ('HEADING_USERNAME',   1, 'Gebruikersnaam'),
    ('HEADING_USERNAME',   2, 'Benutzername'),
    ('HEADING_USERNAME',   3, 'Nom d’utilisateur');

INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation, admin_only_flag)
  VALUES
    ('HEADING_DATABASE_NAME',   0, 'Database name', 1),
    ('HEADING_DATABASE_NAME',   1, 'Databasenaam', 1),
    ('HEADING_DATABASE_NAME',   2, 'Datenbankname', 1),
    ('HEADING_DATABASE_NAME',   3, 'Nom de la base de données', 1),

    ('HEADING_DATABASE_SETTINGS',   0, 'Database settings', 1),
    ('HEADING_DATABASE_SETTINGS',   1, 'Database-instellingen', 1),
    ('HEADING_DATABASE_SETTINGS',   2, 'Datenbankeinstellungen', 1),
    ('HEADING_DATABASE_SETTINGS',   3, 'Paramètres de la base de données', 1),

    ('HEADING_HOST_NAME_OR_IP_ADDRESS',   0, 'Host name or IP address', 1),
    ('HEADING_HOST_NAME_OR_IP_ADDRESS',   1, 'Hostnaam of IP-adres', 1),
    ('HEADING_HOST_NAME_OR_IP_ADDRESS',   2, 'Hostname oder IP-Adresse', 1),
    ('HEADING_HOST_NAME_OR_IP_ADDRESS',   3, 'Nom d’hôte ou adresse IP', 1),

    ('HEADING_PDO_DRIVER',   0, 'PDO driver', 1),
    ('HEADING_PDO_DRIVER',   1, 'PDO-stuurprogramma', 1),
    ('HEADING_PDO_DRIVER',   2, 'PDO-Treiber', 1),
    ('HEADING_PDO_DRIVER',   3, 'Pilote PDO', 1);
