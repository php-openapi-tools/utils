<?php

declare (strict_types=1);
namespace ApiClients\Client\PetStore\Internal\Operation\Pets\Kinds;

use ApiClients\Client\PetStore\Contract;
use ApiClients\Client\PetStore\Error as ErrorSchemas;
use ApiClients\Client\PetStore\Internal;
use ApiClients\Client\PetStore\Operation;
use ApiClients\Client\PetStore\Schema;
use League\OpenAPIValidation;
use React\Http;
use ApiClients\Contracts;
final class Walking
{
    public const OPERATION_ID = 'pets/kinds/walking';
    public const OPERATION_MATCH = 'GET /pets/kinds/walking';
    /**The number of results per page (max 100). **/
    private int $perPage;
    /**Page number of the results to fetch. **/
    private int $page;
    private readonly \League\OpenAPIValidation\Schema\SchemaValidator $responseSchemaValidator;
    private readonly Internal\Hydrator\Operation\Pets\Kinds\Walking $hydrator;
    public function __construct(\League\OpenAPIValidation\Schema\SchemaValidator $responseSchemaValidator, Internal\Hydrator\Operation\Pets\Kinds\Walking $hydrator, int $perPage = 30, int $page = 1)
    {
        $this->perPage = $perPage;
        $this->page = $page;
        $this->responseSchemaValidator = $responseSchemaValidator;
        $this->hydrator = $hydrator;
    }
    public function createRequest() : \Psr\Http\Message\RequestInterface
    {
        return new \RingCentral\Psr7\Request('GET', (string) (new \League\Uri\UriTemplate('/pets/kinds/walking{?page,per_page}'))->expand(array('page' => $this->page, 'per_page' => $this->perPage)));
    }
    /**
     * @return \Rx\Observable<Schema\Cat|Schema\Dog|Schema\HellHound>
     */
    public function createResponse(\Psr\Http\Message\ResponseInterface $response) : \Rx\Observable
    {
        $code = $response->getStatusCode();
        [$contentType] = explode(';', $response->getHeaderLine('Content-Type'));
        switch ($contentType) {
            case 'application/json':
                $body = json_decode($response->getBody()->getContents(), true);
                switch ($code) {
                    /**
                     * A paged array of cats
                     **/
                    case 200:
                        return \Rx\Observable::fromArray($body, new \Rx\Scheduler\ImmediateScheduler())->map(function (array $body) : Schema\Cat|Schema\Dog|Schema\HellHound {
                            $error = new \RuntimeException();
                            try {
                                $this->responseSchemaValidator->validate($body, \cebe\openapi\Reader::readFromJson(Schema\Cat::SCHEMA_JSON, '\\cebe\\openapi\\spec\\Schema'));
                                return $this->hydrator->hydrateObject(Schema\Cat::class, $body);
                            } catch (\Throwable $error) {
                                goto items_application_json_two_hundred_aaaaa;
                            }
                            items_application_json_two_hundred_aaaaa:
                            try {
                                $this->responseSchemaValidator->validate($body, \cebe\openapi\Reader::readFromJson(Schema\Dog::SCHEMA_JSON, '\\cebe\\openapi\\spec\\Schema'));
                                return $this->hydrator->hydrateObject(Schema\Dog::class, $body);
                            } catch (\Throwable $error) {
                                goto items_application_json_two_hundred_aaaab;
                            }
                            items_application_json_two_hundred_aaaab:
                            try {
                                $this->responseSchemaValidator->validate($body, \cebe\openapi\Reader::readFromJson(Schema\HellHound::SCHEMA_JSON, '\\cebe\\openapi\\spec\\Schema'));
                                return $this->hydrator->hydrateObject(Schema\HellHound::class, $body);
                            } catch (\Throwable $error) {
                                goto items_application_json_two_hundred_aaaac;
                            }
                            items_application_json_two_hundred_aaaac:
                            throw $error;
                        });
                    /**
                     * unexpected error
                     **/
                    default:
                        $this->responseSchemaValidator->validate($body, \cebe\openapi\Reader::readFromJson(Schema\Error::SCHEMA_JSON, \cebe\openapi\spec\Schema::class));
                        throw new ErrorSchemas\Error($code, $this->hydrator->hydrateObject(Schema\Error::class, $body));
                }
                break;
        }
        throw new \RuntimeException('Unable to find matching response code and content type');
    }
}
