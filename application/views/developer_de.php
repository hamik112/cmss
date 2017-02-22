<div class="wrapper">
<div class="row">
<ul class="tabs vertical" data-tab>
    <li class="tab-title <?php echo (($active=='general'||$active==false)?'active':'') ?>"><a href="#general"><i class="fa fa-cogs"></i> &nbsp; Allgemein</a></li>
    <li class="tab-title <?php echo (($active=='text')?'active':'') ?>"><a href="#text"><i class="fa fa-file-text-o"></i> &nbsp; Text</a></li>
    <li class="tab-title <?php echo (($active=='image')?'active':'') ?>"><a href="#image"><i class="fa fa-file-image-o"></i> &nbsp; Bild</a></li>
    <li class="tab-title <?php echo (($active=='file')?'active':'') ?>"><a href="#file"><i class="fa fa-file-archive-o"></i> &nbsp; Datei</a></li>
    <li class="tab-title <?php echo (($active=='loop')?'active':'') ?>"><a href="#loops"><i class="fa fa-dot-circle-o"></i> &nbsp; Schleifen</a></li>
</ul>
<div class="tabs-content vertical developer">
<div class="content <?php echo (($active=='general'||$active==false)?'active':'') ?>" id="general">
    <h3>Allgemeine Informationen</h3>
    <p>simpleCE ist ein einfaches Content-Management-System mit Frontend-Bearbeitungsmodus. Das heißt du kannst deine Inhalte, Dateien und Bilder direkt in der Ansicht bearbeiten, in der du die Webseite auch als normaler Nutzer sehen würdest. Es gibt also kein komplexes Backend, keine komplizierten Einstellungen oder andere Hindernisse. Das System wurde so konzipiert, dass man sich nicht an ein komplexes Template oder Theme System gewöhnen muss, denn es gibt keins. Templates können individuell über eigene PHP Includes gestaltet werden.</p>

    <p>Das eigentliche System bietet ein ID basiertes Elemente System: So kannst du in all deinen PHP-Dateien einfache und ohne viel Aufwand bearbeitbare Text-, Bild- und Datei-Elemente einbauen. Die Bearbeitungsoberfläche und Lightbox Funktionen werden eigenständig vom System verwaltet und eingebunden.</p>

    <h5>Features</h5>
    <ul>
        <li>einfache Installation und Integration </li>
        <li>modernes und einfach zu bedienende Oberfläche</li>
        <li>WYSIWYG Editor für eine Textbearbeitung</li>
        <li>Bild und Datei Upload</li>
        <li>Bildmanipulation zur automatisierten Thumbnail-Erstellung</li>
        <li>automatische Lightbox Integration</li>
        <li>kein komplexes Template System</li>
    </ul>

    <h3>simpleCE in deine Webseite integrieren</h3>
    <p>Die Integration von simpleCE in deine Webseite ist ebenso einfach wie die Installation, als erstes müssen einige Standard-Funktionen eingebaut werden, bevor du die Inhaltselemente einbauen und verwenden kannst.</p>

    <p>Die erste Voraussetzung die deine Webseite unbedingt erfüllen muss, ist das diese auf PHP basiert. Deine Dateien heißen also beispielsweise index.php und nicht etwa index.html oder index.htm.</p>

    <p>Füge nun, in die erste Zeile deiner PHP-Datei, folgende require Anweisung hinzu:
        <code>
            &lt;?php<br />require_once 'simplece'.DIRECTORY_SEPARATOR.'frontend.php';<br />?&gt;
        </code>
        und ruf deine Webseite auf, sollte es eine Fehlermeldung geben, überprüfe die Ordnerstruktur aus dem Installations-Script.</p>

    <p>Im nächsten Schritt fügst du die Standard-Funktionen von simpleCE der Webseite hinzu:</p>

    <p>Diese Funktion
        <code>
            &lt;?php sce_head() ?&gt;
        </code>
        muss in den &lt;head&gt; &lt;/head&gt; Bereich der Webseite kopiert werden und die Funktion
        <code>
            &lt;?php sce_footer() ?&gt;
        </code>
        vor den schließenden &lt;/body&gt; Tag.</p>

    <p>Wenn beide Funktionen integriert und die require Anweisung eingebunden sind kannst du damit beginnen die bearbeitbaren simpleCE Elemente einzubauen, dazu gehören: Text, Bild, Datei und Schleifen Elemente.</p>

    <p><strong>WICHTIG:</strong> Bitte beachte das im folgenden Verlauf alle ID's in Funktionen immer einzigartige Zahlen in der kompletten Webseite seien müssen. Die Zahlen selber können frei definiert werden.</p>

    <p><strong>Tipp:</strong> Falls es bei der Nutzung von simpleCE Kompatibilitätsprobleme mit anderen Scripten oder Funktionen geben sollte, besteht die Möglichkeit mit der unten gezeigten Funktion, Scripte oder Codes nur für eingeloggte Nutzer oder nur für Gäste / Besucher auszuführen:</p>

    <p>
        <code>
            &lt;?php<br />
            if( is_logged_in() === true ) {<br />
                // Wird nur für eingeloggte Nutzer ausgeführt<br />
                echo '&lt;script src=”scripts.js”&gt;&lt;/script&gt;';<br />
            }<br /><br />

            if( is_logged_in() !== true ) {<br />
                // Wird nur für NICHT eingeloggte Nutzer / Besucher ausgeführt<br />
                echo '&lt;script src=”scripts.js”&gt;&lt;/script&gt;';<br />
            }<br />
            ?&gt;
        </code>
    </p>
</div>
<div class="content <?php echo (($active=='text')?'active':'') ?>" id="text">
    <h3>Text-Element</h3>
    <p>Das Text Element bietet die Möglichkeit bearbeitbare Texte in drei Varianten in die Webseite einzubauen: Kurztext, Langtext und Langtext mit Editor.</p>

    <p>Die komplette Funktion hat folgenden Aufbau:</p>

    <p><code>&lt;?php sce_editor( <strong class="green">ID</strong> , <strong class="green">Editor-Mode</strong>, <strong class="green">[options array]</strong>); ?&gt;</code></p>

    <p>Ein Beispiel für die einfache Funktion mit dem Mindestparameter ID, die ID muss eine Zahl und einzigartig in der ganzen Webseite sein, außer du willst das gleiche Element mit dem gleichen Inhalt an verschiedenen Stellen ausgeben:</p>

    <p><code>&lt;?php sce_editor( 10, 'editor' ); ?&gt;</code></p>

    <p>Wird die Funktion nur mit dem ID-Parameter aufgerufen, wird automatisch das große Textfeld ohne Editor eingebunden. Als Editor-Modus Parameter sind folgende Einstellungen möglich: "short" für ein kleines Textfeld, "long" für ein großes Textfeld ohne Editor oder "editor" für ein großes Textfeld mit CKEditor.</p>

     <p>Der Options Parameter muss als Array definiert sein, dieser kann die Key's "before" und "after" beinhalten, "before" gibt HTML Code an der vor dem Text ausgegeben wird und "after" gibt HTML-Code an der nach dem Text ausgegeben wird. Sowohl before als auch after werden nur ausgegeben, wenn das Textfeld nicht leer ist. Hier ein Beispiel für die komplette Funktion mit allen Parametern:</p>

    <p><code>&lt;?php sce_editor( 10, 'short', array('mode' =&gt; 'inline', 'before' =&gt; '&lt;h2&gt;', 'after' =&gt; '&lt;/h2&gt;') ); ?&gt;</code></p>

    <h3>Text-Element-Generator</h3>
    <form name="text-generator" id="text-generator" method="post">
        <div class="row">
            <div class="small-6 columns">
                <label for="text_sce_id"><?php echo lang('ct_id') ?>
                    <input type="text" name="text_sce_id" id="text_sce_id" placeholder="<?php echo lang('ct_id') ?>" value="" />
                </label>
            </div>
            <div class="small-6 columns">
                <label for="text_type"><?php echo lang('ct_txt_type') ?>
                    <select name="text_type" id="text_type">
                        <option value="editor"><?php echo lang('ct_editor_type_editor') ?></option>
                        <option value="html"><?php echo lang('ct_editor_type_html') ?></option>
                        <option value="long"><?php echo lang('ct_editor_type_long') ?></option>
                        <option value="short"><?php echo lang('ct_editor_type_short') ?></option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <label for="text_mode">Mode (optional)
                    <select name="text_mode" id="text_mode">
                        <option value="modal">Modal</option>
                        <option value="inline">Inline</option>
                    </select>
                </label>
            </div>
            <div class="small-6 columns">
                <label for="text_return">Return Mode (optional)
                    <select name="text_return" id="text_return">
                        <option value="echo">echo</option>
                        <option value="return">return</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <label for="text_before">Output before Element (optional)
                    <input type="text" name="text_before" id="text_before" placeholder="Output before Element" value="" />
                </label>
            </div>
            <div class="small-6 columns">
                <label for="text_after">Output after Element (optional)
                    <input type="text" name="text_after" id="text_after" placeholder="Output after Element" value="" />
                </label>
            </div>
        </div>

        <a href="#" id="generate-text" class="button">Text-Element generieren</a>

        <p id="text-element-output">

        </p>
    </form>
</div>
<div class="content <?php echo (($active=='image')?'active':'') ?>" id="image">
    <h3>Bild-Element</h3>
    <p>Mit der Bild-Funktion kannst du im Frontend einen kompletten Bild-Upload mit Lightbox Funktionen einbinden, der Funktionsaufbau ist wie folgt:</p>

    <p><code>&lt;?php sce_image( <strong class="green">ID</strong>, <strong class="green">[options array]</strong>); ?&gt;</code></p>

    <p>Die ID muss eine Zahl und einzigartig in der ganzen Webseite sein, außer Sie wollen das gleiche Element mit dem gleichen Inhalt an verschiedenen Stellen ausgeben.</p>

    <p>Der Array mit den Optionen kann folgende Keys beinhalten: before, after, target, thumb_width, thumb_height, gallery_name.</p>

    <p>"before" gibt HTML Code an, der vor dem Bild ausgegeben wird und "after" gibt HTML-Code an der nach dem Bild ausgegeben wird. Sowohl before als auch after werden nur ausgegeben, wenn ein Bild hochgeladen wurde.</p>

    <p>"target" gibt das Ziel des Links an, falls das Bild im Frontend verlinkt wird, möglich sind: _self, _parent oder _blank.</p>

    <p>"thumb_width" und "thumb_height" können die Größe der automatisch erzeugten Thumbnails regeln.</p>

    <p>"gallery_name" gibt den Gruppennamen für die Lightbox-Galerie Funktion an.</p>

    <p>"class" CSS Klasse für den Link-Tag.</p>

    <p>"id" CSS ID für den Link-Tag.</p>

    <p>"custom_attributes_a" individuelle Attribute die im Link-Tag ausgeführt werden z.B. <i>data-link="test"</i>.</p>

    <p>"custom_attributes_img" individuelle Attribute die im Bild-Tag ausgeführt werden z.B. <i>data-hidpi-src="your-value"</i>.</p>

    <p>Hier ein Beispiel:

    <p><code>&lt;?php sce_image( 20, array('thumb_width' =&gt; 250, 'thumb_height' =&gt; 150, 'gallery_name' =&gt; 'screenshots') ); ?&gt;</code></p>

    <h3>Bild-Element-Generator</h3>
    <form name="image-generator" id="image-generator" method="post">
        <div class="row">
            <div class="small-6 columns">
                <label for="image_sce_id"><?php echo lang('ct_id') ?>
                    <input type="text" name="image_sce_id" id="image_sce_id" placeholder="<?php echo lang('ct_id') ?>" value="" />
                </label>
            </div>
            <div class="small-6 columns">
                <label for="image_target">Link-Target (optional)
                    <select name="image_target" id="image_target">
                        <option value="self">_self</option>
                        <option value="parent">_parent</option>
                        <option value="blank">_blank</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <label for="image_before">Output before Element (optional)
                    <input type="text" name="image_before" id="image_before" placeholder="Output before Element" value="" />
                </label>
            </div>
            <div class="small-6 columns">
                <label for="image_after">Output after Element (optional)
                    <input type="text" name="image_after" id="image_after" placeholder="Output after Element" value="" />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-3 columns">
                <label for="image_thumb_width">Thumb-Width (opt.)
                    <input type="text" name="image_thumb_width" id="image_thumb_width" placeholder="Thumb-Width" value="" />
                </label>
            </div>
            <div class="small-3 columns">
                <label for="image_thumb_height">Thumb-Height (opt.)
                    <input type="text" name="image_thumb_height" id="image_thumb_height" placeholder="Thumb-Height" value="" />
                </label>
            </div>
            <div class="small-6 columns">
                <label for="image_return">Return Mode (optional)
                    <select name="image_return" id="image_return">
                        <option value="echo">echo</option>
                        <option value="return">return</option>
                        <option value="array">array</option>
                    </select>
                </label>
            </div>
        </div>

        <a href="#" id="generate-image" class="button">Bild-Element generieren</a>

        <p id="image-element-output">

        </p>
    </form>
</div>
<div class="content <?php echo (($active=='file')?'active':'') ?>" id="file">

    <h3>Datei-Element</h3>
    <p>Das Datei-Element ermöglicht den Upload von verschiedenen Dateien und positioniert automatisch einen Download-Link im Frontend, die Funktion ist wie folgt aufgebaut:</p>

    <p><code>&lt?php sce_file( <strong class="green">ID</strong>, <strong class="green">[options array]</strong> ); ?&gt;</code></p>

    <p>Die ID muss eine Zahl und einzigartig in der ganzen Webseite sein, außer Sie wollen das gleiche Element mit dem gleichen Inhalt an verschiedenen Stellen ausgeben.</p>

    <p>Als Optionen können "target" und "class" eingestellt werden, bei Optionen sind auf die normalen HTML-Attribute target="" und class="" übertragbar, hier ein komplettes Beispiel:</p>

    <p><code>&lt;?php sce_file( 30, array('target' =&gt; '_blank', 'class' =&gt; 'sce_file_element') ); ?&gt;</code></p>

    <p>"target" Link-Ziel z.B. "_blank".</p>

    <p>"class" CSS Klasse für den Link-Tag.</p>

    <p>"id" CSS ID für den Link-Tag.</p>

    <p>"custom_attributes_a" individuelle Attribute die im Link-Tag ausgeführt werden z.B. <i>data-link="test"</i>.</p>

    <h3>Datei-Element-Generator</h3>
    <form name="file-generator" id="file-generator" method="post">
        <div class="row">
            <div class="small-6 columns">
                <label for="file_sce_id"><?php echo lang('ct_id') ?>
                    <input type="text" name="file_sce_id" id="file_sce_id" placeholder="<?php echo lang('ct_id') ?>" value="" />
                </label>
            </div>
            <div class="small-6 columns">
                <label for="file_target">Link-Target (optional)
                    <select name="file_target" id="file_target">
                        <option value="blank">_blank</option>
                        <option value="self">_self</option>
                        <option value="parent">_parent</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <label for="file_before">Output before Element (optional)
                    <input type="text" name="file_before" id="file_before" placeholder="Output before Element" value="" />
                </label>
            </div>
            <div class="small-6 columns">
                <label for="file_after">Output after Element (optional)
                    <input type="text" name="file_after" id="file_after" placeholder="Output after Element" value="" />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="small-6 columns">
                <label for="file_return">Return Mode (optional)
                    <select name="file_return" id="file_return">
                        <option value="echo">echo</option>
                        <option value="return">return</option>
                        <option value="array">array</option>
                    </select>
                </label>
            </div>
            <div class="small-6 columns">

            </div>
        </div>

        <a href="#" id="generate-file" class="button">Datei-Element generieren</a>

        <p id="file-element-output">

        </p>
    </form>
</div>
<div class="content <?php echo (($active=='loop')?'active':'') ?>" id="loops">
    <h3>Schleifen-Funktion</h3>

    <p>Die Schleifen-Funktion ermöglicht es bestimmte Funktionen zu wiederholen und neu anzulegen zum Beispiel für Bildergalerien oder News-Seiten. Der Aufbau sieht wie folgt aus:</p>

    <p>Dieser Code wird vor den Elementen der Schleife platziert:<br />
        <code>
            &lt;?php sce_loopInit(<strong class="green">ID</strong>); while(sce_loopController()){sce_loopStart(); ?&gt;
        </code>
        Der Platzhalter <strong class="green">ID</strong> muss mit einem nummerischen Wert ausgetauscht werden.
    </p>

    <p>In diesem Bereich zwischen den Codes können komplett frei so viele HTML-Elemente, sowie simpleCE Funktionen eingebaut werden wie du für deine Inhalte benötigst.</p>

    <p>Diese Funktion wird zum beenden der Schleife aufgerufen:<br />
        <code>&lt;?php sce_loopStop();} ?&gt;</code></p>

    <h3>Beispiel</h3>
    <p><code>
            &lt;?php sce_loopInit(<strong class="green">10</strong>); while(sce_loopController()){sce_loopStart(); ?&gt;<br />

            &nbsp;&nbsp;&nbsp;&nbsp;&lt;?php sce_image(<strong class="green">15</strong>); ?&gt;<br />

            &lt;?php sce_loopStop();} ?&gt;
        </code></p>
</div>
</div>
</div>
</div>