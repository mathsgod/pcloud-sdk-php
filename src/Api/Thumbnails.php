<?php

namespace pCloud\Sdk\Api;


trait Thumbnails
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Get a link to a thumbnail of a file.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @param string $size 縮圖尺寸（WIDTHxHEIGHT）
     * @param bool $crop 是否裁切
     * @param string|null $type 指定格式（如 png）
     * @return array 包含 hosts, path, expires, size 等資訊
     * @throws \InvalidArgumentException 若未提供 fileid/path 或 size
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getthumblink(
        ?int $fileid = null,
        ?string $path = null,
        string $size,
        bool $crop = false,
        ?string $type = null
    ): array {
        if (($fileid === null && $path === null) || empty($size)) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' and 'size' are required.");
        }
        $query = ['size' => $size];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        }
        if ($crop) {
            $query['crop'] = 1;
        }
        if ($type !== null) {
            $query['type'] = $type;
        }

        $response = $this->client->get('getthumblink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get links to thumbnails of a list of files.
     *
     * @param string $fileids 以逗號分隔的 fileid 列表
     * @param string $size 縮圖尺寸（WIDTHxHEIGHT）
     * @param bool $crop 是否裁切
     * @param string|null $type 指定格式（如 png）
     * @return array thumbs 陣列
     * @throws \InvalidArgumentException 若未提供 fileids 或 size
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getthumbslinks(
        string $fileids,
        string $size,
        bool $crop = false,
        ?string $type = null
    ): array {
        if (empty($fileids) || empty($size)) {
            throw new \InvalidArgumentException("Parameters 'fileids' and 'size' are required.");
        }
        $query = [
            'fileids' => $fileids,
            'size' => $size
        ];
        if ($crop) {
            $query['crop'] = 1;
        }
        if ($type !== null) {
            $query['type'] = $type;
        }

        $response = $this->client->get('getthumbslinks', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a thumbnail of a file (binary content).
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @param string $size 縮圖尺寸（WIDTHxHEIGHT）
     * @param bool $crop 是否裁切
     * @param string|null $type 指定格式（如 png）
     * @return string 縮圖二進位內容
     * @throws \InvalidArgumentException 若未提供 fileid/path 或 size
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getthumb(
        ?int $fileid = null,
        ?string $path = null,
        string $size,
        bool $crop = false,
        ?string $type = null
    ): string {
        if (($fileid === null && $path === null) || empty($size)) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' and 'size' are required.");
        }
        $query = ['size' => $size];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        }
        if ($crop) {
            $query['crop'] = 1;
        }
        if ($type !== null) {
            $query['type'] = $type;
        }

        $response = $this->client->get('getthumb', [
            'query' => $query
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * Create a thumbnail of a file and save it in the current user's filesystem.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @param string $size 縮圖尺寸（WIDTHxHEIGHT）
     * @param string|null $topath 儲存縮圖的完整路徑
     * @param int|null $tofolderid 儲存縮圖的資料夾ID
     * @param string|null $toname 儲存縮圖的檔名
     * @param bool $crop 是否裁切
     * @param string|null $type 指定格式（如 png）
     * @param bool $noover 不覆蓋已存在檔案
     * @return array metadata, width, height
     * @throws \InvalidArgumentException 若未提供 fileid/path 或 size 或未指定儲存目標
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function savethumb(
        ?int $fileid = null,
        ?string $path = null,
        string $size,
        ?string $topath = null,
        ?int $tofolderid = null,
        ?string $toname = null,
        bool $crop = false,
        ?string $type = null,
        bool $noover = false
    ): array {
        if (($fileid === null && $path === null) || empty($size)) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' and 'size' are required.");
        }
        if ($topath === null && ($tofolderid === null || $toname === null)) {
            throw new \InvalidArgumentException("Either 'topath' or both 'tofolderid' and 'toname' must be provided.");
        }
        $query = ['size' => $size];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
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
        if ($crop) {
            $query['crop'] = 1;
        }
        if ($type !== null) {
            $query['type'] = $type;
        }
        if ($noover) {
            $query['noover'] = 1;
        }

        $response = $this->client->get('savethumb', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
