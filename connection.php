<?php
$host=
error_reporting(E_ALL);
ini_set('display_errors', '1');

$pdo=new PDO('mysql:host=localhost;dbname=groupe5vj','martelna','toto');

// $results = $pdo->exec('INSERT…');
$nom='Quentin';
$prenom='Izard';
$age='21';
?>
<?php
$query = sprintf('
    SELECT * FROM test '
);
$enreg=$pdo->query($query);
$enreg2=$enreg->fetchAll();
echo count($enreg2). "\n";
foreach($enreg as $row) {
    echo $enreg['nom'] . "\t";
    echo $enreg['prenom'] . "\n";
}
/*
$results=$pdo->query('SELECT * FROM test;');
foreach($results as $row) {
  var_dump($row);
  echo $row['nom'];
}
*/
?>
