<?php
if (!defined('PLX_ROOT')) exit; // Ensure this file is not accessed directly

class simplemde extends plxPlugin
{
    public function __construct($default_lang)
    {
        parent::__construct($default_lang);
        $this->addHook('AdminTopEndHead', 'AdminTopEndHead');
        $this->addHook('AdminFootEndBody', 'AdminFootEndBody');
        error_log('simplemde plugin initialized');        
    }

    public function AdminTopEndHead()
    {
        echo '<link rel="stylesheet" href="' . PLX_PLUGINS . 'simplemde/dist/simplemde.min.css">' . "\n";
        echo '<script src="' . PLX_PLUGINS . 'simplemde/dist/simplemde.min.js"></script>' . "\n";
    }  

    public function AdminFootEndBody()
    {
?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var simplemdeContent = new SimpleMDE({
                    element: document.getElementById("id_content"),
                    toolbar: ["preview", "side-by-side", "fullscreen"],
                    autosave: {
                        enabled: false,
                        uniqueId: "id_content",
                        delay: 10000,
                    },
                    spellChecker: false,
                    forceSync: true,
                });

                var simplemdeChapo = new SimpleMDE({
                    element: document.getElementById("id_chapo"),
                    toolbar: ["preview", "side-by-side", "fullscreen"],
                    autosave: {
                        enabled: true,
                        uniqueId: "id_chapo",
                        delay: 10000,
                    },
                    spellChecker: false,
                    forceSync: true,
                });
            });
        </script>
<?php
    }
}
?>