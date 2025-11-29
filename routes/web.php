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
        });

        // Portefeuille
        Route::get('/wallet', [\App\Http\Controllers\Organizer\WalletController::class, 'index'])->name('wallet.index');

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

// Routes publiques pour concours et collectes
Route::get('/contests', [\App\Http\Controllers\ContestController::class, 'index'])->name('contests.index');
Route::get('/contests/{contest}', [\App\Http\Controllers\ContestController::class, 'show'])->name('contests.show');
Route::get('/fundraisings', [\App\Http\Controllers\FundraisingController::class, 'index'])->name('fundraisings.index');
Route::get('/fundraisings/{fundraising}', [\App\Http\Controllers\FundraisingController::class, 'show'])->name('fundraisings.show');

