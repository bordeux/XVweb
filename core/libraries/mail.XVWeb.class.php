<?php
class AttachmentEmail {
	private $from = 'yours@email.com';
	private $from_name = 'Your Name';
	private $reply_to = 'yours@email.com';
	private $to = '';
	private $subject = '';
	private $message = '';
	private $attachment = array();
	private $attachment_filename = '';

	public function __construct($to, $subject, $message, $attachment = '', $attachment_filename = '') {
		$this -> to = $to;
		$this -> subject = $subject;
		$this -> message = $message;
		$this -> attachment = $attachment;
		$this -> attachment_filename = $attachment_filename;
	}

	public function mail() {
		$mailto = $this -> to;
		$from_mail = $this -> from;
		$from_name = $this -> from_name;
		$replyto = $this -> reply_to;
		$subject = $this -> subject;
		$message = $this -> message;


		$uid = md5(uniqid(time()));
		$name = basename($file);
		$header = "From: ".$from_name." <".$from_mail.">\r\n";
		$header .= "Reply-To: ".$replyto."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-type:text/html; charset=utf-8\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $message."\r\n\r\n";
		if (!empty($this -> attachment)) {
			foreach($this -> attachment as $fileInfo){
				$filename = empty($fileInfo['name']) ? basename($fileInfo['path']) : $fileInfo['name'] ;
				$path = dirname($fileInfo['path']);
				$file = $path.'/'.$filename;
				$file_size = filesize($file);
				$content = file_get_contents($file);
				$content = chunk_split(base64_encode($content));
				$header .= "--".$uid."\r\n";
				$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use diff. tyoes here
				$header .= "Content-Transfer-Encoding: base64\r\n";
				$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
				$header .= $content."\r\n\r\n";
				$header .= "--".$uid."--";
			}
			if (mail($mailto, $subject, "", $header)) {
				return true;
			} else {
				return false;
			}
		}else {
			$header = "From: ".($this -> from_name)." <".($this -> from).">\r\n";
			$header .= "Reply-To: ".($this -> reply_to)."\r\n";

			if (mail($this -> to, $this -> subject, $this -> message, $header)) {
				return true;
			} else {
				return false;
			}

		}
	}
}

class MailClass
{
	public function __construct() {
		$GLOBALS['Debug']['Classes'][] = array("ClassName"=>get_class(), "File"=>__FILE__, "Time"=>microtime(true), "MemoryUsage"=>memory_get_usage());
	}
	public function mail($do, $temat, $text, $headers="Content-type: text/html; charset=utf-8;",$files= array()) {
		if(!$this->mail_attachment($do, $temat, $text, $headers,$files)){
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'phpmailer'.DIRECTORY_SEPARATOR.'class.phpmailer.php');

			try {
				$mail = new PHPMailer(true); //New instance, with exceptions enabled
				$body             = $text;
				$body             = preg_replace('/\\\\/','', $body); //Strip backslashes
				$mail->IsSMTP();                           // tell the class to use SMTP
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Port       = 587;                    // set the SMTP server port
				$mail->Host       = "smtp.gmail.com"; // SMTP server
				$mail->Username   = "xvwebp@bordeux.net";     // SMTP server username
				$mail->Password   = "polska";            // SMTP server password
				$mail->CharSet = "UTF-8";
				//$mail->IsSendmail();  // tell the class to use Sendmail

				$mail->AddReplyTo($do,"First Last");

				$mail->From       = $mail->Username;
				$mail->FromName   = "XVweb";

				$to = $do;
				foreach( $files as $data)
				$mail->AddAttachment($data['path']); 
				
				$mail->AddAddress($to);

				$mail->Subject  = $temat;

				$mail->WordWrap   = 80; // set word wrap

				$mail->MsgHTML($body);

				$mail->IsHTML(true); // send as HTML

				$mail->Send();
				return true;
			} catch (phpmailerException $e) {
				echo $e->errorMessage();
				exit;
			}
			
		}
	}
	public function mail_attachment($to,$subject,$message,$headers='Content-type: text/html; charset=utf-8',$files=null ){
		if(empty($files)){
			return mail($to,$subject,$message,$headers);
		}
		
		$sendit = new AttachmentEmail($to, $subject, $message, $files);
		return $sendit -> mail();
	}

}

?>