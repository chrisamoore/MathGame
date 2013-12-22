<?php
    require_once(__DIR__ . '/../vendor/autoload.php');

    use Aura\Sql\ExtendedPdo;
    use Moore\Game\Game;

    $pdo = new ExtendedPdo( 'mysql:host=localhost;dbname=game', 'root', 'root' );
    $result = $pdo->fetchObject("SELECT * FROM `games` WHERE id = :id", ['id' => $_POST['id']]);
    // Kill Connection
    $pdo = null;

    $game = unserialize($result->object);
    $answer = $game->isCorrect($_POST['guess']);

    header('Content-Type: application/json');
    echo json_encode(['answer' => $answer]);