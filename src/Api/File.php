<?php

namespace pCloud\Sdk\Api; 

trait File
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Upload a file to a folder.
     *
     * @param array $files 欲上傳的檔案（['fieldname' => '/path/to/file'] 或 [['name'=>'file', 'path'=>'/path/to/file', 'filename'=>'xxx.ext']]）
     * @param string|null $path 目標資料夾路徑（備選）
     * @param int|null $folderid 目標資料夾ID（優先）
     * @param bool $nopartial 不儲存部分上傳檔案
     * @param string|null $progresshash 上傳進度 hash
     * @param bool $renameifexists 命名衝突時自動更名
     * @param int|null $mtime 檔案修改時間（Unix timestamp）
     * @param int|null $ctime 檔案建立時間（需同時指定 mtime）
     * @return array 包含 fileids 與 metadata
     * @throws \InvalidArgumentException 若未提供 files
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadfile(
        array $files,
        ?string $path = null,
        ?int $folderid = null,
        bool $nopartial = false,
        ?string $progresshash = null,
        bool $renameifexists = false,
        ?int $mtime = null,
        ?int $ctime = null
    ): array {
        if (empty($files)) {
            throw new \InvalidArgumentException("Parameter 'files' is required.");
        }
        $multipart = [];
        foreach ($files as $key => $file) {
            if (is_array($file) && isset($file['path'])) {
                $filename = $file['filename'] ?? basename($file['path']);
                $multipart[] = [
                    'name' => is_string($key) ? $key : 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => $filename
                ];
            } else {
                $multipart[] = [
                    'name' => is_string($key) ? $key : 'file',
                    'contents' => fopen($file, 'r'),
                    'filename' => basename($file)
                ];
            }
        }
        $query = [];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        }
        if ($nopartial) {
            $query['nopartial'] = 1;
        }
        if ($progresshash !== null) {
            $query['progresshash'] = $progresshash;
        }
        if ($renameifexists) {
            $query['renameifexists'] = 1;
        }
        if ($mtime !== null) {
            $query['mtime'] = $mtime;
        }
        if ($ctime !== null) {
            $query['ctime'] = $ctime;
        }

        $response = $this->client->request('POST', 'uploadfile', [
            'query' => $query,
            'multipart' => $multipart
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get upload progress of a file.
     *
     * @param string $progresshash 上傳進度 hash
     * @return array
     * @throws \InvalidArgumentException 若未提供 progresshash
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadprogress(string $progresshash): array
    {
        if (empty($progresshash)) {
            throw new \InvalidArgumentException("Parameter 'progresshash' is required.");
        }
        $response = $this->client->get('uploadprogress', [
            'query' => ['progresshash' => $progresshash]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Download one or more files from URLs to a folder in the user's filesystem.
     *
     * @param string $url 一個或多個下載連結（以空白分隔）
     * @param string|null $path 目標資料夾路徑（備選）
     * @param int|null $folderid 目標資料夾ID（優先）
     * @param string|null $target 下載後檔名（逗號分隔，對應 url 順序，需 urlencode）
     * @param string|null $progresshash 上傳進度 hash
     * @return array metadata 陣列
     * @throws \InvalidArgumentException 若未提供 url
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadfile(
        string $url,
        ?string $path = null,
        ?int $folderid = null,
        ?string $target = null,
        ?string $progresshash = null
    ): array {
        if (empty($url)) {
            throw new \InvalidArgumentException("Parameter 'url' is required.");
        }
        $query = ['url' => $url];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        }
        if ($target !== null) {
            $query['target'] = $target;
        }
        if ($progresshash !== null) {
            $query['progresshash'] = $progresshash;
        }
        $response = $this->client->get('downloadfile', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Queue one or more files for download from URLs to a folder in the user's filesystem (async).
     *
     * @param string $url 一個或多個下載連結（以空白分隔）
     * @param string|null $path 目標資料夾路徑（備選）
     * @param int|null $folderid 目標資料夾ID（優先）
     * @param string|null $target 下載後檔名（逗號分隔，對應 url 順序，需 urlencode）
     * @param string|null $progresshash 上傳進度 hash
     * @return array metadata 陣列
     * @throws \InvalidArgumentException 若未提供 url
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadfileasync(
        string $url,
        ?string $path = null,
        ?int $folderid = null,
        ?string $target = null,
        ?string $progresshash = null
    ): array {
        if (empty($url)) {
            throw new \InvalidArgumentException("Parameter 'url' is required.");
        }
        $query = ['url' => $url];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        }
        if ($target !== null) {
            $query['target'] = $target;
        }
        if ($progresshash !== null) {
            $query['progresshash'] = $progresshash;
        }
        $response = $this->client->get('downloadfileasync', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Copies a file as another file in the user's filesystem.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @param int|null $tofolderid 目標資料夾ID
     * @param string|null $topath 目標完整路徑
     * @param string|null $toname 目標檔案名稱
     * @param bool $noover 不覆蓋已存在檔案
     * @param int|null $mtime 檔案修改時間（Unix timestamp）
     * @param int|null $ctime 檔案建立時間（需同時指定 mtime）
     * @return array metadata 結構
     * @throws \InvalidArgumentException 若未提供 fileid/path 或未指定目標
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function copyfile(
        ?int $fileid = null,
        ?string $path = null,
        ?int $tofolderid = null,
        ?string $topath = null,
        ?string $toname = null,
        bool $noover = false,
        ?int $mtime = null,
        ?int $ctime = null
    ): array {
        if ($fileid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' is required.");
        }
        if ($tofolderid === null && $topath === null) {
            throw new \InvalidArgumentException("At least one of 'tofolderid' or 'topath' must be specified.");
        }
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } else {
            $query['path'] = $path;
        }
        if ($tofolderid !== null) {
            $query['tofolderid'] = $tofolderid;
        }
        if ($topath !== null) {
            $query['topath'] = $topath;
        }
        if ($toname !== null) {
            $query['toname'] = $toname;
        }
        if ($noover) {
            $query['noover'] = 1;
        }
        if ($mtime !== null) {
            $query['mtime'] = $mtime;
        }
        if ($ctime !== null) {
            $query['ctime'] = $ctime;
        }
        $response = $this->client->get('copyfile', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Calculate checksums of a given file.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @return array 包含 sha1、md5、sha256 與 metadata
     * @throws \InvalidArgumentException 若未提供 fileid/path
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checksumfile(
        ?int $fileid = null,
        ?string $path = null
    ): array {
        if ($fileid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' is required.");
        }
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } else {
            $query['path'] = $path;
        }
        $response = $this->client->get('checksumfile', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Delete a file identified by fileid or path.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @return array metadata 結構（含 isdeleted）
     * @throws \InvalidArgumentException 若未提供 fileid/path
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deletefile(
        ?int $fileid = null,
        ?string $path = null
    ): array {
        if ($fileid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' is required.");
        }
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } else {
            $query['path'] = $path;
        }
        $response = $this->client->get('deletefile', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Rename (and/or move) a file.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @param string|null $topath 目標路徑（若為資料夾，需以 / 結尾）
     * @param int|null $tofolderid 目標父資料夾ID
     * @param string|null $toname 新檔案名稱
     * @return array metadata 結構（若合併會含 deletedfileid）
     * @throws \InvalidArgumentException 若未提供 fileid/path 或未指定目標
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function renamefile(
        ?int $fileid = null,
        ?string $path = null,
        ?string $topath = null,
        ?int $tofolderid = null,
        ?string $toname = null
    ): array {
        if ($fileid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' is required.");
        }
        if ($topath === null && $tofolderid === null && $toname === null) {
            throw new \InvalidArgumentException("At least one of 'topath', 'tofolderid', or 'toname' must be specified.");
        }
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
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
        $response = $this->client->get('renamefile', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get metadata for a file or folder by fileid or path.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @return array metadata 結構
     * @throws \InvalidArgumentException 若未提供 fileid/path
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stat(
        ?int $fileid = null,
        ?string $path = null
    ): array {
        if ($fileid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' is required.");
        }
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } else {
            $query['path'] = $path;
        }
        $response = $this->client->get('stat', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

}
