<?php

namespace pCloud\Sdk\Api;

trait General
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Returns information about the current user.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function userinfo(): array
    {
        $response = $this->client->get('/userinfo');
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['result']) && $data['result'] !== 0) {
            throw new \RuntimeException('Failed to fetch user info: ' . ($data['error'] ?? 'Unknown error'));
        }

        return $data;
    }

    /**
     * Lists supported languages in the returned languages hash.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function supportedlanguages(): array
    {
        $response = $this->client->get('/supportedlanguages');
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['result']) && $data['result'] !== 0) {
            throw new \RuntimeException('Failed to fetch supported languages: ' . ($data['error'] ?? 'Unknown error'));
        }

        return $data['languages'] ?? [];
    }

    /**
     * Sets user's language.
     *
     * @param string $language The language to be set.
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function setlanguage(string $language): array
    {
        $response = $this->client->get('/setlanguage', [
            'query' => ['language' => $language]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['result']) && $data['result'] !== 0) {
            throw new \RuntimeException('Failed to set language: ' . ($data['error'] ?? 'Unknown error'));
        }

        return $data;
    }

    /**
     * Returns IP and hostname of the server you are currently connected to.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function currentserver(): array
    {
        $response = $this->client->get('/currentserver');
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['result']) && $data['result'] !== 0) {
            throw new \RuntimeException('Failed to fetch current server info: ' . ($data['error'] ?? 'Unknown error'));
        }

        return $data;
    }

    /**
     * Lists updates of the user's folders/files.
     *
     * @param array $params Optional parameters: diffid, after, last, block, limit
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function diff(array $params = []): array
    {
        $response = $this->client->get('/diff', [
            'query' => $params
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['result']) && $data['result'] !== 0) {
            throw new \RuntimeException('Failed to fetch diff: ' . ($data['error'] ?? 'Unknown error'));
        }

        return $data;
    }

    /**
     * Returns event history of a file identified by fileid.
     *
     * @param int $fileid File ID to get history for.
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getfilehistory(int $fileid): array
    {
        $response = $this->client->get('/getfilehistory', [
            'query' => ['fileid' => $fileid]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['result']) && $data['result'] !== 0) {
            throw new \RuntimeException('Failed to fetch file history: ' . ($data['error'] ?? 'Unknown error'));
        }

        return $data;
    }

    /**
     * Gets the IP address and country of the remote device connecting to the API.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getip(): array
    {
        $response = $this->client->get('/getip');
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['result']) && $data['result'] !== 0) {
            throw new \RuntimeException('Failed to fetch IP info: ' . ($data['error'] ?? 'Unknown error'));
        }

        return $data;
    }

    /**
     * Returns closest API server to the requesting client.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getapiserver(): array
    {
        $response = $this->client->get('/getapiserver');
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['result']) && $data['result'] !== 0) {
            throw new \RuntimeException('Failed to fetch API server info: ' . ($data['error'] ?? 'Unknown error'));
        }

        return $data;
    }
}
