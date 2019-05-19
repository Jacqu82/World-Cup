<?php

namespace Service;

use PDO;
use Repository\CommentRepository;
use Repository\FavouriteRepository;
use Repository\GroupRepository;
use Repository\ImageRepository;
use Repository\MatchRepository;
use Repository\MessageRepository;
use Repository\NationalTeamRepository;
use Repository\PostRepository;
use Repository\UserRepository;

class Container
{
    private $configuration;

    private $pdo;

    private $userRepository;

    private $messageRepository;

    private $postRepository;

    private $commentRepository;

    private $groupRepository;

    private $nationalTeamRepository;

    private $favouriteRepository;

    private $imageRepository;

    private $matchRepository;

    private $motorCycleLoader;

    private $imageService;


    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return PDO
     */
    public function getPDO()
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                $this->configuration['db_dsn'],
                $this->configuration['db_user'],
                $this->configuration['db_pass']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $this->pdo;
    }

    public function loggedUser()
    {
        if (isset($_SESSION['id'])) {
            return $this->getUserRepository()->loadUserById($_SESSION['id']);
        }

        return false;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository()
    {
        if ($this->userRepository === null) {
            $this->userRepository = new UserRepository($this->getPDO());
        }

        return $this->userRepository;
    }

    /**
     * @return MessageRepository
     */
    public function getMessageRepository()
    {
        if ($this->messageRepository === null) {
            $this->messageRepository = new MessageRepository($this->getPDO());
        }

        return $this->messageRepository;
    }

    /**
     * @return PostRepository
     */
    public function getPostRepository()
    {
        if ($this->postRepository === null) {
            $this->postRepository = new PostRepository($this->getPDO());
        }

        return $this->postRepository;
    }

    /**
     * @return CommentRepository
     */
    public function getCommentRepository()
    {
        if ($this->commentRepository === null) {
            $this->commentRepository = new CommentRepository($this->getPDO());
        }

        return $this->commentRepository;
    }

    /**
     * @return GroupRepository
     */
    public function getGroupRepository()
    {
        if ($this->groupRepository === null) {
            $this->groupRepository = new GroupRepository($this->getPDO());
        }

        return $this->groupRepository;
    }

    /**
     * @return NationalTeamRepository
     */
    public function getNationalTeamRepository()
    {
        if ($this->nationalTeamRepository === null) {
            $this->nationalTeamRepository = new NationalTeamRepository($this->getPDO());
        }

        return $this->nationalTeamRepository;
    }

    /**
     * @return FavouriteRepository
     */
    public function getFavouriteRepository()
    {
        if ($this->favouriteRepository === null) {
            $this->favouriteRepository = new FavouriteRepository($this->getPDO());
        }

        return $this->favouriteRepository;
    }

    /**
     * @return ImageRepository
     */
    public function getImageRepository()
    {
        if ($this->imageRepository === null) {
            $this->imageRepository = new ImageRepository($this->getPDO());
        }

        return $this->imageRepository;
    }

    /**
     * @return MatchRepository
     */
    public function getMatchRepository()
    {
        if ($this->matchRepository === null) {
            $this->matchRepository = new MatchRepository($this->getPDO());
        }

        return $this->matchRepository;
    }

//    /**
//     * @return CarLoader
//     */
//    public function getCarLoader()
//    {
//        if ($this->carLoader === null) {
//            $this->carLoader = new CarLoader($this->getCarRepository());
//        }
//
//        return $this->carLoader;
//    }

//
//    public function getImageService()
//    {
//        if ($this->imageService === null) {
//            $this->imageService = new ImageService($this);
//        }
//
//        return $this->imageService;
//    }
//

//
//    public function loggedAdmin()
//    {
//        if (isset($_SESSION['adminId'])) {
//            return $this->getAdminRepository()->findOneById($_SESSION['adminId']);
//        }
//
//        return false;
//    }
}
