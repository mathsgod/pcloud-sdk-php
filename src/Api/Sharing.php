<?php

namespace pCloud\Sdk\Api;

trait Sharing
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Shares a folder with another user.
     *
     * @param int|null $folderid 資料夾ID（優先）
     * @param string|null $path 資料夾路徑（備選）
     * @param string $mail 對方電子郵件
     * @param int $permissions 權限（0=唯讀，1=建立，2=修改，4=刪除，可組合）
     * @param string|null $name 分享名稱（預設為資料夾名稱）
     * @param string|null $message 傳送訊息
     * @return array
     * @throws \InvalidArgumentException 若未提供 folderid/path、mail、permissions
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sharefolder(
        ?int $folderid = null,
        ?string $path = null,
        string $mail,
        int $permissions,
        ?string $name = null,
        ?string $message = null
    ): array {
        $query = [
            'mail' => $mail,
            'permissions' => $permissions
        ];
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException("Either 'folderid' or 'path' must be provided.");
        }
        if ($name !== null) {
            $query['name'] = $name;
        }
        if ($message !== null) {
            $query['message'] = $message;
        }

        $response = $this->client->get('sharefolder', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * List current shares and share requests.
     *
     * @param array $params 可選參數：norequests, noshares, noincoming, nooutgoing
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listshares(array $params = []): array
    {
        $response = $this->client->get('listshares', [
            'query' => $params
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get information about a share request from the code that was sent to the user's email.
     *
     * @param string $code 信件中的分享請求代碼
     * @return array
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sharerequestinfo(string $code): array
    {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $response = $this->client->get('sharerequestinfo', [
            'query' => ['code' => $code]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Cancels a share request sent by the current user.
     *
     * @param int $sharerequestid 請求識別碼
     * @return array
     * @throws \InvalidArgumentException 若未提供 sharerequestid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancelsharerequest(int $sharerequestid): array
    {
        if (empty($sharerequestid)) {
            throw new \InvalidArgumentException("Parameter 'sharerequestid' is required.");
        }
        $response = $this->client->get('cancelsharerequest', [
            'query' => ['sharerequestid' => $sharerequestid]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Accept a share request.
     *
     * @param int|null $sharerequestid 分享請求ID（優先）
     * @param string|null $code 信件中的分享請求代碼（備選）
     * @param string|null $name 指定資料夾名稱
     * @param int|null $folderid 指定掛載資料夾ID
     * @param string|null $path 指定掛載路徑
     * @param bool $always 是否自動接受未來同用戶分享
     * @return array
     * @throws \InvalidArgumentException 若未提供 sharerequestid/code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function acceptshare(
        ?int $sharerequestid = null,
        ?string $code = null,
        ?string $name = null,
        ?int $folderid = null,
        ?string $path = null,
        bool $always = false
    ): array {
        $query = [];
        if ($sharerequestid !== null) {
            $query['sharerequestid'] = $sharerequestid;
        } elseif ($code !== null) {
            $query['code'] = $code;
        } else {
            throw new \InvalidArgumentException("Either 'sharerequestid' or 'code' must be provided.");
        }
        if ($name !== null) {
            $query['name'] = $name;
        }
        if ($folderid !== null) {
            $query['folderid'] = $folderid;
        }
        if ($path !== null) {
            $query['path'] = $path;
        }
        if ($always) {
            $query['always'] = 1;
        }

        $response = $this->client->get('acceptshare', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Decline a share request.
     *
     * @param int|null $sharerequestid 分享請求ID（優先）
     * @param string|null $code 信件中的分享請求代碼（備選）
     * @param bool $block 是否自動拒絕未來同用戶分享
     * @return array
     * @throws \InvalidArgumentException 若未提供 sharerequestid/code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function declineshare(
        ?int $sharerequestid = null,
        ?string $code = null,
        bool $block = false
    ): array {
        $query = [];
        if ($sharerequestid !== null) {
            $query['sharerequestid'] = $sharerequestid;
        } elseif ($code !== null) {
            $query['code'] = $code;
        } else {
            throw new \InvalidArgumentException("Either 'sharerequestid' or 'code' must be provided.");
        }
        if ($block) {
            $query['block'] = 1;
        }

        $response = $this->client->get('declineshare', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Remove an active share (incoming or outgoing).
     *
     * @param int $shareid 分享ID（由 listshares 回傳）
     * @return array
     * @throws \InvalidArgumentException 若未提供 shareid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeshare(int $shareid): array
    {
        if (empty($shareid)) {
            throw new \InvalidArgumentException("Parameter 'shareid' is required.");
        }
        $response = $this->client->get('removeshare', [
            'query' => ['shareid' => $shareid]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Change permissions of a share (only for outgoing shares).
     *
     * @param int $shareid 分享ID（由 listshares 回傳）
     * @param int $permissions 權限（0=唯讀，1=建立，2=修改，4=刪除，可組合）
     * @return array
     * @throws \InvalidArgumentException 若未提供 shareid 或 permissions
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changeshare(int $shareid, int $permissions): array
    {
        if (empty($shareid)) {
            throw new \InvalidArgumentException("Parameter 'shareid' is required.");
        }
        if (!isset($permissions)) {
            throw new \InvalidArgumentException("Parameter 'permissions' is required.");
        }
        $response = $this->client->get('changeshare', [
            'query' => [
                'shareid' => $shareid,
                'permissions' => $permissions
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
