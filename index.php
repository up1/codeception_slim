<?php
use Slim\Slim as Slim;
require 'vendor/autoload.php';
require 'WineDao.php';
require 'WinePdoDao.php';

$app = new Slim();
$app->log->setEnabled(true);

$app->container->singleton('wineDao', function () {
  return new WinePdoDao();
});

$app->get('/wines', 'getWines');
$app->get('/wine/:id', 'getWine');
$app->post('/wines', 'addWine');
$app->put('/wine/:id', 'updateWine');
$app->delete('/wine/:id', 'deleteWine');

$app->run();

function deleteWine($id){
  try{
    $app = Slim::getInstance();
    $wineDao = $app->wineDao;
    $wineDao->deleteWine($id);
    echo "deleted";
  }catch(PDOException $exception){
    echo '{"error":{"text":'. $exception->getMessage() .'}}';
  }
}

function updateWine($id){
  $request = Slim::getInstance()->request();
  $body = $request->getBody();
  $wine = json_decode($body);
  try{
    $app = Slim::getInstance();
    $winePdo = $app->wineDao;
    $winePdo->updateWine($id, $wine);
    echo json_encode($wine);
  }catch(PDOException $exception){
    echo '{"error":{"text":'. $exception->getMessage() .'}}';
  }
}

function getWines(){
  try{
    $app = Slim::getInstance();
    $winePdo = $app->wineDao; 
    $wines = $winePdo->getWines();
    echo '{"wines":' . json_encode($wines) . '}';
  }catch(PDOException $exception){
    echo '{"error":{"text":'. $exception->getMessage() .'}}';
  }
}

function getWine($id){
  try{
    $app = Slim::getInstance();
    $winePdo = $app->wineDao; 
    $wine = $winePdo->getWine($id);
    echo json_encode($wine);
  }catch(PDOException $exception){
    echo '{"error":{"text":'.$exception->getMessage() .'}}';
  }
}

function addWine(){
  $request = Slim::getInstance()->request();
  $wine = json_decode($request->getBody());
  try{
    $app = Slim::getInstance();
    $windDao = $app->wineDao;
    $wind = $windDao->addWine($wine);
    echo json_encode($wine);
  }catch(PDOException $exception){
    echo '{"error":{"text":'.$exception->getMessage() .'}}';
  }
}

