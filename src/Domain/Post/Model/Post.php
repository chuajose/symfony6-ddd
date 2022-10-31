<?php

namespace App\Domain\Post\Model;

use App\Domain\File\Model\File;
use App\Domain\PostBase\Model\PostBase;
use App\Domain\Shared\Collection;
use DateTime;
use Ramsey\Uuid\Uuid;

class Post extends PostBase
{

    public static function create($title, File $file): Post
    {
        return new self(Uuid::uuid4(), $title, $file, new DateTime('now'), new DateTime('now'));
    }

}
