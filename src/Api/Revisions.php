<?php

namespace pCloud\Sdk\Api;


trait Revisions
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Lists revisions for a given fileid or path.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @return array
     * @throws \InvalidArgumentException 若未提供 fileid/path
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listrevisions(?int $fileid = null, ?string $path = null): array
    {
        if ($fileid === null && $path === null) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' is required.");
        }
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        }

        $response = $this->client->get('listrevisions', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Revert a file to a given revision.
     *
     * @param int|null $fileid 檔案ID（優先）
     * @param string|null $path 檔案路徑（備選）
     * @param int $revisionid 目標版本ID
     * @return array 新檔案 metadata
     * @throws \InvalidArgumentException 若未提供 fileid/path 或 revisionid
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function revertrevision(
        ?int $fileid = null,
        ?string $path = null,
        int $revisionid
    ): array {
        if (($fileid === null && $path === null) || empty($revisionid)) {
            throw new \InvalidArgumentException("Parameter 'fileid' or 'path' and 'revisionid' are required.");
        }
        $query = ['revisionid' => $revisionid];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        }

        $response = $this->client->get('revertrevision', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
