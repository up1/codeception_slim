<?php
use Slim\Slim as Slim;
require 'vendor/autoload.php';
$app = new Slim();

$app->get('/hello/:name', function($name){
  echo "Hello, $name";
});

$app->get('/wines', 'getWines');
$app->get('/wine/:id', 'getWine');
$app->post('/wines', 'addWine');
$app->put('/wine/:id', 'updateWine');
$app->delete('/wine/:id', 'deleteWine');

$app->run();

function deleteWine($id){
  $sql = "DELETE FROM WINES WHERE id=:id";
  try{
    $dbConnection = getDatabaseConnection();
    $statement = $dbConnection->prepare($sql);
    $statement->bindParam("id", $id);
    $statement->execute();
    $dbConnection = null;
    echo "deleted";
  }catch(PDOException $exception){

  }
}

function updateWine($id){
  $sql = "UPDATE WINES SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, note=:note WHERE id=:id";
  $request = Slim::getInstance()->request();
  $body = $request->getBody();
  $wine = json_decode($body);
  try{
    $dbConnection = getDatabaseConnection();
    $statement = $dbConnection->prepare($sql);
    $statement->bindParam("name", $wine->wine_name);
    $statement->bindParam("grapes", $wine->grapes);
    $statement->bindParam("country", $wine->country);
    $statement->bindParam("region", $wine->region);
    $statement->bindParam("year", $wine->year);
    $statement->bindParam("note", $wine->note);
    $statement->bindParam("id", $id);
    $statement->execute();
    $dbConnection = null;
    echo json_encode($wine);
  }catch(PDOException $exception){
    echo '{"error":{"text":'. $exception->getMessage() .'}}';
  }
}

function getWines(){
  $sql = "SELECT * FROM WINES ORDER BY NAME";
  try{
    $dbConnection = getDatabaseConnection();
    $statement = $dbConnection->query($sql);
    $wines = $statement->fetchAll(PDO::FETCH_OBJ);
    $dbConnection = null;
    echo '{"wine":' . json_encode($wines) .'}';
  }catch(PDOException $exception){
    echo '{"error":{"text":'. $exception->getMessage() .'}}';
  }
}

function getWine($id){
  $sql = "SELECT * FROM WINES WHERE ID = :ID";
  try{
    $dbConnection = getDatabaseConnection();
    $statement = $dbConnection->prepare($sql);
    $statement->bindParam("ID", $id);
    $statement->execute();
    $wine = $statement->fetchObject();
    $dbConnection = null;
    echo json_encode($wine);
  }catch(PDOException $exception){
    echo '{"error":{"text":'.$exception->getMessage() .'}}';
  }
}

function addWine(){
  $sql = "INSERT INTO wines(name, grapes, country, region, year, note) VALUES(:name, :grapes, :country, :region, :year, :note)"; 
  $request = Slim::getInstance()->request();
  $wine = json_decode($request->getBody());
  try{
    $dbConnection = getDatabaseConnection();
    $statement = $dbConnection->prepare($sql);
    $statement->bindParam("name", $wine->wine_name);
    $statement->bindParam("grapes", $wine->grapes);
    $statement->bindParam("country", $wine->country);
    $statement->bindParam("region", $wine->region);
    $statement->bindParam("year", $wine->year);
    $statement->bindParam("note", $wine->note);
    $statement->execute();
    $wine->id = $dbConnection->lastInsertId();
    $dbConnection = null;
    echo json_encode($wine);
  }catch(PDOException $exception){
    echo '{"error":{"text":'.$exception->getMessage() .'}}';
  }
}


function getDatabaseConnection(){
  $dbHost = "127.0.0.1";
  $dbUser = "slim";
  $dbPassword = "password";
  $dbName = "wine";
  $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $dbh;
}
