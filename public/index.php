<?php 

require_once __DIR__."/../vendor/autoload.php";

use App\Core\Application;

$app = new Application(dirname(__DIR__));

$app->router->get("/", 'home');

$app->router->get("/cep/{cep}", function($cep){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://viacep.com.br/ws/$cep[0]/json");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    echo "<pre>";
    echo(curl_exec($curl));
    echo "</pre>";
    curl_close($curl);
});

$app->router->get("/{cep}", function(){
    return "Handling cep";
});

$app->router->post("/contact", function(){
    return "Handling post";
});

$app->router->post("/contact/teste", function(){
    return "Handling post";
});

$app->run();

?>