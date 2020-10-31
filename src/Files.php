<?php

namespace Codemim\Uploader;

class Files
{

    private $files;
    private $errors;

    function __construct()
    {
        $this->files = [];
        $this->errors = [];
    }

    /**
     * Retorna os arquivos adicionados na fila
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * Retorna mensagens de erro
     *
     * @param boolean $stringfy
     * @return string|null
     */
    public function getFilesError(bool $stringfy = true): ?string
    {
        if (empty($this->errors)) {
            return null;
        }

        if ($stringfy) {
            return implode('; ', $this->errors);
        }

        return $this->errors;
    }

    /**
     * Adiciona e valida os arquivos
     *
     * @param array $files
     * @return boolean
     */
    public function add(array $files, bool $hash_name = true): bool
    {

        if (!$files) {
            $this->setError('Nenhum arquivo foi informado', __FILE__, __LINE__);
            return false;
        }

        if (!is_array($files)) {
            $this->setError('Formato de parâmetro inválido', __FILE__, __LINE__);
            return false;
        }

        if (!is_array($files['name'])) {

            $validate = $this->validateAndAdd([
                'name' => $files['name'],
                'type' => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error' => $files['error'],
                'size' => $files['size']
            ], $hash_name);

            if (!$validate) {
                $this->files = [];
                return false;
            }
        } else {

            for ($i = 0; $i < count($files['name']); $i++) {

                $validate = $this->validateAndAdd([
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i]
                ], $hash_name);

                if (!$validate) {
                    $this->files = [];
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Valida o arquivo e adiciona na fila para upload
     *
     * @param array $file
     * @param boolean $hash_name
     * @return boolean
     */
    private function validateAndAdd(array $file, bool $hash_name): bool
    {

        $valid = true;
        $msg = [];

        $ext = pathinfo($file['name'])['extension'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if ($file['error'] == 1) {
            $valid = false;
            $msg[] = 'Identificado erro no arquivo';
        }

        if (!in_array($mime, UPLOADER_ALLOW_MIMETYPES)) {
            $valid = false;
            $msg[] = 'Formato do arquivo (Mime Type) não permitido';
        }

        if ((($file['size']) / (1024 * 1024)) > UPLOADER_MAX_FILESIZE) {
            $valid = false;
            $msg[] = 'Ultrapassou o tamanho limite de ' . UPLOADER_MAX_FILESIZE . 'MB';
        }

        if ($hash_name) {
            $save_with_name = date('YmdHis', time()) . '_' . md5($file['name']) . '.' . mb_strtolower($ext);
        } else {
            $save_with_name = date('YmdHis', time()) . '_' . $this->sanitizeNameFile($file['name']);
        }

        $file['name'] = $this->sanitizeNameFile($file['name']);
        $file['mimetype'] = $mime;
        $file['extension'] = mb_strtolower($ext);
        $file['save_with_name'] = $save_with_name;

        if ($valid) {
            $this->files[] = $file;
            return true;
        } else {
            $this->setError('Falha ao adicionar o arquivo: ' . $file['name'] . ' | ' . implode('; ', $msg), __FILE__, __LINE__);
            return false;
        }
    }

    /**
     * Retira caracteres prejudiciais do nome do arquivo
     *
     * @param string $filename
     * @return string
     */
    private function sanitizeNameFile(string $filename): string
    {
        return preg_replace('/[^a-zA-Z0-9\-\._]/','', str_replace(' ', '_', mb_strtolower($filename)));
    }

    /**
     * Adiciona mensagem de erro
     *
     * @param string $message
     * @param string $file
     * @param integer $line
     * @param boolean $showInfo
     * @return void
     */
    private function setError(string $message, string $file, int $line, bool $showInfo = SHOW_MORE_INFO_ERRORS): void
    {

        if ($showInfo) {
            $this->errors[] = $message . ' .: Arquivo: ' . pathinfo($file)['basename'] . ' Linha: ' . $line . ' :.';
        } else {
            $this->errors[] = $message;
        }
    }
}
