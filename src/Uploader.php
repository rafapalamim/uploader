<?php

namespace Codemim\Uploader;

class Uploader extends Files
{

    private $logOption;
    private $storageOption;

    private $file;

    function __construct(
        array $logOption = [UPLOADER_DEFAULT_LOG_FORMAT],
        array $storageOption = [UPLOADER_DEFAULT_STORAGE]
    ) {
        $this->logOption = $logOption;
        $this->storageOption = $storageOption;

        Database::initialize();
    }
}
