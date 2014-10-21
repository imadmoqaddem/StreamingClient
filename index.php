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

$enstreaming = 'http://enstreaming.com/film-'.$id.'.html';
//{"clip":{"titleHeader":"Ar-S1E01-Vostfr","autoPlay":true,"downloadUrl":"http:\/\/www.purevid.com\/?m=download&id=992RTX538yz2PKP9EEQWTz716273","websiteLink":"http:\/\/www.purevid.com\/v\/992RTX538yz2PKP9EEQWTz716273\/","scaling":"fit","autoBuffering":true,"bufferLength":1,"bitrates":[{"url":"http:\/\/str9.purevid.com\/get\/39dcf78c45b508d18aac4bc8920568c6\/54445506\/raid1\/videos\/0\/13\/1358400\/1358400.flv","bitrate":"360","title":"360p","premium":false,"isSd":true}],"linkUrl":"http:\/\/www.purevid.com\/v\/992RTX538yz2PKP9EEQWTz716273\/","linkWindow":"_blank","embed":"

$purevid_output = substr($purevid_output, 0, strpos($purevid_output, '"embed":"')
		+ 9);
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
curl_setopt($curl, CURLOPT_COOKIE, '__cfduid=d465b65186780f2e30fbe22cfb561d0411413762473519; PHPSESSID=jie9q89lloarg854cn2bcrnc43; __atuvc=2%7C43; enstreaming=vartest; __asc=da1deca41492acf784e62f46c6f; __auc=da1deca41492acf784e62f46c6f; __utma=175113462.1817969435.1413762475.1413762475.1413762475.1; __utmb=175113462.5.10.1413762475; __utmc=175113462; __utmz=175113462.1413762475.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)');
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
