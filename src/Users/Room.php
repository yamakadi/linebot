<?php

namespace Yamakadi\LineBot\Users;

class Room
{
    /** @var string */
    protected $id;

    /** @var array */
    protected $members;

    /**
     * Create a new Group Instance
     *
     * @param string $id
     * @param array  $members
     */
    public function __construct(string $id, array $members = [])
    {
        $this->id = $id;
        $this->members = $members;
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
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param User|string $user
     *
     * @return bool
     */
    public function hasMember($user)
    {
        if($user instanceof User) {
            $user = $user->getId();
        }

        return !! array_search($user, $this->members);
    }
}