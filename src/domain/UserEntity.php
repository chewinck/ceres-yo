<?php

declare(strict_types=1);

namespace Src\domain;


use Src\domain\UserRepository;
use Illuminate\Support\Facades\Hash;


final class UserEntity{

    private  int $id;
    private  string $email;
    private  string $password;
    private  string $estado;
    private  string $perfil;
    private  string $createdAt;
    private  UserRepository $repository;


    public function setRepository(UserRepository $repository): void{
        $this->repository = $repository;
    }
    
    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getId(): int{
        return $this->id;
    }

    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function setPassword(string $password): void{
        $this->password = $password;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function setTipoUsuarioId(string $perfil): void{
        $this->perfil = $perfil;
    }


    public function getTipoUsuarioId(): string{
        return $this->perfil;
    }

    
    public function setCreatedAt(string $createdAt): void{
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): string{
        return $this->createdAt;
    }

    public function exist(): bool{
        return $this->id > 0;
    }

    public static function listar(UserRepository $repository): array{
        return $repository->listUsers();
    }

    public static function searchForId(UserRepository $repository, int $userId): ?UserEntity{
        return $repository->searchUserForId($userId);
    }

    public function saveUser(UserEntity $user): void{
        $this->repository->saveUser($user);
    }

    /**
     * Get the value of estado
     */ 
    public function getEstado() : string{
        return $this->estado;
    }

    /**
     * Set the value of estado
     *
     * @return  self
     */ 
    public function setEstado(string $estado): void{
        $this->estado = $estado;
    }

    /**
     * Get the value of perfil
     */ 
    public function getPerfil() : string{
        return $this->perfil;
    }

    /**
     * Set the value of perfil
     *
     * @return  self
     */ 
    public function setPerfil(string $perfil) : void{
        $this->perfil = $perfil;
    }
}