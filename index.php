<?php 

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

require 'vendor/autoload.php';
include 'db.php';

$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,
	]
	]);

$container = $app->getContainer();
$container['renderer'] = new PhpRenderer("./templates");

$app->get('/', function (Request $request, Response $response){
    return $this->renderer->render($response, "/index.php");
	});
$app->get('/actividades/', function (Request $request, Response $response){
    return $this->renderer->render($response, "actividades.php");
	});
$app->get('/actividades/{name}', function ($request, $response, $args){
    return $this->renderer->render($response, "ver_actividad.php", array('nombre' =>$args['name'] ));
	});
$app->get('/booking/', function (Request $request, Response $response){
    return $this->renderer->render($response, "reservas.php");
	});

$app->get('/api/actividades/', function (){
    $sql = "SELECT * FROM activities";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->execute();
		$activiades = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo ' { "actividades" : ';
		echo  json_encode($activiades);
		echo '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	});
$app->get('/api/actividades/{id}', function ($request, $response, $args){
    $sql = "SELECT * FROM activities where slug like '".$args['id']."'";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->execute();
		$actividad = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo ' { "actividad" : ';
		echo  json_encode($actividad);
		echo '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	});
$app->get('/api/reservas/', function (){
    $sql = "SELECT * FROM bookings";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->execute();
		$bookings = $stmt->fetchAll(PDO::FETCH_OBJ);
		foreach ($bookings as $b) {
				$sql = "SELECT name FROM activities where id= ".$b->activity_id;
				try {
					$db = getDB();
					$stmt = $db->prepare($sql);
					$stmt->execute();
					$aux = $stmt->fetch(PDO::FETCH_OBJ);
					$b->activity_id = $aux->name;
					}
				catch(PDOException $e){
					echo '{"error":{"text":'. $e->getMessage() .'}}';
				}

		}
		$db = null;
		echo ' { "reservas" : ';
		echo  json_encode($bookings);
		echo '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	});
$app->post('/api/agendar/', function($request){
	$update = $request->getParsedBody();

	$sql = "INSERT INTO bookings (`activity_id`, `date`, `people_number`, `total_price`) VALUES (?, ?, ?, ?)";
	try {
		$total = $update['form_precio']*$update['numero'];
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam(1, $update['nro_actividad']);
		$stmt->bindParam(2, $update['fecha']);
		$stmt->bindParam(3, $update['numero']);
		$stmt->bindParam(4, $total);
		
		$stmt->execute();
		$db = null;
	
		header('Location: ../../booking/');
     	exit();

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() . var_dump($request->getParsedBody()).'}}'; 
	}


	});

$app->run();