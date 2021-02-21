<?php

namespace Pdo\Infrastructure\Repository;

use PDO;
use Pdo\Domain\Model\Phone;
use Pdo\Domain\Model\Student;
use Pdo\Domain\Repository\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function all(): array
    {
        $statement = $this->connection->query("select * from students;");
        return $this->hydrate($statement);
    }

    public function birthAt(\DateTimeInterface $dateTime): array
    {
        $statement = $this->connection->prepare("select * from students where birth_date = ?");
        $statement->bindValue(1, $dateTime->format('Y-m-d'));
        $statement->execute();

        return $this->hydrate($statement);
    }

    public function save(Student $student): bool
    {
        if ($student->getId() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $statement = $this->connection
            ->prepare('INSERT INTO students (name, birth_date) VALUES(:name,:birth_date);');

        $executeStatus = $statement->execute([
            ':name' => $student->getName(),
            ':birth_date' => $student->getBirthDate()->format('Y-m-d')
        ]);

        return $executeStatus
            ? (bool) $student->setId($this->connection->lastInsertId())
            : false;
    }

    private function update(Student $student): bool
    {
        $query = "update students set (id = :id, name = :name, birth_date = :birth_date)";
        $statement = $this->connection->prepare($query);
        $statement->bindValue(':id', $student->getId(), PDO::PARAM_INT);
        $statement->bindValue(':name', $student->getName());
        $statement->bindValue(':birth_date', $student->getBirthDate()->format('Y-m-d'));

        return $statement->execute();
    }

    public function remove(Student $student): bool
    {
        $statement = $this->connection->prepare("delete from students where id = ?");
        $statement->bindValue(1, $student->getId(), PDO::PARAM_INT);

        return $statement->execute();
    }

    private function hydrate(\PDOStatement $statement): array
    {
        $list = [];

        foreach ($statement->fetchAll() as $value) {
            $list[] = $student =  new Student(
                $value['id'],
                $value['name'],
                new \DateTimeImmutable($value['birth_date'])
            );
        }

        return $list;
    }

    public function withPhones(): array
    {
//        $list  = [];
//        $query = "select students.id, students.name, students.birth_date, phones.id as phone_id, phones.area_code, phones.number
//                  from students
//                  join phones on phones.student_id = students.id;";
//
//        $statement = $this->connection->query($query);
//        $statement->execute();
//
//        foreach ($statement->fetchAll() as $value) {
//            $studentId = $value['id'];
//            $student   = new Student($studentId, $value['name'], new \DateTimeImmutable($value['birth_date']));
//
//            if (!array_key_exists($studentId, $list)) {
//
//                $list[$studentId] = $student;
//            }
//
//            $phone = new Phone($value['phone_id'], $value['area_code'], $value['number']);
//            $list[$studentId]->setPhone($phone);
//        }
//
//        return $list;

        //---------------------------------------------------------------------------------------

        $query = "select students.id, students.name, students.birth_date, group_concat(phones.id || ':' || phones.area_code || ':' || phones.number, ';') as phones
                  from students
                  join phones on phones.student_id = students.id
                  group by students.id;";

        $statement = $this->connection->query($query);
        $statement->execute();

        return array_map(static function ($array) {
            $birthDate = new \DateTimeImmutable($array['birth_date']);
            $student   = new Student($array['id'], $array['name'], $birthDate);
            self::hydratePhones($student, explode(';', $array['phones']));
            return $student;
        }, $statement->fetchAll());
    }

    private static function hydratePhones(Student $student, array $phones): void
    {
        foreach ($phones as $phone) {
            $splitPhone = explode(':', $phone);
            $phone      = new Phone($splitPhone[0], $splitPhone[1], $splitPhone[2]);
            $student->setPhone($phone);
        }
    }
}
