<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts;

use CarloNicora\Minimalism\Interfaces\Encrypter\Interfaces\EncrypterInterface;
use CarloNicora\Minimalism\Interfaces\ServiceInterface;
use CarloNicora\Minimalism\Minimalism;
use Exception;
use JsonException;
use PHPUnit\Framework\TestCase;

class AbstractFunctionalTest extends TestCase
{
    /** @var Minimalism|null  */
    private static ?Minimalism $minimalism=null;

    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $servicesCache = __DIR__ . '/../../cache/services.cache';
        if (file_exists($servicesCache)){
            self::assertTrue(unlink($servicesCache));
        } else {
            self::assertTrue(true);
        }

        $servicesCache = __DIR__ . '/../../cache/models.cache';
        if (file_exists($servicesCache)){
            self::assertTrue(unlink($servicesCache));
        } else {
            self::assertTrue(true);
        }

        $servicesCache = __DIR__ . '/../../cache/modelsDefinitions.cache';
        if (file_exists($servicesCache)){
            self::assertTrue(unlink($servicesCache));
        } else {
            self::assertTrue(true);
        }

        $servicesCache = __DIR__ . '/../../cache/servicesModels.cache';
        if (file_exists($servicesCache)){
            self::assertTrue(unlink($servicesCache));
        } else {
            self::assertTrue(true);
        }

        foreach(glob(__DIR__ . '/../../logs/*') as $file) {
            if(is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * @param Data $request
     * @return ApiResponse
     * @throws JsonException
     * @throws Exception
     */
    protected static function call(
        Data $request
    ): ApiResponse
    {
        $curl = curl_init();

        $serverUrl = 'http://docker.for.mac.localhost/v1.0';

        $options = $request->getCurlOpts($serverUrl);

        curl_setopt_array($curl, $options);

        $curlResponse = curl_exec($curl);

        $result = new ApiResponse($curl, $curlResponse, $request::$responseHeaders);

        if (isset($curl)) {
            curl_close($curl);
        }

        unset($curl);

        return $result;
    }

    /**
     * @throws Exception
     */
    protected function removeGraceCollectorDataFields(
        string $message,
        array $removedFields,
    ): string
    {
        $arrayMessage = json_decode($message, true, 512, JSON_THROW_ON_ERROR);

        if ($removedFields !== []) {
            foreach ($removedFields as $removedField){
                if (array_key_exists($removedField, $arrayMessage)){
                    unset($arrayMessage[$removedField]);
                }
            }
        }

        return json_encode($arrayMessage, JSON_THROW_ON_ERROR);
    }

    /**
     * @return EncrypterInterface|ServiceInterface
     * @throws Exception
     */
    protected static function createEncrypter(
    ): EncrypterInterface|ServiceInterface
    {
        if (self::$minimalism === null) {
            self::$minimalism = new Minimalism();
        }

        return self::$minimalism->getService(EncrypterInterface::class);
    }
}
