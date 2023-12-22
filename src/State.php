<?php

declare(strict_types=1);

namespace OpenAPITools\Utils;

use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use OpenAPITools\Utils\State\Files as StateFiles;

use function Safe\json_decode;
use function Safe\json_encode;

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
        return (new ObjectMapperUsingReflection())->hydrateObject(
            self::class,
            json_decode($json, true), /** @phpstan-ignore-line */
        );
    }

    public static function serialize(State $state): string
    {
        return json_encode((new ObjectMapperUsingReflection())->serializeObject($state));
    }

    /** @internal */
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
