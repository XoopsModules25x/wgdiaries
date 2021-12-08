<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgDiaries module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgdiaries
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         wedega - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

require_once __DIR__ . '/common.php';
require_once __DIR__ . '/main.php';

// ---------------- Admin Index ----------------
\define('_AM_WGDIARIES_STATISTICS', 'Statistiken');
// There are
\define('_AM_WGDIARIES_THEREARE_ITEMS', "Es gibt <span class='bold'>%s</span> Einträge in der Datenbank");
\define('_AM_WGDIARIES_THEREARE_FILES', "Es gibt <span class='bold'>%s</span> Dateien in der Datenbank");
\define('_AM_WGDIARIES_THEREARE_CATEGORIES', "Es gibt <span class='bold'>%s</span> Kategorien in der Datenbank");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_WGDIARIES_THEREARENT_ITEMS', "Es gibt keine Einträge");
\define('_AM_WGDIARIES_THEREARENT_FILES', "Es gibt keine Dateien");
\define('_AM_WGDIARIES_THEREARENT_CATEGORIES', "Es gibt keine Kategorien");
// Buttons
\define('_AM_WGDIARIES_ADD_ITEM', 'Neuen Eintrag hinzufügen');
\define('_AM_WGDIARIES_ADD_FILE', 'Neue Datei hinzufügen');
\define('_AM_WGDIARIES_ADD_CATEGORY', 'Newsletterkategorie hinzufügen');
// Lists
\define('_AM_WGDIARIES_LIST_ITEMS', 'Liste der Einräge');
\define('_AM_WGDIARIES_LIST_FILES', 'Liste der Dateien');
\define('_AM_WGDIARIES_LIST_CATEGORIES', 'Liste der Kategorien');
// ---------------- Admin Classes ----------------
// Category add/edit
\define('_AM_WGDIARIES_CATEGORY_ADD', 'Kategorie hinzufügen');
\define('_AM_WGDIARIES_CATEGORY_EDIT', 'Kategorie bearbeiten');
// Elements of Category
\define('_AM_WGDIARIES_CATEGORY_ID', 'Id');
\define('_AM_WGDIARIES_CATEGORY_NAME', 'Name');
\define('_AM_WGDIARIES_CATEGORY_LOGO', 'Logo');
\define('_AM_WGDIARIES_CATEGORY_LOGO_UPLOADS', 'Logo in %s :');
\define('_AM_WGDIARIES_CATEGORY_ONLINE', 'Online');
\define('_AM_WGDIARIES_CATEGORY_WEIGHT', 'Reihung');
\define('_AM_WGDIARIES_CATEGORY_DATECREATED', 'Datum erstellt');
\define('_AM_WGDIARIES_CATEGORY_SUBMITTER', 'Einsender');
// ---------------- Admin Permissions ----------------
// Permissions
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL', 'Globale Berechtigungen');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_DESC', 'Globale Berechtigung für die verschiedenen Gruppen festlegen');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_SUBMIT', 'Globale Berechtigungen zum Einsenden');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_EDIT', 'Globale Berechtigungen zum Bearbeiten');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_VIEW', 'Globale Berechtigungen zum Ansehen');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_SUBMIT', 'Berechtigungen zum Einsenden von eines Eintrages');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_GROUP_EDIT', 'Berechtigungen zum Bearbeiten der Einträge der Gruppe');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_GROUP_VIEW', 'Berechtigungen zum Ansehen der Einträge der Gruppe');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_OWN_EDIT', 'Berechtigungen zum Bearbeiten der eigenen Einträge');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_OWN_VIEW', 'Berechtigungen zum Ansehen der eigenen Einträge');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_COMEDIT', 'Berechtigungen zum Ansehen und Bearbeiten der Kommentare zu Einträgen');
\define('_AM_WGDIARIES_PERMISSIONS_CALPAGE_VIEW', 'Berechtigungen zum Ansehen der Kalenderseite');
\define('_AM_WGDIARIES_PERMISSIONS_OUTPUTS_VIEW', 'Berechtigungen zum Ansehen der Ausgabeseite');
\define('_AM_WGDIARIES_PERMISSIONS_STATISTICS_VIEW', 'Berechtigungen zum Ansehen der Statistikseite');
\define('_AM_WGDIARIES_PERMISSIONS_USERITEMS_VIEW', 'Berechtigungen zum Ansehen der Einträgeseite des Benutzers');
\define('_AM_WGDIARIES_NO_PERMISSIONS_SET', 'Keine Berechtigung gesetzt');
//clone
\define('_AM_WGDIARIES_CLONE', 'Klonen');
\define('_AM_WGDIARIES_CLONE_DSC', 'Ein Modul zu klonen war noch nie so einfach! Geben Sie einfach den Namen den Sie wollen und Knopf drücken!');
\define('_AM_WGDIARIES_CLONE_TITLE', 'Klone %s');
\define('_AM_WGDIARIES_CLONE_NAME', 'Wählen Sie einen Namen für das neue Modul');
\define('_AM_WGDIARIES_CLONE_NAME_DSC', 'Verwenden Sie keine Sonderzeichen ! <br> Wählen Sie bitte kein vorhandenes Modul Modul Verzeichnisname  oder Datenbank-Tabellenname!');
\define('_AM_WGDIARIES_CLONE_INVALIDNAME', 'FEHLER: Ungültige Modulnamen, bitte versuchen Sie einen anderen!');
\define('_AM_WGDIARIES_CLONE_EXISTS', 'FEHLER: Modulnamen bereits benutzt, bitte versuchen Sie einen anderen!');
\define('_AM_WGDIARIES_CLONE_CONGRAT', 'Herzliche Glückwünsche! %s wurde erfolgreich erstellt! <br /> Sie können Änderungen in Sprachdateien machen.');
\define('_AM_WGDIARIES_CLONE_IMAGEFAIL', 'Achtung, wir haben es nicht geschafft, das neue Modul-Logo zu erstellen. Bitte beachten Sie assets / images / logo_module.png manuell zu modifizieren!');
\define('_AM_WGDIARIES_CLONE_FAIL', "Leider konnten wir den neuen Klon nicht erstellen . Vielleicht müssen Sie die Schreibrechte von 'modules' Verzeichnis auf  (CHMOD 777) festlegen und neu versuchen.");

// ---------------- Admin Others ----------------
\define('_AM_WGDIARIES_ABOUT_MAKE_DONATION', 'Absenden');
\define('_AM_WGDIARIES_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGDIARIES_DONATION_AMOUNT', 'Spendenbetrag Amount');
\define('_AM_WGDIARIES_MAINTAINEDBY', ' wird unterstützt von ');
// ---------------- End ----------------
