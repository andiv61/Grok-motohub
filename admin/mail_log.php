<?php
function logMail($to, $subject, $success) {
    $log = date('Y-m-d H:i:s') . " | To: $to | Subject: $subject | Status: " . 
          ($success ? 'SUCCESS' : 'FAILED') . PHP_EOL;
    file_put_contents('mail.log', $log, FILE_APPEND);
}