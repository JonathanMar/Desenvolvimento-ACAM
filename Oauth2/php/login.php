<?
ob_start();

require __DIR__ . "vendor/autoload.php";

define("FACEBOOK", [
    "app_id" => "261472416577338",
    "app_secret" => "1659b9f57718e77dc75668cf49422783",
    "app_redirect" => "http://localhost/sites/Desenvolvimento-ACAM/Oauth2/",
    "app_version" => "v17.0"
]);


if (empty($_SESSION["userLogin"])){
    $facebook = new \League\OAuth2\Client\Provider\Facebook([
            "clientId" => FACEBOOK["app_id"],
            "clientSecret" => FACEBOOK["app_secret"],
            "redirectUri" => FACEBOOK["app_redirect"],
            "graphApiVersion" => FACEBOOK["graphApiVersion"]
        ]);

        $authUrl = $facebook->getAuthorizationUrl([
            "scope" => ["email"]
        ]);

        echo "<a title='FB login' href='{$authUrl}'>Facebook Login</a>";
}


ob_end_flush();
  