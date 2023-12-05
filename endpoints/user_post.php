<?php

function api_user_post($request) {
  $email = sanitize_email($request['email']);
  $username = sanitize_text_field($request['username']);
  $password = $request['password'];

  if (empty($email) || empty($username) || empty($password)) {
    $response = new WP_Error('error', 'Dados incompletos', ['status' => 406]);
    return rest_ensure_response($response);
  }

  if (username_exists($username) || email_exists($email)) {
    $response = new WP_Error('error', 'Email já cadastrado', ['status' => 403]);
    return rest_ensure_response($response);
  }

  $response = wp_insert_user([
    'user_login' => $username,
    'user_email' => $email,
    'user_pass' => $password,
    'role' => 'subscriber',
  ]);

  // retorna uma função que garante que a response sempre seja no formato rest
  return rest_ensure_response($response);
}

function register_api_user_post() {
  // funçao do wp que registra as rotas
  // primeiro argumento é a base da api, é bem comum ter v1, para quando tiver atualizações
  // o segundo argumento é o endpoint da api
  // por ultimo é uma array com as opções dessa rota
  register_rest_route('v1', '/user', [
    'methods' => WP_REST_Server::CREATABLE,
    'callback' => 'api_user_post',
  ]);
}
add_action('rest_api_init', 'register_api_user_post');

?>