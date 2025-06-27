<?php

namespace pCloud\Sdk\Api;


trait Folder
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Creates a folder.
     *
     * @param string|null $path 完整路徑（建議用 folderid+name 取代）
     * @param int|null $folderid 父資料夾ID
     * @param string|null $name 新資料夾名稱
     * @return array metadata 結構
     * @throws \InvalidArgumentException 若未提供 path 或 (folderid+name)
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createfolder(
        ?string $path = null,
        ?int $folderid = null,
        ?string $name = null
    ): array {
        if ($path === null && ($folderid === null || $name === null)) {
            throw new \InvalidArgumentException("Parameter 'path' or both 'folderid' and 'name' are required.");
        }
        $query = [];
        if ($path !== null) {
            $query['path'] = $path;
        } else {
            $query['folderid'] = $folderid;
            $query['name'] = $name;
        }
        $response = $this->client->get('createfolder', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Creates a folder if it doesn't exist or returns the existing folder's metadata.
     *
     * @param string|null $path 完整路徑（建議用 folderid+name 取代）
     * @param int|null $folderid 父資料夾ID
     * @param string|null $name 新資料夾名稱
     * @return array metadata 結構，含 created 欄位
     * @throws \InvalidArgumentException 若未提供 path 或 (folderid+name)
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createfolderifnotexists(
        ?string $path = null,
        ?int $folderid = null,
        ?string $name = null
    ): array {
        if ($path === null && ($folderid === null || $name === null)) {
            throw new \InvalidArgumentException("Parameter 'path' or both 'folderid' and 'name' are required.");
        }
        $query = [];
        if ($path !== null) {
            $query['path'] = $path;
        } else {
            $query['folderid'] = $folderid;
            $query['name'] = $name;
        }
        $response = $this->client->get('createfolderifnotexists', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Receive data for a folder (list contents).
     *
     * @param string|null $path 資料夾路徑（備選）
     * @param int|null $folderid 資料夾ID（優先）
     * @param bool $recursive 是否遞迴
     * @param bool $showdeleted 顯示可還原的已刪除檔案
     * @param bool $nofiles 僅回傳資料夾結構
     * @param bool $noshares 僅顯示自己的檔案/資料夾
     * @return array metadata 結構
     * @throws \InvalidArgumentException 若未提供 path 或 folderid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listfolder(
        ?string $path = null,
        ?int $folderid = null,
        bool $recursive = false,
        bool $showdeleted = false,
        bool $nofiles = false,
        bool $noshares = false
    ): array {
        if ($path === null && $folderid === null) {
            throw new \InvalidArgumentException("Parameter 'path' or 'folderid' is required.");
        }
        $query = [];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } else {
            $query['path'] = $path;
        }
        if ($recursive) {
            $query['recursive'] = 1;
        }
        if ($showdeleted) {
            $query['showdeleted'] = 1;
        }
        if ($nofiles) {
            $query['nofiles'] = 1;
        }
        if ($noshares) {
            $query['noshares'] = 1;
        }
        $response = $this->client->get('listfolder', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Renames (and/or moves) a folder.
     *
     * @param int|null $folderid 資料夾ID（優先）
     * @param string|null $path 資料夾路徑（備選）
     * @param string|null $topath 目標資料夾路徑（若為資料夾，需以 / 結尾）
     * @param int|null $tofolderid 目標父資料夾ID
     * @param string|null $toname 新資料夾名稱
     * @return array metadata 結構
     * @throws \InvalidArgumentException 若未提供 folderid/path 或未指定目標
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function renamefolder(
        ?int $folderid = null,
        ?string $path = null,
        ?string $topath = null,
        ?int $tofolderid = null,
        ?string $toname = null
    ): array {
        if ($folderid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'folderid' or 'path' is required.");
        }
        if ($topath === null && $tofolderid === null && $toname === null) {
            throw new \InvalidArgumentException("At least one of 'topath', 'tofolderid', or 'toname' must be specified.");
        }
        $query = [];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } else {
            $query['path'] = $path;
        }
        if ($topath !== null) {
            $query['topath'] = $topath;
        }
        if ($tofolderid !== null) {
            $query['tofolderid'] = $tofolderid;
        }
        if ($toname !== null) {
            $query['toname'] = $toname;
        }
        $response = $this->client->get('renamefolder', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Deletes a folder (must be empty).
     *
     * @param int|null $folderid 資料夾ID（優先）
     * @param string|null $path 資料夾路徑（備選）
     * @return array metadata 結構
     * @throws \InvalidArgumentException 若未提供 folderid/path
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deletefolder(
        ?int $folderid = null,
        ?string $path = null
    ): array {
        if ($folderid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'folderid' or 'path' is required.");
        }
        $query = [];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } else {
            $query['path'] = $path;
        }
        $response = $this->client->get('deletefolder', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Recursively deletes a folder and all its contents.
     *
     * @param int|null $folderid 資料夾ID（優先）
     * @param string|null $path 資料夾路徑（備選）
     * @return array 包含 deletedfiles, deletedfolders
     * @throws \InvalidArgumentException 若未提供 folderid/path
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deletefolderrecursive(
        ?int $folderid = null,
        ?string $path = null
    ): array {
        if ($folderid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'folderid' or 'path' is required.");
        }
        $query = [];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } else {
            $query['path'] = $path;
        }
        $response = $this->client->get('deletefolderrecursive', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Copies a folder to a destination folder or path.
     *
     * @param int|null $folderid 原始資料夾ID（優先）
     * @param string|null $path 原始資料夾路徑（備選）
     * @param int|null $tofolderid 目標資料夾ID
     * @param string|null $topath 目標資料夾路徑
     * @param bool $noover 不覆蓋同名檔案
     * @param bool $skipexisting 跳過已存在檔案
     * @param bool $copycontentonly 僅複製內容
     * @return array metadata 結構
     * @throws \InvalidArgumentException 若未提供 folderid/path 或未指定目標
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function copyfolder(
        ?int $folderid = null,
        ?string $path = null,
        ?int $tofolderid = null,
        ?string $topath = null,
        bool $noover = false,
        bool $skipexisting = false,
        bool $copycontentonly = false
    ): array {
        if ($folderid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'folderid' or 'path' is required.");
        }
        if ($tofolderid === null && $topath === null) {
            throw new \InvalidArgumentException("At least one of 'tofolderid' or 'topath' must be specified.");
        }
        $query = [];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } else {
            $query['path'] = $path;
        }
        if ($tofolderid !== null) {
            $query['tofolderid'] = $tofolderid;
        }
        if ($topath !== null) {
            $query['topath'] = $topath;
        }
        if ($noover) {
            $query['noover'] = 1;
        }
        if ($skipexisting) {
            $query['skipexisting'] = 1;
        }
        if ($copycontentonly) {
            $query['copycontentonly'] = 1;
        }
        $response = $this->client->get('copyfolder', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

}
