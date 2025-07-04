<?php

namespace Src\admin\dao\eloquent;


use Src\admin\domain\User;
use Src\admin\domain\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;    
use Src\ciudadano\domain\Ciudadano;
use Illuminate\Support\Facades\Auth;


class EloquentUserRepository implements UserRepositoryInterface{

    public function saveUser(User $user): void{
        DB::table('users')->insert([
            'email' => $user->getEmail(),
            'password' => Hash::make($user->getPassword()),
            'estado' => 'activo',
            'perfil' => $user->getPerfil(),
            'created_at' => now()
        ]);
    }

    public function listUsers(): array{
        return \App\Models\User::whereIn('perfil', ['Revisor', 'Admin'])
            ->get()
            ->makeHidden(['password']) // Ocultar el campo password
            ->toArray();
            }


    public function searchUserForId(int $userId): ?User{
        $user = DB::table('users')->where('id', $userId)->first();
        if($user){
            $userEntity = new User();
            $userEntity->setId($user->id);
            $userEntity->setEmail($user->email);
            $userEntity->setPassword($user->password);
            $userEntity->setPerfil($user->perfil);
            return $userEntity;
        }
        return null;
    }

    public function getAuthenticatedUserWithCiudadano(): ?User {
        $user =  \App\Models\User::with('ciudadano')->find(Auth::id());

        if($user){
            $ciudadano = $user->ciudadano;
            if ($ciudadano) {
                $ciudadanoEntity = new Ciudadano();
                $ciudadanoEntity->setId($ciudadano->id);
                $ciudadanoEntity->setNumeroIdentificacion($ciudadano->numero_identificacion);
                $ciudadanoEntity->setNacionalidad($ciudadano->nacionalidad);
                $ciudadanoEntity->setTipoIdentificacion($ciudadano->tipo_identificacion);
                $ciudadanoEntity->setFechaExpedicion(new \DateTime($ciudadano->fecha_expedicion));
                $ciudadanoEntity->setTelefono($ciudadano->telefono);
                $ciudadanoEntity->setTipoDireccion($ciudadano->tipo_direccion);
                $ciudadanoEntity->setBarrio($ciudadano->barrio);
                $ciudadanoEntity->setDireccion($ciudadano->direccion);
            }
                
            $userEntity = new User();
            $userEntity->setId($user->id);
            $userEntity->setNombre($user->nombre); 
            $userEntity->setEmail($user->email);
            $userEntity->setPassword($user->password);
            $userEntity->setPerfil($user->rol);
            $userEntity->setCiudadano($ciudadanoEntity);
            return $userEntity;
        }
    }
    
}