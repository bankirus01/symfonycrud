<?php
namespace AppBundle\Command;

use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\InterfaceSymfony;
use AppBundle\Entity\NamespaceSymfony;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ParseCommand
 * @package AppBundle\Command
 */
class ParseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:parse')
            ->setDescription('Parse api.symfony.com')
            ->setHelp('This command allows you to create a user...');
    }

    /**
     * @param InputInterface $input
     *
     * @param OutputInterface $output
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        return $this->getRecursion( 'http://api.symfony.com/3.2/Symfony.html', null);
    }

    /**
     * @param string $link
     *
     * @param NamespaceSymfony|null $parent
     *
     */
    public function getRecursion(string $link, ?NamespaceSymfony $parent)
    {

        $em = $this->getContainer()->get('doctrine')->getManager();
        $html = file_get_contents($link);
        $crawler = new Crawler($html);
        $nodeLinks = $crawler->filter('div.namespace-list > a');

            foreach ($nodeLinks as $item){
                var_dump($item->textContent);
                $url = 'http://api.symfony.com/3.2/' . str_replace('../', '', $item->getAttribute('href'));
                $namespace = new NamespaceSymfony();
                $namespace->setName($item->textContent);
                $namespace->setUrl($url);
                $namespace->setParent($parent);
                $em->persist($namespace);

                $this->getRecursion($url, $namespace);
                //var_dump('Namespaces: '.'http://api.symfony.com/3.2/Symfony'. str_replace('../', '', $item->getAttribute('href')));
            }

        $DOMcrawler = $crawler->filter('div#page-content > div.container-fluid.underlined > div.row > div > a');

            if($DOMcrawler->count() > 0){

                foreach ($DOMcrawler as $item){
                    $class = new ClassSymfony();
                    $class->setUrl('http://api.symfony.com/3.2/' . str_replace("../", "", $item->getAttribute('href')));
                    $class->setName($item->textContent);
                    //$class->setNamespace($namespace);
                    $em->persist($class);
                     //var_dump('Classes: '.'http://api.symfony.com/3.2/'.$item->getAttribute('href'));
                }
            }
        $node = $crawler->filter('h2');

            if ($node->count() > 0){
                foreach ($node as $item){
                    if ($item->textContent == 'Interfaces'){
                        $hItem = $item->nextSibling->nextSibling->getElementsByTagName('a');

                        foreach ($hItem as $item){
                            $interface = new InterfaceSymfony();
                            $interface->setUrl('http://api.symfony.com/3.2/' . str_replace("../", "", $item->getAttribute('href')));
                            $interface->setName($item->textContent);
                           // $interface->setNamespace($namespace);
                            $em->persist($interface);
                           // var_dump('Interfaces: '.'http://api.symfony.com/3.2/'.$item->getAttribute('href'));
                        }
                    }
                }
            }
                $em->flush();
             //  var_dump($item->nodeValue);
        }
}