<?php
$xv_texts_hp_config = HTMLPurifier_Config::createDefault();
$xv_texts_hp_config->set('Attr.EnableID', true);
$xv_texts_hp_config->set('HTML.Doctype', 'XHTML 1.1');
$xv_texts_hp_config->set('HTML.TidyLevel', 'heavy');
$xv_texts_hp_config->set('Core.Encoding', 'UTF-8');
$xv_texts_hp_config->set('Attr.IDPrefix', 'texts_');
$xv_texts_hp_config->set('HTML.TargetBlank', true);
$xv_texts_hp_config->set('HTML.SafeIframe', true);
$xv_texts_hp_config->set('URI.SafeIframeRegexp','%^(http|https|ftp)://(www\.|)(youtube.com/embed/|player.vimeo.com/video/|dailymotion.com/embed/)%');
//$xv_texts_hp_config->set('AutoFormat.Linkify', true);

$def = $xv_texts_hp_config->getHTMLDefinition(true);
$def->addAttribute('a', 'target', new HTMLPurifier_AttrDef_Enum(
  array('_blank')
));

