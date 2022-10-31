<?php

namespace App\Domain\PostBase\Model;


use App\Domain\File\Model\File;
use App\Domain\Shared\Collection;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PostBase
{
    private UuidInterface $id;
    private string $title;
    private File $file;
    private \Doctrine\Common\Collections\Collection $files;
    private DateTime $created_at;
    private DateTime $updated_at;

    /**
     * @param UuidInterface $id
     * @param string $title
     * @param File $file
     * @param DateTime $created_at
     * @param DateTime $updated_at
     */
    protected function __construct(UuidInterface $id, string $title, File $file, DateTime $created_at, DateTime $updated_at)
    {
        $this->id = $id;
        $this->title = $title;
        $this->file = $file;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }



    public function setFiles(array $files): void
    {
        $this->files = new ArrayCollection();
        foreach ($files as $file) {
            $this->files->add($file);
        }
    }

    public function files(): Collection
    {
        $files = new Collection([]);
        if ($this->files->count()>0) {
            foreach ($this->files as $file) {
                $files->add($file);
            }
        }
        return $files;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function id(): string
    {
        return $this->id->toString();
    }

    public function file():File{
        return  $this->file;
    }
}
