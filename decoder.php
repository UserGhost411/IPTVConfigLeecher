<?php
if($_GET['tv']=="metrotv"){$urlx = getvideobyid(777);}
if($_GET['tv']=="antv"){$urlx = getvideobyid(782);}
if($_GET['tv']=="transtv"){$urlx = getvideobyid(733);}
if($_GET['tv']=="kompastv"){$urlx = getvideobyid(874);}
if($_GET['tv']=="tvone"){$urlx = getvideobyid(783);}
if($_GET['tv']=="inews"){$urlx = getvideobyid(5409);}
if($_GET['tv']=="mnctv"){$urlx = getvideobyid(870);}
if($_GET['tv']=="trans7"){$urlx = getvideobyid(734);}
if($_GET['tv']=="sctv"){$urlx = getvideobyid(204);}
if($_GET['tv']=="rcti"){$urlx = getvideobyid(665);}
if($_GET['tv']=="tvri"){$urlx = getvideobyid(6441);}
if($_GET['tv']=="beritasatu"){$urlx = getvideobyid(6165);}
if($_GET['tv']=="globaltv"){$urlx = getvideobyid(778);}
if($_GET['tv']=="nettv"){$urlx = getvideobyid(875);}
if($_GET['tv']=="indosiar"){$urlx = getvideobyid(205);}
if($_GET['tv']=="ochannel"){$urlx = getvideobyid(206);}
if($_GET['tv']=="jtv"){$urlx = getcustomvideo("jtv");}
if($_GET['tv']=="fox2news"){$urlx = getcustomvideo("fox2news");}
if($_GET['tv']=="reformed21"){$urlx ="http://edge.linknetott.swiftserve.com/live/BsNew/amlst:reformedch/playlist.m3u8";}
if($_GET['tv']=="other"){$urlx = getvideobyid(34);}

if($_GET['tv']=="no"){$urlx ="http://api.ugserver.cf/tv/m3u8/index.m3u8";}
header("Location:$urlx");

function getcustomvideo($nam){
	if($nam=="jtv"){
	$apilink = "http://jtv.co.id/home.php?page=live-streaming";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$apilink);
	//curl_setopt($ch, CURLOPT_POST, 1);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, "");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	$info = curl_getinfo($ch);
	$httpcode =  $info["http_code"];
	curl_close ($ch);
	
	if($httpcode!=200){
		return "http://api.ugserver.cf/tv/m3u8/index.m3u8";
	}else{
		//return "http://api.ugserver.cf/tv/m3u8/index.m3u8";
		$url_b64 = (get_string_between($server_output,'<source type="application/x-mpegURL" src="','">')); 
		return $url_b64;
	}
	
	//return "http://122.248.43.138:1935/ch2/myStream/playlist.m3u";
	}
	if($nam=="fox2news"){
	$apilink = "https://player-api.new.livestream.com/accounts/2075940/events/1701970/stream_info";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$apilink);
	//curl_setopt($ch, CURLOPT_POST, 1);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, "");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = json_decode(curl_exec($ch),true);
	$info = curl_getinfo($ch);
	$httpcode =  $info["http_code"];
	curl_close ($ch);
	
	if($httpcode!=200){
		return "http://api.ugserver.cf/tv/m3u8/index.m3u8";
	}else{
		return $server_output['secure_m3u8_url'];
	}
	}
	if($nam=="hbo"){
		return "http://api.ugserver.cf/tv/m3u8/index.m3u8";
		return "http://iphone-streaming.ustream.tv/uhls/20481179/streams/live/iphone/playlist.m3u8";
	}
}
function getvideobyid($id){
$check = cek($id);
if($check){
return $check;
}
$apilink = "https://www.vidio.com/live/$id/tokens";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$apilink);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = json_decode(curl_exec($ch),true);
$info = curl_getinfo($ch);
$httpcode =  $info["http_code"];
curl_close ($ch);

if($httpcode!=200){
	return "http://api.ugserver.cf/tv/m3u8/index.m3u8";
}else{
	//if($id==206){return "https://app-etslive-2.vidio.com/live/geo_206/master.m3u8?".$server_output['token']; }
	return "https://app-etslive-2.vidio.com/live/$id/master.m3u8?".$server_output['token'];
}
}
 function cek($id){
	$jam = date("H");
	 if($id==782 && $jam<5){
		 return "http://api.ugserver.cf/tv/m3u8/index.m3u8";
	 }
	 return "";
 }
 function get_string_between($string, $start, $end){
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) {return "";}
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
  }
?>