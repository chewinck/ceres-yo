<?php

namespace Src\admin\infrastructure;


use Src\admin\domain\User;
use Src\admin\domain\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;    

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
    
}