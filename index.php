<?php
const PLX_ROOT = './';
const PLX_CORE = PLX_ROOT . 'core/';

$config = include(PLX_ROOT . 'config.php');
$twig = $config['twig'];

include(PLX_CORE . 'lib/config.php');

// Check if PluXml is installed
if (!file_exists(path('XMLFILE_PARAMETERS'))) {
    header('Location: ' . PLX_ROOT . 'install.php');
    exit;
}

// Start the session
session_set_cookie_params(0, "/", $_SERVER['SERVER_NAME'], isset($_SERVER["HTTPS"]), true);
session_start();

// Include necessary libraries
include(PLX_CORE . 'lib/class.plx.date.php');
include(PLX_CORE . 'lib/class.plx.glob.php');
include(PLX_CORE . 'lib/class.plx.utils.php');
include(PLX_CORE . 'lib/class.plx.capcha.php');
include(PLX_CORE . 'lib/class.plx.erreur.php');
include(PLX_CORE . 'lib/class.plx.record.php');
include(PLX_CORE . 'lib/class.plx.motor.php');
include(PLX_CORE . 'lib/class.plx.feed.php');
include(PLX_CORE . 'lib/class.plx.show.php');
include(PLX_CORE . 'lib/class.plx.encrypt.php');
include(PLX_CORE . 'lib/class.plx.plugins.php');

// Create the main object and start processing
$plxMotor = plxMotor::getInstance();

// Determine the language to use (modifiable by the hook: Index)
$lang = $plxMotor->aConf['default_lang'];

// Hook Plugins
eval($plxMotor->plxPlugins->callHook('Index'));

// Load the language file
loadLang(PLX_CORE . 'lang/' . $lang . '/core.php');

$plxMotor->prechauffage();
$plxMotor->demarrage();

// Create the display object
$plxShow = plxShow::getInstance();

eval($plxMotor->plxPlugins->callHook('IndexBegin')); // Hook Plugins

// Render the Twig template (Laurent's way)
echo $twig->render('home.twig', [
    array($arts[] = [
        'id' => $plxShow->artId(),
        'content' => $plxShow->artContent(),
    ]),
    'arts' => $arts,
    'pagination' => $plxShow->pagination(),
    'feedLink' => $plxShow->artFeed('rss', $plxShow->catId(), '<span><a href="#feedUrl" title="#feedTitle">#feedName</a></span>'),
    'plxShow' => $plxShow, // Ensure plxShow is available in Twig templates
]);

/*$arts = [];
if (isset($plxMotor) && isset($plxShow)) {
    if (isset($plxMotor->plxRecord_arts) && $plxMotor->plxRecord_arts->size > 0) {
        // Loop through each article
        while ($plxMotor->plxRecord_arts->loop()) {
            $arts[] = [
                'id' => $plxShow->artId(),
                'content' => $plxShow->artContent(),
            ];
        }
    }
}

// Capture pagination and feed link
$pagination = $plxShow->pagination();
$feedLink = $plxShow->artFeed('rss', $plxShow->catId(), '<span><a href="#feedUrl" title="#feedTitle">#feedName</a></span>');

// Collect all data to pass to the template
$data = [
    'arts' => $arts,
    'pagination' => $pagination,
    'feedLink' => $feedLink,
    'plxShow' => $plxShow,
];

// Render the Twig template
echo $twig->render('home.twig', $data);*/

// Hook Plugins
eval($plxMotor->plxPlugins->callHook('IndexEnd'));

exit;
