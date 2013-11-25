<?php

    namespace app\control;
    
    require_once 'app/core/renderer.php';
    
    use app\core\CRenderer;
    
    /*
     * This should be a wrapper for our main program flow.
     * Useful to have an overview.
     * 
     * Certainly this should be extended for your use. (for example different application states)
     */
    
    class CApplication
    {
        private $m_title       = '';
        private $m_description = '';
        
        private $m_renderer    = null;
        private $m_GET         = null;
        private $m_POST        = null;
        
        //title and description are only given for testing to the constructor (look at index.php to understand the progress)
        public function __construct($_applicationTitle, $_applicationDescription)
        {
            $this->m_title       = $_applicationTitle;
            $this->m_description = $_applicationDescription;
            $this->m_renderer    = CRenderer::getInstance(); // get an instance from the singleton renderer
            
            //feel free to use them ;) these are the global PHP requests
            $this->m_GET         = $_GET;  // variables provided to the script via URL query string
            $this->m_POST        = $_POST; // variables provided to the script via HTTP POST
        }
        
        public function run()
        {
            $this->m_renderer->loadTemplate('default.html');
            $this->m_renderer->assign(array('title' => $this->m_title, 'description' => $this->m_description));
            $this->m_renderer->render();
        }
    }
    
?>