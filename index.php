<?php
session_start();

require __DIR__ . '../vendor/autoload.php';

$provider = new \League\OAuth2\Client\Provider\Facebook([
    'clientId'          => '261472416577338',
    'clientSecret'      => '1659b9f57718e77dc75668cf49422783',
    'redirectUri'       => 'http://localhost/sites/Desenvolvimento-ACAM/',
    'graphApiVersion'   => 'v2.10',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl([
        'scope' => ['email'],
    ]);
    $_SESSION['oauth2state'] = $provider->getState();
    
    echo '<a href="'.$authUrl.'">Log in with Facebook!</a>';
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    echo 'Invalid state.';
    exit;

}

// Try to get an access token (using the authorization code grant)
$token = $provider->getAccessToken('authorization_code', [
    'code' => $_GET['code']
]);

// Optional: Now you have a token you can look up a users profile data
try {

    // We got an access token, let's now get the user's details
    $user = $provider->getResourceOwner($token);

    // Mostra a imagem do Usuário
    echo "<img width='120' alt='' src='{$user->getPictureUrl()}'/>";

    // Mostra o nome do usuário
    echo "<h2>Você está logado(a) como {$user->getFirstName()}</h1>";

    // echo('Hello %s!', $user->getFirstName());
    
    echo '<pre>';
    var_dump($user);
    # object(League\OAuth2\Client\Provider\FacebookUser)#10 (1) { ...
    echo '</pre>';

} catch (\Exception $e) {

    // Failed to get user details
    exit('Oh dear...');
}

echo '<pre>';
// Use this to interact with an API on the users behalf
var_dump($token->getToken());
# string(217) "CAADAppfn3msBAI7tZBLWg...

// The time (in epoch time) when an access token will expire
var_dump($token->getExpires());
# int(1436825866)
echo '</pre>';

ob_end_flush();