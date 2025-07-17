<?php
$name= $_POST['name'];
$phone= $_POST['phone'];
$emailHelp= $_POST['email'];
$comments=$_POST['comments'];

if(isset($name) && isset($phone) && isset($emailHelp))
{
	global $to_email,$vpb_message_body,$headers;
	$to_email="rmayra2010@gmail.com";
	// $email_subject="Inquiry From Contact Page";
	$vpb_message_body = nl2br("Dear Admin,\n
	The user whose detail is shown below has sent this message from ".$_SERVER['HTTP_HOST']." dated ".date('d-m-Y').".\n
	
	name: ".$name."\n
	Email Address: ".$emailHelp."\n
    Phone: ".$phone."\n

	Message: ".$comments."\n
	User Ip:".getHostByName(getHostName())."\n
	Thank You!\n\n");
	
	//Set up the email headers
    $headers    = "From: $name <$emailHelp>\r\n";
    $headers   .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers   .= "Message-ID: <".time().rand(1,1000)."@".$_SERVER['SERVER_NAME'].">". "\r\n"; 
   
	 if(@mail($to_email, $vpb_message_body, $headers))
		{
			  $status='Success';
			//Displays the success message when email message is sent
			  $output="Felicidades ".$name.", tu mensaje se ha envidado correctamennte! Pronto nos comunicaremos contigo.";
		} 
		else 
		{
			 $status='error';
			 //Displays an error message when email sending fails
			  $output="Lo siento, el mensaje no se puede enviar en estos momentos. Intenta de nuevo, gracias";
		}
		
}
else{

	echo $name;
	$status='error';
	$output="please fill require fields";
	
	}
echo json_encode(array('status'=> $status, 'msg'=>$output));


?>