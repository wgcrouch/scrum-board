<?php 

namespace itsallagile\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use itsallagile\CoreBundle\Document;
class MongoSwitchCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('core:mongo-switch')
            ->setDescription('convert an instance to mongodb')
        ;
    }
    
    protected $output = null;
    
    protected $users = array();
    protected $teams = array();
    
    protected $storyStatuses = array(
        1 => Document\Story::STATUS_NEW,
        2 => Document\Story::STATUS_IN_PROGRESS,
        3 => Document\Story::STATUS_TESTABLE,
        4 => Document\Story::STATUS_DONE   
    );
    
    protected $ticketStatuses = array(
        1 => Document\Ticket::STATUS_NEW,
        2 => Document\Ticket::STATUS_ASSIGNED,
        3 => Document\Ticket::STATUS_DONE
    );

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->migrateUsers();
        $this->migrateTeams();
        $this->migrateBoards();
    }
    
    protected function out($text) 
    {
        $this->output->writeln($text);
    }
    
    protected function getDb()
    {
        $db = $this->getContainer()
            ->get('doctrine')
            ->getEntityManager()
            ->getConnection();

        return $db;        
    }
    
    protected function getDoctrine()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        return $dm;
    }
    
    protected function migrateUsers()
    {
        $this->out("Migrating Users");
        $this->out("---------------"); 
       
        $users = $this->runQuery("Select * from user");
        $dm = $this->getDoctrine();
        foreach ($users as $user) {
            $this->users[$user['userId']] = new Document\User();
            $this->out("\tCreating: " . $user['email']);
            $this->users[$user['userId']]->setEmail($user['email']);
            $this->users[$user['userId']]->setFullName($user['fullName']);
            $this->users[$user['userId']]->setPassword($user['password']);
            $this->users[$user['userId']]->setSalt($user['salt']);
            
            $dm->persist($this->users[$user['userId']]);                
        }
        $dm->flush();
        $this->out("Done");
        $this->out("----");        
    }
    
    protected function runQuery($query)
    {
        $stmt = $this->getDb()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    protected function migrateTeams()
    {
        $this->out("Migrating Boards");
        $this->out("---------------"); 
        
        $teams = $this->runQuery('select * from team');

        $dm = $this->getDoctrine();
        foreach ($teams as $team) {
            $teamId = $team['teamId'];
            $this->out("Creating: " . $team['name']); 
            $this->teams[$teamId] = new Document\Team();
            $this->teams[$teamId]->setName($team['name']);
            $this->teams[$teamId]->setVelocity($team['velocity']);
            $this->teams[$teamId]->setOwner($this->users[$team['ownerId']]);
            
            $users = $this->runQuery("select * from teamUser where teamId = " . $teamId);
            foreach ($users as $user) {
                $this->teams[$teamId]->addUser($this->users[$user['userId']]);
            }
            
            $dm->persist($this->teams[$teamId]);            
        }
        $dm->flush();
        $this->out("Done");
        $this->out("----"); 
    }
    
    protected function migrateBoards()
    {
        $this->out("Migrating Teams");
        $this->out("---------------"); 
        
        $boards = $this->runQuery('select * from board order by boardId ASC');

        $dm = $this->getDoctrine();
        foreach ($boards as $board) {
            $boardId = $board['boardId'];
            $this->out("Creating: " . $board['name']); 
            $this->boards[$boardId] = new Document\Board();
            $this->boards[$boardId]->setName($board['name']);
            $this->boards[$boardId]->setSlug($board['slug']);
            $this->boards[$boardId]->setTeam($this->teams[$board['teamId']]);
            
            $messages = $this->runQuery("select * from chatMessage where boardId = " . $boardId);
            foreach ($messages as $message) {
                $messageNew = new Document\ChatMessage();
                $messageNew->setContent($message['content']);
                $messageNew->setDateTime(new \DateTime($message['datetime']));
                $messageNew->setUser($this->users[$message['userId']]->getEmail());
                $this->boards[$boardId]->addChatMessage(clone($messageNew));
            }
            
            $stories = $this->runQuery("select * from story where boardId = " . $boardId . " order by storyId ASC");
            foreach ($stories as $story) {
                sleep(1);
                $storyId = $story['storyId'];
                $storyNew = new Document\Story();
                $storyNew->setContent($story['content']);
                $storyNew->setPoints($story['points']);
                $storyNew->setSort($story['sort']);
                $storyNew->setStatus($this->storyStatuses[$story['statusId']]);
                
                $tickets = $this->runQuery("select * from ticket where storyId = " . $storyId);
                foreach ($tickets as $ticket) {
                    $ticketNew = new Document\Ticket();
                    $ticketNew->setContent($ticket['content']);
                    $ticketNew->setType($ticket['type']);
                    $ticketNew->setStatus($this->ticketStatuses[$ticket['statusId']]);
                    $storyNew->addTicket(clone($ticketNew));
                }
                
                $this->boards[$boardId]->addStory(clone($storyNew));
            }
            
            $dm->persist($this->boards[$boardId]); 
            sleep(1);
        }
        $dm->flush();
        $this->out("Done");
        $this->out("----"); 
    }
}