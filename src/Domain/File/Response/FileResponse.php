<?php

namespace App\Domain\File\Response;

use App\Domain\File\Model\File;

class FileResponse
{
    private File $file;

    /**
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function toArray(){
        return [
            'id' => $this->file->id(),
            'url' => $this->file->path().$this->file->originalName()
        ];
    }
}