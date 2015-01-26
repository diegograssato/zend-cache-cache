<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{


    public function indexAction()
    {

        $dados = array(
        'nome' => 'Teste Teste',
        'login'  => 'teste',
        'senha'   => '1234',
        );


        $authentication = new AuthenticationService();
        $authentication->getStorage()->write($dados);
        var_dump($authentication->getIdentity());

        $dm = $this->getServiceLocator()->get('Doctrine\ODM\MongoDB\DocumentManager');
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $userDM = new \Application\Document\User();
        $userDM->setLogin($dados['login']);
        $userDM->setSenha($dados['senha']);
        $userDM->setNome($dados['nome']);
        $dm->persist($userDM);


        $userEM = new \Application\Entity\User();
        $userEM->setLogin($dados['login']);
        $userEM->setSenha($dados['senha']);
        $userEM->setNome($dados['nome']);
        $em->persist($userEM);

        $dm->flush();
        $em->flush();

        echo $userDM->getId();
        echo $userEM->getId();

        return new ViewModel();
    }
}
