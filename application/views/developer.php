<div class="wrapper">
    <div class="row">
        <ul class="tabs vertical" data-tab>
            <li class="tab-title <?php echo (($active=='general'||$active==false)?'active':'') ?>"><a href="#general"><i class="fa fa-cogs"></i> &nbsp; General</a></li>
            <li class="tab-title <?php echo (($active=='text')?'active':'') ?>"><a href="#text"><i class="fa fa-file-text-o"></i> &nbsp; Text</a></li>
            <li class="tab-title <?php echo (($active=='image')?'active':'') ?>"><a href="#image"><i class="fa fa-file-image-o"></i> &nbsp; Image</a></li>
            <li class="tab-title <?php echo (($active=='file')?'active':'') ?>"><a href="#file"><i class="fa fa-file-archive-o"></i> &nbsp; File</a></li>
            <li class="tab-title <?php echo (($active=='loop')?'active':'') ?>"><a href="#loops"><i class="fa fa-dot-circle-o"></i> &nbsp; Loops</a></li>
        </ul>
        <div class="tabs-content vertical developer">
            <div class="content <?php echo (($active=='general'||$active==false)?'active':'') ?>" id="general">
                <h3>General-Informations</h3>
                <p>simpleCE is a simple Content-Management System with front-end editor mode. That means, you can directly edit its contents, files and images in the view in which you would see your website as a normal user. There is also no complex back-end, no complicated settings or other hindrances. The system has been so designed that one need not familiarize oneself with a complex template or theme system, because there are none. Templates can be designed individually through separate PHP Includes.</p>
                <p>The actual system offers an ID-based elements system; you can thus incorporate editable texts, images and file elements into all your PHP files, easily and without much expenditure. The editor interface and Light Box functions are managed and integrated autonomously by the system.</p>

                <h5>Features</h5>
                <ul>
                    <li>Easy installation and integration</li>
                    <li>Modern and easy-to-operate interface</li>
                    <li>WYSIWYG Editor for editing text</li>
                    <li>Image and file upload</li>
                    <li>Image manipulation by using phpThumb</li>
                    <li>Automatic Light Box Integration</li>
                    <li>No complex template system</li>
                </ul>

                <h3>Integrating simpleCE into your web page</h3>
                <p>The integration of simpleCE into your web page is as easy as the installation; the first thing to do is to incorporate some standard functions before you can pass the content elements.</p>
                <p>The first prerequisite that your web page must necessarily fulfill is that it should be based on PHP. So your files should be called, for example, index.php and not, say, index.html or index.htm.</p>
                <p>Now if you add the following require instruction in the first line of your PHP file:
                    <code>
                        &lt;?php<br />require_once 'simplece'.DIRECTORY_SEPARATOR.'frontend.php';<br />?&gt;
                    </code>
                    and make a call to your web page, it should give an error message Check the folder structure from the Installations Script.</p>
                <p>In the next step, add the standard functions of simpleCE to the web page:</p>
                <p>This function:
                    <code>
                        &lt;?php sce_head() ?&gt;
                    </code>
                    must be copied to the <em>&lt;head&gt; &lt;/head&gt;</em> area of the website and the function:
                    <code>
                        &lt;?php sce_footer() ?&gt;
                    </code>
                    before the closing <em>&lt;/body&gt;</em> tag.</p>
                <p>If both functions are integrated and the require instruction is included, you can begin to incorporate the editable simpleCE elements, which cover: text, image, file and loop elements.</p>
                <p><strong>IMPORTANT:</strong> Please note that, in the following course, all IDs in functions must be unique numbers in the complete web page. The numbers themselves can be freely defined.</p>

                <p><strong>Hint:</strong> If you have some compability issues with other scripts or function you can use the following function to execute scripts and codes only for logged in users or guests:</p>

                <p>
                    <code>
                        &lt;?php<br />
                        if( is_logged_in() === true ) {<br />
                            // Only for logged in users<br />
                            echo '&lt;script src=”scripts.js”&gt;&lt;/script&gt;';<br />
                        }<br /><br />

                        if( is_logged_in() !== true ) {<br />
                            // Only for NON logged in users / visitors<br />
                            echo '&lt;script src=”scripts.js”&gt;&lt;/script&gt;';<br />
                        }<br />
                        ?&gt;
                    </code>
                </p>
            </div>
            <div class="content <?php echo (($active=='text')?'active':'') ?>" id="text">
                <h3>Text-Element</h3>
                <p>The text element offers the option to incorporate texts into the web page in three variants: short text, long text, long text with editor and pure HTML.</p>

                <p>The complete function has the following structure:</p>

                <p><code>&lt;?php sce_editor( <strong class="green">ID</strong> , <strong class="green">Editor-Mode</strong>, <strong class="green">[options array]</strong>); ?&gt;</code></p>

                <p>An example of the simple function with the minimum parameter ID, the ID must be a number and unique in the entire web page, except when you wish to output the same element with the same content at different locations:</p>

                <p><code>&lt;?php sce_editor( 10, 'editor' ); ?&gt;</code></p>

                <p>If the function is only called with the ID parameter, the large text is incorporated without editor. The settings possible as Editor mode parameter are as follows: "short" for a short text field, "long" for a large text field without editor or "editor" for a large text field with CKEditor.</p>

                <p>The optional parameter must be defined as array; it can contain the keys "before" and "after"; "before" indicates the HTML code that is outputted before the text and "after" indicates the HTML code which is outputted after the text. Both before and after are only outputted if the text field is not blank. Here is an example for the complete function with all parameters:</p>

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

                    <a href="#" id="generate-text" class="button">Generate Text-Element</a>

                    <p id="text-element-output">

                    </p>
                </form>
            </div>
            <div class="content <?php echo (($active=='image')?'active':'') ?>" id="image">
                <h3>Image-Element</h3>
                <p>You can use the image function to incorporate a complete image upload in the front-end using Light Box function; the function structure is as follows:</p>

                <p><code>&lt;?php sce_image( <strong class="green">ID</strong>, <strong class="green">[options array]</strong>); ?&gt;</code></p>

                <p>The ID must be a number and unique in the whole web page; except when you wish to output the same element with the same content at different locations.</p>

                <p>The alternative options must be defined as array and can contain the following keys: before, after, target, thumb_width, thumb_height, gallery_name.</p>

                <p>"before" indicates the HTML code that is outputted before the image and "after" indicates the HTML code which is outputted after the image. Both before and after are only outputted if the image field is not blank.</p>

                <p>"target" indicates the destination of the link, in case the image is linked in the front-end, the following are possible: _self, _parent or _blank.</p>

                <p>"thumb_width" and "thumb_height" can control the dimension of a thumbnail, leave them blank to use the originally uploaded picture.</p>

                <p>"gallery_name" is the groupname of a lightbox gallery e.g. in a loop.</p>

                <p>"class" CSS class for the link element.</p>

                <p>"id" CSS ID for the link element.</p>

                <p>"custom_attributes_a" custom attributes for the link element e.g. <i>data-link="test"</i>.</p>

                <p>"custom_attributes_img" custom attributes for the image element e.g. <i>data-hidpi-src="your-value"</i>.</p>

                <p>Here is an example with optional parameters:

                <p><code>&lt;?php sce_image( 20, array('thumb_width' =&gt; 250, 'thumb_height' =&gt; 150, 'gallery_name' =&gt; 'screenshots') ); ?&gt;</code></p>

                <h3>Image-Element-Generator</h3>
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

                    <a href="#" id="generate-image" class="button">Generate Image-Element</a>

                    <p id="image-element-output">

                    </p>
                </form>
            </div>
            <div class="content <?php echo (($active=='file')?'active':'') ?>" id="file">

                <h3>File-Element</h3>
                <p>The File element allows uploading of various files and automatically positions a download link in the front-end; the function is constructed as follows:</p>

                <p><code>&lt?php sce_file( <strong class="green">ID</strong>, <strong class="green">[options array]</strong> ); ?&gt;</code></p>

                <p>The ID must be a number and unique in the whole web page, except when you wish to output the same element with the same content at different locations.</p>

                <p>As alternative options, "target" and "class" can be set; in the case of options, they can be transferred to the normal HTML attributes target="" and class=""; here is an example:</p>

                <p><code>&lt;?php sce_file( 30, array('target' =&gt; '_blank', 'class' =&gt; 'sce_file_element') ); ?&gt;</code></p>

                <p>"target" link target e.g. "_blank".</p>

                <p>"class" CSS class for the link element.</p>

                <p>"id" CSS ID for the link element.</p>

                <p>"custom_attributes_a" custom attributes for the link element e.g. <i>data-link="test"</i>.</p>

                <h3>File-Element-Generator</h3>
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

                    <a href="#" id="generate-file" class="button">Generate File-Element</a>

                    <p id="file-element-output">

                    </p>
                </form>
            </div>
            <div class="content <?php echo (($active=='loop')?'active':'') ?>" id="loops">
                <h3>Snippets for the Loop-Function</h3>

                <p>The Loop function allows repetition and new creation of certain functions, for example for image galleries or news pages. The structure is as follows:</p>

                <p>Start a Loop with this code before your elements:<br />
                <code>
                    &lt;?php sce_loopInit(<strong class="green">ID</strong>); while(sce_loopController()){sce_loopStart(); ?&gt;
                </code>
                And change the placeholder <strong class="green">ID</strong> with a numeric value (ID) for this loop.
                </p>

                <p>Every Loop must be closed with the following code:<br />
                <code>&lt;?php sce_loopStop();} ?&gt;</code></p>

                <h3>Example</h3>
                <p><code>
                        &lt;?php sce_loopInit(<strong class="green">10</strong>); while(sce_loopController()){sce_loopStart(); ?&gt;<br />

                        &nbsp;&nbsp;&nbsp;&nbsp;&lt;?php sce_image(<strong class="green">15</strong>); ?&gt;<br />

                        &lt;?php sce_loopStop();} ?&gt;
                </code></p>
            </div>
        </div>
    </div>
</div>