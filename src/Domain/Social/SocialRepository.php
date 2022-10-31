<?php

namespace App\Domain\Social;

use App\Domain\Social\Model\Social;
use Ramsey\Uuid\UuidInterface;

interface SocialRepository
{
    public function find(UuidInterface $id):?Social;
    public function save(Social $post):void;
    public function search():array;
}