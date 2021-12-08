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

// ---------------- Admin Main ----------------
\define('_MI_WGDIARIES_NAME', 'wgDiaries');
\define('_MI_WGDIARIES_DESC', 'Ein einfaches Modul zur Erfassung der täglichen Tätigkeiten bei Heimarbeit');
// ---------------- Admin Menu ----------------
\define('_MI_WGDIARIES_ADMENU1', 'Dashboard');
\define('_MI_WGDIARIES_ADMENU2', 'Einträge');
\define('_MI_WGDIARIES_ADMENU3', 'Dateien');
\define('_MI_WGDIARIES_ADMENU4', 'Kategorien');
\define('_MI_WGDIARIES_ADMENU6', 'Berechtigungen');
\define('_MI_WGDIARIES_ADMENU7', 'Feedback');
\define('_MI_WGDIARIES_ADMENU8', 'Klonen');
\define('_MI_WGDIARIES_ABOUT', 'Über das Modul');
// ---------------- Admin Nav ----------------
\define('_MI_WGDIARIES_ADMIN_PAGER', 'Listen Admin');
\define('_MI_WGDIARIES_ADMIN_PAGER_DESC', 'Anzahl Einträge in Listen im Adminbereich');
// User
\define('_MI_WGDIARIES_INDEX_PAGER', 'Index-Seite');
\define('_MI_WGDIARIES_INDEX_PAGER_DESC', 'Anzahl Einträge Liste auf Indexseite');
\define('_MI_WGDIARIES_USER_PAGER', 'Listen User');
\define('_MI_WGDIARIES_USER_PAGER_DESC', 'Anzahl Einträge in Listen im Userbereich');
// Submenu
\define('_MI_WGDIARIES_SMNAME1', 'Index-Seite');
\define('_MI_WGDIARIES_SMNAME2', 'Meine Einträge');
\define('_MI_WGDIARIES_SMNAME3', 'Eintrag einsenden');
\define('_MI_WGDIARIES_SMNAME4', 'Einträge meiner Gruppen');
\define('_MI_WGDIARIES_SMNAME5', 'Statistiken');
\define('_MI_WGDIARIES_SMNAME6', 'Ausgabe');
\define('_MI_WGDIARIES_SMNAME7', 'Kalender');
\define('_MI_WGDIARIES_SMNAME8', 'Archive');
\define('_MI_WGDIARIES_SMNAME9', 'Einträge je Benutzer');
// Config
\define('_MI_WGDIARIES_EDITOR_ADMIN', 'Editor Admin');
\define('_MI_WGDIARIES_EDITOR_ADMIN_DESC', 'Bitte den zu verwendenden Editor für den Admin-Bereich wählen');
\define('_MI_WGDIARIES_EDITOR_USER', 'Editor User');
\define('_MI_WGDIARIES_EDITOR_USER_DESC', 'Bitte den zu verwendenden Editor für den User-Bereich wählen');
\define('_MI_WGDIARIES_EDITOR_MAXCHAR', 'Maximale Zeichen Text');
\define('_MI_WGDIARIES_EDITOR_MAXCHAR_DESC', 'Maximale Anzahl an Zeichen für die Anzeige von Texten in Listen im Admin-Bereich');
\define('_MI_WGDIARIES_KEYWORDS', 'Schlüsselworter');
\define('_MI_WGDIARIES_KEYWORDS_DESC', 'Bitte Schlüsselwörter angeben (getrennt durch ein Komma)');
\define('_MI_WGDIARIES_SIZE_MB', 'MB');
\define('_MI_WGDIARIES_MAXSIZE_FILE', 'Maximale Dateigröße');
\define('_MI_WGDIARIES_MAXSIZE_FILE_DESC', 'Bitte die für den Upload von Dateien maximal zulässige Dateigröße definieren');
\define('_MI_WGDIARIES_MAX_FILEUPLOADS', 'Maximale Dateiuploads');
\define('_MI_WGDIARIES_MAX_FILEUPLOADS_DESC', 'Bitte die maximal zulässige Anzahl von Dateiuploads definieren');
\define('_MI_WGDIARIES_MIMETYPES_FILE', 'Zulässige Dateierweiterungen');
\define('_MI_WGDIARIES_MIMETYPES_FILE_DESC', 'Bitte die für den Upload von Dateien zulässigen Dateierweiterungen definieren');
\define('_MI_WGDIARIES_MAXSIZE_IMAGE', 'Maximale Bildgröße');
\define('_MI_WGDIARIES_MAXSIZE_IMAGE_DESC', 'Wähle die maximale Größe der Bilder für Upload aus');
\define('_MI_WGDIARIES_MIMETYPES_IMAGE', 'Erlaubte Mime-types');
\define('_MI_WGDIARIES_MIMETYPES_IMAGE_DESC', 'Definere die erlaubten Mime-Types für Bilderupload');
\define('_MI_WGDIARIES_MAXWIDTH_IMAGE', 'Maximale Breite für große Bilder');
\define('_MI_WGDIARIES_MAXWIDTH_IMAGE_DESC', 'Definieren Sie die maximale Breite, auf die die hochgeladenen Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Wenn ein Bild kleiner ist als die angegebenen Maximalwerte, so wird das Bild nicht vergrößert, sondern es wird in Originalgröße abgespeichert');
\define('_MI_WGDIARIES_MAXHEIGHT_IMAGE', 'Maximale Höhe für große Bilder');
\define('_MI_WGDIARIES_MAXHEIGHT_IMAGE_DESC', 'Definieren Sie die maximale Höhe, auf die die hochgeladenen Bilder automatisch verkleinert werden sollen (in pixel)<br>0 bedeutet, dass Bilder die Originalgröße behalten. <br>Wenn ein Bild kleiner ist als die angegebenen Maximalwerte, so wird das Bild nicht vergrößert, sondern es wird in Originalgröße abgespeichert');
\define('_MI_WGDIARIES_USE_GROUPS', 'Benutzergruppen');
\define('_MI_WGDIARIES_USE_GROUPS_DESC', 'Benutzersystem verwenden, um die Einträge von Mitgliedern spezifischer Gruppen zusammenzufassen');
\define('_MI_WGDIARIES_INDEXHEADER', 'Index Kopfzeile');
\define('_MI_WGDIARIES_INDEXHEADER_DESC', 'Diesen Text als Überschrift in der Indexseite anzeigen');
\define('_MI_WGDIARIES_INDEXSORT', 'Sortierung Indexseite');
\define('_MI_WGDIARIES_INDEXSORT_DESC', 'Wählen Sie wie die Einträge auf der Indexseite sortiert werden sollen');
\define('_MI_WGDIARIES_INDEXSORT_ACT', 'Letzte Aktivitäten');
\define('_MI_WGDIARIES_INDEXSORT_DATEFROM', 'Sortierung nach Eintragsdatum absteigend');
\define('_MI_WGDIARIES_ITEMS_CALENDAR', 'Kalender Einträge anzeigen');
\define('_MI_WGDIARIES_ITEMS_CALENDAR_DESC', 'Auf der Übersichtsseite mit den eigenen Einträgen den Kalender anzeigen');
\define('_MI_WGDIARIES_USERITEMS_AVATAR', 'Avatare Übersichtsseite anzeigen');
\define('_MI_WGDIARIES_USERITEMS_AVATAR_DESC', 'Auf der Übersichtsseite mit den eigenen Einträgen die Avatare anzeigen');
\define('_MI_WGDIARIES_USERITEMS_EMPTY', 'Benutzer ohne Einträge auf Übersichtsseite');
\define('_MI_WGDIARIES_USERITEMS_EMPTY_DESC', 'Auf der Übersichtsseite auch Benutzer ohne Einträge anzeigen');
\define('_MI_WGDIARIES_TABLE_TYPE', 'Tabellentype');
\define('_MI_WGDIARIES_TABLE_TYPE_DESC', 'Tabellentyp ist bootstrap html table');
\define('_MI_WGDIARIES_IDPAYPAL', 'Paypal ID');
\define('_MI_WGDIARIES_IDPAYPAL_DESC', 'Deinen PayPal ID für Spenden hier angeben.');
\define('_MI_WGDIARIES_SHOW_BREADCRUMBS', 'Brotkrumen-Navigation (Breadcrumbs) anzeigen');
\define('_MI_WGDIARIES_SHOW_BREADCRUMBS_DESC', 'Brotkrumen-Navigation anzeigen, welche die aktuelle Seite innerhalb der Websitestruktur darstellt');
\define('_MI_WGDIARIES_ADVERTISE', 'Code Werbung');
\define('_MI_WGDIARIES_ADVERTISE_DESC', 'Bitte Code für Werbungen eingeben');
\define('_MI_WGDIARIES_MAINTAINEDBY', 'Unterstützt durch');
\define('_MI_WGDIARIES_MAINTAINEDBY_DESC', 'Bitte Url für Support oder zur Community angeben');
\define('_MI_WGDIARIES_BOOKMARKS', 'Social Bookmarks');
\define('_MI_WGDIARIES_BOOKMARKS_DESC', 'Social Bookmarks in den Seiten anzeigen');
\define('_MI_WGDIARIES_SHOWCOPYRIGHT', 'Copyright anzeigen');
\define('_MI_WGDIARIES_SHOWCOPYRIGHT_DESC', 'Sie können das Copyright bei der wgSimpleAcc-Ansicht entfernen, jedoch wird ersucht, an einer beliebigen Stelle einen Backlink auf www.wedega.com anzubringen');
\define('_MI_WGDIARIES_CALENDAR_FIRSTDAY', 'Erster Tag im Kalender');
\define('_MI_WGDIARIES_CALENDAR_FIRSTDAY_DESC', 'Entscheiden Sie welcher Tag im Monatskalender als erster Tag angezeigt werden soll.');
\define('_MI_WGDIARIES_CAL_SUNDAY', 'Sonntag');
\define('_MI_WGDIARIES_CAL_MONDAY', 'Montag');
\define('_MI_WGDIARIES_CAL_TUESDAY', 'Dienstag');
\define('_MI_WGDIARIES_CAL_WEDNESDAY', 'Mittwoch');
\define('_MI_WGDIARIES_CAL_THURSDAY', 'Donnerstag');
\define('_MI_WGDIARIES_CAL_FRIDAY', 'Freitag');
\define('_MI_WGDIARIES_CAL_SATURDAY', 'Samstag');
// ---------------- End ----------------
