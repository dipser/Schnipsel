<?php


function Email($remail, $rname, $semail, $sname, $cc, $bcc, $subject, $message, $attachments, $priority, $type)  {

// Checks if carbon copy & blind carbon copy exist
if($cc != null){$cc="CC: ".$cc."\r\n";}else{$cc="";}
if($bcc != null){$bcc="BCC: ".$bcc."\r\n";}else{$bcc="";}

// Checks the importance of the email
if($priority == "high"){$priority = "X-Priority: 1\r\nX-MSMail-Priority: High\r\nImportance: High\r\n";}
elseif($priority == "low"){$priority = "X-Priority: 3\r\nX-MSMail-Priority: Low\r\nImportance: Low\r\n";}
else{$priority = "";}

// Checks if it is plain text or HTML
if($type == "plain"){$type="text/plain";}else{$type="text/html";}

// The boundary is set up to separate the segments of the MIME email
$boundary = md5(@date("Y-m-d-g:ia"));

// The header includes most of the message details, such as from, cc, bcc, priority etc. 
$header = "From: ".$sname." <".$semail.">\r\nMIME-Version: 1.0\r\nX-Mailer: PHP\r\nReply-To: ".$sname." <".$semail.">\r\nReturn-Path: ".$sname." <".$semail.">\r\n".$cc.$bcc.$priority."Content-Type: multipart/mixed; boundary = ".$boundary."\r\n\r\n";    
  
// The full message takes the message and turns it into base 64, this basically makes it readable at the recipients end
$fullmessage .= "--".$boundary."\r\nContent-Type: ".$type."; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n".chunk_split(base64_encode($message));

// A loop is set up for the attachments to be included.
if($attachments != null) {
  foreach ($attachments as $attachment)  {
    $attachment = explode(":", $attachment);
    $fullmessage .= "--".$boundary."\r\nContent-Type: ".$attachment[1]."; name=\"".$attachment[2]."\"\r\nContent-Transfer-Encoding: base64\r\nContent-Disposition: attachment\r\n\r\n".chunk_split(base64_encode(file_get_contents($attachment[0])));
  }
}

// And finally the end boundary to set the end of the message
$fullmessage .= "--".$boundary."--";

return mail($rname."<".$remail.">", $subject, $fullmessage, $header);
}






$docid_agb = 13680; // Allgemeine Geschäftsbedingungen
$docid_wrb = 13680; // Widerrufsbelehrung

$file_agb = $_SERVER['DOCUMENT_ROOT'].id_to_path($docid_agb);
$file_wrb = $_SERVER['DOCUMENT_ROOT'].id_to_path($docid_wrb);




$RecipientEmail = "sd@domain.de"; 
$RecipientName = "Joe Bloggs";
$SenderEmail = "fredbloggs@example.com"; 
$SenderName = "Fred Bloggs";
$subject = "lorem ipsum"; 
$cc = "";//
$bcc = "";//"johndoe@example.com";
$message = "<b>Sed urna odio, imperdiet a semper ut, fermentum ut tellus.</b> Quisque tempor venenatis quam, ut porttitor lacus pretium sit amet.";
$priority = "";
$attachments = array(
  $file_agb.':application/pdf:'.pathinfo($file_agb, PATHINFO_BASENAME),
  $file_wrb.':application/pdf:'.pathinfo($file_wrb, PATHINFO_BASENAME)
);
$files = array($file_agb, $file_wrb);
$type = "";

$sent = Email($RecipientEmail, // "name@domain.de"
              $RecipientName, // "Em Pfänger"
              $SenderEmail, // "sender@domain.de"
              $SenderName, // "Sen Der"
              $cc, // "alice@example.com, bob@example.com"; 
              $bcc, // "name@domain.de"
              $subject, 
              $message, 
              $attachments, // Array im Format: VollerPfad:MIMEType:EmailDateiname
              $priority, // "", "high", "low"
              $type // "plain" für text oder "" für html
);

echo $sent ? "It worked!!" : "It didn't work"; 



?>
