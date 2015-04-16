--
-- Translation Memory (TM)
--
-- +------------+------------+-----------------------+
-- | Prefix     | en         | nl                    |
-- +------------+------------+-----------------------+
-- | ADJECTIVE  | Adjective  | Bijvoeglijk naamwoord |
-- | NOUN       | Noun       | Zelfstandig naamwoord |
-- | VERB       | Verb       | Werkwoord             |
-- +------------+------------+-----------------------+
-- | COMMAND    | Command    | Opdracht              |
-- | ERROR      | Error      | Fout                  |
-- | HEADING    | Heading    | Kop                   |
-- | TEXT       | Text       | Tekst                 |
-- +------------+------------+-----------------------+
--
-- @author    Ward van der Put <Ward.van.der.Put@gmail.com>
-- @copyright Copyright (c) 2014-2015 StoreCore
-- @license   http://www.gnu.org/licenses/gpl.html GPLv3
-- @version   0.0.3
--

--
-- Adjectives
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('ADJECTIVE_BOLD', 1031, 'fett'),
    ('ADJECTIVE_BOLD', 1036, 'gras'),
    ('ADJECTIVE_BOLD', 1043, 'vet'),
    ('ADJECTIVE_BOLD', 2057, 'bold'),

    ('ADJECTIVE_DEFAULT', 1031, 'standard'),
    ('ADJECTIVE_DEFAULT', 1036, 'par défaut'),
    ('ADJECTIVE_DEFAULT', 1043, 'standaard'),
    ('ADJECTIVE_DEFAULT', 2057, 'default');


--
-- Nouns that are not translated, usually proper nouns and proper names
--
INSERT INTO sc_translation_memory
    (translation_id, translation, is_admin_only)
  VALUES
    ('NOUN_MYSQL', 'MySQL', 1),
    ('NOUN_PHP', 'PHP', 1);

--
-- Nouns
--
INSERT INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('NOUN_DATABASE', 1031, 'Datenbank'),
    ('NOUN_DATABASE', 1036, 'base de données'),
    ('NOUN_DATABASE', 1043, 'database'),
    ('NOUN_DATABASE', 2057, 'database'),

    ('NOUN_DUTCH', 1031, 'Holländisch'),
    ('NOUN_DUTCH', 1036, 'néerlandais'),
    ('NOUN_DUTCH', 1043, 'Nederlands'),
    ('NOUN_DUTCH', 2057, 'Dutch'),

    ('NOUN_ENGLISH', 1031, 'Englisch'),
    ('NOUN_ENGLISH', 1036, 'anglais'),
    ('NOUN_ENGLISH', 1043, 'Engels'),
    ('NOUN_ENGLISH', 2057, 'English'),

    ('NOUN_FRENCH', 1031, 'Französisch'),
    ('NOUN_FRENCH', 1036, 'français'),
    ('NOUN_FRENCH', 1043, 'Frans'),
    ('NOUN_FRENCH', 2057, 'French'),

    ('NOUN_GERMAN', 1031, 'Deutsch'),
    ('NOUN_GERMAN', 1036, 'allemand'),
    ('NOUN_GERMAN', 1043, 'Duits'),
    ('NOUN_GERMAN', 2057, 'German'),

    ('NOUN_PASSWORD', 1031, 'Kennwort'),
    ('NOUN_PASSWORD', 1036, 'mot de passe'),
    ('NOUN_PASSWORD', 1043, 'wachtwoord'),
    ('NOUN_PASSWORD', 2057, 'password'),

    ('NOUN_USER', 1031, 'Benutzer'),
    ('NOUN_USER', 1036, 'utilisateur'),
    ('NOUN_USER', 1043, 'gebruiker'),
    ('NOUN_USER', 2057, 'user'),

    ('NOUN_USERS', 1031, 'Benutzer'),
    ('NOUN_USERS', 1036, 'utilisateurs'),
    ('NOUN_USERS', 1043, 'gebruikers'),
    ('NOUN_USERS', 2057, 'users');


--
-- Verbs
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('VERB_CANCEL', 1031, 'abbrechen'),
    ('VERB_CANCEL', 1036, 'annuler'),
    ('VERB_CANCEL', 1043, 'annuleren'),
    ('VERB_CANCEL', 2057, 'cancel'),

    ('VERB_PRINT', 1031, 'drucken'),
    ('VERB_PRINT', 1036, 'imprimer'),
    ('VERB_PRINT', 1043, 'printen'),
    ('VERB_PRINT', 2057, 'print'),

    ('VERB_SAVE', 1031, 'speichern'),
    ('VERB_SAVE', 1036, 'enregistrer'),
    ('VERB_SAVE', 1043, 'opslaan'),
    ('VERB_SAVE', 2057, 'save');


--
-- User Interface (UI)
--

--
-- Commands, used for command buttons and menu commands,
-- usually derived from nouns with the NOUN_ prefix.
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('COMMAND_PRINT', 1031, 'Drucken…'),
    ('COMMAND_PRINT', 1036, 'Imprimer…'),
    ('COMMAND_PRINT', 1043, 'Printen…'),
    ('COMMAND_PRINT', 2057, 'Print…'),

    ('COMMAND_SAVE', 1031, 'Speichern'),
    ('COMMAND_SAVE', 1036, 'Enregistrer'),
    ('COMMAND_SAVE', 1043, 'Opslaan'),
    ('COMMAND_SAVE', 2057, 'Save'),

    ('COMMAND_SIGN_IN', 1031, 'Anmelden'),
    ('COMMAND_SIGN_IN', 1036, 'Se connecter'),
    ('COMMAND_SIGN_IN', 1043, 'Inloggen'),
    ('COMMAND_SIGN_IN', 2057, 'Sign in'),

    ('COMMAND_SIGN_OUT', 1031, 'Abmelden'),
    ('COMMAND_SIGN_OUT', 1036, 'Se déconnecter'),
    ('COMMAND_SIGN_OUT', 1043, 'Uitloggen'),
    ('COMMAND_SIGN_OUT', 2057, 'Sign out'),

    ('COMMAND_UNLOCK', 1031, 'Entsperren…'),
    ('COMMAND_UNLOCK', 1036, 'Déverrouiller…'),
    ('COMMAND_UNLOCK', 1043, 'Ontgrendelen…'),
    ('COMMAND_UNLOCK', 2057, 'Unlock…');

--
-- Errors
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('ERROR_PASSWORD_CHARACTERS', 1031, 'Das Kennwort muss sowohl Zahlen als auch Buchstaben enthalten.'),
    ('ERROR_PASSWORD_CHARACTERS', 1036, 'Le mot de passe doit contenir des chiffres et des lettres.'),
    ('ERROR_PASSWORD_CHARACTERS', 1043, 'Het wachtwoord moet cijfers en letters bevatten.'),
    ('ERROR_PASSWORD_CHARACTERS', 2057, 'The password must contain both numbers and letters.'),

    ('ERROR_PASSWORD_MIN_LENGTH', 1031, 'Das Kennwort muss aus mindestens 7 Zeichen bestehen.'),
    ('ERROR_PASSWORD_MIN_LENGTH', 1036, 'Le mot de passe doit être composé d’au moins 7 caractères.'),
    ('ERROR_PASSWORD_MIN_LENGTH', 1043, 'Het wachtwoord moet minimaal 7 tekens bevatten.'),
    ('ERROR_PASSWORD_MIN_LENGTH', 2057, 'The password must be at least 7 characters long.'),

    ('ERROR_PASSWORD_TOO_COMMON', 1031, 'Das Kennwort ist zu allgemein.'),
    ('ERROR_PASSWORD_TOO_COMMON', 1036, 'Le mot de passe est trop commun.'),
    ('ERROR_PASSWORD_TOO_COMMON', 1043, 'Het wachtwoord komt te vaak voor.'),
    ('ERROR_PASSWORD_TOO_COMMON', 2057, 'The password is too common.');

--
-- Headings
--
INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation)
  VALUES
    ('HEADING_CONFIRM_PASSWORD', 1031, 'Kennwort bestätigen'),
    ('HEADING_CONFIRM_PASSWORD', 1036, 'Confirmer le mot de passe'),
    ('HEADING_CONFIRM_PASSWORD', 1043, 'Wachtwoord bevestigen'),
    ('HEADING_CONFIRM_PASSWORD', 2057, 'Confirm password'),

    ('HEADING_EMAIL_ADDRESS', 1031, 'E-Mail-Adresse'),
    ('HEADING_EMAIL_ADDRESS', 1036, 'Adresse de messagerie'),
    ('HEADING_EMAIL_ADDRESS', 1043, 'E-mailadres'),
    ('HEADING_EMAIL_ADDRESS', 2057, 'E-mail address'),

    ('HEADING_FIRST_NAME', 1031, 'Vorname'),
    ('HEADING_FIRST_NAME', 1036, 'Prénom'),
    ('HEADING_FIRST_NAME', 1043, 'Voornaam'),
    ('HEADING_FIRST_NAME', 2057, 'First name'),

    ('HEADING_LAST_NAME', 1031, 'Nachname'),
    ('HEADING_LAST_NAME', 1036, 'Nom'),
    ('HEADING_LAST_NAME', 1043, 'Achternaam'),
    ('HEADING_LAST_NAME', 2057, 'Last name'),

    ('HEADING_PASSWORD', 1031, 'Kennwort'),
    ('HEADING_PASSWORD', 1036, 'Mot de passe'),
    ('HEADING_PASSWORD', 1043, 'Wachtwoord'),
    ('HEADING_PASSWORD', 2057, 'Password'),

    ('HEADING_USER_ACCOUNT', 1031, 'Benutzerkonto'),
    ('HEADING_USER_ACCOUNT', 1036, 'Compte d’utilisateur'),
    ('HEADING_USER_ACCOUNT', 1043, 'Gebruikersaccount'),
    ('HEADING_USER_ACCOUNT', 2057, 'User account'),

    ('HEADING_USERNAME', 1031, 'Benutzername'),
    ('HEADING_USERNAME', 1036, 'Nom d’utilisateur'),
    ('HEADING_USERNAME', 1043, 'Gebruikersnaam'),
    ('HEADING_USERNAME', 2057, 'Username');

INSERT IGNORE INTO sc_translation_memory
    (translation_id, language_id, translation, is_admin_only)
  VALUES
    ('HEADING_DATABASE_NAME', 1031, 'Datenbankname', 1),
    ('HEADING_DATABASE_NAME', 1036, 'Nom de la base de données', 1),
    ('HEADING_DATABASE_NAME', 1043, 'Databasenaam', 1),
    ('HEADING_DATABASE_NAME', 2057, 'Database name', 1),

    ('HEADING_DATABASE_SETTINGS', 1031, 'Datenbankeinstellungen', 1),
    ('HEADING_DATABASE_SETTINGS', 1036, 'Paramètres de la base de données', 1),
    ('HEADING_DATABASE_SETTINGS', 1043, 'Database-instellingen', 1),
    ('HEADING_DATABASE_SETTINGS', 2057, 'Database settings', 1),

    ('HEADING_HOST_NAME_OR_IP_ADDRESS', 1031, 'Hostname oder IP-Adresse', 1),
    ('HEADING_HOST_NAME_OR_IP_ADDRESS', 1036, 'Nom d’hôte ou adresse IP', 1),
    ('HEADING_HOST_NAME_OR_IP_ADDRESS', 1043, 'Hostnaam of IP-adres', 1),
    ('HEADING_HOST_NAME_OR_IP_ADDRESS', 2057, 'Host name or IP address', 1),

    ('HEADING_PDO_DRIVER', 1031, 'PDO-Treiber', 1),
    ('HEADING_PDO_DRIVER', 1036, 'Pilote PDO', 1),
    ('HEADING_PDO_DRIVER', 1043, 'PDO-stuurprogramma', 1),
    ('HEADING_PDO_DRIVER', 2057, 'PDO driver', 1);

--
-- Finally, optimize the TM table
--
OPTIMIZE TABLE sc_translation_memory;
