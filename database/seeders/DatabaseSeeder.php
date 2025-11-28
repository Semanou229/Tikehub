<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les rôles
        $roles = ['admin', 'organizer', 'agent', 'buyer'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web'], ['name' => $roleName, 'guard_name' => 'web']);
        }

        // Créer les permissions
        $permissions = [
            'events.create',
            'events.edit',
            'events.delete',
            'events.publish',
            'tickets.create',
            'tickets.scan',
            'tickets.manual',
            'payments.view',
            'payments.refund',
            'contests.create',
            'contests.manage',
            'fundraisings.create',
            'fundraisings.manage',
            'reports.view',
            'users.manage',
            'kyc.verify',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assigner permissions aux rôles
        $adminRole = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::all());
        }

        $organizerRole = Role::where('name', 'organizer')->where('guard_name', 'web')->first();
        if ($organizerRole) {
            $organizerRole->givePermissionTo([
                'events.create',
                'events.edit',
                'events.publish',
                'tickets.create',
                'tickets.scan',
                'tickets.manual',
                'contests.create',
                'contests.manage',
                'fundraisings.create',
                'fundraisings.manage',
                'reports.view',
            ]);
        }

        $agentRole = Role::where('name', 'agent')->where('guard_name', 'web')->first();
        if ($agentRole) {
            $agentRole->givePermissionTo([
                'tickets.scan',
                'tickets.manual',
            ]);
        }

        // Créer un admin par défaut
        $admin = User::firstOrCreate(
            ['email' => 'admin@tikehub.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('password'),
                'kyc_status' => 'verified',
                'kyc_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Créer un organisateur de test
        $organizer = User::firstOrCreate(
            ['email' => 'organizer@tikehub.com'],
            [
                'name' => 'Organisateur Test',
                'password' => Hash::make('password'),
                'kyc_status' => 'verified',
                'kyc_verified_at' => now(),
            ]
        );
        $organizer->assignRole('organizer');

        // Créer des données de test (événements, concours, collectes)
        $this->call(ContentSeeder::class);
    }
}

