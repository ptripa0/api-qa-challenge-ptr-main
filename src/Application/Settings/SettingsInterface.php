<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Application\Settings;

interface SettingsInterface
{
    public function get(string $key = ''): mixed;
}
