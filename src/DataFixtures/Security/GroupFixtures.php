<?php

/**
 * @Author: Gallarian <gallarian@gmail.com>
 */

namespace App\DataFixtures\Security;

use App\Entity\Security\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @codeCoverageIgnore
 */
class GroupFixtures extends Fixture
{
    private SluggerInterface $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $data = ["root", "administrateur", "modérateur", "validateur", "rédacteur", "membre", "api"];
        $i = 0;

        foreach ($data as $k => $grp) {
            if ($grp !== "root") {
                $group = (new Group())->setName($grp)->setScope($i + 1);
                $i++;
            } else {
                $group = (new Group())->setName($grp);
            }

            $group->setSlug($this->slugger->slug($group->getName())->lower());

            $manager->persist($group);
            $this->addReference("group-{$k}", $group);
        }

        $manager->flush();
    }
}
