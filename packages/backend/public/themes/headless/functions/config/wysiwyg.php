<?php

/* Custom WYSIWYG Toolbar */
function custom_acf_wysiwyg_toolbar($toolbars)
{

    $toolbars['Basic'] = array();
    $toolbars['Basic'][1] = array('link', 'unlink');
    $toolbars['Advanced'] = array();
    $toolbars['Advanced'][1] = array('link', 'unlink', 'bullist', 'formatselect');

    if (($key = array_search('code', $toolbars['Full'][2])) !== false) {
        unset($toolbars['Full'][2][$key]);
    }

    return $toolbars;
}

function custom_acf_wysiwyg_formats($settings)
{
    $settings['block_formats'] = 'Paragraph=p; Headline=h3;';
    $settings['wpautop'] = false;
    $settings['toolbar1'] = false;
    $settings['keep_styles'] = true;
    return $settings;
}

/* Clean Copy & Paste */
function configure_tinymce($in)
{
    $in['paste_preprocess'] = "function(plugin, args){
    // Strip all HTML tags except those we have whitelisted
    var whitelist = 'a,p,span,br,ul,li,h3';
    var stripped = jQuery('<div>' + args.content + '</div>');
    var els = stripped.find('*').not(whitelist);
    for (var i = els.length - 1; i >= 0; i--) {
    var e = els[i];
    jQuery(e).replaceWith(e.innerHTML);
    }
    // Strip all class and id attributes
    stripped.find('*').removeAttr('id').removeAttr('class');
    // Return the clean HTML
    args.content = stripped.html();
    }";
    return $in;
}


add_theme_support('editor-styles');
add_editor_style('/assets/css/editor.css');

/* Filters
---------------------------------------*/
add_filter('acf/fields/wysiwyg/toolbars', 'custom_acf_wysiwyg_toolbar');
add_filter('tiny_mce_before_init', 'custom_acf_wysiwyg_formats');
add_filter('tiny_mce_before_init', 'configure_tinymce');
