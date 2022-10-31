<?php

namespace App\Domain\File\Model;


use DateTime;
use Ramsey\Uuid\UuidInterface;

class File
{

    /**
     * @var UuidInterface
     *
     */
    private UuidInterface $id;
    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     *
     */
    private string $original_name;
    /**
     * @var string
     */
    private string $type;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private string $acl; //TODO pendiente de pasar a Object Value
    /**
     * @var DateTime
     */
    private $created_at;
    /**
     * @var DateTime
     */
    private $updated_at;

    /**
     * @var string
     */
    private string $url;

    /**
     * @var array|null
     */
    private $meta;

    /**
     * File constructor.
     *
     * @param UuidInterface $id
     * @param $name
     * @param $original_name
     * @param $type
     * @param $path
     * @param $acl
     * @param DateTime $created_at
     * @param DateTime $updated_at
     */
    public function __construct(UuidInterface $id, $name, $original_name, $type, $path, $acl, DateTime $created_at, DateTime $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->original_name = $original_name;
        $this->type = $type;
        $this->path = $path;
        $this->acl = $acl;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->meta = null;
    }

    public static function create(UuidInterface $id, $name, $original_name, $type, $path, $acl): File
    {
        $file = new self($id, $name, str_replace(' ', '-',$original_name), $type, $path, $acl, new DateTime('now'), new DateTime('now'));

        return  $file;
    }
    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }


    /**
     * @return DateTime
     */
    public function createdAt(): DateTime
    {
        return $this->created_at;
    }


    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return DateTime
     */
    public function updatedAt()
    {
        return $this->updated_at;
    }


    public function setUpdatedAt(DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }


    /**
     * @return string
     */
    public function id(): string
    {

        return $this->id->toString();
    }

    /**
     * @param mixed $id
     */
    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function originalName(): string
    {
        return str_replace(' ', '-', $this->original_name);
    }

    /**
     * @param string $original_name
     */
    public function setOriginalName(string $original_name): void
    {
        $this->original_name = $original_name;
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return array|null
     */
    public function meta(): ?array
    {
        return  $this->meta;

    }

    /**
     * @param array $meta
     */
    public function setMeta(array $meta): void
    {
        $this->meta = $meta;
    }

    public function acl(): string
    {
        return $this->acl;
    }

}