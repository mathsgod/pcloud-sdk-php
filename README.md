# pcloud-sdk-php

> **Note:** This library was developed because the official SDK ([pCloud/pcloud-sdk-php](https://github.com/pCloud/pcloud-sdk-php)) lacks many features. This project aims to provide a more complete and practical PHP SDK for pCloud.

pcloud-sdk-php is a PHP SDK for accessing the [pCloud API](https://docs.pcloud.com/). It supports file, folder, sharing, public links, thumbnails, trash, archiving, transfer, collection, and account management operations.

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
    "verify" => false, // Disable SSL verification for testing purposes
    'headers' => [
        'Authorization' => 'Bearer ' . $access_token,
    ],
]);

$api = new \pCloud\Sdk\Api($client);
```

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
