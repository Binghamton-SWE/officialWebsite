<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}

$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$visitor_email = $_POST['visitor email'];
$message = $_POST['subject'];
//Validate names
if(empty($first_name)){
	echo "Error: please enter a first name";
	exit;
}
if(empty($last_name)){
	echo "Error: please enter a last name";
	exit;
}
if(empty($visitor_email)){
	echo "Error: please enter an email";
	exit;
}
if(empty($message)){
	echo "Error: please enter a message";
	exit;
}
//Check for injection
if(IsInjected($visitor_email)){
	echo "Bad email value!";
	exit;
}

//Email information
$email_from = "swe@binghamtonsa.org";
$email_subject = "Website Form Submission";
$email_body = "You have recieved a new message from $first_name $last_name.\n".
					"Here is the message: \n $subject".
//Send email
$to = "swe@binghamtonsa.org";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
mail($to,$email_subject,$email_body,$headers);
//Done - echo verification message
echo "You message was successfully sent";

//Function to check if email is injected (avoid spam emails)
function IsInjected($str)
{
	$injections = array('(n+)',
	       '(\r+)',
           '(\t+)',
           '(%0A+)',
           '(%0D+)',
           '(%08+)',
           '(%09+)'
		   );
	$inject = join('+',$injections);
	$inject = "/$inject/i";
	
	if(preg_match($inject,$str))
	{
		return true;
	}
	else
	{
		return false;
	}
}


?>

	
	