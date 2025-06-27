<?php

namespace pCloud\Sdk\Api;


trait Streaming
{
    /** @var \GuzzleHttp\Client */
    private $client;

    /**
     * Get a download link for a file.
     *
     * @param int|null $fileid File ID (preferred)
     * @param string|null $path File path (alternative)
     * @param bool $forcedownload Force download as octet-stream
     * @param string|null $contenttype Custom Content-Type
     * @param int|null $maxspeed Limit download speed (bytes/sec)
     * @param bool $skipfilename Exclude filename from link
     * @return array
     * @throws \InvalidArgumentException if neither fileid nor path is provided
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getfilelink(
        ?int $fileid = null,
        ?string $path = null,
        bool $forcedownload = false,
        ?string $contenttype = null,
        ?int $maxspeed = null,
        bool $skipfilename = false
    ): array {
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException('Either fileid or path must be provided.');
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

        $response = $this->client->get('getfilelink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a streaming link for a video file.
     *
     * @param int|null $fileid File ID (preferred)
     * @param string|null $path File path (alternative)
     * @param bool $forcedownload Force download as octet-stream
     * @param string|null $contenttype Custom Content-Type
     * @param bool $skipfilename Exclude filename from link
     * @param int|null $abitrate Audio bitrate in kbps (16-320)
     * @param int|null $vbitrate Video bitrate in kbps (16-4000)
     * @param string|null $resolution Resolution (e.g. "640x360")
     * @param bool $fixedbitrate Use constant bitrate
     * @return array
     * @throws \InvalidArgumentException if neither fileid nor path is provided
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getvideolink(
        ?int $fileid = null,
        ?string $path = null,
        bool $forcedownload = false,
        ?string $contenttype = null,
        bool $skipfilename = false,
        ?int $abitrate = null,
        ?int $vbitrate = null,
        ?string $resolution = null,
        bool $fixedbitrate = false
    ): array {
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException('Either fileid or path must be provided.');
        }
        if ($forcedownload) {
            $query['forcedownload'] = 1;
        }
        if ($contenttype !== null) {
            $query['contenttype'] = $contenttype;
        }
        if ($skipfilename) {
            $query['skipfilename'] = 1;
        }
        if ($abitrate !== null) {
            $query['abitrate'] = $abitrate;
        }
        if ($vbitrate !== null) {
            $query['vbitrate'] = $vbitrate;
        }
        if ($resolution !== null) {
            $query['resolution'] = $resolution;
        }
        if ($fixedbitrate) {
            $query['fixedbitrate'] = 1;
        }

        $response = $this->client->get('getvideolink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Returns variants array of different quality/resolution versions of a video.
     *
     * @param int|null $fileid File ID (preferred)
     * @param string|null $path File path (alternative)
     * @param bool $forcedownload Force download as octet-stream
     * @param string|null $contenttype Custom Content-Type
     * @param int|null $maxspeed Limit download speed (bytes/sec)
     * @param bool $skipfilename Exclude filename from link
     * @return array
     * @throws \InvalidArgumentException if neither fileid nor path is provided
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getvideolinks(
        ?int $fileid = null,
        ?string $path = null,
        bool $forcedownload = false,
        ?string $contenttype = null,
        ?int $maxspeed = null,
        bool $skipfilename = false
    ): array {
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException('Either fileid or path must be provided.');
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

        $response = $this->client->get('getvideolinks', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a streaming link for an audio file (or extract audio from video).
     *
     * @param int|null $fileid File ID (preferred)
     * @param string|null $path File path (alternative)
     * @param bool $forcedownload Force download as octet-stream
     * @param string|null $contenttype Custom Content-Type
     * @param int|null $abitrate Audio bitrate in kbps (16-320)
     * @return array
     * @throws \InvalidArgumentException if neither fileid nor path is provided
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getaudiolink(
        ?int $fileid = null,
        ?string $path = null,
        bool $forcedownload = false,
        ?string $contenttype = null,
        ?int $abitrate = null
    ): array {
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException('Either fileid or path must be provided.');
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

        $response = $this->client->get('getaudiolink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a m3u8 playlist for live streaming for video file.
     *
     * @param int|null $fileid File ID (preferred)
     * @param string|null $path File path (alternative)
     * @param int|null $abitrate Audio bitrate in kbps (16-320)
     * @param int|null $vbitrate Video bitrate in kbps (16-4000)
     * @param string|null $resolution Resolution (e.g. "640x360")
     * @param bool $skipfilename Exclude filename from link
     * @return array
     * @throws \InvalidArgumentException if neither fileid nor path is provided
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gethlslink(
        ?int $fileid = null,
        ?string $path = null,
        ?int $abitrate = null,
        ?int $vbitrate = null,
        ?string $resolution = null,
        bool $skipfilename = false
    ): array {
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException('Either fileid or path must be provided.');
        }
        if ($abitrate !== null) {
            $query['abitrate'] = $abitrate;
        }
        if ($vbitrate !== null) {
            $query['vbitrate'] = $vbitrate;
        }
        if ($resolution !== null) {
            $query['resolution'] = $resolution;
        }
        if ($skipfilename) {
            $query['skipfilename'] = 1;
        }

        $response = $this->client->get('gethlslink', [
            'query' => $query
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Download a file in different character encoding.
     *
     * @param int|null $fileid File ID (preferred)
     * @param string|null $path File path (alternative)
     * @param string|null $fromencoding Original character encoding (optional)
     * @param string|null $toencoding Requested character encoding (default: utf-8)
     * @param bool $forcedownload Force download as octet-stream
     * @param string|null $contenttype Custom Content-Type
     * @return string File contents (streamed as response)
     * @throws \InvalidArgumentException if neither fileid nor path is provided
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function gettextfile(
        ?int $fileid = null,
        ?string $path = null,
        ?string $fromencoding = null,
        ?string $toencoding = null,
        bool $forcedownload = false,
        ?string $contenttype = null
    ): string {
        $query = [];
        if ($fileid !== null) {
            $query['fileid'] = $fileid;
        } elseif ($path !== null) {
            $query['path'] = $path;
        } else {
            throw new \InvalidArgumentException('Either fileid or path must be provided.');
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

        $response = $this->client->get('gettextfile', [
            'query' => $query
        ]);
        return $response->getBody()->getContents();
    }
}