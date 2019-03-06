<?php
function gethttp_value($url){
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function sendingmail($subject,$address,$body,$replyto = "it@corphr.com|Indottech System", $attachments = "", $ccs = "") {
	require_once("phpmailer/class.phpmailer.php");
	include_once("phpmailer/class.smtp.php");
	$domain = explode("@",$address);

	$_server = 1;
	$config[1]["secure"] = "ssl";
	$config[1]["host"] = "webmail.corphr.com";
	$config[1]["port"] = 465;
	$config[1]["username"] = "mailer@corphr.com";
	$config[1]["password"] = "R2h2s12*R2h2s12*";
	
	$config[2]["secure"] = "ssl";
	$config[2]["host"] = "mail.corphr-nokia.com";
	$config[2]["port"] = 465;
	$config[2]["username"] = "faris@corphr-nokia.com";
	$config[2]["password"] = "R2h2s12*R2h2s12*";

	$mail             = new PHPMailer();
	$mail->IsSMTP(); 
	$mail->SMTPDebug  = 0;
	$mail->SMTPAuth   = true;
	$mail->SMTPSecure = $config[$_server]["secure"];
	$mail->Host       = $config[$_server]["host"];
	$mail->Port       = $config[$_server]["port"];
	$mail->Username   = $config[$_server]["username"];
	$mail->Password   = $config[$_server]["password"];

	$mail->SMTPKeepAlive = true;  
	$mail->Mailer = "smtp"; 
	$mail->CharSet = 'utf-8';  
	$arr_replyto = explode("|",$replyto);
	$mail->SetFrom($arr_replyto[0],$arr_replyto[1]);
	$mail->AddReplyTo($arr_replyto[0],$arr_replyto[1]);
	$mail->Subject    = $subject;
	
	if($ccs != ""){
		$_ccs = pipetoarray($ccs);
		$mail->AddCC($_ccs[0]);
		$mail->AddCC($_ccs[1]);
	}
	if($attachments != ""){
		$mail->addAttachment($attachments);
	}

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

	$mail->MsgHTML($body);

	$mail->AddAddress($address);

	if(!$mail->Send()) { return "0"; } else { return "1"; }
}
?>
