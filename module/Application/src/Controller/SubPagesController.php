<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\PostForm;
use Application\Entity\Post;
use Application\Form\CommentForm;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


class SubPagesController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Post manager.
     * @var Application\Service\PostManager
     */
    private $postManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $postManager)
    {
        $this->entityManager = $entityManager;
        $this->postManager = $postManager;
    }

    public function projectsAction()
    {
        $query = $this->entityManager->getRepository(Post::class)
            ->findPostsByTag('projects')->getResult();
        $items = array();
        foreach($query as $item )
        {
            array_push($items,$item);

        }

        return new ViewModel(['data'=>$items]);
    }

    public function peoplesAction()
    {
        $query = $this->entityManager->getRepository(Post::class)
            ->findPostsByTag('peoples')->getResult();
        $items = array();
        foreach($query as $item )
        {
            array_push($items,$item);

        }

        return new ViewModel(['data'=>$items]);
    }
    public function addactionsAction()
    {
        $query = $this->entityManager->getRepository(Post::class)
            ->findPostsByTag('addactions')->getResult();
        $items = array();
        foreach($query as $item )
        {
            array_push($items,$item);

        }

        return new ViewModel(['data'=>$items]);
    }

    public function labAction()
    {
        $query = $this->entityManager->getRepository(Post::class)
            ->findPostsByTag('lab')->getResult();
        $items = array();
        foreach($query as $item )
        {
            array_push($items,$item);

        }

        return new ViewModel(['data'=>$items]);
    }
    public function initiativesAction()
    {
        $query = $this->entityManager->getRepository(Post::class)
            ->findPostsByTag('initiatives')->getResult();
        $items = array();
        foreach($query as $item )
        {
            array_push($items,$item);

        }

        return new ViewModel(['data'=>$items]);
    }

//    /**
//     * This action displays the "View Post" page allowing to see the post title
//     * and content. The page also contains a form allowing
//     * to add a comment to post.
//     */
//    public function viewAction()
//    {
//        $postId = (int)$this->params()->fromRoute('id', -1);
//
//        // Validate input parameter
//        if ($postId<0) {
//            $this->getResponse()->setStatusCode(404);
//            return;
//        }
//
//        // Find the post by ID
//        $post = $this->entityManager->getRepository(Post::class)
//            ->findOneById($postId);
//
//        if ($post == null) {
//            $this->getResponse()->setStatusCode(404);
//            return;
//        }
//
//        // Create the form.
//        $form = new CommentForm();
//
//        // Check whether this post is a POST request.
//        if($this->getRequest()->isPost()) {
//
//            // Get POST data.
//            $data = $this->params()->fromPost();
//
//            // Fill form with data.
//            $form->setData($data);
//            if($form->isValid()) {
//
//                // Get validated form data.
//                $data = $form->getData();
//
//                // Use post manager service to add new comment to post.
//                $this->postManager->addCommentToPost($post, $data);
//
//                // Redirect the user again to "view" page.
//                return $this->redirect()->toRoute('posts', ['action'=>'view', 'id'=>$postId]);
//            }
//        }
//
//        // Render the view template.
//        return new ViewModel([
//            'post' => $post,
//            'form' => $form,
//            'postManager' => $this->postManager
//        ]);
//    }


}
