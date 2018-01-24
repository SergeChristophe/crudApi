<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $post = new Post();
        $post->setTitle('post1');

        $post2 = new Post();
        $post2->setTitle('post2');

        $manager->persist($post);
        $manager->persist($post2);
        
        $manager->flush();
    }
}