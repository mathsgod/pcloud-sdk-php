<?php

namespace pCloud\Sdk\Api;

trait PublicLinks
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Creates and returns a public link to a file.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @param string|null $expire 到期時間（datetime）
     * @param int|null $maxdownloads 最大下載次數
     * @param int|null $maxtraffic 最大流量（bytes）
     * @param bool $shortlink 是否產生短連結
     * @param string|null $linkpassword 連結密碼
     * @return array
     * @throws \InvalidArgumentException 若未提供 fileid/path
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getfilepublink(
        ?int $fileid = null,
        ?string $path = null,
        ?string $expire = null,
        ?int $maxdownloads = null,
        ?int $maxtraffic = null,
        bool $shortlink = false,
        ?string $linkpassword = null
    ): array {
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException("Either 'fileid' or 'path' must be provided.");
        }
        if ($expire !== null) {
            $query['expire'] = $expire;
        }
        if ($maxdownloads !== null) {
            $query['maxdownloads'] = $maxdownloads;
        }
        if ($maxtraffic !== null) {
            $query['maxtraffic'] = $maxtraffic;
        }
        if ($shortlink) {
            $query['shortlink'] = 1;
        }
        if ($linkpassword !== null) {
            $query['linkpassword'] = $linkpassword;
        }

        $response = $this->client->get('getfilepublink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Creates and returns a public link to a folder.
     *
     * @param int|null $folderid 資料夾ID（優先）
     * @param string|null $path 資料夾路徑（備選）
     * @param string|null $expire 到期時間（datetime）
     * @param int|null $maxdownloads 最大下載次數
     * @param int|null $maxtraffic 最大流量（bytes）
     * @param bool $shortlink 是否產生短連結
     * @param string|null $linkpassword 連結密碼
     * @return array
     * @throws \InvalidArgumentException 若未提供 folderid/path
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getfolderpublink(
        ?int $folderid = null,
        ?string $path = null,
        ?string $expire = null,
        ?int $maxdownloads = null,
        ?int $maxtraffic = null,
        bool $shortlink = false,
        ?string $linkpassword = null
    ): array {
        $query = [];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException("Either 'folderid' or 'path' must be provided.");
        }
        if ($expire !== null) {
            $query['expire'] = $expire;
        }
        if ($maxdownloads !== null) {
            $query['maxdownloads'] = $maxdownloads;
        }
        if ($maxtraffic !== null) {
            $query['maxtraffic'] = $maxtraffic;
        }
        if ($shortlink) {
            $query['shortlink'] = 1;
        }
        if ($linkpassword !== null) {
            $query['linkpassword'] = $linkpassword;
        }

        $response = $this->client->get('getfolderpublink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Creates and returns a public link to a virtual folder defined by requested tree.
     *
     * @param string $name 虛擬資料夾名稱
     * @param string|null $fileids 以逗號分隔的 fileid
     * @param string|null $folderids 以逗號分隔的 folderid
     * @param int|null $folderid 若指定，將資料夾內容直接放入虛擬資料夾
     * @param string|null $expire 到期時間（datetime）
     * @param int|null $maxdownloads 最大下載次數
     * @param int|null $maxtraffic 最大流量（bytes）
     * @param bool $shortlink 是否產生短連結
     * @param string|null $linkpassword 連結密碼
     * @return array
     * @throws \InvalidArgumentException 若未提供 name
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gettreepublink(
        string $name,
        ?string $fileids = null,
        ?string $folderids = null,
        ?int $folderid = null,
        ?string $expire = null,
        ?int $maxdownloads = null,
        ?int $maxtraffic = null,
        bool $shortlink = false,
        ?string $linkpassword = null
    ): array {
        if (empty($name)) {
            throw new \InvalidArgumentException("Parameter 'name' is required.");
        }
        $query = ['name' => $name];
        if ($fileids !== null) {
            $query['fileids'] = $fileids;
        }
        if ($folderids !== null) {
            $query['folderids'] = $folderids;
        }
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        }
        if ($expire !== null) {
            $query['expire'] = $expire;
        }
        if ($maxdownloads !== null) {
            $query['maxdownloads'] = $maxdownloads;
        }
        if ($maxtraffic !== null) {
            $query['maxtraffic'] = $maxtraffic;
        }
        if ($shortlink) {
            $query['shortlink'] = 1;
        }
        if ($linkpassword !== null) {
            $query['linkpassword'] = $linkpassword;
        }

        $response = $this->client->get('gettreepublink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Returns metadata of the object the public link points to.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @return array
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function showpublink(string $code): array
    {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $response = $this->client->get('showpublink', [
            'query' => ['code' => $code]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Returns link(s) where the file can be downloaded from a public link.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param int|null $fileid 若為資料夾連結時需指定檔案ID
     * @param bool $forcedownload 強制下載
     * @param string|null $contenttype 指定 Content-Type
     * @param int|null $maxspeed 限制下載速度
     * @param bool $skipfilename 不包含檔名於連結
     * @return array
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getpublinkdownload(
        string $code,
        ?int $fileid = null,
        bool $forcedownload = false,
        ?string $contenttype = null,
        ?int $maxspeed = null,
        bool $skipfilename = false
    ): array {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $query = ['code' => $code];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        }
        if ($forcedownload) {
            $query['forcedownload'] = 1;
        }
        if ($contenttype !== null) {
            $query['contenttype'] = $contenttype;
        }
        if ($maxspeed !== null) {
            $query['maxspeed'] = $maxspeed;
        }
        if ($skipfilename) {
            $query['skipfilename'] = 1;
        }

        $response = $this->client->get('getpublinkdownload', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Copies the file from the public link to the current user's filesystem.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param int|null $fileid 若為資料夾連結時需指定檔案ID
     * @param string|null $topath 目標完整路徑
     * @param int|null $tofolderid 目標資料夾ID
     * @param string|null $toname 目標檔案名稱
     * @param bool $noover 不覆蓋已存在檔案
     * @return array 新檔案 metadata
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function copypubfile(
        string $code,
        ?int $fileid = null,
        ?string $topath = null,
        ?int $tofolderid = null,
        ?string $toname = null,
        bool $noover = false
    ): array {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $query = ['code' => $code];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
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
        if ($noover) {
            $query['noover'] = 1;
        }

        $response = $this->client->get('copypubfile', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Return a list of current user's public links.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listpublinks(): array
    {
        $response = $this->client->get('listpublinks');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Return a short list of current user's public links (no metadata).
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listplshort(): array
    {
        $response = $this->client->get('listplshort');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Delete a specified public link.
     *
     * @param int $linkid 公開連結ID
     * @return array
     * @throws \InvalidArgumentException 若未提供 linkid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deletepublink(int $linkid): array
    {
        if (empty($linkid)) {
            throw new \InvalidArgumentException("Parameter 'linkid' is required.");
        }
        $response = $this->client->get('deletepublink', [
            'query' => ['linkid' => $linkid]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Modify a specified public link.
     *
     * @param int $linkid 公開連結ID
     * @param array $options 可選參數：shortlink, deleteshortlink, expire, deleteexpire, maxtraffic, maxdownloads, linkpassword
     * @return array
     * @throws \InvalidArgumentException 若未提供 linkid 或 options 為空
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changepublink(int $linkid, array $options): array
    {
        if (empty($linkid)) {
            throw new \InvalidArgumentException("Parameter 'linkid' is required.");
        }
        if (empty($options)) {
            throw new \InvalidArgumentException("At least one option parameter must be specified.");
        }
        $query = array_merge(['linkid' => $linkid], $options);

        $response = $this->client->get('changepublink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a thumbnail of a public file.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param int $fileid 檔案ID（若為資料夾連結時必填）
     * @param string $size 縮圖尺寸（WIDTHxHEIGHT）
     * @param bool $crop 是否裁切
     * @param string|null $type 指定格式（如 png）
     * @return string 縮圖內容（二進位資料）
     * @throws \InvalidArgumentException 若未提供必要參數
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getpubthumb(
        string $code,
        int $fileid,
        string $size,
        bool $crop = false,
        ?string $type = null
    ): string {
        if (empty($code) || empty($fileid) || empty($size)) {
            throw new \InvalidArgumentException("Parameters 'code', 'fileid', and 'size' are required.");
        }
        $query = [
            'code' => $code,
            'fileid' => $fileid,
            'size' => $size
        ];
        if ($crop) {
            $query['crop'] = 1;
        }
        if ($type !== null) {
            $query['type'] = $type;
        }

        $response = $this->client->get('getpubthumb', [
            'query' => $query
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * Get a link to a thumbnail of a public file.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param int $fileid 檔案ID（若為資料夾連結時必填）
     * @param string $size 縮圖尺寸（WIDTHxHEIGHT）
     * @param bool $crop 是否裁切
     * @param string|null $type 指定格式（如 png）
     * @return array 包含 hosts, path, expires 等資訊
     * @throws \InvalidArgumentException 若未提供必要參數
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getpubthumblink(
        string $code,
        int $fileid,
        string $size,
        bool $crop = false,
        ?string $type = null
    ): array {
        if (empty($code) || empty($fileid) || empty($size)) {
            throw new \InvalidArgumentException("Parameters 'code', 'fileid', and 'size' are required.");
        }
        $query = [
            'code' => $code,
            'fileid' => $fileid,
            'size' => $size
        ];
        if ($crop) {
            $query['crop'] = 1;
        }
        if ($type !== null) {
            $query['type'] = $type;
        }

        $response = $this->client->get('getpubthumblink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get links to thumbnails of a public file (multiple sizes).
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param int $fileid 檔案ID（若為資料夾連結時必填）
     * @param string $size 多個尺寸（WIDTHxHEIGHT, 逗號分隔）
     * @param bool $crop 是否裁切
     * @param string|null $type 指定格式（如 png）
     * @return array 包含 hosts, links, expires 等資訊
     * @throws \InvalidArgumentException 若未提供必要參數
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getpubthumbslinks(
        string $code,
        int $fileid,
        string $size,
        bool $crop = false,
        ?string $type = null
    ): array {
        if (empty($code) || empty($fileid) || empty($size)) {
            throw new \InvalidArgumentException("Parameters 'code', 'fileid', and 'size' are required.");
        }
        $query = [
            'code' => $code,
            'fileid' => $fileid,
            'size' => $size
        ];
        if ($crop) {
            $query['crop'] = 1;
        }
        if ($type !== null) {
            $query['type'] = $type;
        }

        $response = $this->client->get('getpubthumbslinks', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a thumbnail of a public link file and save it in the current user's filesystem.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param int $fileid 檔案ID（若為資料夾連結時必填）
     * @param string $size 縮圖尺寸（WIDTHxHEIGHT）
     * @param string|null $topath 儲存縮圖的完整路徑
     * @param int|null $tofolderid 儲存縮圖的資料夾ID
     * @param string|null $toname 儲存縮圖的檔名
     * @param bool $crop 是否裁切
     * @param string|null $type 指定格式（如 png）
     * @param bool $noover 不覆蓋已存在檔案
     * @return array 新縮圖檔案 metadata
     * @throws \InvalidArgumentException 若未提供必要參數
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function savepubthumb(
        string $code,
        int $fileid,
        string $size,
        ?string $topath = null,
        ?int $tofolderid = null,
        ?string $toname = null,
        bool $crop = false,
        ?string $type = null,
        bool $noover = false
    ): array {
        if (empty($code) || empty($fileid) || empty($size)) {
            throw new \InvalidArgumentException("Parameters 'code', 'fileid', and 'size' are required.");
        }
        if ($topath === null && ($tofolderid === null || $toname === null)) {
            throw new \InvalidArgumentException("Either 'topath' or both 'tofolderid' and 'toname' must be provided.");
        }
        $query = [
            'code' => $code,
            'fileid' => $fileid,
            'size' => $size
        ];
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

        $response = $this->client->get('savepubthumb', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a zip archive file of a public link file and download it.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param bool $forcedownload 是否強制下載（Content-Type: application/octet-stream）
     * @param string|null $filename 指定下載檔名（必須含 .zip）
     * @param string|null $timeoffset 時區偏移（如 +0800, -0500, PST）
     * @return string zip 檔案內容（二進位資料）
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getpubzip(
        string $code,
        bool $forcedownload = false,
        ?string $filename = null,
        ?string $timeoffset = null
    ): string {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $query = ['code' => $code];
        if ($forcedownload) {
            $query['forcedownload'] = 1;
        }
        if ($filename !== null) {
            $query['filename'] = $filename;
        }
        if ($timeoffset !== null) {
            $query['timeoffset'] = $timeoffset;
        }

        $response = $this->client->get('getpubzip', [
            'query' => $query
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * Create a link to a zip archive file of a public link file.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param bool $forcedownload 是否強制下載（Content-Type: application/octet-stream）
     * @param string|null $filename 指定下載檔名（必須含 .zip）
     * @param string|null $timeoffset 時區偏移（如 +0800, -0500, PST）
     * @return array 包含 path、hosts、expires 等資訊
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getpubziplink(
        string $code,
        bool $forcedownload = false,
        ?string $filename = null,
        ?string $timeoffset = null
    ): array {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $query = ['code' => $code];
        if ($forcedownload) {
            $query['forcedownload'] = 1;
        }
        if ($filename !== null) {
            $query['filename'] = $filename;
        }
        if ($timeoffset !== null) {
            $query['timeoffset'] = $timeoffset;
        }

        $response = $this->client->get('getpubziplink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a zip archive file of a public link file in the current user filesystem.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param string|null $timeoffset 時區偏移（如 +0800, -0500, PST）
     * @param string|null $topath 儲存 zip 的完整路徑
     * @param int|null $tofolderid 儲存 zip 的資料夾 ID
     * @param string|null $toname zip 檔案名稱
     * @return array 回傳 metadata 結構
     * @throws \InvalidArgumentException 若未提供 code 或未提供 topath 或 (tofolderid+toname)
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function savepubzip(
        string $code,
        ?string $timeoffset = null,
        ?string $topath = null,
        ?int $tofolderid = null,
        ?string $toname = null
    ): array {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        if ($topath === null && ($tofolderid === null || $toname === null)) {
            throw new \InvalidArgumentException("Either 'topath' or both 'tofolderid' and 'toname' must be provided.");
        }
        $query = ['code' => $code];
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

        $response = $this->client->get('savepubzip', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Returns variants array of different quality/resolution versions of a video in a public link.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param int|null $fileid 若為資料夾連結時需指定檔案ID
     * @param bool $forcedownload 強制下載
     * @param string|null $contenttype 指定 Content-Type
     * @param int|null $maxspeed 限制下載速度
     * @param bool $skipfilename 不包含檔名於連結
     * @return array variants 陣列
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getpubvideolinks(
        string $code,
        ?int $fileid = null,
        bool $forcedownload = false,
        ?string $contenttype = null,
        ?int $maxspeed = null,
        bool $skipfilename = false
    ): array {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $query = ['code' => $code];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        }
        if ($forcedownload) {
            $query['forcedownload'] = 1;
        }
        if ($contenttype !== null) {
            $query['contenttype'] = $contenttype;
        }
        if ($maxspeed !== null) {
            $query['maxspeed'] = $maxspeed;
        }
        if ($skipfilename) {
            $query['skipfilename'] = 1;
        }

        $response = $this->client->get('getpubvideolinks', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a link to an audio file of a public link file (for streaming).
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param int|null $fileid 若為資料夾連結時需指定檔案ID
     * @param bool $forcedownload 強制下載
     * @param string|null $contenttype 指定 Content-Type
     * @param int|null $abitrate 音訊比特率（16~320 kbps）
     * @return array 包含 hosts, path, expires 等資訊
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getpubaudiolink(
        string $code,
        ?int $fileid = null,
        bool $forcedownload = false,
        ?string $contenttype = null,
        ?int $abitrate = null
    ): array {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $query = ['code' => $code];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        }
        if ($forcedownload) {
            $query['forcedownload'] = 1;
        }
        if ($contenttype !== null) {
            $query['contenttype'] = $contenttype;
        }
        if ($abitrate !== null) {
            $query['abitrate'] = $abitrate;
        }

        $response = $this->client->get('getpubaudiolink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Download a text file from a public link with optional encoding conversion.
     *
     * @param string $code 公開連結的 code 或 shortcode
     * @param int|null $fileid 若為資料夾連結時需指定檔案ID
     * @param string|null $fromencoding 原始編碼（預設自動判斷）
     * @param string|null $toencoding 輸出編碼（預設 utf-8）
     * @param bool $forcedownload 強制下載
     * @param string|null $contenttype 指定 Content-Type
     * @return string 文字檔內容
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getpubtextfile(
        string $code,
        ?int $fileid = null,
        ?string $fromencoding = null,
        ?string $toencoding = null,
        bool $forcedownload = false,
        ?string $contenttype = null
    ): string {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $query = ['code' => $code];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        }
        if ($fromencoding !== null) {
            $query['fromencoding'] = $fromencoding;
        }
        if ($toencoding !== null) {
            $query['toencoding'] = $toencoding;
        }
        if ($forcedownload) {
            $query['forcedownload'] = 1;
        }
        if ($contenttype !== null) {
            $query['contenttype'] = $contenttype;
        }

        $response = $this->client->get('getpubtextfile', [
            'query' => $query
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * Generates a public link to a collection, owned by the current user.
     *
     * @param int $collectionid 收藏集ID
     * @param string|null $expire 到期時間（datetime）
     * @param int|null $maxdownloads 最大下載次數
     * @param int|null $maxtraffic 最大流量（bytes）
     * @param bool $shortlink 是否產生短連結
     * @return array
     * @throws \InvalidArgumentException 若未提供 collectionid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getcollectionpublink(
        int $collectionid,
        ?string $expire = null,
        ?int $maxdownloads = null,
        ?int $maxtraffic = null,
        bool $shortlink = false
    ): array {
        if (empty($collectionid)) {
            throw new \InvalidArgumentException("Parameter 'collectionid' is required.");
        }
        $query = ['collectionid' => $collectionid];
        if ($expire !== null) {
            $query['expire'] = $expire;
        }
        if ($maxdownloads !== null) {
            $query['maxdownloads'] = $maxdownloads;
        }
        if ($maxtraffic !== null) {
            $query['maxtraffic'] = $maxtraffic;
        }
        if ($shortlink) {
            $query['shortlink'] = 1;
        }

        $response = $this->client->get('getcollectionpublink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}