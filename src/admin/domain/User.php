<?php

declare(strict_types=1);

namespace Src\admin\domain;


use Src\admin\domain\UserRepository;
use Illuminate\Support\Facades\Hash;
use Src\ciudadano\domain\CIudadano;


final class User{

    private  int $id;
    private  string $nombre;
    private  string $email;
    private  string $password;
    private  string $estado;
    private  string $perfil;
    private  string $createdAt;
    private  Ciudadano $ciudadano;


    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getId(): int{
        return $this->id;
    }

    public function setNombre(string $nombre): void{
        $this->nombre = $nombre;
    }
    public function getNombre(): string{
        return $this->nombre;
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

    public function setCiudadano(Ciudadano $ciudadano): void
    {
        $this->ciudadano = $ciudadano;
    }

    public function getCiudadano()
    {
        return $this->ciudadano;
    }
}