<?php
    require_once (__DIR__ . '/../vendor/autoload.php');

    use Aura\Sql\ExtendedPdo;
    use Moore\Game\Game;

    // Setup Game
    $game = new Game(0, 15);
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
    <meta name="author" content="Christopher A. Moore">
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
        .alert{
			width: 600px;
			margin: 40px 0px 0px 80px;
			font-size: 80px;
			padding: 62px;
        }
        .btn-info {
			font-size: 80px;
			padding: 40px 62px;
		}
		.btn-info:hover {
			background-color: #39D752;
			border-color: #26BC62;
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
        <h1>How Many Pepperonis are there ?</h1>
          <?php for ($i = 1; $i <= $number; $i++): ?>
              <img src="img/pepperoni.png" height="200" width="auto">
          <?php endfor; ?>
      </div>
      <div>
          <?php foreach ($game->getShuffled () as $key => $value): ?>
              <button id="<?= $key ?>" class="btn btn-info btn-lg answer"> <?= $value ?></button>
          <?php endforeach; ?>
<!--           <button class="btn btn-sucess btn-lrg next">Play Again</button>
 -->      </div>
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

           $('.answer').on('click', function () {
               obj.guess = $(this).context.id;
               $.post('/check.php', obj, function (data, textStatus, xhr) {
                   obj.answer = data.answer;
                   if(obj.answer == true){
						location.reload(); // Correct answer
                   }else{
						$('body').prepend('<div class="alert alert-danger">Try Again</div>');
						setTimeout(function(){
							$('.alert').fadeOut( "slow", function() {
								$('.alert').remove();
						  }); },2500);
                    }
               });
           });

           $('img').on('click', function () {
				$(this).css('opacity', .4);
           });

           $('.next').on('click', function(){
               console.log(obj);
               if(obj.answer == true){
                   location.reload();
               }
           });
       });
    </script>
</body></html>
