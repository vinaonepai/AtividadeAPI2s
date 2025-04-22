<?php
 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;        
use Slim\Exception\HttpNotFoundException;
use ViniCavilha\Tarefas\service\TarefasService;
use ViniCavilha\Tarefas\Math\Basic;
 
require __DIR__ . '/vendor/autoload.php';
 
$app = AppFactory::create();
 
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});
 
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write('{"error": "Recurso não foi encontrado"}');
    return $response->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
});
 
$app->get('/tarefas', function (Request $request, Response $response, array $args){
    $tarefas_service = new TarefasService();
    $tarefas = $tarefas_service->getAllTarefas();
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');
});
 
$app->post('/tarefas', function(Request $request, Response $response, array $args){
if (!array_key_exists('titulo', $args) || empty($args['titulo'])){
    $response->getBody()->write(json_encode([
        "mensagem" => "título é obrigatorio"
    ]));
    return $response->withHeader('Content-type', 'application/json')->withStatus(400);
}
    $tarefa = array_merge(['titulo' => '', 'concluido' => false], $parametros);
    $tarefas_service = new TarefaService();
    $tarefas_service->createTarefa($tarefa);
 
    return $response->withStatus(201);
});
 
$app->delete('/tarefas', function(Request $request, Response $response, array $args){
});
 
$app->put('/tarefas', function(Request $request, Response $response, array $args){
    $id= $args['id'];
    $dados_para_atualizar = json_decode($request->getBody()->getContents(), true);
    if(array_key_exists('titulo', $dados_para_atualizar) && empty($dadps_para_atualizar['titulo'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "título é obrigatório"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    $tarefa_service = new TarefaService();
    $tarefa_service->updateTarefa($id,$dados_para_atualizar);
 
    return $response->withStatus(201);
});

$app->get("/math/soma/{num1}/{num2}", function(Request $request, Response $response, array $args) {
    $basic = new Basic();
    $resultado = $basic->soma($args['num1'], $args['num2']);
    $response->getBody()->write ((string) $resultado);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();