<?php

    /*
     * 
     * index.php is always our main entrance for our application.
     * 
     * In this case we instantiate our application wrapper
     * and call the run() method to start.
     * 
     * see application.controller.php for more information
     * 
     * You also can call start_session() here, if you need it. 
     * 
     */

    require_once 'app/control/application.controller.php';
    
    $app = new app\control\CApplication('Test-Application', 'some test content');
    
    $app->run();
?>