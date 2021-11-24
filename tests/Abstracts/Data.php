<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use CURLFile;
use JsonException;

class Data
{
    public static array $responseHeaders = [];

    /**
     * Data constructor.
     * @param Verbs $verb
     * @param string $endpoint
     * @param array|string $body
     * @param string|null $bearer
     * @param array $files
     * @param array $requestHeader
     */
    public function __construct(
        public Verbs $verb,
        public string $endpoint,
        public array|string $body = [],
        public ?string $bearer = null,
        public array $files = [],
        public array $requestHeader = []
    )
    {
    }

    /**
     *
     */
    protected function getCurlHttpHeaders(): array
    {
        $httpHeaders = [
            'Host:minimalism.dev.carlonicora.com',
            'Test-Environment:1'
        ];

        if (false === empty($this->files)) {
            $httpHeaders[] = 'Content-Type:multipart/form-data';
        } else {
            $httpHeaders[] ='Content-Type:application/vnd.api+json';
        }

        if ($this->bearer !== null) {
            $httpHeaders[] = 'Authorization:Bearer ' . $this->bearer;
        }

        return array_merge($httpHeaders, $this->requestHeader);
    }

    /**
     * @param string $serverUrl
     * @return array
     * @throws JsonException
     */
    public function getCurlOpts(
        string $serverUrl
    ): array
    {
        /** @noinspection CurlSslServerSpoofingInspection */
        $opts = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => $this->getCurlHttpHeaders(),
            CURLOPT_HEADER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ];

        $endpointWithUriParams = null;

        switch ($this->verb){
            case Verbs::Post:
                $opts [CURLOPT_POST] = 1;
                if (false === empty($this->body)) {
                    if (is_array($this->body)) {
                        $arrayBody = json_encode($this->body, JSON_THROW_ON_ERROR);
                    }

                    $opts[CURLOPT_POSTFIELDS] = $arrayBody ?? $this->body;
                }

                if (false === empty($this->files)) {
                    $buildFiles = static function(
                        array $files,
                        bool $subLevel = false
                    ) use (&$buildFiles): array
                    {
                        $fileArray = [];
                        foreach ($files as $fileKey => $file) {
                            $multidimensialKey = $subLevel ? '[' . $fileKey . ']' : $fileKey;
                            if (false === empty($file['path'])) {
                                $cFile = new CURLFile(
                                    $file['path'],
                                    $file['mimeType'],
                                    $file['name']
                                );

                                $fileArray [$multidimensialKey] = $cFile;
                            } else {
                                foreach ($buildFiles($file, true) as $subFileKey => $subFile) {
                                    $fileArray [$multidimensialKey . $subFileKey ] = $subFile;
                                }
                            }
                        }

                        return $fileArray;
                    };

                    $opts[CURLOPT_POSTFIELDS] = $buildFiles($this->files);
                }
                break;
            case Verbs::Delete:
            case Verbs::Patch:
            case Verbs::Put:
                $opts [CURLOPT_CUSTOMREQUEST] = $this->verb->value;
                if (is_array($this->body)) {
                    $bodyArray = json_encode($this->body, JSON_THROW_ON_ERROR);
                }

                $opts[CURLOPT_POSTFIELDS] = $bodyArray ?? $this->body;
                break;
            default:
                if (isset($this->body)) {
                    $query = http_build_query($this->body);
                    if (!empty($query)) {
                        $endpointWithUriParams .= ((str_contains($this->endpoint, '?')) ? '&' : '?') . $query;
                    }
                }
                break;
        }

        $opts[CURLOPT_URL] = $serverUrl . ($endpointWithUriParams ?? $this->endpoint);

        $opts[CURLOPT_HEADERFUNCTION] = static function($stub, $header)
        {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
            {
                return $len;
            }

            static::$responseHeaders[strtolower(trim($header[0]))][] = trim($header[1]);

            return $len;
        };

        return $opts;
    }
}