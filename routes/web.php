<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
// IMPORTANT: events/{event} doit être défini APRÈS events/create pour éviter les conflits
// Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Formulaires publics
Route::get('/form/{slug}', [\App\Http\Controllers\PublicFormController::class, 'show'])->name('forms.show');
Route::post('/form/{slug}/submit', [\App\Http\Controllers\PublicFormController::class, 'submit'])->name('forms.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes Admin
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Gestion des événements
        Route::get('/events', [\App\Http\Controllers\Admin\EventController::class, 'index'])->name('events.index');
        Route::get('/events/create', [\App\Http\Controllers\Admin\EventController::class, 'create'])->name('events.create');
        Route::post('/events', [\App\Http\Controllers\Admin\EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}', [\App\Http\Controllers\Admin\EventController::class, 'show'])->name('events.show');
        Route::get('/events/{event}/edit', [\App\Http\Controllers\Admin\EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [\App\Http\Controllers\Admin\EventController::class, 'update'])->name('events.update');
        Route::post('/events/{event}/approve', [\App\Http\Controllers\Admin\EventController::class, 'approve'])->name('events.approve');
        Route::post('/events/{event}/reject', [\App\Http\Controllers\Admin\EventController::class, 'reject'])->name('events.reject');
        Route::post('/events/{event}/suspend', [\App\Http\Controllers\Admin\EventController::class, 'suspend'])->name('events.suspend');
        
        // Gestion des utilisateurs
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::put('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.updateRole');
        Route::post('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::put('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.resetPassword');
        
        // Gestion KYC
        Route::get('/kyc', [\App\Http\Controllers\Admin\KycController::class, 'index'])->name('kyc.index');
        Route::get('/kyc/{user}', [\App\Http\Controllers\Admin\KycController::class, 'show'])->name('kyc.show');
        Route::post('/kyc/{user}/approve', [\App\Http\Controllers\Admin\KycController::class, 'approve'])->name('kyc.approve');
        Route::post('/kyc/{user}/reject', [\App\Http\Controllers\Admin\KycController::class, 'reject'])->name('kyc.reject');
        
        // Gestion des paiements
        Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show');
        
        // Gestion des concours
        Route::get('/contests', [\App\Http\Controllers\Admin\ContestController::class, 'index'])->name('contests.index');
        Route::get('/contests/create', [\App\Http\Controllers\Admin\ContestController::class, 'create'])->name('contests.create');
        Route::post('/contests', [\App\Http\Controllers\Admin\ContestController::class, 'store'])->name('contests.store');
        Route::get('/contests/{contest}', [\App\Http\Controllers\Admin\ContestController::class, 'show'])->name('contests.show');
        Route::get('/contests/{contest}/edit', [\App\Http\Controllers\Admin\ContestController::class, 'edit'])->name('contests.edit');
        Route::put('/contests/{contest}', [\App\Http\Controllers\Admin\ContestController::class, 'update'])->name('contests.update');
        
        // Gestion des collectes
        Route::get('/fundraisings', [\App\Http\Controllers\Admin\FundraisingController::class, 'index'])->name('fundraisings.index');
        Route::get('/fundraisings/create', [\App\Http\Controllers\Admin\FundraisingController::class, 'create'])->name('fundraisings.create');
        Route::post('/fundraisings', [\App\Http\Controllers\Admin\FundraisingController::class, 'store'])->name('fundraisings.store');
        Route::get('/fundraisings/{fundraising}', [\App\Http\Controllers\Admin\FundraisingController::class, 'show'])->name('fundraisings.show');
        Route::get('/fundraisings/{fundraising}/edit', [\App\Http\Controllers\Admin\FundraisingController::class, 'edit'])->name('fundraisings.edit');
        Route::put('/fundraisings/{fundraising}', [\App\Http\Controllers\Admin\FundraisingController::class, 'update'])->name('fundraisings.update');
        
        // Paramètres
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'store'])->name('settings.store');
        Route::delete('/settings/{id}', [\App\Http\Controllers\Admin\SettingsController::class, 'destroy'])->name('settings.destroy');
        
        // Demandes de retrait
        Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('/withdrawals/{withdrawal}', [\App\Http\Controllers\Admin\WithdrawalController::class, 'show'])->name('withdrawals.show');
        Route::post('/withdrawals/{withdrawal}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');
        Route::post('/withdrawals/{withdrawal}/complete', [\App\Http\Controllers\Admin\WithdrawalController::class, 'complete'])->name('withdrawals.complete');
    });

    // Événements (création, édition, publication - nécessitent auth)
    // Route explicite pour create AVANT les routes avec paramètres pour éviter les conflits
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');

    // Billets
    Route::get('/events/{event}/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/events/{event}/tickets/checkout', [TicketController::class, 'checkout'])->name('tickets.checkout');
    Route::post('/tickets/purchase', [TicketController::class, 'purchase'])->name('tickets.purchase');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');

    // Paiements
    Route::get('/payments/{payment}/return', [PaymentController::class, 'return'])->name('payments.return');
    Route::post('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');

    // Concours
    Route::resource('contests', \App\Http\Controllers\ContestController::class)->except(['index', 'show']);
    Route::post('/contests/{contest}/publish', [\App\Http\Controllers\ContestController::class, 'publish'])->name('contests.publish');
    Route::post('/contests/{contest}/candidates/{candidate}/vote', [\App\Http\Controllers\ContestController::class, 'vote'])->name('contests.vote');

    // Collectes de fonds
    Route::resource('fundraisings', \App\Http\Controllers\FundraisingController::class)->except(['index', 'show']);
    Route::post('/fundraisings/{fundraising}/publish', [\App\Http\Controllers\FundraisingController::class, 'publish'])->name('fundraisings.publish');
    Route::post('/fundraisings/{fundraising}/donate', [\App\Http\Controllers\FundraisingController::class, 'donate'])->name('fundraisings.donate');

    // Routes organisateur
    Route::middleware(\App\Http\Middleware\EnsureUserIsOrganizer::class)->prefix('organizer')->name('organizer.')->group(function () {
        // Gestion des événements
        Route::get('/events', [\App\Http\Controllers\Organizer\EventManagementController::class, 'index'])->name('events.index');
        Route::delete('/events/{event}', [\App\Http\Controllers\Organizer\EventManagementController::class, 'destroy'])->name('events.destroy');
        
        // Gestion des collaborateurs pour les événements
        Route::get('/events/{event}/collaborators', [\App\Http\Controllers\Organizer\CollaboratorController::class, 'index'])->name('events.collaborators');
        Route::post('/events/{event}/collaborators', [\App\Http\Controllers\Organizer\CollaboratorController::class, 'store'])->name('events.collaborators.store');
        Route::delete('/events/{event}/collaborators/{collaborator}', [\App\Http\Controllers\Organizer\CollaboratorController::class, 'destroy'])->name('events.collaborators.destroy');

        // Gestion des types de billets
        Route::get('/events/{event}/ticket-types', [\App\Http\Controllers\Organizer\TicketTypeController::class, 'index'])->name('ticket-types.index');
        Route::get('/events/{event}/ticket-types/create', [\App\Http\Controllers\Organizer\TicketTypeController::class, 'create'])->name('ticket-types.create');
        Route::post('/events/{event}/ticket-types', [\App\Http\Controllers\Organizer\TicketTypeController::class, 'store'])->name('ticket-types.store');
        Route::get('/events/{event}/ticket-types/{ticketType}/edit', [\App\Http\Controllers\Organizer\TicketTypeController::class, 'edit'])->name('ticket-types.edit');
        Route::put('/events/{event}/ticket-types/{ticketType}', [\App\Http\Controllers\Organizer\TicketTypeController::class, 'update'])->name('ticket-types.update');
        Route::delete('/events/{event}/ticket-types/{ticketType}', [\App\Http\Controllers\Organizer\TicketTypeController::class, 'destroy'])->name('ticket-types.destroy');

        // Gestion des agents
        Route::get('/agents', [\App\Http\Controllers\Organizer\AgentController::class, 'index'])->name('agents.index');
        Route::get('/agents/create', [\App\Http\Controllers\Organizer\AgentController::class, 'create'])->name('agents.create');
        Route::post('/agents', [\App\Http\Controllers\Organizer\AgentController::class, 'store'])->name('agents.store');
        Route::delete('/events/{event}/agents/{agent}', [\App\Http\Controllers\Organizer\AgentController::class, 'destroy'])->name('agents.destroy');

        // Rapports
        Route::get('/reports', [\App\Http\Controllers\Organizer\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/events/{event}', [\App\Http\Controllers\Organizer\ReportController::class, 'eventReport'])->name('reports.event');
        Route::get('/reports/events/{event}/export/{format}', [\App\Http\Controllers\Organizer\ReportController::class, 'exportEvent'])->name('reports.export');

        // Paiements
        Route::get('/payments', [\App\Http\Controllers\Organizer\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [\App\Http\Controllers\Organizer\PaymentController::class, 'show'])->name('payments.show');

        // Scans
        Route::get('/events/{event}/scans', [\App\Http\Controllers\Organizer\ScanController::class, 'index'])->name('scans.index');
        Route::post('/events/{event}/scans', [\App\Http\Controllers\Organizer\ScanController::class, 'scan'])->name('scans.scan');

        // Gestion des concours
        Route::get('/contests', [\App\Http\Controllers\Organizer\ContestManagementController::class, 'index'])->name('contests.index');
        Route::delete('/contests/{contest}', [\App\Http\Controllers\Organizer\ContestManagementController::class, 'destroy'])->name('contests.destroy');

        // Gestion des collectes
        Route::get('/fundraisings', [\App\Http\Controllers\Organizer\FundraisingManagementController::class, 'index'])->name('fundraisings.index');
        Route::delete('/fundraisings/{fundraising}', [\App\Http\Controllers\Organizer\FundraisingManagementController::class, 'destroy'])->name('fundraisings.destroy');

        // CRM Routes
        Route::prefix('crm')->name('crm.')->group(function () {
            // Contacts
            Route::resource('contacts', \App\Http\Controllers\Organizer\Crm\ContactController::class);
            Route::post('/contacts/import', [\App\Http\Controllers\Organizer\Crm\ContactController::class, 'import'])->name('contacts.import');
            Route::post('/contacts/{contact}/assign', [\App\Http\Controllers\Organizer\Crm\ContactController::class, 'assign'])->name('contacts.assign');
            
            // Pipeline
            Route::get('/pipeline', [\App\Http\Controllers\Organizer\Crm\PipelineController::class, 'index'])->name('pipeline.index');
            Route::post('/pipeline/{contact}/stage', [\App\Http\Controllers\Organizer\Crm\PipelineController::class, 'updateStage'])->name('pipeline.updateStage');
            
            // Email Campaigns
            Route::resource('campaigns', \App\Http\Controllers\Organizer\Crm\EmailCampaignController::class);
            Route::post('/campaigns/{campaign}/send', [\App\Http\Controllers\Organizer\Crm\EmailCampaignController::class, 'send'])->name('campaigns.send');
            
            // Automations
            Route::resource('automations', \App\Http\Controllers\Organizer\Crm\AutomationController::class);
            Route::post('/automations/{automation}/toggle', [\App\Http\Controllers\Organizer\Crm\AutomationController::class, 'toggle'])->name('automations.toggle');
            
            // Sponsors
            Route::resource('sponsors', \App\Http\Controllers\Organizer\Crm\SponsorController::class);
            
            // Teams (fusionné avec agents)
            Route::resource('teams', \App\Http\Controllers\Organizer\Crm\TeamController::class);
            Route::post('/teams/{team}/members', [\App\Http\Controllers\Organizer\Crm\TeamController::class, 'addMember'])->name('teams.addMember');
            Route::delete('/teams/{team}/members/{user}', [\App\Http\Controllers\Organizer\Crm\TeamController::class, 'removeMember'])->name('teams.removeMember');
            Route::resource('teams.tasks', \App\Http\Controllers\Organizer\Crm\TeamTaskController::class)->except(['show']);
            
            // Custom Forms
            Route::resource('forms', \App\Http\Controllers\Organizer\Crm\CustomFormController::class);
            Route::get('/forms/{form}/submissions', [\App\Http\Controllers\Organizer\Crm\CustomFormController::class, 'submissions'])->name('forms.submissions');
            Route::get('/forms/{form}/submissions/{submission}', [\App\Http\Controllers\Organizer\Crm\CustomFormController::class, 'showSubmission'])->name('forms.submissions.show');
            Route::post('/forms/{form}/submissions/{submission}/approve', [\App\Http\Controllers\Organizer\Crm\CustomFormController::class, 'approveSubmission'])->name('forms.submissions.approve');
            Route::get('/forms/{form}/export', [\App\Http\Controllers\Organizer\Crm\CustomFormController::class, 'export'])->name('forms.export');
        });

        // Portefeuille
        Route::get('/wallet', [\App\Http\Controllers\Organizer\WalletController::class, 'index'])->name('wallet.index');
        Route::post('/wallet/withdraw', [\App\Http\Controllers\Organizer\WalletController::class, 'withdraw'])->name('wallet.withdraw');

        // Profil
        Route::get('/profile', [\App\Http\Controllers\Organizer\ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [\App\Http\Controllers\Organizer\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/kyc', [\App\Http\Controllers\Organizer\ProfileController::class, 'kyc'])->name('profile.kyc');
        Route::post('/profile/kyc', [\App\Http\Controllers\Organizer\ProfileController::class, 'submitKyc'])->name('profile.kyc.submit');

        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\Organizer\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Organizer\NotificationController::class, 'markAsRead'])->name('notifications.markRead');
        Route::post('/notifications/read-all', [\App\Http\Controllers\Organizer\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    });
});

// Route publique pour afficher un événement (APRÈS les routes auth pour éviter les conflits)
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Routes collaborateur
Route::middleware(['auth', 'collaborator'])->prefix('collaborator')->name('collaborator.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Collaborator\DashboardController::class, 'index'])->name('dashboard');
    
    // Événements assignés
    Route::get('/events', [\App\Http\Controllers\Collaborator\EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [\App\Http\Controllers\Collaborator\EventController::class, 'show'])->name('events.show');
    
    // Scans de tickets
    Route::get('/events/{event}/scans', [\App\Http\Controllers\Collaborator\ScanController::class, 'index'])->name('scans.index');
    Route::post('/events/{event}/scans', [\App\Http\Controllers\Collaborator\ScanController::class, 'scan'])->name('scans.scan');
    
    // Tâches
    Route::get('/tasks', [\App\Http\Controllers\Collaborator\TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}', [\App\Http\Controllers\Collaborator\TaskController::class, 'show'])->name('tasks.show');
    Route::put('/tasks/{task}/status', [\App\Http\Controllers\Collaborator\TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    
    // Profil
    Route::get('/profile', [\App\Http\Controllers\Collaborator\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\Collaborator\ProfileController::class, 'update'])->name('profile.update');
});

// Routes publiques pour concours et collectes
Route::get('/contests', [\App\Http\Controllers\ContestController::class, 'index'])->name('contests.index');
Route::get('/contests/{contest}', [\App\Http\Controllers\ContestController::class, 'show'])->name('contests.show');
Route::get('/fundraisings', [\App\Http\Controllers\FundraisingController::class, 'index'])->name('fundraisings.index');
Route::get('/fundraisings/{fundraising}', [\App\Http\Controllers\FundraisingController::class, 'show'])->name('fundraisings.show');

