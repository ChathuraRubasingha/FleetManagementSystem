<?php

Yii::import('ext.jqAutocomplete');

$json_options = array(
	'script'=> $this->createUrl('test/json',array('json'=>'true','limit'=>6)) . '&',
	'varName'=>'input',
	'shownoresults'=>true,
	'maxresults'=>16,
	'callback'=>'js:function(obj){ $(\'#json_info\').html(\'you have selected: \'+obj.id + \' \' + obj.value + \' (\' + obj.info + \')\'); }'	
);
jqAutocomplete::addAutocomplete('#test_json',$json_options);

/*

// comment out (and comment the one above) to test XML
$xml_options = array(
	'script'=> $this->createUrl('test/xml',array('limit'=>6)) . '&',
	'varName'=>'input',
	'json' => false,
	'shownoresults'=>true,
	'maxresults'=>16,
	'callback'=>'js:function(obj){ $(\'#xml_info\').html(\'you have selected: \'+obj.id + \' \' + obj.value + \' (\' + obj.info + \')\'); }'	
);

jqAutocomplete::addAutocomplete('#test_xml',$xml_options); */