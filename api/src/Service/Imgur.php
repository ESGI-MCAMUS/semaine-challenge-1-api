<?php

namespace App\Service;

class Imgur {
  private $client;
  public function __construct() {
    $this->client = new \Imgur\Client();
    $this->client->setOption('client_id', $_SERVER['IMGUR_CLIENT_ID']);
    $this->client->setOption('client_secret', $_SERVER['IMGUR_CLIENT_SECRET']);
  }

  public function upload($image) {
    $image = $this->client->api('image')->upload([
      'image' => $image,
      'type' => 'base64',
    ]);
    return $image["link"];
  }
}
