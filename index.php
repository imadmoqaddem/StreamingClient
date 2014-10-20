<?php

$url = 'http://www.purevid.com/v/' . $_GET['id'];
$id_ = explode('/', $url);
$id = $id_[count($id_) - 1];
$id = empty($id) ? $id_[count($id_) - 2] : $id;

$purevid = 'http://www.purevid.com/?m=video_info_embed_flv&id='.$id;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $purevid);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$purevid_output = curl_exec($curl);
curl_close($curl);

$enstreaming = 'http://enstreaming.com/film-'.$id.'.html';
$curl = curl_init();


$purevid_output = substr($purevid_output, 0, strpos($purevid_output, '"embed":"')
		+ 6);
$fields = array(
		'id' => urlencode($purevid_output)
);

$fields_string = '';
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

curl_setopt($curl, CURLOPT_URL, $enstreaming);
curl_setopt($curl, CURLOPT_POST, $fields_string);
curl_setopt($curl, CURLOPT_POSTFIELDS, count($fields));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$enstreaming_output = curl_exec($curl);
curl_close($curl);


?>
<html>
<head>
<title>PHP Streaming Client</title>
</head>
<body>

<?= $enstreaming_output ?>


</body>
<html>
