<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');
$channelAccessToken = 'rGLmU7kWFFSW7+2K64LofStlXbOkKPE0ahpWAzt/qIjBpKhhgC6ViTRCNJyN2Iv8GBuBmzPncbsmrDGP7SH0SFiNE+KZ3texYrirn4/4pnIefVgNEpSJIo0oko2rqJmOg0/+8VX/AIn4ZQEhzuNNBgdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$channelSecret = '5f6a60f6771c29b326a998965f391580';//sesuaikan

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];
if ($type == 'join') {
    $text = "Makasih dh invite aku ke grup";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                {
  "type": "template",
  "altText": "this is a buttons template",
  "template": {
    "type": "buttons",
    "actions": [
      {
        "type": "message",
        "label": "halo",
        "text": "halo"
      },
      {
        "type": "message",
        "label": "apa",
        "text": "apa"
      },
      {
        "type": "message",
        "label": "iya",
        "text": "iya"
      },
      {
        "type": "message",
        "label": "aku",
        "text": "aku"
      }
    ],
    "thumbnailImageUrl": "https://2.bp.blogspot.com/-EMlQ3W8S3a8/WN_anZgsvmI/AAAAAAAOWEo/UHPk_0VTQUcxpa6N-DZuDSj-gonRFP6SgCLcB/s1600/AW401668_01.gif",
    "title": "kontol",
    "text": "andri"
  }
		}
}
if($message['type']=='contact')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'siapa itu'										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'f1830f11-af68-49ef-bbc8-c4308cbf4d20'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf '.$profil->displayName.' lagi puasa chat.'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);
file_put_contents('./reply.json',$result);
$client->replyMessage($balas);
