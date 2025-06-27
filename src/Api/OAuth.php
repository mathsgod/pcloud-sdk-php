<?php

namespace pCloud\Sdk\Api;

trait OAuth
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Exchange authorization code for access token (OAuth2 code flow).
     *
     * @param string $client_id Application client ID
     * @param string $client_secret Application client secret
     * @param string $code Code returned from the authorize page
     * @return array 包含 access_token, token_type, uid
     * @throws \InvalidArgumentException 若未提供必要參數
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function oauth2_token(string $client_id, string $client_secret, string $code): array
    {
        if (empty($client_id) || empty($client_secret) || empty($code)) {
            throw new \InvalidArgumentException("Parameters 'client_id', 'client_secret', and 'code' are required.");
        }
        $response = $this->client->get('oauth2_token', [
            'query' => [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'code' => $code
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
