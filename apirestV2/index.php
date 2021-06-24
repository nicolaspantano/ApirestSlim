<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
/*require './clases/accesodatos.php';
require '/clases/usuario.php';
require '/clases/verificadora.php';*/

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);


//implementar...

$app->group('/credenciales',function () {

    //EN LA RAIZ DEL GRUPO
    $this->get('[/]', function (Request $request, Response $response) {        
      return $response->getBody()->write("<br>API => GET</br>");
    });
  
    $this->post('[/]', function (Request $request, Response $response) {
      return $response->getBody()->write("<br>API => POST</br>");
    });

})->add(function($request, $response, $next){
    if($request->isGet()) 
    {      
      $response->getBody()->write('<br>NO necesita credenciales por get<br>');                                    
    }
    else if($request->isPost())
    {
        $ArrayDeParametros = $request->getParsedBody();
        $nombre = $ArrayDeParametros["nombre"];
        $perfil = $ArrayDeParametros["perfil"];
        $response->getBody()->write('<br>Verifico credenciales<br>');             
        if($perfil=="administrador"){
            $response->getBody()->write("Bienvenido ". $nombre);
        }
        else{
            $response->getBody()->write(("<br>No tienes habilitado el ingreso<br>"));
        }           
    }

    $response = $next($request, $response);
    $response->getBody()->write('<br>Vuelvo del verificador de credenciales<br>');

    return $response;
});


$app->group('/json',function () {

    //EN LA RAIZ DEL GRUPO
    $this->get('[/]', function (Request $request, Response $response) {
        $mensaje="API => GET";        
      return $response->getBody()->write("<br>".json_encode($mensaje)."</br>");
    });
  
    $this->post('[/]', function (Request $request, Response $response) {
      return $response->getBody()->write("<br>API => POST</br>");
    });

})->add(function($request, $response, $next){

    if($request->isGet()) 
    {      
      $response->getBody()->write('<br>{"GET:200}<br>');                                    
    }
    else if($request->isPost())
    {
        $ArrayDeParametros = $request->getParsedBody();
        $obj_json = $ArrayDeParametros["obj_json"];
        $obj=json_decode($obj_json);

        $response->getBody()->write('<br>Verifico credenciales<br>');             
        if($obj->perfil=="administrador"){
            $response->getBody()->write("Bienvenido ". $obj->nombre);
        }
        else{
            $response->getBody()->write(("<br>No tienes habilitado el ingreso<br>"));
        }           
    }

    $response = $next($request, $response);
    $response->getBody()->write('<br>Vuelvo del verificador de credenciales<br>');

    return $response;

});

$app->run();