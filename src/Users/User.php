<?php

namespace Yamakadi\LineBot\Users;

class User
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $photo;

    /** @var string */
    protected $status;

    /** @var array */
    protected $raw;

    /**
     * Create a  new User instance.
     *
     * @param string $id
     * @param string $name
     * @param string $photo
     * @param string $status
     * @param array  $raw
     */
    public function __construct(string $id, string $name, string $photo, string $status = '', array $raw = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->photo = $photo;
        $this->status = $status;
        $this->raw = $raw;
    }

    /**
     * Create a new User instance from an API response
     *
     * @param array $attributes
     *
     * @return \Yamakadi\LineBot\Users\User
     */
    public static function create(array $attributes = [])
    {
        return new static(
            $attributes['userId'],
            $attributes['displayName'],
            $attributes['pictureUrl'] ?? '',
            $attributes['statusMessage'] ?? '',
            $attributes
        );
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }
}