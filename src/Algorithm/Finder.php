<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class Finder
{
    /** @var Person[] */
    private $persons;

    public function __construct(array $persons)
    {
        $this->persons = $persons;
    }

    public function find(int $findType): Result
    {
        $results = $this->compareAll();

        return $this->getResult($findType, $results);
    }

    private function compareAll()
    {
        /** @var Result[] $results */
        $results = [];

        $numberOfPersons = count($this->persons);

        for ($i = 0; $i < $numberOfPersons; $i++) {
            for ($j = $i + 1; $j < $numberOfPersons; $j++) {
                $results[] = $this->compare($this->persons[$i], $this->persons[$j]);
            }
        }

        return $results;
    }

    private function compare(Person $firstPerson, Person $secondPerson) : Result
    {
        $newResult = new Result();

        if ($firstPerson->isOlderThan($secondPerson)) {
            $newResult->firstPerson = $firstPerson;
            $newResult->secondPerson = $secondPerson;
        } else {
            $newResult->firstPerson = $secondPerson;
            $newResult->secondPerson = $firstPerson;
        }

        $newResult->diference = $newResult->secondPerson->birthDateDiference($newResult->firstPerson);

        return $newResult;
    }

    private function getResult(int $findType, $results) : Result
    {
        if (count($results) < 1) {
            return new Result();
        }

        if ($findType == FindType::CLOSEST) {
            return $this->getClosest($results);
        }

        if ($findType == FindType::FURTHEST) {
            return $this->getFurthest($results);
        }

        throw new \InvalidArgumentException("Invalid find type: {$findType}.");
    }

    private function getClosest($results) : Result
    {
        $answer = $results[0];

        foreach ($results as $result) {
            if ($result->diference < $answer->diference) {
                $answer = $result;
            }
        }

        return $answer;
    }

    private function getFurthest($results) : Result
    {
        $answer = $results[0];

        foreach ($results as $result) {
            if ($result->diference > $answer->diference) {
                $answer = $result;
            }
        }

        return $answer;
    }
}
