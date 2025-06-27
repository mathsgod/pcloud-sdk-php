<?php

namespace pCloud\Sdk\Api;

trait Archiving
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Receive a zip file from the user's filesystem.
     *
     * @param array $tree 檔案/資料夾結構
     * @param bool $forcedownload 是否強制下載（Content-Type: application/octet-stream）
     * @param string|null $filename 指定下載檔名（必須含 .zip）
     * @param string|null $timeoffset 時區偏移（如 +0800, -0500, PST）
     * @return string zip 檔案內容
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getzip(
        array $tree,
        bool $forcedownload = false,
        ?string $filename = null,
        ?string $timeoffset = null
    ): string {
        $query = [
            'tree' => json_encode($tree)
        ];
        if ($forcedownload) {
            $query['forcedownload'] = 1;
        }
        if ($filename !== null) {
            $query['filename'] = $filename;
        }
        if ($timeoffset !== null) {
            $query['timeoffset'] = $timeoffset;
        }

        $response = $this->client->get('getzip', [
            'query' => $query
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * Receive a zip file link for files in the user's filesystem.
     *
     * @param array $tree 檔案/資料夾結構
     * @param int|null $maxspeed 限制下載速度（bytes/sec）
     * @param bool $forcedownload 是否強制下載（Content-Type: application/octet-stream）
     * @param string|null $filename 指定下載檔名（必須含 .zip）
     * @param string|null $timeoffset 時區偏移（如 +0800, -0500, PST）
     * @return array 包含 path、hosts、expires 等資訊
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getziplink(
        array $tree,
        ?int $maxspeed = null,
        bool $forcedownload = false,
        ?string $filename = null,
        ?string $timeoffset = null
    ): array {
        $query = [
            'tree' => json_encode($tree)
        ];
        if ($maxspeed !== null) {
            $query['maxspeed'] = $maxspeed;
        }
        if ($forcedownload) {
            $query['forcedownload'] = 1;
        }
        if ($filename !== null) {
            $query['filename'] = $filename;
        }
        if ($timeoffset !== null) {
            $query['timeoffset'] = $timeoffset;
        }

        $response = $this->client->get('getziplink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a zip file in the user's filesystem.
     *
     * @param array $tree 檔案/資料夾結構
     * @param string|null $timeoffset 時區偏移（如 +0800, -0500, PST）
     * @param string|null $topath 儲存 zip 的完整路徑
     * @param int|null $tofolderid 儲存 zip 的資料夾 ID
     * @param string|null $toname zip 檔案名稱
     * @param string|null $progresshash 進度查詢用 key
     * @return array 回傳 metadata 結構
     * @throws \InvalidArgumentException 若未提供 topath 或 (tofolderid+toname)
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function savezip(
        array $tree,
        ?string $timeoffset = null,
        ?string $topath = null,
        ?int $tofolderid = null,
        ?string $toname = null,
        ?string $progresshash = null
    ): array {
        $query = [
            'tree' => json_encode($tree)
        ];
        if ($timeoffset !== null) {
            $query['timeoffset'] = $timeoffset;
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
        if ($progresshash !== null) {
            $query['progresshash'] = $progresshash;
        }
        // 必須提供 topath 或 (tofolderid 與 toname)
        if ($topath === null && ($tofolderid === null || $toname === null)) {
            throw new \InvalidArgumentException("Either 'topath' or both 'tofolderid' and 'toname' must be provided.");
        }

        $response = $this->client->get('savezip', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Extracts archive file from the user's filesystem.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @param int|null $tofolderid 目標資料夾ID
     * @param string|null $topath 目標資料夾路徑
     * @param string|null $password 解壓縮密碼
     * @param string $overwrite 覆蓋行為（rename, overwrite, skip）
     * @param bool $nooutput 不回傳解壓縮輸出
     * @return array 解壓縮進度與結果
     * @throws \InvalidArgumentException 若未提供 fileid/path 或 tofolderid/topath
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function extractarchive(
        ?int $fileid = null,
        ?string $path = null,
        ?int $tofolderid = null,
        ?string $topath = null,
        ?string $password = null,
        string $overwrite = 'rename',
        bool $nooutput = false
    ): array {
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException("Either 'fileid' or 'path' must be provided.");
        }
        if ($tofolderid !== null) {
            $query['tofolderid'] = $tofolderid;
        }
        if ($topath !== null) {
            $query['topath'] = $topath;
        }
        if ($tofolderid === null && $topath === null) {
            throw new \InvalidArgumentException("Either 'tofolderid' or 'topath' must be provided.");
        }
        if ($password !== null) {
            $query['password'] = $password;
        }
        if ($overwrite !== 'rename') {
            $query['overwrite'] = $overwrite;
        }
        if ($nooutput) {
            $query['nooutput'] = 1;
        }

        $response = $this->client->get('extractarchive', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Returns output and completion status of an archive extraction process.
     *
     * @param string $progresshash 由 extractarchive 回傳的 progresshash
     * @param int|null $lines 跳過前幾行輸出（可選）
     * @return array 包含 finished, output, lines 等資訊
     * @throws \InvalidArgumentException 若未提供 progresshash
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function extractarchiveprogress(string $progresshash, ?int $lines = null): array
    {
        if (empty($progresshash)) {
            throw new \InvalidArgumentException("Parameter 'progresshash' is required.");
        }
        $query = ['progresshash' => $progresshash];
        if ($lines !== null) {
            $query['lines'] = $lines;
        }

        $response = $this->client->get('extractarchiveprogress', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get the progress in process of zipping file in the user's filesystem.
     *
     * @param string $progresshash 由 savezip 傳入的進度 key
     * @return array 包含 files, totalfiles, bytes, totalbytes 等資訊
     * @throws \InvalidArgumentException 若未提供 progresshash
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function savezipprogress(string $progresshash): array
    {
        if (empty($progresshash)) {
            throw new \InvalidArgumentException("Parameter 'progresshash' is required.");
        }
        $query = ['progresshash' => $progresshash];

        $response = $this->client->get('savezipprogress', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
