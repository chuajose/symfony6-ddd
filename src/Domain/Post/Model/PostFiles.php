<?php
declare(strict_types=1);

/**
 * Created by stik_api
 * User: jose
 * Date: 26/11/21
 * Time: 13:33
 */

namespace App\Domain\Post\Model;


use App\Domain\File\Model\File;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PostFiles
{
    private Post $post;
    private File $file;
    private UuidInterface $id;
    /**
     * @param Post $postParent
     * @param File $file
     */
    public function __construct(Post $postParent, File $file)
    {
        $this->post = $postParent;
        $this->file = $file;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }
    public function file(): File
    {
        return $this->file;
    }

    public function post(): Post
    {
        return $this->post;
    }

}