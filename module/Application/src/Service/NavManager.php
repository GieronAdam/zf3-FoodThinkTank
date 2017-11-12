<?php
namespace Application\Service;
use Application\Service\PostManager;
use Doctrine\ORM\EntityRepository;
use Application\Entity\Post;
use Application\Entity\Tag;
/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */

class NavManager
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;
    /**
     * Auth service.
     * @var Zend\Authentication\Authentication
     */
    private $authService;
    
    /**
     * Url view helper.
     * @var Zend\View\Helper\Url
     */
    private $urlHelper;
    
    /**
     * RBAC manager.
     * @var User\Service\RbacManager
     */
    private $rbacManager;
    
    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper, $rbacManager,$entityManager)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->rbacManager = $rbacManager;
    }
    
    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems() 
    {
        $url = $this->urlHelper;
        $items = [];
        
        $items[] = [
            'id' => 'home',
            'label' => 'Home',
            'link'  => $url('home')
        ];
        
        $items[] = [
            'id' => 'projects',
            'label' => 'Projects',
            'link'  => $url('projects')
        ];

        $items[] = [
            'id' => 'about',
            'label' => 'About',
            'link'  => $url('about'),
        ];

//TODO:: ===============================================================
//
//
//        $postsByTag = $this->entityManager->getRepository(Post::class)
//            ->findPostsByTag('projects')->getResult();
//        echo '<pre>';
//        foreach ($postsByTag[0]->getTags() as $tag){
//
//            $items[] = [
//                'id' => $tag->getName(),
//                'label' => $tag->getName(),
//                'link'  => $url($tag->getName()),
//            ];
//        }
//        echo '</pre>';
//va
//        foreach ($tags as $tag) {
//
//            $postsByTag = $this->entityManager->getRepository(Post::class)
//                ->findPostsByTag($tag->getName())->getResult();
//
//            $postCount = count($postsByTag);
//            if ($postCount > 0) {
//                $tagCloud[$tag->getName()] = $postCount;
//                var_dump($tag->getName());
//            }
//        }


//TODO:: ===============================================================
        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link'  => $url('login'),
                'float' => 'right'
            ];
        } else {
            
            // Determine which items must be displayed in Admin dropdown.
            $adminDropdownItems = [];
            
            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'users',
                            'label' => 'Manage Users',
                            'link' => $url('users')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'post.manage')) {
                $adminDropdownItems[] = [
                    'id' => 'posts',
                    'label' => 'Manage posts',
                    'link' => $url('postsmanage'),
                ];
            }

            if ($this->rbacManager->isGranted(null, 'permission.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'permissions',
                            'label' => 'Manage Permissions',
                            'link' => $url('permissions')
                        ];
            }
            
            if ($this->rbacManager->isGranted(null, 'role.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'roles',
                            'label' => 'Manage Roles',
                            'link' => $url('roles')
                        ];
            }
            
            if (count($adminDropdownItems)!=0) {
                $items[] = [
                    'id' => 'admin',
                    'label' => 'Admin',
                    'dropdown' => $adminDropdownItems,
                    'float' => 'right'
                ];
            }
            
            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',
                'dropdown' => [
                    [
                        'id' => 'settings',
                        'label' => 'Settings',
                        'link' => $url('application', ['action'=>'settings'])
                    ],
                    [
                        'id' => 'logout',
                        'label' => 'Sign out',
                        'link' => $url('logout')
                    ],
                ]
            ];
        }
        
        return $items;
    }
}


