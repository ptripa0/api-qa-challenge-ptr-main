<?php

declare(strict_types=1);
namespace Kartenmacherei\ApiQaChallenge\Application\Actions\Product;

use Exception;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Product;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductName;
use Kartenmacherei\ApiQaChallenge\Domain\Product\ProductRepository;
use Kartenmacherei\ApiQaChallenge\Domain\Product\Sku;
use Kartenmacherei\ApiQaChallenge\Domain\Product\UnitPrice;
use Kartenmacherei\ApiQaChallenge\Exceptions\HttpConflictException;
use Kartenmacherei\ApiQaChallenge\Infrastructure\Filesystem\BasePath;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;

class AddProductAction extends ProductAction
{
    const FORM_SKU = 'sku';
    const FORM_NAME = 'name';
    const FORM_UNIT_PRICE = 'unitPrice';
    const FORM_IMAGE = 'mainImage';

    private array $formParameters = [self::FORM_SKU, self::FORM_NAME, self::FORM_UNIT_PRICE];

    public function __construct(LoggerInterface $logger, ProductRepository $productRepository)
    {
        parent::__construct($logger, $productRepository);
    }

    protected function action(): Response
    {
        $uploadedFiles = $this->request->getUploadedFiles();
        $parsedBody = $this->request->getParsedBody();

        $this->validateRequestForm($parsedBody, $uploadedFiles);

        $filename = $this->saveUploadedFile($uploadedFiles[self::FORM_IMAGE]);

        try {
            $sku = new Sku($parsedBody['sku']);
            $name = new ProductName($parsedBody['name']);
            $unitPrice = new UnitPrice((float) $parsedBody['unitPrice']);

            $product = new Product($sku, $name, $unitPrice, new BasePath($filename));
        } catch (Exception $exception) {
            throw new HttpBadRequestException($this->request, $exception->getMessage());
        }

        if ($this->productRepository->findProductOfSku($sku)) {
            throw new HttpConflictException($this->request, sprintf('A product with sku %s already exists', $sku->asString()));
        }

        $this->productRepository->addProduct($product);

        $this->logger->info(sprintf('Product with SKU %s was added.', $sku->asString()));

        return $this->respondWithData($product);
    }

    private function validateRequestForm(array $parsedBody, array $uploadedFiles): void
    {
        array_walk($this->formParameters, function ($parameter) use ($parsedBody): void {
            try {
                $parsedBody[$parameter] = filter_var($parsedBody[$parameter], FILTER_DEFAULT);
            } catch (Exception) {
                throw new HttpBadRequestException($this->request, sprintf('The form is missing the parameter "%s"', $parameter));
            }
        });

        if (!filter_var($parsedBody[self::FORM_UNIT_PRICE], FILTER_VALIDATE_FLOAT)) {
            throw new HttpBadRequestException($this->request, sprintf('Invalid "unitPrice" %s, is not a float', $parsedBody[self::FORM_UNIT_PRICE]));
        }

        try {
            $uploadedFile = $uploadedFiles[self::FORM_IMAGE];
        } catch (Exception) {
            throw new HttpBadRequestException($this->request, sprintf('The form is missing the parameter "%s"', self::FORM_IMAGE));
        }

        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            throw new HttpInternalServerErrorException($this->request, 'Image could not be uploaded');
        }
    }

    private function saveUploadedFile(UploadedFileInterface $uploadedFile)
    {
        return $uploadedFile->getClientFilename();
    }
}
