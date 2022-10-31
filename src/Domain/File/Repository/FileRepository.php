<?php

namespace App\Domain\File\Repository;

use App\Domain\File\Model\File;
use Ramsey\Uuid\UuidInterface;

interface FileRepository
{
    public function find(UuidInterface $id):?File;
    public function save(File $file):void;
}