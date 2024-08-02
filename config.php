<?php
const PLX_CONFIG_PATH = 'data/configuration/';

// Include Composer's autoloader
require_once 'vendor/autoload.php';

// Set up Twig
$loader = new \Twig\Loader\FilesystemLoader('themes/defaut/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
    'debug' => true,
    'strict_variables' => true
]);

// Add the DebugExtension
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Return the Twig environment and data preparation function
return [
    'twig' => $twig
];
