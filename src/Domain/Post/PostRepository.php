<?php

namespace App\Domain\Post;

use App\Domain\Post\Model\Post;
use Ramsey\Uuid\UuidInterface;

interface PostRepository
{
    public function find(UuidInterface $id):?Post;
    public function save(Post $post):void;
    public function search():array;
}