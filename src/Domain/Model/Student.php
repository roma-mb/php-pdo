<?php

namespace Pdo\Domain\Model;

class Student
{
    private ?int $id;
    private string $name;
    private \DateTimeInterface $birth_date;

    /**
     * @var Phone[]
     */
    private array $phones = [];

    public function __construct(?int $id, string $name, \DateTimeInterface $birth_date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birth_date = $birth_date;
    }

    public function setId(int $id): Student
    {
        if ($this->id === null) {
            $this->id = $id;

            return $this;
        }

        throw new \DomainException('Você só pode definir o id uma vez');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Student
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birth_date;
    }

    public function age(): int
    {
        return $this->birth_date
            ->diff(new \DateTimeImmutable())
            ->y;
    }

    public function setPhone(Phone $phone): Student
    {
        $this->phones[] = $phone;
        return $this;
    }

    /**
     * @return Phone[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }
}
