<?php

namespace App\Service;

use App\Entity\User;
use GuzzleHttp\Client;

class SendinblueMailer {

  public function __construct() {
  }

  public function sendEmail(User $to, array $params = []): void {
    $client = new Client();

    if (strpos($to->getEmail(), '@example.com') === false) {
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
        'templateId' => 1,
        'params' => $params
      ]);

      $response = $client->request('POST', 'https://api.sendinblue.com/v3/smtp/email', [
        'headers' => $headers,
        'body' => $body
      ]);
    } else {
      return;
    }
  }

  public function sendResetPasswordEmail(User $to, array $params = []): void {

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
      'templateId' => 2,
      'params' => $params
    ]);

    $response = $client->request('POST', 'https://api.sendinblue.com/v3/smtp/email', [
      'headers' => $headers,
      'body' => $body
    ]);
  }
}
