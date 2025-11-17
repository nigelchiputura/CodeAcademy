<?php

require ('../../vendor/autoload.php');
use Twilio\Rest\Client;

// Twilio config
$twilioSid    = "";
$twilioToken  = "";       
$twilioNumber = "";

// Twilio config
const TWILIO_SID = "";
const TWILIO_TOKEN  = "";       
const TWILIO_NUMBER = ""; 

$twilio = new Client($twilioSid, $twilioToken);
