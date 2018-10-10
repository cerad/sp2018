<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

//use Scheduler\SchBundle\Entity\Enquiry;
//use Scheduler\SchBundle\Form\EnquiryType;

class PageController extends AbstractController
{
  /**
   * Home page.
   *
   * @Route("/", name="scheduler_homepage")
   * @Template()
   */
  public function indexAction()
  {
    return [];
  }

  /**
   * Help page.
   *
   * @Route("/help", name="help")
   * @Template()
   */
  public function helpAction()
  {
    return [];
  }

  /**
   * Help sub-pages.
   *
   * @Route("/help/{topic}", name="help_topic")
   * @Template()
   */
  public function helpTopicAction($topic)
  {
    $topic = preg_replace('/[^0-9a-zA-Z_]/', '', $topic);
    return $this->render("page/help.$topic.html.twig");
  }

  /**
   * Contact page.
   *
   * @Route("/contact", name="scheduler_contact")
   * @Template()
   */
  /*
  public function contactAction(Request $request)
  {
    $enquiry = new Enquiry();
    $form = $this->createForm(EnquiryType::class, $enquiry);
    $form->handleRequest($request);

    if ($form->isValid()) {
      // send an email
      $message = \Swift_Message::newInstance()
        ->setSubject('Contact enquiry from Sportac.us')
        ->setFrom($this->container->getParameter('scheduler.contact.emails.from'))
        ->setTo($this->container->getParameter('scheduler.contact.emails.to'))
        ->setBody($this->renderView('SchedulerBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
      $this->get('mailer')->send($message);

      $this->get('session')->getFlashBag()->add('contact-notice', 'Your contact enquiry was successfully sent. Thank you!');

      // Redirect - This is important to prevent users re-posting
      // the form if they refresh the page
      return $this->redirect($this->generateUrl('scheduler_contact'));
    }
    return $this->render('SchedulerBundle:Page:contact.html.twig',
      array('form' => $form->createView())
    );
  }*/
}

