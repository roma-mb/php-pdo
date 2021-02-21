<?php

use Pdo\Domain\Model\Student;
use Pdo\Infrastructure\Persistence\Connection;
use Pdo\Infrastructure\Repository\StudentRepository;

require('vendor/autoload.php');

$connection = Connection::create();

//$pdo->exec("create table teste (id integer primary key, name text, birth_date text);"));

//$student   = new Student(null, 'Student C', new DateTimeImmutable('2002-02-02'));
//$query     = "INSERT INTO students (name, birth_date) VALUES ('{$student->getName()}','{$student->getBirthDate()->format('Y-m-d')}');";

//$stmt = $connection->query("SELECT * FROM students");

//https://www.php.net/manual/pt_BR/pdostatement.fetch.php
//$result = $stmt->fetchAll(PDO::FETCH_BOTH);
//$result = $stmt->fetchAll(PDO::FETCH_BOUND);
//$result = $stmt->fetchAll(PDO::FETCH_NAMED);
//$result = $stmt->fetchAll(PDO::FETCH_NUM);
//$result = $stmt->fetchAll(PDO::FETCH_OBJ);

//$result = $stmt->fetchAll(PDO::FETCH_CLASS, Student::class); //Pdo\Domain\Model\Student
//$result = $stmt->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_CLASSTYPE, Student::class);  //object(stdClass)

//$list   = [];
//$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//foreach ($result as $value) {
//    $list[] = new Student(
//        $value['id'],
//        $value['name'],
//        new DateTimeImmutable($value['birth_date'])
//    );
//}

// FETCH_INTO
//$stmt->setFetchMode(PDO::FETCH_INTO, new Student());
//dd($stmt->fetch());

//$stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Student::class, ['Name Test']);
//dd($stmt->fetchAll());

//$result = $stmt->fetch(PDO::FETCH_LAZY);
//$result = $stmt->fetchColumn(1);
//$result = $stmt->fetchObject(Student::class);

//$statement = $pdo->prepare("insert into students (name, birth_date) values (?, ?)");
//$statement->bindValue(1, "Name C");
//$statement->bindValue(2, "2000-11-01");
//$statement->bindParam(2, $byReference);
//$result = $statement->execute();

// -------------------------------------------------------------------------------------------------------

//try {
//$connection->beginTransaction();
//    $studentRepository = new StudentRepository($connection);
//$studentRepository->save(new Student(null, 'Name A', new DateTimeImmutable('2000-01-01')));
//    $studentRepository->all();
//$studentRepository->birthAt(new DateTimeImmutable('2000-01-01'));

//$connection->commit();
//} catch (PDOException $exception) {
//    echo $exception->getMessage();
//    $connection->rollBack();
//}

// -------------------------------------------------------------------------------------------------------

$studentRepository = new StudentRepository($connection);
//dd($studentRepository->all());

dd($studentRepository->all());
