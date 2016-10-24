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
                $newResult = new Result();

                if ($this->persons[$firstPerson]->isOlderThan($this->persons[$secondPerson])) {
                    $newResult->firstPerson = $this->persons[$firstPerson];
                    $newResult->secondPerson = $this->persons[$secondPerson];
                } else {
                    $newResult->firstPerson = $this->persons[$secondPerson];
                    $newResult->secondPerson = $this->persons[$firstPerson];
                }

                $newResult->diference = $newResult->secondPerson->birthDate->getTimestamp()
                    - $newResult->firstPerson->birthDate->getTimestamp();

                $results[] = $newResult;
            }
        }

        return $results;
    }
}
