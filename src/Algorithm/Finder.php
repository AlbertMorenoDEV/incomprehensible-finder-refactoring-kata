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

        return $this->getAnswer($findType, $results);
    }

    private function compareAll()
    {
        /** @var Result[] $results */
        $results = [];

        for ($firstPersonPosition = 0; $firstPersonPosition < count($this->persons); $firstPersonPosition++) {
            for ($secondPersonPosition = $firstPersonPosition + 1; $secondPersonPosition < count($this->persons); $secondPersonPosition++) {
                $results[] = $this->compare($this->persons[$firstPersonPosition],
                    $this->persons[$secondPersonPosition]);
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

    private function getAnswer(int $findType, $results)
    {
        $answer = $results[0];

        foreach ($results as $result) {
            if ($findType == FindType::CLOSEST) {
                if ($result->diference < $answer->diference) {
                    $answer = $result;
                }
            } elseif ($findType == FindType::FURTHEST) {
                if ($result->diference > $answer->diference) {
                    $answer = $result;
                }
            } else {
                throw new \InvalidArgumentException("Invalid find type: {$findType}.");
            }
        }

        return $answer;
    }
}
