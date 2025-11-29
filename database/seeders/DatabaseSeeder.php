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

        // Créer les comptes de test pour tous les rôles
        
        // ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin@tikehub.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('password'),
                'phone' => '+229 90 00 00 01',
                'kyc_status' => 'verified',
                'kyc_verified_at' => now(),
                'is_active' => true,
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // ORGANISATEUR
        $organizer = User::firstOrCreate(
            ['email' => 'organizer@tikehub.com'],
            [
                'name' => 'Organisateur Test',
                'password' => Hash::make('password'),
                'phone' => '+229 90 00 00 02',
                'kyc_status' => null,
                'kyc_verified_at' => null,
                'is_active' => true,
            ]
        );
        if (!$organizer->hasRole('organizer')) {
            $organizer->assignRole('organizer');
        }

        // CLIENT / BUYER
        $buyer = User::firstOrCreate(
            ['email' => 'client@tikehub.com'],
            [
                'name' => 'Client Test',
                'password' => Hash::make('password'),
                'phone' => '+229 90 00 00 03',
                'kyc_status' => 'pending',
                'is_active' => true,
            ]
        );
        if (!$buyer->hasRole('buyer')) {
            $buyer->assignRole('buyer');
        }

        // AGENT
        $agent = User::firstOrCreate(
            ['email' => 'agent@tikehub.com'],
            [
                'name' => 'Agent Test',
                'password' => Hash::make('password'),
                'phone' => '+229 90 00 00 04',
                'kyc_status' => 'verified',
                'kyc_verified_at' => now(),
                'is_active' => true,
            ]
        );
        if (!$agent->hasRole('agent')) {
            $agent->assignRole('agent');
        }

        // Afficher les informations de connexion
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('  COMPTES DE TEST CRÉÉS');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('🔴 ADMINISTRATEUR:');
        $this->command->info('   Email: admin@tikehub.com');
        $this->command->info('   Mot de passe: password');
        $this->command->info('');
        $this->command->info('🟣 ORGANISATEUR:');
        $this->command->info('   Email: organizer@tikehub.com');
        $this->command->info('   Mot de passe: password');
        $this->command->info('');
        $this->command->info('🟢 CLIENT / BUYER:');
        $this->command->info('   Email: client@tikehub.com');
        $this->command->info('   Mot de passe: password');
        $this->command->info('');
        $this->command->info('🟡 AGENT:');
        $this->command->info('   Email: agent@tikehub.com');
        $this->command->info('   Mot de passe: password');
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('');

        // Créer des données de test (événements, concours, collectes)
        $this->call(ContentSeeder::class);
    }
}

