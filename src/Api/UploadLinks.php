<?php

namespace pCloud\Sdk\Api;


trait UploadLinks
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Creates upload link for a folder.
     *
     * @param int|null $folderid 目標資料夾ID（優先）
     * @param string|null $path 目標資料夾路徑（備選）
     * @param string $comment 給上傳者的說明
     * @param string|null $expire 到期時間（datetime）
     * @param int|null $maxspace 上傳總容量上限（bytes）
     * @param int|null $maxfiles 上傳檔案數量上限
     * @return array
     * @throws \InvalidArgumentException 若未提供 folderid/path 或 comment
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createuploadlink(
        ?int $folderid = null,
        ?string $path = null,
        string $comment= '',
        ?string $expire = null,
        ?int $maxspace = null,
        ?int $maxfiles = null
    ): array {
        if ($folderid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'folderid' or 'path' is required.");
        }
        if (empty($comment)) {
            throw new \InvalidArgumentException("Parameter 'comment' is required.");
        }
        $query = ['comment' => $comment];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        }
        if ($expire !== null) {
            $query['expire'] = $expire;
        }
        if ($maxspace !== null) {
            $query['maxspace'] = $maxspace;
        }
        if ($maxfiles !== null) {
            $query['maxfiles'] = $maxfiles;
        }

        $response = $this->client->get('createuploadlink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Lists all upload links in uploadlinks.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listuploadlinks(): array
    {
        $response = $this->client->get('listuploadlinks');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Deletes upload link identified by uploadlinkid.
     *
     * @param int $uploadlinkid 上傳連結ID
     * @return array
     * @throws \InvalidArgumentException 若未提供 uploadlinkid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteuploadlink(int $uploadlinkid): array
    {
        if (empty($uploadlinkid)) {
            throw new \InvalidArgumentException("Parameter 'uploadlinkid' is required.");
        }
        $response = $this->client->get('deleteuploadlink', [
            'query' => ['uploadlinkid' => $uploadlinkid]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Modify upload link identified by uploadlinkid.
     *
     * @param int $uploadlinkid 上傳連結ID
     * @param array $options 可選參數：expire, deleteexpire, maxspace, maxfiles
     * @return array
     * @throws \InvalidArgumentException 若未提供 uploadlinkid 或 options 為空
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changeuploadlink(int $uploadlinkid, array $options): array
    {
        if (empty($uploadlinkid)) {
            throw new \InvalidArgumentException("Parameter 'uploadlinkid' is required.");
        }
        if (empty($options)) {
            throw new \InvalidArgumentException("At least one option parameter must be specified.");
        }
        $query = array_merge(['uploadlinkid' => $uploadlinkid], $options);

        $response = $this->client->get('changeuploadlink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Show upload link info by uploadlinkid.
     *
     * @param int $uploadlinkid 上傳連結ID
     * @return array
     * @throws \InvalidArgumentException 若未提供 uploadlinkid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function showuploadlink(int $uploadlinkid): array
    {
        if (empty($uploadlinkid)) {
            throw new \InvalidArgumentException("Parameter 'uploadlinkid' is required.");
        }
        $response = $this->client->get('showuploadlink', [
            'query' => ['uploadlinkid' => $uploadlinkid]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Upload file(s) to an upload link.
     *
     * @param string $code 上傳連結的 code
     * @param array $files 欲上傳的檔案（['fieldname' => '/path/to/file'] 或 [['name'=>'file', 'path'=>'/path/to/file']]）
     * @param bool $nopartial 不儲存部分上傳檔案
     * @param string|null $progresshash 上傳進度 hash
     * @return array
     * @throws \InvalidArgumentException 若未提供 code 或 files
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadtolink(
        string $code,
        array $files,
        bool $nopartial = false,
        ?string $progresshash = null
    ): array {
        if (empty($code) || empty($files)) {
            throw new \InvalidArgumentException("Parameters 'code' and 'files' are required.");
        }
        $multipart = [];
        // 支援兩種格式：['fieldname' => '/path'] 或 [['name'=>'file', 'path'=>'/path']]
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
        $query = ['code' => $code];
        if ($nopartial) {
            $query['nopartial'] = 1;
        }
        if ($progresshash !== null) {
            $query['progresshash'] = $progresshash;
        }

        $response = $this->client->request('POST', 'uploadtolink', [
            'query' => $query,
            'multipart' => $multipart
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Monitor the progress of uploaded files to an upload link.
     *
     * @param string $code 上傳連結的 code
     * @param string $progresshash 上傳進度 hash
     * @return array
     * @throws \InvalidArgumentException 若未提供 code 或 progresshash
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadlinkprogress(string $code, string $progresshash): array
    {
        if (empty($code) || empty($progresshash)) {
            throw new \InvalidArgumentException("Parameters 'code' and 'progresshash' are required.");
        }
        $query = [
            'code' => $code,
            'progresshash' => $progresshash
        ];
        $response = $this->client->get('uploadlinkprogress', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Copy a file from the current user's filesystem to a upload link.
     *
     * @param string $code 上傳連結的 code
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @param string|null $toname 複製後的檔名
     * @return array
     * @throws \InvalidArgumentException 若未提供 code 或 fileid/path
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function copytolink(
        string $code,
        ?int $fileid = null,
        ?string $path = null,
        ?string $toname = null
    ): array {
        if (empty($code) || ($fileid === null && $path === null)) {
            throw new \InvalidArgumentException("Parameter 'code' and ('fileid' or 'path') are required.");
        }
        $query = ['code' => $code];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        }
        if ($toname !== null) {
            $query['toname'] = $toname;
        }

        $response = $this->client->get('copytolink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
