<?php
/// This stores the basic database configuration information and it is also a repository for the commonly accessed database functions */
date_default_timezone_set('America/New_York');
$approot = "sorter.seattlenannyjob.com"; 
$dbhost  = 'localhost';    // Unlikely to require changing
$dbname  = 'seatwppu_sorter';   // Modify these...
$dbuser  = 'seatwppu_sorter';   // ...variables according  
$dbpass  = '4*V4_07#nn87';   // ...to your installation  
$appname = "Quick Sort"; // ...and preference
$upload_dir = "upload/";

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);  
if ($connection->connect_error) die($connection->connect_error);

$salt1 = "qm&h*";
$salt2 = "pg!@";
$salt3 = 24324;   ///' default pass : stepupAC for usertype=3, bromilow for usertype=2

  function createTable($name, $query) /// create a new table in the database
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
  }

  function queryMysql($query) /// Query interface for the database
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }
  
  function multiQueryMysql($query) /// Interface to execute multiple SQL queries on the current database
  {
    global $connection;
    $result = $connection->multi_query($query);
    if (!$result) die($connection->error);
    return $result;
  }

  function destroySession() /// Destroy the currently active session
  {
    $_SESSION=array();

    //if (session_id() != "" || isset($_COOKIE[session_name()]))
    //  setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
  }

  function sanitizeString($var) /// Remove malicious characters from user input.
  {
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
  } 
  
  function escapeString($var) /// Remove malicious characters from user input.
  {
    global $connection;
    //$var = strip_tags($var);
    return $connection->real_escape_string($var);
  } 
  
  function lastInsertID() /// Id of recently inserted record in the current database
  {
      global $connection;
      return mysqli_insert_id($connection);
  }
  
  function affectedRows() /// Number of rows added in the recently executed operation on the current database
  {
      global $connection;
      return mysqli_affected_rows($connection);
  }
  
  function mysqlErrorNumber() /// Error number of recently executed database operation
  {
      global $connection;
      return mysqli_errno($connection);
  }

?>