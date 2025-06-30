<?php

namespace pCloud\Sdk;

class Api
{
    use Api\General;
    use Api\Folder;
    use Api\File;
    use Api\Auth;
    use Api\Streaming;
    use Api\Archiving;
    use Api\Sharing;
    use Api\PublicLinks;
    use Api\Thumbnails;
    use Api\UploadLinks;
    use Api\Revisions;
    use Api\Trash;
    use Api\Collection;
    use Api\Transfer;
    use Api\Upload;

    private $client;

    public function __construct(
        \GuzzleHttp\Client $client
    ) {
        $this->client = $client;
    }
}
