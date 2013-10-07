<?php
class WinePdoDao implements WineDAO{
  function getWines(){
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
      return $wine;
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
    $dbHost = "127.0.0.1";
    $dbUser = "slim";
    $dbPassword = "password";
    $dbName = "wine";
    $dbh = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
  }
}
