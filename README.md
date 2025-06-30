# pcloud-sdk-php

> **Note:** This library was developed because the official SDK ([pCloud/pcloud-sdk-php](https://github.com/pCloud/pcloud-sdk-php)) lacks many features. This project aims to provide a more complete and practical PHP SDK for pCloud.

pcloud-sdk-php is a PHP SDK for accessing the [pCloud API](https://docs.pcloud.com/). It supports file, folder, sharing, public links, thumbnails, trash, archiving, transfer, collection, and account management operations.

## EU or US API Endpoint

pCloud provides both EU and US API endpoints.  
- **EU:** `https://eapi.pcloud.com/`
- **US:** `https://api.pcloud.com/`

## Installation

Recommended via Composer:

```bash
composer require mathsgod/pcloud-sdk-php
```

Or simply include the `src/` directory in your project.

## Quick Start

```php
$access_token = 'YOUR_TOKEN';
$client = new \GuzzleHttp\Client([
    'base_uri' => "https://eapi.pcloud.com/", 
    'headers' => [
        'Authorization' => 'Bearer ' . $access_token,
    ],
]);

$api = new \pCloud\Sdk\Api($client);
```

---

## Function List

> For detailed parameters and return values, please refer to the source code comments.

<details>
<summary><strong>General</strong></summary>

- userinfo()
- supportedlanguages()
- setlanguage(string $language)
- currentserver()
- diff(array $params = [])
- getfilehistory(int $fileid)
- getip()
- getapiserver()
</details>

<details>
<summary><strong>Auth</strong></summary>

- sendverificationemail()
- verifyemail(string $code)
- changepassword(string $oldpassword, string $newpassword)
- lostpassword(string $mail)
- resetpassword(string $code, string $newpassword)
- register(string $mail, string $password, string $termsaccepted, ?string $language = null, ?string $referer = null)
- invite()
- userinvites()
- logout()
- listtokens()
- deletetoken(int $tokenid)
- sendchangemail(?string $newmail = null, ?string $code = null)
- changemail(string $password, string $code)
- senddeactivatemail()
- deactivateuser(string $password, string $code)
</details>

<details>
<summary><strong>Collection</strong></summary>

- collection_list(?int $type = null, bool $showfiles = false, ?int $pagesize = null)
- collection_details(int $collectionid, ?int $page = null, ?int $pagesize = null)
- collection_create(string $name, ?int $type = null, ?string $fileids = null)
- collection_rename(int $collectionid, string $name)
- collection_delete(int $collectionid)
- collection_linkfiles(int $collectionid, string $fileids, bool $noitems = false)
- collection_unlinkfiles(int $collectionid, ?string $positions = null, bool $all = false, ?string $fileids = null)
- collection_move(int $collectionid, int $item, int $fileid, int $position)
</details>

<details>
<summary><strong>PublicLinks</strong></summary>

- getfilepublink(?int $fileid = null, ?string $path = null, ?string $expire = null, ?int $maxdownloads = null, ?int $maxtraffic = null, bool $shortlink = false, ?string $linkpassword = null)
- getfolderpublink(?int $folderid = null, ?string $path = null, ?string $expire = null, ?int $maxdownloads = null, ?int $maxtraffic = null, bool $shortlink = false, ?string $linkpassword = null)
- gettreepublink(string $name, ?string $fileids = null, ?string $folderids = null, ?int $folderid = null, ?string $expire = null, ?int $maxdownloads = null, ?int $maxtraffic = null, bool $shortlink = false, ?string $linkpassword = null)
- showpublink(string $code)
- getpublinkdownload(string $code, ?int $fileid = null, bool $forcedownload = false, ?string $contenttype = null, ?int $maxspeed = null, bool $skipfilename = false)
- copypubfile(string $code, ?int $fileid = null, ?string $topath = null, ?int $tofolderid = null, ?string $toname = null, bool $noover = false)
- listpublinks()
- listplshort()
- deletepublink(int $linkid)
- changepublink(int $linkid, array $options)
- getpubthumb(string $code, int $fileid, string $size, bool $crop = false, ?string $type = null)
- getpubthumblink(string $code, int $fileid, string $size, bool $crop = false, ?string $type = null)
- getpubthumbslinks(string $code, int $fileid, string $size, bool $crop = false, ?string $type = null)
- savepubthumb(string $code, int $fileid, string $size, ?string $topath = null, ?int $tofolderid = null, ?string $toname = null, bool $crop = false, ?string $type = null, bool $noover = false)
- getpubzip(string $code, bool $forcedownload = false, ?string $filename = null, ?string $timeoffset = null)
- getpubziplink(string $code, bool $forcedownload = false, ?string $filename = null, ?string $timeoffset = null)
- savepubzip(string $code, ?string $timeoffset = null, ?string $topath = null, ?int $tofolderid = null, ?string $toname = null)
- getpubvideolinks(string $code, ?int $fileid = null, bool $forcedownload = false, ?string $contenttype = null, ?int $maxspeed = null, bool $skipfilename = false)
- getpubaudiolink(string $code, ?int $fileid = null, bool $forcedownload = false, ?string $contenttype = null, ?int $abitrate = null)
- getpubtextfile(string $code, ?int $fileid = null, ?string $fromencoding = null, ?string $toencoding = null, bool $forcedownload = false, ?string $contenttype = null)
- getcollectionpublink(int $collectionid, ?string $expire = null, ?int $maxdownloads = null, ?int $maxtraffic = null, bool $shortlink = false)
</details>

<details>
<summary><strong>Revisions</strong></summary>

- listrevisions(?int $fileid = null, ?string $path = null)
- revertrevision(?int $fileid = null, ?string $path = null, ?int $revisionid = null)
</details>

<details>
<summary><strong>Thumbnails</strong></summary>

- getthumblink(?int $fileid = null, ?string $path = null, ?string $size = null, bool $crop = false, ?string $type = null)
- getthumbslinks(string $fileids, string $size, bool $crop = false, ?string $type = null)
- getthumb(?int $fileid = null, ?string $path = null, ?string $size = null, bool $crop = false, ?string $type = null)
- savethumb(?int $fileid = null, ?string $path = null, ?string $size = null, ?string $topath = null, ?int $tofolderid = null, ?string $toname = null, bool $crop = false, ?string $type = null, bool $noover = false)
</details>

<details>
<summary><strong>Trash</strong></summary>

- trash_list(int $folderid = 0, bool $nofiles = false, bool $recursive = false)
- trash_restorepath(?int $fileid = null, ?int $folderid = null)
- trash_restore(?int $fileid = null, ?int $folderid = null, ?int $restoreto = null, bool $metadata = false)
- trash_clear(?int $fileid = null, ?int $folderid = null)
</details>

<details>
<summary><strong>UploadLinks</strong></summary>

- createuploadlink(?int $folderid = null, ?string $path = null, string $comment = '', ?string $expire = null, ?int $maxspace = null, ?int $maxfiles = null)
- listuploadlinks()
- deleteuploadlink(int $uploadlinkid)
- changeuploadlink(int $uploadlinkid, array $options)
- showuploadlink(int $uploadlinkid)
- uploadtolink(string $code, array $files, bool $nopartial = false, ?string $progresshash = null)
- uploadlinkprogress(string $code, string $progresshash)
- copytolink(string $code, ?int $fileid = null, ?string $path = null, ?string $toname = null)
</details>

---

## Common Examples

### Upload a file

```php
// Single file
$result = $api->uploadfile([
    '/path/to/local/file.jpg'
], null, 0); // Upload to root folder

// Multiple files (custom filenames)
$result = $api->uploadfile([
    ['path' => '/tmp/a.jpg', 'filename' => 'photo1.jpg'],
    ['path' => '/tmp/b.png', 'filename' => 'photo2.png'],
], null, 123456); // Upload to folderid=123456
```

### Get file info

```php
// By fileid
$meta = $api->stat(123456789);
// By path
$meta = $api->stat(null, '/Documents/test.pdf');
```

### Download file (get download link)

```php
$link = $api->getfilelink(123456789);
echo $link['hosts'][0] . $link['path'];
```

### Delete file

```php
$api->deletefile(123456789);
// or
$api->deletefile(null, '/Documents/test.pdf');
```

### Create folder

```php
// By folderid+name
$meta = $api->createfolder(null, 123456, 'New Folder');
// By full path
$meta = $api->createfolder('/Documents/New Folder');
```

### List folder contents

```php
$list = $api->listfolder(null, 123456); // By folderid
$list = $api->listfolder('/Documents'); // By path
```

### Recursively delete folder

```php
$api->deletefolderrecursive(123456); // Deletes all contents, use with caution
```

### Copy folder

```php
// Copy to another folder
$api->copyfolder(123456, null, 654321);
// Copy to a specific path
$api->copyfolder(123456, null, null, '/Documents/Backup/');
```

### Copy, move, or rename file

```php
// Copy file to new folder
$api->copyfile(123, null, 456, null, 'newname.jpg');
// Move and rename
$api->renamefile(123, null, null, 456, 'newname.jpg');
```

### Calculate file checksum

```php
$hash = $api->checksumfile(123456789);
echo $hash['sha1'];
```

### Get thumbnail link

```php
$thumb = $api->getthumblink(123456789, null, '200x200');
echo $thumb['hosts'][0] . $thumb['path'];
```

---

## Supported API Features

- File operations (upload, download, copy, delete, stat, checksum, revisions, thumbnails)
- Folder operations (create, delete, recursive delete, copy, move, stat/list)
- Sharing and public links
- Trash (recycle bin)
- Archiving (zip/unzip)
- Transfer
- Collection (playlist)
- Authentication and account management
- Server and language settings

## Documentation

- [pCloud API Official Docs](https://docs.pcloud.com/)
- All SDK methods correspond to API endpoints. See source code comments for parameters and return values.

## License

MIT License
