<?php
    require_once (__DIR__ . '/../vendor/autoload.php');

    use Aura\Sql\ExtendedPdo;
    use Moore\Game\Game;

    // Setup Game
    $game = new Game(0, 10);
    $game->play ();
    $number = $game->getNumber ();

    // SaveGame
    $pdo = new ExtendedPdo('mysql:host=localhost;dbname=game', 'root', 'root');
    $pdo->bindValues (['object' => serialize ($game)]);
    $sth = $pdo->query ("INSERT INTO `games` (object) VALUES (:object)");

    // Store Game ID
    $game->id = $pdo->lastInsertId ();

    // Kill Connection
    $pdo = null;
?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <style type="text/css">
        button {
            margin-right: 20px;
        }
    </style>
</head>

  <body style="">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Math Game</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
      <br /><br />
      <div class="starter-template">
        <h1>Select the Number of Items</h1>
          <?php for ($i = 1; $i <= $number; $i++): ?>
              <img src="img/pepperoni.png" height="200" width="auto">
          <?php endfor; ?>
      </div>
      <div>
          <?php foreach ($game->getShuffled () as $key => $value): ?>
              <button id="<?= $key ?>" class="btn btn-info btn-lg"> <?= $value ?></button>
          <?php endforeach; ?>
      </div>
      <pre>
          <?php print_r ($game); ?>
      </pre>
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script>
       $(function () {
           var obj = {
               id: <?= $game->id ?>
           };
           $('button').on('click', function () {
               obj.guess = $(this).context.id;
               $.post('/check.php', obj, function (data, textStatus, xhr) {
                   console.log(data);
               });
           });
       });
    </script>
</body></html>
