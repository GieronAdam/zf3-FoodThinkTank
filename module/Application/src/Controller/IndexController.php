<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Entity\User;
use Application\Form\ContactForm;
use Application\Service\MailSender;


/**
 * This is the main controller class of the User Demo application. It contains
 * site-wide actions such as Home or About.
 */
class IndexController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * Mail sender.
     * @var Application\Service\MailSender
     */
    private $mailSender;
    /**
     * Constructor. Its purpose is to inject dependencies into the controller.
     */
    public function __construct($entityManager, $mailSender)
    {
       $this->entityManager = $entityManager;
        $this->mailSender = $mailSender;
    }

    /**
     * This is the default "index" action of the controller. It displays the
     * Home page.
     */
    public function indexAction()
    {
        $appName = 'Food Think Tank';
        $appDescription = 'Food Think Tank Foundation is the bunch of the individualists
                            and experts in multiple fields which have focused on the process of common learning
                            and progression. Each of us is different and brings to unity something extra. 
                            We are as free as free is our mind and as limited as the joint discussion may limit us. 
                            We are forging the enormous number of relative to food-thinking ideas 
                            into concerted effect from which we are able to get in a responsible way. 
                            We have met here, in Wrocław so here we eat and act!';

        // Return variables to view script with the help of
        // ViewObject variable container
        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription
        ]);
    }

    /**
     * The "settings" action displays the info about currently logged in user.
     */
    public function settingsAction()
    {
        $id = $this->params()->fromRoute('id');

        if ($id!=null) {
            $user = $this->entityManager->getRepository(User::class)
                    ->find($id);
        } else {
            $user = $this->currentUser();
        }

        if ($user==null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        if (!$this->access('profile.any.view') &&
            !$this->access('profile.own.view', ['user'=>$user])) {
            return $this->redirect()->toRoute('not-authorized');
        }

        return new ViewModel([
            'user' => $user
        ]);
    }

    public function projectsAction()
    {
        $view = new ViewModel([
            'article' => 'Projects Article'
        ]);
        return $view;
    }

    /**
     * This action displays the Contact Us page.
     */
    public function contactUsAction()
    {
        // Create Contact Us form
        $form = new ContactForm();

        // Check if user has submitted the form
        if($this->getRequest()->isPost()) {

            // Fill in the form with POST data
            $data = $this->params()->fromPost();

            $form->setData($data);

            // Validate form
            if($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();
                $email = $data['email'];
                $subject = $data['subject'];
                $body = $data['body'];

                // Send E-mail
                if(!$this->mailSender->sendMail('adam.gieron@foodthinktank.pl', $email,
                    $subject, $body)) {
                    // In case of error, redirect to "Error Sending Email" page
                    return $this->redirect()->toRoute('application',
                        ['action'=>'sendError']);
                }

                // Redirect to "Thank You" page
                return $this->redirect()->toRoute('application',
                    ['action'=>'thankYou']);
            }
        }

        // Pass form variable to view
        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * This action displays the Thank You page. The user is redirected to this
     * page on successful mail delivery.
     */
    public function thankYouAction()
    {
        return new ViewModel();
    }

    /**
     * This action displays the Send Error page. The user is redirected to this
     * page on mail delivery error.
     */
    public function sendErrorAction()
    {
        return new ViewModel();
    }
}

