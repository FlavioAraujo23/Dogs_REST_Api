<?php
// Remove as rotas definidas pelo WordPress
remove_action('rest_api_init', 'create_initial_rest_routes', 99);

// Modifica o prefixo da API de wp-json para json apenas
// Necessário salvar os permalinks para dar um refresh nos URL's
function change_api($slug) {
  return 'json';
}
add_filter('rest_url_prefix', 'change_api');
?>