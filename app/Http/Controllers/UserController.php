<?php
namespace App\Http\Controllers;

use Src\admin\usecase\listUsersUseCase;
use Src\admin\usecase\saveUserUseCase;
use Src\admin\domain\User;
use Src\shared\factoryrepository\FactoryRepository;

class UserController extends Controller
{
    public function index(){

        $Users = new listUsersUseCase(FactoryRepository::getInstance()->getUserRepository());
        $response = $Users->execute();
        return $this->response($response->getCode(), $response->getMessage(), $response->getData());

    }

    public function save(){
        $request = request();
        $user = new User();
        $user->setEmail($request->email);
        $user->setPassword($request->password);
        $user->setperfil($request->perfil);
        $user->setEstado('activo');
        $Users = new saveUserUseCase(FactoryRepository::getInstance()->getUserRepository());
        $response = $Users->execute($user);
        return $this->response($response->getCode(), $response->getMessage(), $response->getData());
    }


}