<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\Setup\Traits\GenerateData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Traits\ServiceGenerationTrait;
use Exception;
use PHPUnit\Framework\TestCase;

class AbstractFunctionalTest extends TestCase
{
    use GenerateData;
    use ServiceGenerationTrait;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        sleep(1);
    }

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

        static::createRedis()->remove(static::createRedis()->getKeys('minimalism*'));

        static::generateTestData(
            mysqlService: static::createMySQL(),
        );
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
}
