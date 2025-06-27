<?php

namespace pCloud\Sdk\Api;


trait Collection
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Get a list of the collections owned by the current user.
     *
     * @param int|null $type 過濾型別（1=playlist）
     * @param bool $showfiles 是否回傳內容檔案 metadata
     * @param int|null $pagesize 若 showfiles 時，限制內容數量
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function collection_list(
        ?int $type = null,
        bool $showfiles = false,
        ?int $pagesize = null
    ): array {
        $query = [];
        if ($type !== null) {
            $query['type'] = $type;
        }
        if ($showfiles) {
            $query['showfiles'] = 1;
        }
        if ($pagesize !== null) {
            $query['pagesize'] = $pagesize;
        }
        $response = $this->client->get('collection_list', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get details for a given collection and the items in it.
     *
     * @param int $collectionid 收藏集ID
     * @param int|null $page 頁碼（預設0，全部）
     * @param int|null $pagesize 每頁數量
     * @return array
     * @throws \InvalidArgumentException 若未提供 collectionid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function collection_details(
        int $collectionid,
        ?int $page = null,
        ?int $pagesize = null
    ): array {
        if (empty($collectionid)) {
            throw new \InvalidArgumentException("Parameter 'collectionid' is required.");
        }
        $query = ['collectionid' => $collectionid];
        if ($page !== null) {
            $query['page'] = $page;
        }
        if ($pagesize !== null) {
            $query['pagesize'] = $pagesize;
        }
        $response = $this->client->get('collection_details', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a new collection for the current user.
     *
     * @param string $name 收藏集名稱
     * @param int|null $type 收藏集型別（預設1=playlist）
     * @param string|null $fileids 以逗號分隔的 fileid
     * @return array
     * @throws \InvalidArgumentException 若未提供 name
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function collection_create(
        string $name,
        ?int $type = null,
        ?string $fileids = null
    ): array {
        if (empty($name)) {
            throw new \InvalidArgumentException("Parameter 'name' is required.");
        }
        $query = ['name' => $name];
        if ($type !== null) {
            $query['type'] = $type;
        }
        if ($fileids !== null) {
            $query['fileids'] = $fileids;
        }
        $response = $this->client->get('collection_create', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Renames a given collection owned by the current user.
     *
     * @param int $collectionid 收藏集ID
     * @param string $name 新名稱
     * @return array
     * @throws \InvalidArgumentException 若未提供 collectionid 或 name
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function collection_rename(int $collectionid, string $name): array
    {
        if (empty($collectionid) || empty($name)) {
            throw new \InvalidArgumentException("Parameters 'collectionid' and 'name' are required.");
        }
        $query = [
            'collectionid' => $collectionid,
            'name' => $name
        ];
        $response = $this->client->get('collection_rename', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Delete a given collection owned by the current user.
     *
     * @param int $collectionid 收藏集ID
     * @return array
     * @throws \InvalidArgumentException 若未提供 collectionid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function collection_delete(int $collectionid): array
    {
        if (empty($collectionid)) {
            throw new \InvalidArgumentException("Parameter 'collectionid' is required.");
        }
        $query = ['collectionid' => $collectionid];
        $response = $this->client->get('collection_delete', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Appends files to the collection.
     *
     * @param int $collectionid 收藏集ID
     * @param string $fileids 以逗號分隔的 fileid
     * @param bool $noitems 若為 true，linkresult 為空
     * @return array
     * @throws \InvalidArgumentException 若未提供 collectionid 或 fileids
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function collection_linkfiles(
        int $collectionid,
        string $fileids,
        bool $noitems = false
    ): array {
        if (empty($collectionid) || empty($fileids)) {
            throw new \InvalidArgumentException("Parameters 'collectionid' and 'fileids' are required.");
        }
        $query = [
            'collectionid' => $collectionid,
            'fileids' => $fileids
        ];
        if ($noitems) {
            $query['noitems'] = 1;
        }
        $response = $this->client->get('collection_linkfiles', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Remove files from a current collection.
     *
     * @param int $collectionid 收藏集ID
     * @param string|null $positions 以逗號分隔的位置（優先）
     * @param bool $all 若為 true，移除所有檔案
     * @param string|null $fileids 以逗號分隔的 fileid
     * @return array
     * @throws \InvalidArgumentException 若未提供 collectionid 或未指定移除方式
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function collection_unlinkfiles(
        int $collectionid,
        ?string $positions = null,
        bool $all = false,
        ?string $fileids = null
    ): array {
        if (empty($collectionid)) {
            throw new \InvalidArgumentException("Parameter 'collectionid' is required.");
        }
        if ($positions === null && !$all && $fileids === null) {
            throw new \InvalidArgumentException("At least one of 'positions', 'all', or 'fileids' must be specified.");
        }
        $query = ['collectionid' => $collectionid];
        if ($positions !== null) {
            $query['positions'] = $positions;
        } elseif ($all) {
            $query['all'] = 1;
        } elseif ($fileids !== null) {
            $query['fileids'] = $fileids;
        }
        $response = $this->client->get('collection_unlinkfiles', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Changes the position of an item in a given collection.
     *
     * @param int $collectionid 收藏集ID
     * @param int $item 目前位置
     * @param int $fileid 檔案ID
     * @param int $position 目標位置
     * @return array
     * @throws \InvalidArgumentException 若未提供必要參數
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function collection_move(
        int $collectionid,
        int $item,
        int $fileid,
        int $position
    ): array {
        if (empty($collectionid) || empty($item) || empty($fileid) || empty($position)) {
            throw new \InvalidArgumentException("Parameters 'collectionid', 'item', 'fileid', and 'position' are required.");
        }
        $query = [
            'collectionid' => $collectionid,
            'item' => $item,
            'fileid' => $fileid,
            'position' => $position
        ];
        $response = $this->client->get('collection_move', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
