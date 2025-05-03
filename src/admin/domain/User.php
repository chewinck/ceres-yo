<?php

declare(strict_types=1);

namespace Src\admin\domain;


use Src\admin\domain\UserRepository;
use Illuminate\Support\Facades\Hash;


final class User{

    private  int $id;
    private  string $email;
    private  string $password;
    private  string $estado;
    private  string $perfil;
    private  string $createdAt;


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
    
    public function setCreatedAt(string $createdAt): void{
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): string{
        return $this->createdAt;
    }

    public function exist(): bool{
        return $this->id > 0;
    }

    public function getEstado() : string{
        return $this->estado;
    }

 
    public function setEstado(string $estado): void{
        $this->estado = $estado;
    }

 
    public function getPerfil() : string{
        return $this->perfil;
    }


    public function setPerfil(string $perfil) : void{
        $this->perfil = $perfil;
    }
}