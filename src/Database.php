<?php

namespace Codemim\Uploader;

class Database
{

    private static $pdo = null;


    function __construct()
    {
    }

    /**
     * Instancia uma conexão
     *
     * @return \PDO
     */
    public static function getInstance(): \PDO
    {

        if (!self::$pdo) {
            try {
                self::$pdo = new \PDO(UPLOADER_DB['dsn'], UPLOADER_DB['user'], UPLOADER_DB['pass'], UPLOADER_DB['options']);
            } catch (\PDOException $e) {
                die($e->getMessage());
            }
        }

        return self::$pdo;
    }

    /**
     * Inicializa o Uploader, criando as tabelas necessárias para o controle dos arquivos
     *
     * @return void
     */
    public static function initialize(): void
    {

        $pdo = self::getInstance();

        try {

            // Check if tables of Uploader exists
            $stmt = $pdo->prepare("SELECT * FROM information_schema.tables WHERE table_name = '" . UPLOADER_NAME_TABLE_LOG . "'");
            $stmt->execute();

            if ($stmt->rowCount() === 0) {

                $create = "CREATE TABLE `" . UPLOADER_NAME_TABLE_LOG . "` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `filename` varchar(191) NOT NULL,
                    `extension` varchar(5) NOT NULL,
                    `mimetype` varchar(120) NOT NULL,
                    `size` int(11) NOT NULL,
                    `success` bit(1) NOT NULL,
                    `message` varchar(191) NOT NULL,
                    PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

                $stmt = $pdo->prepare($create);
                $stmt->execute();
            }

            $stmt = $pdo->prepare("SELECT * FROM information_schema.tables WHERE table_name = '" . UPLOADER_NAME_TABLE_FILES . "'");
            $stmt->execute();

            if ($stmt->rowCount() === 0) {

                $create = "CREATE TABLE `" . UPLOADER_NAME_TABLE_FILES . "` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `storage` varchar(50) NOT NULL,
                    `path` varchar(191) NOT NULL,
                    `filename` varchar(191) NOT NULL,
                    `extension` varchar(5) NOT NULL,
                    `mimetype` varchar(120) NOT NULL,
                    `size` int(11) NOT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `filename_UNIQUE` (`filename`),
                    UNIQUE KEY `path_UNIQUE` (`path`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

                $stmt = $pdo->prepare($create);
                $stmt->execute();
            }
        } catch (\PDOException $e) {
            die('Erro ao iniciar Uploader: ' . $e->getMessage());
        }
    }
}
