<?php

declare(strict_types=1);

namespace OpenAPITools\Utils;

use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use OpenAPITools\Utils\State\Files as StateFiles;
use RuntimeException;

use function is_array;
use function is_string;
use function json_decode;
use function json_encode;
use function json_last_error;

use const JSON_PRETTY_PRINT;

final class State
{
    public static function initialize(): State
    {
        return (new ObjectMapperUsingReflection())->hydrateObject(
            self::class,
            [
                'specHash' => '',
                'generatedFiles' => [
                    'files' => [],
                ],
                'additionalFiles' => [
                    'files' => [],
                ],
            ],
        );
    }

    public static function deserialize(string $json): State
    {
        $state = json_decode($json, true);

        if (! is_array($state)) {
            throw new RuntimeException('Provided state is not a valid JSON object');
        }

        return (new ObjectMapperUsingReflection())->hydrateObject(
            self::class,
            $state,
        );
    }

    public static function serialize(State $state): string
    {
        $json = json_encode(
            (new ObjectMapperUsingReflection())->serializeObject($state),
            JSON_PRETTY_PRINT,
        );

        if (! is_string($json)) {
            throw new RuntimeException('Unable to serialize state: ' . json_last_error());
        }

        return $json;
    }

    public function __construct(
        #[MapFrom('specHash')]
        public string $specHash,
        #[MapFrom('generatedFiles')]
        public StateFiles $generatedFiles,
        #[MapFrom('additionalFiles')]
        public StateFiles $additionalFiles,
    ) {
    }
}
