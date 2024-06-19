<?php

declare(strict_types=1);

namespace Dealroom\SocialsHelpers\Normalizers;

use Dealroom\SocialsHelpers\Exceptions\NormalizeException;

class Factory
{
    public static array $normalizers = [
        FacebookPageNormalizer::PLATFORM => FacebookPageNormalizer::class,
        FacebookProfileNormalizer::PLATFORM => FacebookProfileNormalizer::class,
        Parser::PLATFORM_TWITTER => TwitterNormalizer::class,
        Parser::PLATFORM_X => XNormalizer::class,
        TwitterNormalizer::PLATFORM  => TwitterNormalizer::class,
        XNormalizer::PLATFORM => XNormalizer::class,
        LinkedinCompanyNormalizer::PLATFORM => LinkedinCompanyNormalizer::class,
        LinkedinShowcaseNormalizer::PLATFORM => LinkedinShowcaseNormalizer::class,
        LinkedinSchoolNormalizer::PLATFORM => LinkedinSchoolNormalizer::class,
        LinkedinProfileNormalizer::PLATFORM => LinkedinProfileNormalizer::class,
    ];

    /**
     * @param string $platform
     *
     * @return NormalizerInterface
     */
    public static function getForPlatform(string $platform): NormalizerInterface
    {
        if (!isset(self::$normalizers[$platform])) {
            throw new NormalizeException(sprintf('No normalizer found for platform %s', $platform));
        }

        return new self::$normalizers[$platform]();
    }

    public static function registerNormalizer($normalizer): void
    {
        if (!is_a($normalizer, NormalizerInterface::class, true)) {
            throw new NormalizeException(sprintf('Normalizer %s must implement NormalizerInterface', $normalizer));
        }
        self::$normalizers[$normalizer::PLATFORM] = $normalizer::class;
    }
}
