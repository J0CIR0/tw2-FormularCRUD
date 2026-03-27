<?php

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'create':
        require_once __DIR__ . '/views/form.php';
        break;
    
    case 'edit':
        require_once __DIR__ . '/views/form.php';
        break;
    
    case 'delete':
        require_once __DIR__ . '/views/delete.php';
        break;
    
    case 'index':
    default:
        require_once __DIR__ . '/views/index.php';
        break;
}