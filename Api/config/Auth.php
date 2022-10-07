<?php

function authorize($writeDB)
{
  $headers = apache_request_headers();
  if (!isset($headers['Authorization']) || strlen($headers['Authorization']) < 1) {
    $response = new Response(false, 401);
    $response->addMessage("Authorization is missing from the header.");
    $response->send();
    exit();
  }

  try {

    $accessToken = $headers['Authorization'];

    $query = $writeDB->prepare("SELECT 
                                UserId,
                                AccessTokenExpiry,
                                Role
                              FROM session
                              WHERE AccessToken = :accessToken");
    $query->bindParam(":accessToken", $accessToken, PDO::PARAM_INT);
    $query->execute();

    $rowCount = $query->rowCount();
    if ($rowCount === 0) {
      $response = new Response(false, 401);
      $response->addMessage("Invalid Access Token");
      $response->send();
      exit();
    }

    $row = $query->fetch(PDO::FETCH_ASSOC);

    $returnedUser = array();
    $returnedUser['id'] = $row['UserId'];
    $returnedAccessTokenExpiry = $row['AccessTokenExpiry'];
    $returnedUser['role'] = $row['Role'];

    if (strtotime($returnedAccessTokenExpiry) < time()) {
      $response = new Response(false, 401);
      $response->addMessage("Access Token Expired");
      $response->send();
      exit();
    }

    return $returnedUser;
  } catch (PDOException $ex) {
    $response = new Response(false, 500);
    $response->addMessage("There was an issue authenticating, please try again.");
    $response->send();
    exit();
  }
}
