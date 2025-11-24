<?php

namespace ReelRank\Domain\ValueObjects;

enum RatingEnum: int
{
  case One = 1;
  case Two = 2;
  case Three = 3;
  case Four = 4;
  case Five = 5;
}