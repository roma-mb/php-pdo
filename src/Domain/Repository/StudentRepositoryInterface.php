<?php

namespace Pdo\Domain\Repository;

use Pdo\Domain\Model\Student;

interface StudentRepositoryInterface
{
    public function all(): array;
    public function birthAt(\DateTimeInterface $dateTime): array;
    public function withPhones(): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;
}
