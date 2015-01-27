<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Console\ColorInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{


    public function indexAction()
    {
        return new ViewModel();
    }


    public function testeAction()
    {
        /**
         * @@var $em \Doctrine\ORM\EntityManager
         * @@var $console \Zend\Console\Adapter\Posix
         */
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $console = $this->getServiceLocator()->get('console');
        $config = $this->getServiceLocator()->get('config');


        for($x = 0; $x <= 3; $x++){

            $metadata_cache = $config['doctrine']['configuration']['orm_default']['metadata_cache'];

            $time_start = microtime(true);

            $cidades = $em->getRepository('Application\Entity\Estados')->findAll();

            $time_end = microtime(true);


            $console->writeLine('Tipo de cache '. $metadata_cache, ColorInterface::YELLOW);
            $console->write('Registros: ', ColorInterface::BLUE);
            $console->writeLine(count($cidades), ColorInterface::BLUE);

            $console->write('Tempo: ', ColorInterface::RED);
            $console->writeLine($time_end - $time_start, ColorInterface::RED);

            unset($time_end, $time_start);
        }


    }
}
