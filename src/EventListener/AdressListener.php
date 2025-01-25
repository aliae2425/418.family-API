<?php

namespace App\EventListener;

use App\Entity\Adress;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;


#[AsEntityListener(event: Events::postUpdate, method: 'postUpdate', entity: Adress::class)]
final class AdressListener
{
    public function preUpdate($event): void
    {
        // echo "preUpdate";
    }

    public function postUpdate($event): void
    {
        // echo "postUpdate";
    }
}
