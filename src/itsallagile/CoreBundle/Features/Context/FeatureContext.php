<?php

namespace itsallagile\CoreBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\Step,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;

use Behat\Gherkin\Node\PyStringNode,    
    Behat\Gherkin\Node\TableNode;

use itsallagile\CoreBundle\Entity\User;
//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext //MinkContext if you want to test web
                  implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
    
    public function getEntityManager() {
        return $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    /**
     * @Given /^I have an account$/
     */
    public function iHaveAnAccount()
    {
        $email = 'behat@example.com';
        $em = $this->getEntityManager();
        $user = $em->getRepository('itsallagileCoreBundle:User')->findBy(array('email' => $email));
        if (!$user) {
            $user = new User();
            $user->setEmail($email);
            $user->setFullName('Behat User');            
            $factory = $this->kernel->getContainer()->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword('password', $user->getSalt());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
        }
    }

    /**
     * @When /^I log in$/
     */
    public function iLogIn()
    {
        return array(
            new Step\When('I am on "/login"'),
            new Step\When('I fill in "email" with "behat@example.com"'),
            new Step\When('I fill in "Password" with "password"'),
            new Step\When('I press "Login"'),
        );
    }
    
    /**
     * @Given /^I am an authenticated user$/
     */
    public function iAmAnAuthenticatedUser()
    {
        return array(
            new Step\When('I am on "/login"'),
            new Step\When('I fill in "email" with "init@example.com"'),
            new Step\When('I fill in "Password" with "password"'),
            new Step\When('I press "Login"'),
        );
    }

    /**
     * @When /^I add a new board called "([^"]*)"$/
     */
    public function iAddANewBoardCalled($boardName)
    {
        return array(
            new Step\When('I am on "/boards/add"'),
            new Step\When('I fill in "Name" with "' . $boardName . '"'),
            new Step\When('I fill in "Slug" with "' . strtolower(str_replace(' ', '', $boardName)) . '"'),
            new Step\When('I press "Add"'),
        );
    }


//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        $container = $this->kernel->getContainer();
//        $container->get('some_service')->doSomethingWith($argument);
//    }
//
}
