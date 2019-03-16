<?php
// Default Auth
Route::auth();

// API
require_once __DIR__ . '/Routes/api.php';

// Consumer
require_once __DIR__ . '/Routes/consumer.php';

// Admin
require_once __DIR__ . '/Routes/admin.php';

// Business
require_once __DIR__ . '/Routes/business.php';

// Company
require_once __DIR__ . '/Routes/company.php';

// WebService
require_once __DIR__ . '/Routes/webservice.php';
