<?php

namespace Codemim\Uploader;

class Uploader extends Files
{

    private $logOptions;
    private $storageOptions;

    function __construct(
        array $logOptions = [UPLOADER_DEFAULT_LOG_FORMAT],
        array $storageOptions = [UPLOADER_DEFAULT_STORAGE]
    ) {

        $this->logOptions = $logOptions;
        $this->storageOptions = $storageOptions;

        Database::initialize();
    }

    public function upload()
    {

        // Load config about storages
        $loadStorages = [];
        foreach ($this->storageOptions as $storage) {
            if (!isset(UPLOADER_STORAGES[$storage])) {
                die('Servidor de armazenamento inválido: ' . $storage);
            }
            $loadStorages[] = UPLOADER_STORAGES[$storage];
        }

        var_dump($this->getFiles(), $this->logOptions, $loadStorages);








        // Save log
        //...
    }
}
