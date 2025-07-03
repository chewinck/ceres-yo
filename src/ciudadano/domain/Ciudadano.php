<?php

declare(strict_types=1);

namespace Src\ciudadano\domain;

class Ciudadano {

    private int $id;
    private string $nacionalidad;
    private string $tipoIdentificacion;
    private string $numeroIdentificacion;
    private \DateTime $fechaExpedicion;
    private ?string $telefono;
    private string $tipoDireccion;
    private string $barrio;
    private string $direccion;


    public function setId(int $id): void {
        $this->id = $id;
    }
    public function setNacionalidad(string $nacionalidad): void {
        $this->nacionalidad = $nacionalidad;
    }
    public function setTipoIdentificacion(string $tipoIdentificacion): void {
        $this->tipoIdentificacion = $tipoIdentificacion;
    }
    public function setNumeroIdentificacion(string $numeroIdentificacion): void {       
        $this->numeroIdentificacion = $numeroIdentificacion;
    }
    public function setFechaExpedicion(\DateTime $fechaExpedicion): void {
        $this->fechaExpedicion = $fechaExpedicion;
    }
    public function setTelefono(?string $telefono): void {
        $this->telefono = $telefono;
    }
    public function setTipoDireccion(string $tipoDireccion): void {
        $this->tipoDireccion = $tipoDireccion;
    }
    public function setBarrio(string $barrio): void {
        $this->barrio = $barrio;
    }
    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }   

    public function getId(): int {
        return $this->id;
    }
    public function getNacionalidad(): string {
        return $this->nacionalidad;
    }
    public function getTipoIdentificacion(): string {
        return $this->tipoIdentificacion;   
    }
    public function getNumeroIdentificacion(): string {
        return $this->numeroIdentificacion;
    }
    public function getFechaExpedicion(): \DateTime {
        return $this->fechaExpedicion;
    }
    public function getTelefono(): ?string {
        return $this->telefono;
    }
    public function getTipoDireccion(): string {
        return $this->tipoDireccion;    
    }
    public function getBarrio(): string {
        return $this->barrio;
    }
    public function getDireccion(): string {
        return $this->direccion;
    }

}
