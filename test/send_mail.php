<?php
	$strTo = "jaruwatpiew@hotmail.com";
	$strSubject = "Test Send Email";
	$strHeader = "From: Jaruwat-PC";
	$strMessage = "My Body & My Tinny";
	$flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //
	if($flgSend)
	{
		echo "Email Sending.";
	}
	else
	{
		echo "Email Can Not Send.";
	}
?>
