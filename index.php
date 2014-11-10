<?php
// load the (optional) Composer auto-loader
require "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("application/entity");
$isDevMode = true;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'foo',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$em = EntityManager::create($dbParams, $config);




// start the application
//echo $_GET['l'];

$app = new Application($em);

//$test = "<iframe src="//player.vimeo.com/video/101235645?title=0" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> <p><a href="http://vimeo.com/101235645">Going Dark: The Final Days of Film Projection</a> from <a href="http://vimeo.com/jsquaredok">J Squared</a> on <a href="https://vimeo.com">Vimeo</a>.</p>";

