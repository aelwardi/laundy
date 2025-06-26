<?php

namespace App\Entity;

use App\Repository\AmeublementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmeublementRepository::class)]
class Ameublement extends Service
{

}
