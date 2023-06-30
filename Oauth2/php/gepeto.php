<?php

// Configurações do aplicativo
$client_id = '261472416577338';
$client_secret = '1659b9f57718e77dc75668cf49422783';
$redirect_uri = 'http://localhost/sites/Desenvolvimento-ACAM/Oauth2/';

// URL de autorização do Instagram
$authorization_url = 'https://api.instagram.com/oauth/authorize';

// Verifique se o código de autorização está presente na URL de retorno
if (isset($_GET['code'])) {
    // Obtendo o código de autorização
    $code = $_GET['code'];

    // Parâmetros para obter o token de acesso
    $token_params = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'authorization_code',
        'redirect_uri' => $redirect_uri,
        'code' => $code
    );

    // URL para obter o token de acesso
    $token_url = 'https://api.instagram.com/oauth/access_token';

    // Realizando uma solicitação POST para obter o token de acesso
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decodificando a resposta JSON
    $token_data = json_decode($response, true);

    // Verificando se o token de acesso foi obtido com sucesso
    if (isset($token_data['access_token'])) {
        // Token de acesso obtido com sucesso
        $access_token = $token_data['access_token'];
        echo "Token de acesso: " . $access_token;
    } else {
        // Erro ao obter o token de acesso
        echo "Erro ao obter o token de acesso.";
    }
} else {
    // Redirecionando o usuário para a página de autorização do Instagram
    $authorization_params = array(
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'response_type' => 'code'
    );

    $authorization_url .= '?' . http_build_query($authorization_params);
    header('Location: ' . $authorization_url);
    exit();
}
