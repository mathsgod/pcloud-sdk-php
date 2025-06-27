<?php

namespace pCloud\Sdk\Api;


trait Transfer
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Does a file(s) transfer and sends transfer links to receiver emails.
     *
     * @param string $sendermail 寄件者 email
     * @param string $receivermails 收件者 email（多個以逗號分隔，最多20個）
     * @param array $files 欲上傳的檔案（['fieldname' => '/path/to/file'] 或 [['name'=>'file', 'path'=>'/path/to/file']]）
     * @param string|null $message 備註訊息（最長160字）
     * @param string|null $progresshash 上傳進度 hash
     * @return array
     * @throws \InvalidArgumentException 若未提供 sendermail、receivermails 或 files
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadtransfer(
        string $sendermail,
        string $receivermails,
        array $files,
        ?string $message = null,
        ?string $progresshash = null
    ): array {
        if (empty($sendermail) || empty($receivermails) || empty($files)) {
            throw new \InvalidArgumentException("Parameters 'sendermail', 'receivermails', and 'files' are required.");
        }
        $multipart = [];
        foreach ($files as $key => $file) {
            if (is_array($file) && isset($file['name'], $file['path'])) {
                $multipart[] = [
                    'name' => $file['name'],
                    'contents' => fopen($file['path'], 'r')
                ];
            } else {
                $multipart[] = [
                    'name' => is_string($key) ? $key : 'file',
                    'contents' => fopen($file, 'r')
                ];
            }
        }
        $query = [
            'sendermail' => $sendermail,
            'receivermails' => $receivermails
        ];
        if ($message !== null) {
            $query['message'] = $message;
        }
        if ($progresshash !== null) {
            $query['progresshash'] = $progresshash;
        }

        $response = $this->client->request('POST', 'uploadtransfer', [
            'query' => $query,
            'multipart' => $multipart
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Monitor the progress of transfered files.
     *
     * @param string $progresshash 上傳進度 hash
     * @return array
     * @throws \InvalidArgumentException 若未提供 progresshash
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadtransferprogress(string $progresshash): array
    {
        if (empty($progresshash)) {
            throw new \InvalidArgumentException("Parameter 'progresshash' is required.");
        }
        $response = $this->client->get('uploadtransferprogress', [
            'query' => ['progresshash' => $progresshash]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
