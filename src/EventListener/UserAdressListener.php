<?php

namespace App\EventListener;

use App\Entity\Adress;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postUpdate, method: 'postUpdate', entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: User::class)]
class UserAdressListener
{

    private $originalAdresses = [];
    private EntityManagerInterface $em;

    public function preUpdate( $event): void
    {

        if($event instanceof User){
            $this->originalAdresses = $event->getAdresses()->toArray();
        }
    }

    public function postUpdate( $event): void
    {

        if($event instanceof User){
            $currentAdresses = $event->getAdresses()->toArray();
        }

        $removedAdresses = array_diff($this->originalAdresses, $currentAdresses
        );

        // dd($removedAdresses);  // ...
    }
}
