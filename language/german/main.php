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

require_once __DIR__ . '/admin.php';

// ---------------- Main ----------------
\define('_MA_WGDIARIES_INDEX', 'Übersicht wgDiaries');
\define('_MA_WGDIARIES_TITLE', 'wgDiaries');
\define('_MA_WGDIARIES_DESC', 'Ein einfaches Modul zur Erfassung der täglichen Tätigkeiten bei Heimarbeit');
\define('_MA_WGDIARIES_INDEX_DESC', "Willkommen auf der Startseite Ihres neuen Moduls wgDiaries");
\define('_MA_WGDIARIES_NO_PDF_LIBRARY', 'Libraries TCPDF ist nicht vorhanden, bitte Hochladen in root/Frameworks');
\define('_MA_WGDIARIES_NO', 'Nein');
\define('_MA_WGDIARIES_DETAILS', 'Details anzeigen');
// ---------------- Contents ----------------
// General/forms
\define('_MA_WGDIARIES_FORM_OK', 'Erfolgreich gespeichert');
\define('_MA_WGDIARIES_FORM_DELETE_OK', 'Erfolgreich gelöscht');
\define('_MA_WGDIARIES_FORM_SURE_DELETE', "Wollen Sie diesen Eintrag wirklich löschen: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGDIARIES_FORM_SURE_RENEW', "Wollen Sie diesen Eintrag wirklich aktualisieren: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGDIARIES_FORM_UPLOAD', 'Datei hochladen');
\define('_MA_WGDIARIES_FORM_UPLOAD_NEW', 'Neue Datei hochladen:');
\define('_MA_WGDIARIES_FORM_UPLOAD_SIZE', 'Maximale Dateigröße: ');
\define('_MA_WGDIARIES_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_MA_WGDIARIES_FORM_UPLOAD_IMG_WIDTH', 'Maximale Bildbreite:');
\define('_MA_WGDIARIES_FORM_UPLOAD_IMG_HEIGHT', 'Maximale Bildhöhe:');
\define('_MA_WGDIARIES_FORM_IMAGE_PATH', 'Dateien in %s :');
\define('_MA_WGDIARIES_FORM_ACTION', 'Aktion');
\define('_MA_WGDIARIES_FORM_EDIT', 'Ändern');
\define('_MA_WGDIARIES_FORM_DELETE', 'Löschen');
\define('_MA_WGDIARIES_INVALID_PARAM', 'Ungültiger Parameter');
\define('_MA_WGDIARIES_FORM_ERROR', 'Fehler beim Verarbeiten von Daten');
// Index
\define('_MA_WGDIARIES_INDEX_ITEMS_OWN', 'Meine letzten Einträge');
\define('_MA_WGDIARIES_INDEX_ITEMS_GROUP', 'Letzte Einträge meiner Gruppen');
\define('_MA_WGDIARIES_INDEX_ITEMS_GROUPOTHER', 'Letzte Einträge der anderen Mitglieder meiner Gruppen');
// Item
\define('_MA_WGDIARIES_ITEM', 'Eintrag');
\define('_MA_WGDIARIES_ITEM_ADD', 'Eintrag hinzufügen');
\define('_MA_WGDIARIES_ITEM_EDIT', 'Eintrag bearbeiten');
\define('_MA_WGDIARIES_ITEM_DELETE', 'Eintrag löschen');
\define('_MA_WGDIARIES_ITEM_DETAILS', 'Details zu Eintrag');
\define('_MA_WGDIARIES_ITEM_GOBACK', 'Zurück zum Eintrag');
\define('_MA_WGDIARIES_ITEM_GOBACK_LIST', 'Zurück zur Eintragsliste');
\define('_MA_WGDIARIES_ITEMS', 'Einträge');
\define('_MA_WGDIARIES_ITEMS_LIST', 'Liste der Einträge');
\define('_MA_WGDIARIES_ITEMS_LISTMY', 'Liste meiner Einträge');
\define('_MA_WGDIARIES_ITEMS_LISTGROUP', 'Liste der Einträge meiner Gruppen');
\define('_MA_WGDIARIES_ITEMS_LISTUSER', 'Liste der Einträge von %s');
\define('_MA_WGDIARIES_ITEMS_DESC', 'Beschreibung Einträge');
\define('_MA_WGDIARIES_ITEM_CAPTION', 'Eintrag Nr. %s (%s, von %s bis %s)');
\define('_MA_WGDIARIES_ITEM_CAPTION_SINGLE', '%s - Eintrag Nr. %s - %s)');
// Caption of Item
\define('_MA_WGDIARIES_ITEM_ID', 'Id');
\define('_MA_WGDIARIES_ITEM_GROUPID', 'Gruppe');
\define('_MA_WGDIARIES_ITEM_NAME', 'Name');
\define('_MA_WGDIARIES_ITEM_REMARKS', 'Anmerkungen');
\define('_MA_WGDIARIES_ITEM_DATEFROM', 'Datum von');
\define('_MA_WGDIARIES_ITEM_DATETO', 'Datum bis');
\define('_MA_WGDIARIES_ITEM_CATID', 'Kategorie');
\define('_MA_WGDIARIES_ITEM_TAGS', 'Tags');
\define('_MA_WGDIARIES_ITEM_DATECREATED', 'Datum erstellt');
\define('_MA_WGDIARIES_ITEM_SUBMITTER', 'Einsender');
\define('_MA_WGDIARIES_ITEM_NBFILES', 'Dateien');
\define('_MA_WGDIARIES_ITEM_COMMENTS', 'Kommentare');
\define('_MA_WGDIARIES_ITEM_SAVEADDFILES', 'Einsenden und Dateien hinzufügen');
\define('_MA_WGDIARIES_ITEM_UPLOADFILES', 'Dateien hochladen');
\define('_MA_WGDIARIES_ITEM_UPLOADFILES_BTN', 'Neues Upload-Feld hinzufügen');
\define('_MA_WGDIARIES_ITEM_UPLOADFILES_MAX', 'Maximale Anzahl an Upload-Feldern');
\define('_MA_WGDIARIES_ITEM_LOGO', 'Logo');
\define('_MA_WGDIARIES_ITEM_LOGO_UPLOADS', 'Logo in %s :');
// File
\define('_MA_WGDIARIES_FILE', 'Datei');
\define('_MA_WGDIARIES_FILE_ADD', 'Datei hinzufügen');
\define('_MA_WGDIARIES_FILE_EDIT', 'Datei bearbeiten');
\define('_MA_WGDIARIES_FILE_DELETE', 'Datei löschen');
\define('_MA_WGDIARIES_FILE_OPEN', 'Datei öffnen');
\define('_MA_WGDIARIES_FILES', 'Dateien');
\define('_MA_WGDIARIES_FILES_LIST', 'Liste der Dateien');
\define('_MA_WGDIARIES_FILES_DESC', 'Dateien Beschreibung');
\define('_MA_WGDIARIES_FILES_NODATA', 'Für diesen Eintrag sind keine Dateien verfügbar');
// Caption of File
\define('_MA_WGDIARIES_FILE_ID', 'Id');
\define('_MA_WGDIARIES_FILE_ITEMID', 'ID Eintrag');
\define('_MA_WGDIARIES_FILE_DESC', 'Beschreibung');
\define('_MA_WGDIARIES_FILE_NAME', 'Name');
\define('_MA_WGDIARIES_FILE_MIMETYPE', 'Erweiterungen / Mimetypes');
\define('_MA_WGDIARIES_FILE_DATECREATED', 'Bearbeitungsdatum');
\define('_MA_WGDIARIES_FILE_SUBMITTER', 'Einsender');
\define('_MA_WGDIARIES_FILE_UPLOAD', 'Neue Datei hochladen');
// Statistics
\define('_MA_WGDIARIES_STATISTICS', 'Statistiken');
\define('_MA_WGDIARIES_STATISTICS_MY_YEAR', 'Statistik über die eigenen Einträge ausgewähltes Jahr');
\define('_MA_WGDIARIES_STATISTICS_MY_MONTH', 'Statistik über die eigenen Einträge ausgewählter Monat');
\define('_MA_WGDIARIES_STATISTICS_GROUP_YEAR', 'Statistik über die Einträge meiner Gruppen ausgewähltes Jahr');
\define('_MA_WGDIARIES_STATISTICS_GROUP_MONTH', 'Statistik über die Einträge meiner Gruppen ausgewählter Monat');
\define('_MA_WGDIARIES_STATISTICS_USER_YEAR', 'Statistik über die Einträge pro Benutzer meiner Gruppen ausgewähltes Jahr');
\define('_MA_WGDIARIES_STATISTICS_USER_MONTH', 'Statistik über die Einträge pro Benutzer meiner Gruppen ausgewählter Monat');
\define('_MA_WGDIARIES_STATS_PERIOD', 'Zeitraum');
\define('_MA_WGDIARIES_STATS_PERIOD_FROMTO', 'Von %s bis %s');
\define('_MA_WGDIARIES_STATS_ITEMS_NB', 'Anzahl der Einträge');
\define('_MA_WGDIARIES_STATS_DAYSHOURS', '%s Stunden gesamt (%s Tage und %s Stunden)');
\define('_MA_WGDIARIES_STATS_DAYSHOURSMINUTES', '%s Stunden gesamt (%a Tage, %h Stunden, %i Minuten)');
\define('_MA_WGDIARIES_STATS_HOURS', 'Stunden');
\define('_MA_WGDIARIES_STATS_USER', 'Benutzer');
\define('_MA_WGDIARIES_STATS_SELECT_YEAR', 'Statistik für Jahr: ');
\define('_MA_WGDIARIES_STATS_SELECT_MONTH', 'Statistic für Monat: ');
// Categorie
\define('_MA_WGDIARIES_CATLOGO', 'Kategorie-Logo');
// calendar
\define('_MA_WGDIARIES_CALENDAR_ITEMS', 'Kalender Einträge');
\define('_MA_WGDIARIES_CALENDAR_EDITITEM', 'Eintrag bearbeiten');
\define('_MA_WGDIARIES_CALENDAR_ADDITEM', 'Eintrag hinzufügen');
//navbar
\define('_MA_WGDIARIES_CAL_PREVMONTH', 'Vorheriges Monat');
\define('_MA_WGDIARIES_CAL_NEXTMONTH', 'Nächster Monat');
\define('_MA_WGDIARIES_CAL_PREVYEAR', 'Vorheriges Jahr');
\define('_MA_WGDIARIES_CAL_NEXTYEAR', 'Nächstes Jahr');
//days
\define('_MA_WGDIARIES_CAL_MIN_SUNDAY', 'So');
\define('_MA_WGDIARIES_CAL_MIN_MONDAY', 'Mo');
\define('_MA_WGDIARIES_CAL_MIN_TUESDAY', 'Di');
\define('_MA_WGDIARIES_CAL_MIN_WEDNESDAY', 'Mi');
\define('_MA_WGDIARIES_CAL_MIN_THURSDAY', 'Do');
\define('_MA_WGDIARIES_CAL_MIN_FRIDAY', 'Fr');
\define('_MA_WGDIARIES_CAL_MIN_SATURDAY', 'Sa');
\define('_MA_WGDIARIES_CAL_SUNDAY', 'Sonntag');
\define('_MA_WGDIARIES_CAL_MONDAY', 'Montag');
\define('_MA_WGDIARIES_CAL_TUESDAY', 'Dienstag');
\define('_MA_WGDIARIES_CAL_WEDNESDAY', 'Mittwoch');
\define('_MA_WGDIARIES_CAL_THURSDAY', 'Donnerstag');
\define('_MA_WGDIARIES_CAL_FRIDAY', 'Freitag');
\define('_MA_WGDIARIES_CAL_SATURDAY', 'Samstag');
\define('_MA_WGDIARIES_CAL_JANUARY', 'Januar');
\define('_MA_WGDIARIES_CAL_FEBRUARY', 'Februar');
\define('_MA_WGDIARIES_CAL_MARCH', 'März');
\define('_MA_WGDIARIES_CAL_APRIL', 'April');
\define('_MA_WGDIARIES_CAL_MAY', 'Mai');
\define('_MA_WGDIARIES_CAL_JUNE', 'Juni');
\define('_MA_WGDIARIES_CAL_JULY', 'Juli');
\define('_MA_WGDIARIES_CAL_AUGUST', 'August');
\define('_MA_WGDIARIES_CAL_SEPTEMBER', 'September');
\define('_MA_WGDIARIES_CAL_OCTOBER', 'Oktober');
\define('_MA_WGDIARIES_CAL_NOVEMBER', 'November');
\define('_MA_WGDIARIES_CAL_DECEMBER', 'Dezember');
// Filter
\define('_MA_WGDIARIES_FILTER_APPLY', 'Filter anwenden');
\define('_MA_WGDIARIES_FILTER_RESULT', 'Ergebnis Filter');
\define('_MA_WGDIARIES_FILTER_NODATA', 'Keine Daten gefunden');
\define('_MA_WGDIARIES_FILTERBY_PERIOD', 'Nach Zeitraum filtern');
\define('_MA_WGDIARIES_FILTER_PERIODFROM', 'Von');
\define('_MA_WGDIARIES_FILTER_PERIODTO', 'Bis');
\define('_MA_WGDIARIES_FILTERBY_OWNER', 'Nach Eigentümer filtern');
\define('_MA_WGDIARIES_FILTERBY_OWN', 'Nur eigene Einträge');
\define('_MA_WGDIARIES_FILTERBY_GROUP', 'Alle Einträge der Gruppe');
\define('_MA_WGDIARIES_FILTER_TYPEALL', 'Alle');
\define('_MA_WGDIARIES_FILTER_LIMIT', 'Anzahl der Zeilen');
\define('_MA_WGDIARIES_FILTER_LIMIT_EXCEED', 'Die Anzahl der Zeilen in der Ergebnisliste ist geringer als die Anzahl der verfügbaren Einträge für den ausgewählten Filter');
// ---------------- Activate ----------------
\define('_MA_WGDIARIES_ACTIVE', 'Aktiv (klicke zum Deaktivieren)');
\define('_MA_WGDIARIES_NONACTIVE', 'Nicht aktiv (klicke zum Aktivieren)');
// Outputs
\define('_MA_WGDIARIES_OUTPUTS', 'Ausgabe');
// Archive
\define('_MA_WGDIARIES_ARCHIVE', 'Archive');
\define('_MA_WGDIARIES_ARCHIVE_TITLE', 'Archiv von wgDiary');
// User list
\define('_MA_WGDIARIES_USERLIST_GROUP', 'Liste aller Benutzer mit Einträgen meiner Gruppen');
\define('_MA_WGDIARIES_USERLIST_GROUPS', 'Gruppen');
\define('_MA_WGDIARIES_USERLIST_NB_ITEMS', 'Anzahl der Einträge');
// General
\define('_MA_WGDIARIES_SUBMIT', 'Absenden');
\define('_MA_WGDIARIES_PRINT_LIST', 'Liste drucken');
\define('_MA_WGDIARIES_PRINT_ITEM', 'Eintrag drucken');
\define('_MA_WGDIARIES_SORT', 'Ergebnis sortieren');
\define('_MA_WGDIARIES_SORT_DATEFROM_ASC', 'Sortierung nach Datum aufsteigend');
\define('_MA_WGDIARIES_SORT_DATEFROM_DESC', 'Sortierung nach Datum absteigend');
\define('_MA_WGDIARIES_SORT_DATECREATED_ASC', 'Sortierung nach Erstelldatum aufsteigend');
\define('_MA_WGDIARIES_SORT_DATECREATED_DESC', 'Sortierung nach Erstelldatum absteigend');

// Admin link
\define('_MA_WGDIARIES_ADMIN', 'Administration');
// ---------------- End ----------------
