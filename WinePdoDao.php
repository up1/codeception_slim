<?php
class WinePdoDao implements WineDAO{
  function getWines(){
    $file = Log::factory('file', 'out.log', 'TEST');
    $file->log('WinePdoDao getWines');
    $sql = "SELECT * FROM WINES ORDER BY NAME";
    try{
      $dbConnection = $this->getDatabaseConnection();
      $statement = $dbConnection->query($sql);
      $wines = $statement->fetchAll(PDO::FETCH_OBJ);
      $dbConnection = null;
      return $wines;
    }catch(PDOException $exception){

    }
  }

  function getWine($id){
    $sql = "SELECT * FROM WINES WHERE ID = :ID";
    try{
      $dbConnection = $this->getDatabaseConnection();
      $statement = $dbConnection->prepare($sql);
      $statement->bindParam("ID", $id);
      $statement->execute();
      $wine = $statement->fetchObject();
      $dbConnection = null;
      return $wine;
    }catch(PDOException $exception){
    }

  }

  function addWine($wine){
    $sql = "INSERT INTO wines(name, grapes, country, region, year, note) VALUES(:name, :grapes, :country, :region, :year, :note)"; 
    try{
      $dbConnection = $this->getDatabaseConnection();
      $statement = $dbConnection->prepare($sql);
      $statement->bindParam("name", $wine->name);
      $statement->bindParam("grapes", $wine->grapes);
      $statement->bindParam("country", $wine->country);
      $statement->bindParam("region", $wine->region);
      $statement->bindParam("year", $wine->year);
      $statement->bindParam("note", $wine->note);
      $statement->execute();
      $wine->id = $dbConnection->lastInsertId();
      $dbConnection = null;
      return $wine;
    }catch(PDOException $exception){
    }

  }

  function updateWine($id, $wine){
    $file = Log::factory('file', 'out.log', 'TEST');
    $file->log('WinePdoDao updateWine');
    $sql = "UPDATE WINES SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, note=:note WHERE id=:id";
    try{
      $dbConnection = $this->getDatabaseConnection();
      $statement = $dbConnection->prepare($sql);
      $statement->bindParam("name", $wine->name);
      $statement->bindParam("grapes", $wine->grapes);
      $statement->bindParam("country", $wine->country);
      $statement->bindParam("region", $wine->region);
      $statement->bindParam("year", $wine->year);
      $statement->bindParam("note", $wine->note);
      $statement->bindParam("id", $id);
      $statement->execute();
      $dbConnection = null;
      return $statement->rowCount();
    }catch(PDOException $exception){
    }

  }

  function deleteWine($id){
    $sql = "DELETE FROM WINES WHERE id=:id";
    try{
      $dbConnection = $this->getDatabaseConnection();
      $statement = $dbConnection->prepare($sql);
      $statement->bindParam("id", $id);
      $statement->execute();
      $dbConnection = null;
    }catch(PDOException $exception){

    }
  }

  function getDatabaseConnection(){
    $pdo = new PDO('sqlite::memory:');
    //$pdo = new PDO('sqlite:wines.sqlite3');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS wines (
      id INTEGER PRIMARY KEY AUTOINCREMENT, 
      name TEXT, 
      grapes TEXT, 
      country TEXT,
      region TEXT,
      year TEXT,
      note TEXT
    )");
    $wines = array(
      array('name' => 'Hello!',
      'grapes' => 'Just testing',
      'country' => 'Australia',
      'region' => 'Victoria',
      'year' => '2010',
      'note' => 'Note'),
    );

    $insert = "INSERT INTO wines (name, grapes, country, region, year, note) 
      VALUES (:name, :grapes, :country, :region, :year, :note)";
    $stmt = $pdo->prepare($insert);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':grapes', $grapes);
    $stmt->bindParam(':country', $country); 
    $stmt->bindParam(':region', $region); 
    $stmt->bindParam(':year', $year); 
    $stmt->bindParam(':note', $note); 

    foreach ($wines as $m) {
      // Bind values directly to statement variables
      $stmt->bindValue(':name', $m['name'], SQLITE3_TEXT);
      $stmt->bindValue(':grapes', $m['grapes'], SQLITE3_TEXT);
      $stmt->bindValue(':country', $m['country'], SQLITE3_TEXT);
      $stmt->bindValue(':region', $m['region'], SQLITE3_TEXT);
      $stmt->bindValue(':year', $m['year'], SQLITE3_TEXT);
      $stmt->bindValue(':note', $m['note'], SQLITE3_TEXT);
      $stmt->execute();
    }
    return $pdo;
  }

/*
  function getDatabaseConnection(){
    $dbHost = "127.0.0.1";
    $dbUser = "slim";
    $dbPassword = "password";
    $dbName = "wine";
    $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
  }
 */
}
