<?php
declare(strict_types=1);

namespace App\Domain\Meeting;

use JsonSerializable;

class Meeting implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int|null
     */
    private $userid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $time;

    /**
     * @param int|null $userid
     * @param string $title
     * @param string $description
     * @param string $time
     */
    public function __construct(int $userid, string $title, string $description, string $time)
    {
        $this->userid = $userid;
        $this->title = ucfirst($title);
        $this->description = $description;
        $this->time = $time;
    }

    /**
     * @param int|null $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userid;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'userid' => $this->userid,
            'title' => $this->title,
            'description' => $this->description,
            'time' => $this->time,
        ];
    }

    public function toString(): string
    {
        return "[`" . $this->id . "`,`" . $this->userid . "`,`" . $this->title . "`,`" . $this->description . "`,`" . $this->time . "`]";
    }
}
