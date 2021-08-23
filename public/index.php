<?php

declare(strict_types=1);
namespace Kartenmacherei\UserImageService;

use Kartenmacherei\ApiQaChallenge\Application\ApplicationBuilder;
use Kartenmacherei\ApiQaChallenge\Domain\EnvironmentReader;

require __DIR__ . '/../bootstrap.php';

$applicationBuilder = new ApplicationBuilder();
$app = $applicationBuilder->build(new EnvironmentReader());

$app->run();
