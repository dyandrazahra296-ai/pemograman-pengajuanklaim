<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// PUBLIC
$routes->get('/', 'Home::index');

// AUTH
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::process');
$routes->get('/logout', 'Auth::logout');

// ==========================
// LOGIN REQUIRED
// ==========================
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // DASHBOARD (SEMUA USER)
    $routes->get('/dashboard', 'Dashboard::index');

    // PROFILE (SEMUA USER)
    $routes->get('/profile', 'ProfileController::index');
    $routes->post('/profile/change-password', 'ProfileController::changePassword');

    // ======================
    // ADMIN ONLY
    // ======================
    $routes->group('', ['filter' => 'admin'], function ($routes) {

        // USERS
        $routes->get('/users', 'Users::index');
        $routes->get('/users/create', 'Users::create');
        $routes->post('/users/store', 'Users::store');
        $routes->get('/users/edit/(:num)', 'Users::edit/$1');
        $routes->post('/users/update/(:num)', 'Users::update/$1');
        $routes->get('/users/delete/(:num)', 'Users::delete/$1');
        $routes->get('/users/reset-password/(:num)', 'Users::resetPassword/$1');

        // users toggle active
        $routes->post('/users/toggle-status', 'Users::toggleStatus');


        // EMPLOYEES
        $routes->get('/employees', 'Employees::index');
        $routes->get('/employees/create', 'Employees::create');
        $routes->post('/employees/store', 'Employees::store');

        //CLAIMS
        $routes->get('/claims', 'MedicalClaims::index');
        $routes->get('/claims/history', 'MedicalClaims::history');

        //REPORTS
        $routes->get('/reports', 'Reports::index');
        $routes->get('/reports/filter', 'Reports::filter');
        $routes->get('/reports/export-pdf', 'Reports::exportPdf');
        $routes->get('/reports/export-excel', 'Reports::exportExcel');
    });

    // ======================
    // HRD ONLY
    // ======================
    $routes->group('', ['filter' => 'hrd'], function ($routes) {

        $routes->get('hrd/dashboard', 'Hrd\HrdController::index');
        $routes->get('hrd/history', 'Hrd\HrdController::history');

        $routes->get('hrd/approve/(:num)', 'Hrd\HrdController::process/approve/$1');
        $routes->get('hrd/reject/(:num)', 'Hrd\HrdController::process/reject/$1');
        $routes->get('hrd/process/(:any)/(:num)', 'Hrd\HrdController::process/$1/$2');
    });

    $routes->group('karyawan', ['namespace' => 'App\Controllers\karyawan', 'filter' => 'auth'], function ($routes) {
        // Dashboard Karyawan
        $routes->get('dashboard', 'MedicalClaimController::index');

        // Klaim Medis
        $routes->get('medical-claim', 'MedicalClaimController::create');
        $routes->post('medical-claim/submit', 'MedicalClaimController::submitClaim');

        // Profil
        $routes->get('profile', 'ProfileController::index');
        $routes->post('profile/update', 'ProfileController::update');
        $routes->get('profile/edit', 'ProfileController::edit');

        // Password
        $routes->get('change-password', 'ProfileController::changePasswordView');
        $routes->post('change-password/update', 'ProfileController::updatePassword');

        // ajukan plafon
        $routes->get('karyawan/ajukan-plafon', 'karyawan\MedicalClaimController::ajukanPlafon');
        $routes->post('karyawan/submit-plafon', 'karyawan\MedicalClaimController::submitPlafon');
    });

    $routes->group('keuangan', ['filter' => 'keuangan'], function ($routes) {
// Keuangan\Keuangan::index artinya:
        // Folder Keuangan -> File Keuangan.php -> Method index
    $routes->get('/', 'Keuangan\Keuangan::index');
    $routes->get('dashboard', 'Keuangan\Keuangan::index');

    $routes->get('klaim', 'Keuangan\Keuangan::klaim');
    $routes->get('riwayat', 'Keuangan\Keuangan::riwayat');
    $routes->post('bayar/(:num)', 'Keuangan\Keuangan::bayar/$1');
    $routes->post('tolak/(:num)', 'Keuangan\Keuangan::tolak/$1');
    $routes->get('export/pdf', 'Keuangan\Keuangan::exportPdf');

});
});
