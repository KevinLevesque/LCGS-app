<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once __DIR__ . '/rest/bootstrap/app.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = app(\Doctrine\ORM\EntityManagerInterface::class);

return ConsoleRunner::createHelperSet($entityManager);