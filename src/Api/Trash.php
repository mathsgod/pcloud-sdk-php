<?php

namespace pCloud\Sdk\Api;


trait Trash
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Lists the contents of a folder in the Trash.
     *
     * @param int $folderid 垃圾桶資料夾ID，預設為0（根目錄）
     * @param bool $nofiles 不包含檔案
     * @param bool $recursive 是否遞迴列出所有子資料夾
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function trash_list(
        int $folderid = 0,
        bool $nofiles = false,
        bool $recursive = false
    ): array {
        $query = ['folderid' => $folderid];
        if ($nofiles) {
            $query['nofiles'] = 1;
        }
        if ($recursive) {
            $query['recursive'] = 1;
        }
        $response = $this->client->get('trash_list', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Calculates where a file or folder from the Trash will be restored.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param int|null $folderid 資料夾ID（備選）
     * @return array 包含 metadata 與 destination
     * @throws \InvalidArgumentException 若未提供 fileid/folderid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function trash_restorepath(?int $fileid = null, ?int $folderid = null): array
    {
        if ($fileid === null && $folderid === null) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'folderid' is required.");
        }
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($folderid !== null) {
            $query['folderid'] = $folderid;
        }
        $response = $this->client->get('trash_restorepath', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Restores files or folders from the Trash back to the filesystem.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param int|null $folderid 資料夾ID（備選）
     * @param int|null $restoreto 指定還原目標資料夾ID
     * @param bool $metadata 若還原資料夾時，是否回傳內容資訊
     * @return array 還原後的 metadata 或 restored 陣列
     * @throws \InvalidArgumentException 若未提供 fileid/folderid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function trash_restore(
        ?int $fileid = null,
        ?int $folderid = null,
        ?int $restoreto = null,
        bool $metadata = false
    ): array {
        if ($fileid === null && $folderid === null) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'folderid' is required.");
        }
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($folderid !== null) {
            $query['folderid'] = $folderid;
        }
        if ($restoreto !== null) {
            $query['restoreto'] = $restoreto;
        }
        if ($metadata) {
            $query['metadata'] = 1;
        }
        $response = $this->client->get('trash_restore', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Permanently deletes files or folders from the Trash.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param int|null $folderid 資料夾ID（備選）
     * @return array
     * @throws \InvalidArgumentException 若未提供 fileid/folderid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function trash_clear(?int $fileid = null, ?int $folderid = null): array
    {
        if ($fileid === null && $folderid === null) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'folderid' is required.");
        }
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($folderid !== null) {
            $query['folderid'] = $folderid;
        }
        $response = $this->client->get('trash_clear', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
