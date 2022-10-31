<?php

namespace App\Domain\Social\Model;

use App\Domain\File\Model\File;
use App\Domain\PostBase\Model\PostBase;
use DateTime;
use Ramsey\Uuid\Uuid;

class Social extends PostBase
{
    public static function create($title, File $file): Social
    {
        return new self(Uuid::uuid4(), $title, $file, new DateTime('now'), new DateTime('now'));
    }

}