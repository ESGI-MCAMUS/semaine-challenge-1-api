<?php

namespace App\Service;

use App\Entity\User;
use GuzzleHttp\Client;

class SendinblueMailer {

  public function __construct() {
  }

  public function sendEmail(User $to, array $params = []): void {

    $client = new Client();

    $headers = [
      'api-key' => $_ENV['MAILER_API'],
      'Content-Type' => 'application/json',
      'accept' => 'application/json'
    ];

    $body = json_encode([
      'to' =>
      array([
        'name' => $to->getFirstname() . ' ' . $to->getLastname(),
        'email' => $to->getEmail()
      ]),
      'templateId' => 5,
      'params' => $params
    ]);

    $response = $client->request('POST', 'https://api.sendinblue.com/v3/smtp/email', [
      'headers' => $headers,
      'body' => $body
    ]);
  }
}