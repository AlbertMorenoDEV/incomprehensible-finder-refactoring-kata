<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class Finder
{
    /** @var Person[] */
    private $_p;

    public function __construct(array $p)
    {
        $this->_p = $p;
    }

    public function find(int $ft): Result
    {
        /** @var Result[] $tr */
        $tr = [];

        for ($i = 0; $i < count($this->_p); $i++) {
            for ($j = $i + 1; $j < count($this->_p); $j++) {
                $r = new Result();

                if ($this->_p[$i]->birthDate < $this->_p[$j]->birthDate) {
                    $r->firstPerson = $this->_p[$i];
                    $r->SecondPerson = $this->_p[$j];
                } else {
                    $r->firstPerson = $this->_p[$j];
                    $r->SecondPerson = $this->_p[$i];
                }

                $r->diference = $r->SecondPerson->birthDate->getTimestamp()
                    - $r->firstPerson->birthDate->getTimestamp();

                $tr[] = $r;
            }
        }

        if (count($tr) < 1) {
            return new Result();
        }

        $answer = $tr[0];

        foreach ($tr as $result) {
            switch ($ft) {
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
}
