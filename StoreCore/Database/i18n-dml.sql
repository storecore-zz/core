DELIMITER ;

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
    ('ADJECTIVE_BOLD', 2057, 'bold');

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
    ('VERB_PRINT', 2057, 'print');


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
    ('COMMAND_PRINT', 2057, 'Print…');

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

    ('HEADING_PASSWORD', 1031, 'Kennwort'),
    ('HEADING_PASSWORD', 1036, 'Mot de passe'),
    ('HEADING_PASSWORD', 1043, 'Wachtwoord'),
    ('HEADING_PASSWORD', 2057, 'Password'),

    ('HEADING_USERNAME', 1031, 'Benutzername'),
    ('HEADING_USERNAME', 1036, 'Nom d’utilisateur'),
    ('HEADING_USERNAME', 1043, 'Gebruikersnaam'),
    ('HEADING_USERNAME', 2057, 'Username');

--
-- Finally, optimize the TM table
--
OPTIMIZE TABLE sc_translation_memory;
