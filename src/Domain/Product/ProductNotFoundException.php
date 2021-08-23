<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Domain\Product;

use Kartenmacherei\ApiQaChallenge\Domain\DomainExceptions\DomainRecordNotFoundException;

class ProductNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The product you requested does not exist.';
}
