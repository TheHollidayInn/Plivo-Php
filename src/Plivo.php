<?php
namespace Plivo;

class Plivo {
  private $authID;
  private $authToken;
  private $srcPhone;
  private $apiBaseUrl;

  public function __construct($authID, $authToken, $srcPhone) {
    $this->authID = $authID;
    $this->authToken = $authToken;
    $this->srcPhone = $srcPhone;
    $this->apiBaseUrl = 'https://api.plivo.com/v1/Account/'.$this->authID;
  }

  public function call($endPoint, $data = array(), $method = "GET")
  {
    $data_string = json_encode($data);

    $url = $this->apiBaseUrl . $endPoint;

    if ($method == "GET") {
      $params = http_build_query($data);
      $url .= '?' . $params;
    }

  	$ch = curl_init($url);

    if ($method == "POST") {
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    }

  	curl_setopt($ch, CURLOPT_HEADER, true);
  	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
  	curl_setopt($ch, CURLOPT_USERPWD, $this->authID . ":" . $this->authToken);
  	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  	$response = curl_exec($ch);
  	curl_close($ch);

    return $response;
  }

  public function setSrcPhone($phoneNumber)
  {
    $this->srcPhone = $phoneNumber;
  }

  function sendMessage($phoneNumbers, $text)
  {
  	$dst = implode("<", $phoneNumbers);

  	$data = array(
      "src" => "$this->srcPhone",
      "dst" => "$dst",
      "text" => "$text"
    );

    return $this->call('/Message/', $data, "POST");
  }

  function getSentMessages($limit = 100, $offset = 0, $direction = 'outbound')
  {
    $data = array(
      'limit' => $limit,
      'offset' => $offset,
      'message_direction ' => $direction,
      // 'message_state' => 'delivered' // The direction of the message to be fltered
    );

    return $this->call('/Message/', $data);
  }
}


 ?>
