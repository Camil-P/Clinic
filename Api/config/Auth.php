<?php

function authorize($writeDB)
{
  if (!isset($_SERVER['HTTP_AUTHORIZATION']) || strlen($_SERVER['HTTP_AUTHORIZATION']) < 1) {
    $response = new Response(false, 401);
    $response->addMessage("Authorization is missing from the header.");
    $response->send();
    exit();
  }

  try {

    $accessToken = $_SERVER['HTTP_AUTHORIZATION'];

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
