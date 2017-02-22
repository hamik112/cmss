<?php
/**
 * Created by PhpStorm.
 * User: pascalbajorat
 * Date: 09/07/14
 * Time: 22:07
 */

/* General Button and Text Elements */
$lang['view'] = "ansehen";
$lang['edit'] = "bearbeiten";
$lang['delete'] = "löschen";
$lang['back'] = "zurück";
$lang['save'] = "speichern";
$lang['show_me_how'] = "zeig mir wie";
$lang['system_info'] = "System-Info";

/* Demo-Mode */
$lang['demo_mode_h'] = "Demo-Modus";
$lang['demo_mode_desc'] = "Sorry, leider ist dieses Feature im Demo-Modus nicht verfügbar, aber du kannst es selbstverständlich bei einer eigenen Installation auf deinem Server verwenden.";
$lang['demo_login'] = "Bitte verwende für den <a href=\"".site_url()."\">Demo-Login</a> den Benutzernamen \"<strong>".demo_user."</strong>\" und das Passwort \"<strong>".demo_pw."</strong>\"!<br />Die Demo wird alle 30 Minuten zurückgesetzt!";

/* License Dialog */
$lang['license_info_h'] = "Lizenzschlüssel";
$lang['license_info_desc'] = "Bitte gib deinen Lizenzschlüssel oder Item Purchase Code in den <a href=\"%s\"><strong>Einstellungen</strong></a> an, um Updates und Support zu erhalten.";

/* Login */
$lang['login_back'] = "zurück zu deiner Webseite";
$lang['login_failed'] = "Deine Login-Daten / Captcha sind falsch!";
$lang['login_username'] = "Benutzername";
$lang['login_password'] = "Passwort";
$lang['login_btn'] = "Anmelden";

/* Frontend */
$lang['fe_edit'] = "bearbeiten";

/* Navigation */
$lang['nav_frontend'] = "Frontend";
$lang['nav_dashboard'] = "Dashboard";
$lang['nav_content'] = "Inhalte";
$lang['nav_files'] = "Dateien";
$lang['nav_developer'] = "Entwickler";
$lang['nav_backup'] = "Backup &amp; Optimierung";
$lang['nav_user'] = "Benutzer";
$lang['nav_user_profile'] = "Dein Profil";
$lang['nav_settings'] = "Einstellungen";
$lang['nav_logout'] = "Abmelden";

/* Dashboard */
$lang['db_status'] = "Status";
$lang['db_content'] = $lang['nav_content'];
$lang['db_files'] = $lang['nav_files'];
$lang['db_user'] = $lang['nav_user'];
$lang['db_backup'] = $lang['nav_backup'];
$lang['db_settings'] = $lang['nav_settings'];
$lang['db_content_text'] = 'In diesem Bereich kannst du alle deine Inhalte verwalten, wie z.B. Texte, Bilder und Dateien.';
$lang['db_files_text'] = 'Hier kannst du alle Dateien auf deinem Webspace verwalten und auch editieren.';
$lang['db_user_text'] = 'Verwalte alle Nutzer mit Zugriff auf das Backend von simpleCE, sowie dein eigenes Profil.';
$lang['db_backup_text'] = 'Erstelle Backups deiner simpleCE Datenbank und Uploads oder optimiere diese.';
$lang['db_user_text2'] = 'Hier kannst du dein Benutzerprofil sowie deine Zugangsdaten anpassen.';
$lang['db_settings_text'] = 'Grundlegende Einstellungen, simpleCE individualisieren, Nutzer-Rollen bearbeiten, uvm.';

/*
 * Content
 ********/
/* Tabs */
$lang['ct_tab_text'] = "Texte";
$lang['ct_tab_images'] = "Bilder";
$lang['ct_tab_files'] = "Dateien";
$lang['ct_tab_search'] = "Suche";

/* Content-Overview */
$lang['ct_id'] = "ID";
$lang['ct_txt_type'] = "Typ";
$lang['ct_txt_content'] = "Inhalt";
$lang['ct_del_success'] = "Der ausgewählte Inhalt wurde erfolgreich gelöscht!";

$lang['ct_lnk_text'] = "Link-Text";
$lang['ct_lnk_file'] = "Datei";
$lang['ct_lnk_size'] = "Dateigröße";
$lang['ct_lnk_date'] = "Datum";

/* Content-Overview Messages */
$lang['ct_empty_msg_empty_text_h'] = "Keine Inhalte verfügbar!";
$lang['ct_empty_msg_empty_text_t'] = "Aktuell sind in diesem Bereich noch keine Inhalte vorhanden, füge die ersten Inhalts-Elemente deiner Webseite hinzu!";
$lang['ct_empty_msg_empty_img_h'] = $lang['ct_empty_msg_empty_text_h'];
$lang['ct_empty_msg_empty_img_t'] = $lang['ct_empty_msg_empty_text_t'];
$lang['ct_empty_msg_empty_file_h'] = $lang['ct_empty_msg_empty_text_h'];
$lang['ct_empty_msg_empty_file_t'] = $lang['ct_empty_msg_empty_text_t'];

/* Editor Types */
$lang['ct_editor_type_editor'] = 'Editor';
$lang['ct_editor_type_html'] = 'HTML';
$lang['ct_editor_type_long'] = 'Long';
$lang['ct_editor_type_short'] = 'Short';

/* Content Text Single */
$lang['ct_txt_creation_date'] = 'Erstellungsdatum';
$lang['ct_txt_last_update'] = 'Letzte Aktualisierung';

/* Content Text Validation Messages */
$lang['ct_validation_id'] = 'Bitte überprüfe die ID, sie scheint falsch zu sein';
$lang['ct_txt_validation_type'] = 'Der gewählte Typ ist nicht erlaubt';
$lang['ct_txt_validation_text'] = 'Dein Text ist leider zu lang';
$lang['ct_txt_validation_unknown'] = 'Leider konnten deine Inhalte nicht aktualisiert werden, es gab einen unbekannten Fehler';
$lang['ct_txt_success'] = 'Deine Texte wurden erfolgreich aktualisiert';

/* Content Image Single */
$lang['ct_img_alt'] = 'Alt-Text';
$lang['ct_img_link'] = 'Link';
$lang['ct_img_upload'] = 'Aktuelles Bild ersetzen';
$lang['ct_img_lightbox'] = 'Lightbox für dieses Bild aktivieren';
$lang['ct_img_delete'] = 'Bild löschen';

/* Content Image Validation Messages */
$lang['ct_img_validation_path'] = 'Bild-Pfad ist zu lang';
$lang['ct_img_validation_alt'] = 'Alternativ Text ist zu lang';
$lang['ct_img_validation_link'] = 'Die Link-URL ist zu lang';
$lang['ct_img_validation_lightbox'] = 'Die Lightbox-Einstellung ist nicht gültig';
$lang['ct_img_validation_unknown'] = 'Leider konnte dein Bild nicht aktualisiert werden, es gab einen unbekannten Fehler';
$lang['ct_img_success'] = 'Dein Bild wurden erfolgreich aktualisiert';

/* Content File Single */
$lang['ct_file_upload'] = 'Aktuelle Datei ersetzen';
$lang['ct_file_delete'] = 'Datei löschen';

/* Content File Validation Messages */
$lang['ct_file_validation_path'] = 'Der Datei-Pfad ist zu lang';
$lang['ct_file_validation_text'] = 'Der Link-Text ist zu lang';
$lang['ct_file_validation_unknown'] = 'Leider konnte deine Datei nicht aktualisiert werden, es gab einen unbekannten Fehler';
$lang['ct_file_success'] = 'Deine Datei wurden erfolgreich aktualisiert';


/*
 * Files
 ********/

/* Files-Overview */
$lang['files_tab1'] = 'Webspace Dateien';
$lang['files_tab2'] = 'Uploads';
$lang['files_name'] = 'Name';
$lang['files_size'] = 'Größe';
$lang['files_error1_h'] = 'Entschuldigung, Verzeichnis konnte nicht geöffnet werden';
$lang['files_error1_t'] = 'Das gewählte Verzeichnis konnte leider nicht geöffnet werden, ggf. verfügst du nicht über ausreichende Zugriffsrechte!';
$lang['files_error2_h'] = 'Entschuldigung, Datei konnte nicht geöffnet werden';
$lang['files_error2_t'] = 'Die gewählte Datei konnte leider nicht geöffnet werden, ggf. verfügst du nicht über ausreichende Zugriffsrechte!';
$lang['files_file_nw'] = 'Die Datei ist nicht beschreibbar';
$lang['files_file_del'] = 'Löschen';
$lang['files_file_edit'] = 'Bearbeiten';
$lang['files_updated'] = 'Erfolgreich aktualisiert!';
$lang['files_not_updated'] = 'Datei konnte nicht aktualisiert werden!';

$lang['files_file'] = 'Datei';
$lang['files_folder'] = 'Ordner';
$lang['files_create_file_or_folder'] = 'Neue Datei oder Ordner anlegen';
$lang['files_add_file'] = 'Datei hinzufügen';

/*
 * User
 ********/
$lang['user_id'] = 'ID';
$lang['user_username'] = 'Benutzername';
$lang['user_password'] = 'Passwort';
$lang['user_repeat'] = 'wiederholen';
$lang['user_email'] = 'E-Mail';
$lang['user_firstname'] = 'Vorname';
$lang['user_surname'] = 'Nachname';
$lang['user_group'] = 'Gruppe';
$lang['user_group_admin'] = 'Admin';
$lang['user_group_user'] = 'Benutzer';
$lang['user_create_new'] = 'Neuen Benutzer anlegen';
$lang['user_no_user_h'] = 'Keine Benutzer gefunden';
$lang['user_no_user_t'] = 'ups, es sind keine Benutzer in deiner Datenbank vorhanden, was hast du getan?';

$lang['user_validate_msg_username'] = 'Benutzername ist nicht gültig, er muss zwischen 4 - 100 Zeichen lang sein';
$lang['user_validate_msg_username2'] = 'Diser Benutzername wird bereits verwendet';
$lang['user_validate_msg_email'] = 'E-Mail Adresse ist nicht gültig';
$lang['user_validate_msg_email2'] = 'Diese E-Mail Adresse wird bereits verwendet';
$lang['user_validate_msg_firstname'] = 'Vorname ist nicht gültig, er muss zwischen 2 - 200 Zeichen lang sein';
$lang['user_validate_msg_surname'] = 'Nachname ist nicht gültig, er muss zwischen 2 - 200 Zeichen lang sein';
$lang['user_validate_msg_usergroup'] = 'Benutzergruppe ist nicht gültig';
$lang['user_validate_msg_password'] = 'Dein Passwort muss zwischen 4 und 32 Zeichen lang sein!';
$lang['user_validate_msg_password2'] = 'Deine beiden Passwörter stimmen nicht miteinander überein!';

$lang['user_success_msg'] = 'Benutzerprofil wurde erfolgreich aktualisiert';
$lang['user_error_msg'] = 'Das Benutzerprofil konnte nicht aktualisiert werden, es trat ein unbekannter Fehler auf!';

$lang['user_create_success_msg'] = 'Benutzerprofil wurde erfolgreich angelegt';
$lang['user_create_error_msg'] = 'Das Benutzerprofil konnte nicht angelegt werden, es trat ein unbekannter Fehler auf!';

/*
 * Settings
 **********/
$lang['settings_yes'] = 'Ja';
$lang['settings_no'] = 'Nein';
$lang['settings_backend'] = 'Backend';
$lang['settings_frontend'] = 'Frontend';
$lang['settings_reset'] = 'zurücksetzen';
$lang['settings_msg_success'] = 'Die Einstellungen wurden erfolgreich gespeichert!';
$lang['settings_license_server_unavailable'] = 'Entschuldigung, der Lizent-Server ist aktuell nicht erreichbar!';
$lang['settings_license_help'] = 'Falls du irgendwelche Probleme mit deinem Lizenzschlüssel hast oder Fragen zum Aktivierungsprozess bestehen, <a href="mailto:pascal@pascal-bajorat.com"><strong>nimm jederzeit Kontakt zu uns auf</strong></a>!';

$lang['settings_tab1'] = 'Allgemein';
$lang['settings_tab2'] = 'Benutzergruppen';
$lang['settings_tab3'] = 'Individualisierung';
$lang['settings_tab4'] = 'System and Updates';
$lang['settings_general_h'] = 'Allgemeine-Einstellungen';
$lang['settings_license_h'] = 'Lizenz';
$lang['settings_code_style'] = 'Code Style';
$lang['settings_editor_mode'] = 'Editor Modus';
$lang['settings_editor_mode_basic'] = 'Basis';
$lang['settings_editor_mode_standard'] = 'Standard';
$lang['settings_editor_mode_full'] = 'Umfangreich';
$lang['settings_disable_dashboard'] = 'Dashboard deaktivieren';
$lang['settings_disable_login_animation'] = 'Login-Animation deaktivieren';
$lang['settings_disable_lightbox'] = 'Lightbox im Frontend deaktivieren';
$lang['settings_disable_cache'] = 'Cache-System deaktivieren';
$lang['settings_login_captcha'] = 'Login-Captcha';
$lang['settings_login_redirect'] = 'Nachdem Login weiterleiten zum';
$lang['settings_license_key'] = 'Lizenzschlüssel / Item Purchase Code';
$lang['settings_license_key_help'] = 'Benötigst du Hilfe beim auffinden deines Item Purchase Codes?';
$lang['settings_ca_files'] = 'Kann auf das Menü Dateien zugreifen';
$lang['settings_ca_developer'] = 'Kann auf das Menü Entwickler zugreifen';
$lang['settings_ca_backup'] = 'Kann auf das Menü Backups zugreifen';
$lang['settings_ca_user'] = 'Kann Benutzer bearbeiten und verwalten';
$lang['settings_ca_settings'] = 'Kann auf die Einstellungen zugreifen und diese verändern';
$lang['settings_fe_color_1'] = 'Frontend Primärfarbe';
$lang['settings_fe_color_2'] = 'Frontend Sekundärfarbe';
$lang['settings_software_name'] = 'Software Name';
$lang['settings_copyright'] = 'Copyright';
$lang['settings_login_logo'] = 'Login Logo (640 x 230 Pixel)';
$lang['settings_topbar_logo'] = 'Topbar Logo (88 x 88 Pixel)';
$lang['settings_login_background'] = 'Login Hintergrund';
$lang['settings_backend_background'] = 'Backend Hintergrund';
$lang['settings_custom_css'] = 'If you need a more flexible customization, you can add a CSS file named "%s" at this location: "%s". This file will automatically included by %s and you can inject your custom CSS code.';
$lang['settings_custom_css'] = 'Falls du mehr Flexibilität beim individualisieren benötigst, kannst du eine Datei mit dem Namen "%s" unter diesem Pfad ablegen "%s". Die CSS-Datei wird dann automatisch von %s eingebunden und du kannst damit die Darstellung des Backends manipulieren.';

$lang['update_installed'] = 'Installierte Version';
$lang['update_available'] = 'Verfügbare Version';
$lang['update_last_check'] = 'Letzte Update-Prüfung';
$lang['update_panel_h'] = 'Update verfügbar';
$lang['update_panel_note'] = 'Wichtiger Hinweis';
$lang['update_panel_note_txt'] = 'Bevor das Update installiert wird, solltest du dringend ein Backup deiner Datenbank und aller Dateien auf dem Webspace erstellen. Während des Update-Vorgangs bitte unter keinen Umständen dieses Browser-Fenster schließen.';
$lang['update_panel_install_btn'] = 'Update jetzt installieren';
$lang['update_panel_successful'] = 'Das Update wurde erfolgreich installiert. <a href=\"%s\"><strong>Klicke hier um das Update abzuschließen!</strong></a>';
$lang['update_panel_failed'] = 'Update fehlgeschlagen';
$lang['update_panel_uptodate'] = 'Deine Installation von %s ist auf dem aktuellsten Stand.';
$lang['update_panel_update_message'] = 'Es ist eine neue Version verfügbar, es wird empfohlen das Update auf v.%s zu installieren.';
$lang['update_panel_changelog_message'] = 'You can find more informations about this update in our <a href=\"%s\" target=\"_blank\">changelogs</a>, please read the informations about the new version before you start the update.';
$lang['update_panel_changelog_message'] = 'Du kannst mehr Informationen über dieses Update in den <a href=\"%s\" target=\"_blank\">Changelogs</a> finden, bitte lies diese Informationen sorgfältig, bevor du dieses Update installierst.';

$lang['backup_desc'] = 'Hier kannst du deine Datenbank aufräumen, optimieren oder Backups erstellen.';
$lang['backup_driver_error'] = 'Sorry, leider können Backups und Datenbank-Optimierungen nur mit dem MySQL Datenbank-Driver durchgeführt werden!';
$lang['backup_driver_error_zip'] = 'Du hast die PHP ZZLIB Bibliothek nicht installiert, ohne diese können Teile des Backups nicht ausgeführt werden!';
$lang['backup_btn_backup'] = 'Neues Backup anlegen';
$lang['backup_btn_optimize'] = 'Datenbank optimieren';
$lang['backup_path'] = 'Backup-Pfad';
$lang['backup_msg_success'] = 'Backup erfolgreich angelegt!';
$lang['backup_msg_error'] = 'Backup konnte nicht erstellt werden!';
$lang['backup_msg_opt_success'] = 'Deine Datenbank-Tabellen wurden repariert und optimiert!';
$lang['backup_msg_opt_error'] = 'Deine Datenbank-Tabellen konnten nicht repariert oder optimiert werden!!';

$lang['cache_h'] = 'Caches leeren';
$lang['cache_desc'] = 'Over the time simpleCE create different files in your cache directories to speed up your website. Here you can clean your caches, simpleCE will automatically reinitialize all needed files on the next start up.';
$lang['cache_desc'] = 'Im Lauf der Zeit legt simpleCE verschiedene Dateien in deinen Cache-Verzeichnissen an, um deine Webseite zu beschleunigen. Hier kannst du alle Caches leeren, simpleCE wird notwendige Dateien automatisch beim nächsten Aufruf neu anlegen.';
$lang['cache_info'] = 'Cache Info';
$lang['cache_general_cache'] = 'Allgemeiner-Cache';
$lang['cache_image_cache'] = 'Bild-Cache';
$lang['cache_update_cache'] = 'Update-Cache';
$lang['cache_clean_btn'] = 'Alle Caches leeren';
$lang['cache_success_msg'] = 'Alle Caches wurden erfolgreich geleert.';

/*
 * Row
 **********/
$lang['row'] = 'Schleife';
$lang['row_add'] = 'Zeile hinzufügen';
$lang['row_delete'] = 'Zeile löschen';

/*
 * Setup
 **********/
$lang['setup_js_warning'] = 'Bitte aktiviere JavaScript in deinem Browser, ohne funktioniert simpleCE leider nicht!';
$lang['setup_step1_h'] = 'Willkommen zu simpleCE';
$lang['setup_step1_welcome'] = 'Welcome to the five minutes setup of simpleCE v.2.2, please check the system requirements before you begin with the installation process:';
$lang['setup_step1_welcome'] = 'Willkommen zur Fünf-Minuten-Installation von simpleCE v.2.2, bitte prüfe dein System auf die entsprechenden Voraussetzungen, bevor du mit der Installation beginnst.';
$lang['setup_step1_change_lang'] = 'System-Sprache ändern';
$lang['setup_step1_english'] = 'Englisch';
$lang['setup_step1_german'] = 'Deutsch';
$lang['setup_step1_requirements'] = 'Server Voraussetzungen';
$lang['setup_step1_php'] = 'PHP-Version';
$lang['setup_step1_mysql'] = 'Eine MySQL 5.1 (oder neuer) Datenbank ist erforderlich';
$lang['setup_step1_curl'] = 'PHP cURL ist erforderlich';
$lang['setup_step1_zzlib'] = 'PHP ZZIPlib ist erforderlich';
$lang['setup_step1_info_h'] = 'Informationen die benötigt werden';
$lang['setup_step1_info2_h'] = 'Auto-Updater Voraussetzungen';
$lang['setup_step1_file_permissions'] = 'Datei Zugriffsrechte';
$lang['setup_step1_check_error'] = 'Bitte behebe erst die aufgetretenen Probleme und setze die entsprechenden Schreibrechte, bevor du die Installation durchführst!';
$lang['setup_step1_nextstep'] = 'Nächster Schritt';
$lang['setup_step1_check_again'] = 'Erneut prüfen';
$lang['setup_step1_image_lib'] = 'Image manipulation library wie z.B. GD2 oder Imagick';
$lang['setup_step1_image_lib_error'] = 'Image manipulation library wie z.B. GD2 oder Imagick (ohne diese Libraries kannst du keine Thumbnails verwenden)';

$lang['setup_step2_h'] = 'Bitte konfiguriere jetzt dein System';
$lang['setup_step2_desc'] = 'Please type in your User and Website credentials and also the access data for your Database:';
$lang['setup_step2_desc'] = 'Bitte gib jetzt die Benutzerdaten für deine neue Webseite ein, sowie die Zugangsdaten zu einer MySQL Datenbank:';
$lang['setup_step2_user_system'] = 'Benutzer und System';
$lang['setup_step2_siteurl'] = 'Site URL';
$lang['setup_step2_firstname'] = 'Admin Vorname';
$lang['setup_step2_surname'] = 'Admin Nachname';
$lang['setup_step2_username'] = 'Admin Benutzername';
$lang['setup_step2_password'] = 'Admin Passwort';
$lang['setup_step2_email'] = 'Admin E-Mail';
$lang['setup_step2_db_config'] = 'Datenbank-Konfiguration';
$lang['setup_step2_db_driver'] = 'Datenbank Driver';
$lang['setup_step2_db_recommended'] = 'empfohlen';
$lang['setup_step2_db_server'] = 'Datenbank Server';
$lang['setup_step2_db_username'] = 'Datenbank Benutzername';
$lang['setup_step2_db_password'] = 'Datenbank Passwort';
$lang['setup_step2_db_database'] = 'Datenbankname';
$lang['setup_step2_db_prefix'] = 'Tabellen Prefix';
$lang['setup_step2_check_btn'] = 'bestätigen und prüfen';
$lang['setup_step2_demo_data'] = 'Demo-Inhalte mitinstallieren (<strong class="red">funktioniert ausschließlich mit der simpleCE demo website!</strong>)';

$lang['setup_step3_h'] = 'Bereit zum installieren ...';
$lang['setup_step3_desc'] = 'Deine Konfiguration sieht soweit gut aus und wir sind bereit simpleCE auf deinem Server zu installieren. simpleCE kann jetzt erfolgreich mit deiner Datenbank kommunizieren. Wenn du bereit bist, ist es jetzt Zeit die Installation zu starten.';
$lang['setup_step3_install_btn'] = 'Jetzt installieren';
$lang['setup_step3_wait'] = 'Bitte warten ...';
$lang['setup_step3_error_db_connect'] = 'Es konnte keine Verbindung zu deiner Datenbank \"%s\" aufgebaut werden. Das heißt, dass entweder deine Passwort oder Benutzername inkorrekt ist, prüfe auch den Namen deines Datenbank-Servers \"%s\"!<br /><br />%s';
$lang['setup_step3_error_db'] = 'Wir können uns mit deinem Datenbank-Server \"%s\" verbinden (dein Benutzername und Passwort scheinen also korrekt zu sein), aber wir können deine gewählte Datenbank \"%s\" nicht selektieren!<br /><br />%s';

$lang['setup_step4_h'] = 'Du bist fertig!';
$lang['setup_step4_desc'] = 'Yeah, du bist fertig - simpleCE ist erfolgreich installiert worden!';