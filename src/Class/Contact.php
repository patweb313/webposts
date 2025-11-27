<?php
namespace App\Class;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank]
    private string $firstName;
    #[Assert\NotBlank]
    private string $lastName;
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 255,
    )]
    private string $subject;
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 15,
    )]
    private string $message;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): Contact
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): Contact
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): Contact
    {
        $this->subject = $subject;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Contact
    {
        $this->message = $message;
        return $this;
    }
}
