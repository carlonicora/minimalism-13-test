<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\Setup\Traits\GenerateData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Traits\ServiceGenerationTrait;
use Exception;
use JsonException;
use PHPUnit\Framework\TestCase;

class AbstractFunctionalTest extends TestCase
{
    use GenerateData;
    use ServiceGenerationTrait;

    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::deleteAllFilesInFolder(__DIR__ . '/../../cache');
        self::deleteAllFilesInFolder(__DIR__ . '/../../logs', false);

        static::cleanDatabases(
            mysqlService: static::createMySQL(),
        );

        static::generateTestData(
            mysqlService: static::createMySQL(),
        );
        try {
            self::createRabbitMq()->purge('myQueue');
        } catch (Exception) {}
    }

    /**
     * @param string $dir
     * @param bool $recursive
     */
    private static function deleteAllFilesInFolder(
        string $dir,
        bool $recursive=true,
    ): void
    {
        foreach(glob($dir . '/*') as $file) {
            if(is_file($file)) {
                unlink($file);
            } elseif ($recursive){
                self::deleteAllFilesInFolder($file);
                rmdir($file);
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
}
