<?php

namespace pCloud\Sdk\Api;

trait Auth
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Sends email to the logged in user with email activation link.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendverificationemail(): array
    {
        $response = $this->client->get('sendverificationemail');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Verify an email using the activation code.
     *
     * @param string $code 驗證信中的 activation code
     * @return array 包含 email 與 userid
     * @throws \InvalidArgumentException 若未提供 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyemail(string $code): array
    {
        if (empty($code)) {
            throw new \InvalidArgumentException("Parameter 'code' is required.");
        }
        $response = $this->client->get('verifyemail', [
            'query' => ['code' => $code]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Change current user's password.
     *
     * @param string $oldpassword 舊密碼
     * @param string $newpassword 新密碼
     * @return array
     * @throws \InvalidArgumentException 若未提供 oldpassword 或 newpassword
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changepassword(string $oldpassword, string $newpassword): array
    {
        if (empty($oldpassword) || empty($newpassword)) {
            throw new \InvalidArgumentException("Parameters 'oldpassword' and 'newpassword' are required.");
        }
        $response = $this->client->get('changepassword', [
            'query' => [
                'oldpassword' => $oldpassword,
                'newpassword' => $newpassword
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Send password reset instructions to the specified email.
     *
     * @param string $mail 使用者 email
     * @return array
     * @throws \InvalidArgumentException 若未提供 mail
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function lostpassword(string $mail): array
    {
        if (empty($mail)) {
            throw new \InvalidArgumentException("Parameter 'mail' is required.");
        }
        $response = $this->client->get('lostpassword', [
            'query' => ['mail' => $mail]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Reset user's password using code sent to email.
     *
     * @param string $code 驗證碼
     * @param string $newpassword 新密碼
     * @return array
     * @throws \InvalidArgumentException 若未提供 code 或 newpassword
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function resetpassword(string $code, string $newpassword): array
    {
        if (empty($code) || empty($newpassword)) {
            throw new \InvalidArgumentException("Parameters 'code' and 'newpassword' are required.");
        }
        $response = $this->client->get('resetpassword', [
            'query' => [
                'code' => $code,
                'newpassword' => $newpassword
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Register a new user account.
     *
     * @param string $mail 使用者 email
     * @param string $password 密碼
     * @param string $termsaccepted 必須為 'yes'
     * @param string|null $language 語言
     * @param string|null $referer 推薦人 userid
     * @return array
     * @throws \InvalidArgumentException 若未提供 mail、password、termsaccepted
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function register(
        string $mail,
        string $password,
        string $termsaccepted,
        ?string $language = null,
        ?string $referer = null
    ): array {
        if (empty($mail) || empty($password) || $termsaccepted !== 'yes') {
            throw new \InvalidArgumentException("Parameters 'mail', 'password' and 'termsaccepted'='yes' are required.");
        }
        $query = [
            'mail' => $mail,
            'password' => $password,
            'termsaccepted' => $termsaccepted
        ];
        if ($language !== null) {
            $query['language'] = $language;
        }
        if ($referer !== null) {
            $query['referer'] = $referer;
        }
        $response = $this->client->get('register', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get url of a registration page with a referrer code.
     *
     * @return array 包含 url 與 spacelimitreached
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function invite(): array
    {
        $response = $this->client->get('invite');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a list of the invitations of the current user.
     *
     * @return array 包含 invites 陣列
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function userinvites(): array
    {
        $response = $this->client->get('userinvites');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Invalidate the current token (logout).
     *
     * @return array 包含 auth_deleted
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function logout(): array
    {
        $response = $this->client->get('logout');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a list with the currently active tokens associated with the current user.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listtokens(): array
    {
        $response = $this->client->get('/listtokens');
        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data['result']) && $data['result'] !== 0) {
            throw new \RuntimeException('Failed to fetch tokens: ' . ($data['error'] ?? 'Unknown error'));
        }

        return $data['tokens'] ?? [];
    }

    /**
     * Delete (invalidate) an authentication token by tokenid.
     *
     * @param int $tokenid 欲刪除的 token ID
     * @return array
     * @throws \InvalidArgumentException 若未提供 tokenid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deletetoken(int $tokenid): array
    {
        if (empty($tokenid)) {
            throw new \InvalidArgumentException("Parameter 'tokenid' is required.");
        }
        $response = $this->client->get('deletetoken', [
            'query' => ['tokenid' => $tokenid]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Sends email to the logged in user with change email link.
     * 若帶 newmail/code，則發送到新信箱。
     *
     * @param string|null $newmail 新信箱
     * @param string|null $code 驗證碼
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendchangemail(?string $newmail = null, ?string $code = null): array
    {
        $query = [];
        if ($newmail !== null) {
            $query['newmail'] = $newmail;
        }
        if ($code !== null) {
            $query['code'] = $code;
        }
        $response = $this->client->get('sendchangemail', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Change current user's email. Takes newmail from code.
     *
     * @param string $password 使用者目前密碼
     * @param string $code 驗證碼
     * @return array
     * @throws \InvalidArgumentException 若未提供 password 或 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changemail(string $password, string $code): array
    {
        if (empty($password) || empty($code)) {
            throw new \InvalidArgumentException("Parameters 'password' and 'code' are required.");
        }
        $response = $this->client->get('changemail', [
            'query' => [
                'password' => $password,
                'code' => $code
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Sends email to the logged in user with account deactivation link.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function senddeactivatemail(): array
    {
        $response = $this->client->get('senddeactivatemail');
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Deactivate current user.
     *
     * @param string $password 使用者目前密碼
     * @param string $code 驗證碼
     * @return array
     * @throws \InvalidArgumentException 若未提供 password 或 code
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deactivateuser(string $password, string $code): array
    {
        if (empty($password) || empty($code)) {
            throw new \InvalidArgumentException("Parameters 'password' and 'code' are required.");
        }
        $response = $this->client->get('deactivateuser', [
            'query' => [
                'password' => $password,
                'code' => $code
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
