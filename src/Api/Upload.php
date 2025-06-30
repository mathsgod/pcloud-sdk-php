<?php

namespace pCloud\Sdk\Api;

trait Upload
{
    /** @var \GuzzleHttp\Client */
    private $client;

    public function upload_create()
    {
        $response = $this->client->get('upload_create');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function upload_write(int $uploadid, int $uploadoffset, string $data)
    {
        $query = [
            'uploadid' => $uploadid,
            'uploadoffset' => $uploadoffset
        ];

        $response = $this->client->put('upload_write', [
            'query' => $query,
            'body' => $data
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function upload_save(int $uploadid, string $name, int $folderid)
    {
        $query = [
            'uploadid' => $uploadid,
            'name' => $name,
            'folderid' => $folderid
        ];
        $response = $this->client->get('upload_save', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
