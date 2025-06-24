<?php

namespace Src\Shared\FactoryRepository;

use Src\admin\domain\UserRepositoryInterface;
use Src\admin\domain\UserRepository;
use Src\admin\infrastructure\EloquentUserRepository;

class FactoryRepository{

     private static ?FactoryRepository $instance = null;

     private UserRepositoryInterface $userRepository;

     public function __construct(){
        $this->userRepository = new EloquentUserRepository();
     }

        public static function getInstance(): FactoryRepository{
            if(self::$instance == null){
                self::$instance = new FactoryRepository();
            }
            return self::$instance;
        }

        public function getUserRepository(): UserRepositoryInterface{
            return $this->userRepository;
        }


}
