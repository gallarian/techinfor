<?php

/**
 * @Author: Gallarian <gallarian@gmail.com>
 */

 namespace App\Tests\Unit\Entity\Security;

use App\Entity\Security\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GroupTest extends KernelTestCase
{
    private ValidatorInterface $validator;
    private Group $group;
    private const LONG_TEXT = <<<HTML
Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page
avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un
imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte.
Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que
son contenu n'en soit modifié.
HTML;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->validator = $kernel->getContainer()->get("validator");
        $this->group = (new Group())->setName("groupTest");
    }

    public function testValidGroup(): void
    {
        $errors = $this->validator->validate($this->group);

        $this->assertCount(0, $errors);
        $this->assertSame("groupTest", $this->group->getName());
        $this->assertNull($this->group->getScope());
        $this->assertNull($this->group->getDescription());
        $this->assertTrue($this->group->getIsActivate());
    }

    public function testNameUniq(): void
    {
        $errors = $this->validator->validate($this->group->setName("root"));
        $this->assertCount(1, $errors);
        $this->assertSame("group.name.existing", $errors[0]->getMessage());
    }

    public function testNameEmpty(): void
    {
        $errors = $this->validator->validate($this->group->setName(""));
        $this->assertCount(1, $errors);
        $this->assertSame("required.field", $errors[0]->getMessage());
    }

    public function testNameMax(): void
    {
        $errors = $this->validator->validate($this->group->setName(self::LONG_TEXT));
        $this->assertCount(1, $errors);
        $this->assertSame("group.name.max", $errors[0]->getMessage());
    }

    public function testDescriptionMax(): void
    {
        $errors = $this->validator->validate($this->group->setDescription(self::LONG_TEXT));
        $this->assertCount(1, $errors);
        $this->assertSame("group.description.max", $errors[0]->getMessage());
    }
}
