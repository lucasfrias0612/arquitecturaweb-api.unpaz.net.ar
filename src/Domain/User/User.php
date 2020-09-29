<?php
declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;

class User implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @param int|null  $id
     * @param string    $email
     * @param string    $password
     * @param string    $fullName
     */
    public function __construct(?int $id, string $email, string $password, string $fullName)
    {
        $this->id = $id;
        $this->email = strtolower($email);
        $this->password = $password;
        $this->fullName = ucfirst($fullName);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
            'fullName' => $this->fullName,
        ];
    }
}
