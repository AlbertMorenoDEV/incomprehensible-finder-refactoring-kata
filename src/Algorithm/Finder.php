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

        if (count($results) < 1) {
            return new Result();
        }

        $answer = $results[0];

        foreach ($results as $result) {
            switch ($findType) {
                case FindType::CLOSEST:
                    if ($result->diference < $answer->diference) {
                        $answer = $result;
                    }
                    break;

                case FindType::FURTHEST:
                    if ($result->diference > $answer->diference) {
                        $answer = $result;
                    }
                    break;
            }
        }

        return $answer;
    }

    private function compareAll()
    {
        /** @var Result[] $results */
        $results = [];

        for ($firstPerson = 0; $firstPerson < count($this->persons); $firstPerson++) {
            for ($secondPerson = $firstPerson + 1; $secondPerson < count($this->persons); $secondPerson++) {
                $results[] = $this->compare($this->persons[$firstPerson], $this->persons[$secondPerson]);
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

        $newResult->diference = $newResult->secondPerson->birthDate->getTimestamp()
            - $newResult->firstPerson->birthDate->getTimestamp();

        return $newResult;
    }
}
