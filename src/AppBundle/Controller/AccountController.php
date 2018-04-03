<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface as Manager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\DataObject\NewPassword;
use AppBundle\Entity\Client\Client;
use AppBundle\Form\ClientType;
use AppBundle\Form\NewPasswordType;

/**
  * @Route("/account")
 */
class AccountController extends Controller {
  /**
   * @Route("/account/register", name="register_get")
   * @Method({ "GET" })
   */
  public function getRegisterAction(Request $request) {
    return $this->render('account-register.html.twig', [
      'user' => $this->createRegisterForm($request->getLocale())->createView()
    ]);
  }

  /**
   * @Route("/account/register", name="register_post")
   * @Method({ "POST" })
   */
  public function postRegisterAction(Request $request, Manager $manager) {
    $form = $this->createRegisterForm($request->getLocale());
    
    $form->handleRequest($request);

    if (!$form->isValid()) {
      return $this->render('account-register.html.twig', ['user' => $form ])->createView();
    } else {
      $user = $form-­­>getData();
      
      $manager->persist($user);
      $manager->flush();

      //$this->logIn($user, $request);

      $this->redirectToRoute('list_products');
    }
  }

  private function logIn($user, $request) {
    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
    $this->get('security.token_storage')->setToken($token);
    $this->get('session')->set('_security_main', serialize($token));
    $this->get('event_dispatcher')->dispatch(
      'security.interactive_login',
      new InteractiveLoginEvent($request, $token));
  }

  private function createRegisterForm($locale, $client = null) {
    if ($client == null) {
      $client = new Client();
      $client->setPassword(new NewPassword(null, null, null));
    }

    return $this->createForm(ClientType::class, $client, [
      'password_class' => NewPasswordType::class,
      'locale' => $locale,
      'action' => $this->generateUrl('register_post')
    ]);
  }
}
