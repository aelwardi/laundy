<?php

namespace App\Entity;

use App\Repository\PressingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PressingRepository::class)]
class Pressing extends Service
{

}
