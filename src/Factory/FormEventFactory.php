<?php 

namespace App\Factory;

use App\Entity\FormEvent;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FormEventFactory
{
    public function autoSlug(string $field): callable
    {
        return function (PreSubmitEvent $event) use ($field){
            $data = $event->getData();
            // dd($data);
            if(empty($data['slug'])){
                $slugger = new AsciiSlugger();
                $data['slug'] = strtolower($slugger->slug($data[$field]));
                $event->setData($data);
            }
        };
    }

    public function dateTimeUpdate(): callable
    {
        return function (PostSubmitEvent $event){
            $data = $event->getData();
            $data->setUpdatedAt(new \DateTimeImmutable());
        };
    }

}