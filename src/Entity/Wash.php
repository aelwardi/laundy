<?php

namespace App\Entity;

use App\Repository\WashRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WashRepository::class)]
class Wash extends Service
{
    
}
