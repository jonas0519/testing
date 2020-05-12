<?php
/**
 * Implements hook_form_alter().
 */
use Drupal\Core\Url;

function login_redirect_user_login($account) {
  // We want to redirect user on login.
  //$response = new RedirectResponse("localhost/user/{%}"); //go to user page
  $url =  \Drupal\Core\Url::fromRoute('/node'); // go to front page
  $response = new RedirectResponse($url->toString());
  $response->send();
  return;
} 
