<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/../vendor/autoload.php";

class Mailer{

    public function mailer($setTo, $message, $subject){
        // Create the Transport
        $transport = (new Swift_SmtpTransport('mail.calybe.com', 45))
          ->setUsername('kospoamela@calybe.com')
          ->setPassword('N;F8z}^26-K{')
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message($subject))
          ->setFrom(['kospoamela@calybe.com' => 'Amela Kospo'])
          ->setTo([$setTo])
          ->setBody($message)
          ;

        // Send the message
        $result = $mailer->send($message);

        print_r($result);
    }
}
?>
