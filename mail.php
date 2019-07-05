<?php
  
require_once 'vendor/autoload.php';

$transport = new Swift_SendmailTransport('/usr/sbin/sendmail -bs');
$transport = new Swift_SmtpTransport('127.0.0.1', 25);
$mailer = new Swift_Mailer($transport);

$from = isset($argv[1]) ? trim($argv[1]) : die();
$to = isset($argv[2]) ? trim($argv[2]) : die();

$subject = isset($argv[3]) ? reMsg(trim($argv[3])) : '';
$msg = isset($argv[4]) ? reMsg(trim($argv[4])) : '';
$message = (new Swift_Message($subject))
  ->setFrom($from)
  ->setTo($to)
  ->setBody($msg)
  ;

// Send the message
$result = $mailer->send($message);

function reMsg($msg){
    if(preg_match_all('/date\([\'"](.*)[\'"]\)/iu', $msg, $output_array)){ 
        foreach($output_array[0] as $key => $val){
            eval("\$date = ".$val.';');
            $msg = str_replace($output_array[0][$key], $date ,$msg);
        }            
    }
    return $msg;
}