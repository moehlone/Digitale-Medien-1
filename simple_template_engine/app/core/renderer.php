<?php
    namespace app\core;
    
    
    /*
     * 
     * A small and simple template engine to replace markers in files.
     * Feel free to extend this class, for example with the usage of 
     * multidimensional content.
     * 
     * Currently it only can replace single markers with single values.
     * 
     * If you want to have a large template engine, have a look at TWIG:
     * 
     * http://twig.sensiolabs.org/
     * 
     */
    class CRenderer
    {
       
        static private $s_instance = null; //see properties of singleton pattern
        
        private $m_templatePath    = 'app/view';
        private $m_outputBuffer    = '';

        
        /*
         * This is our main point of intersection for other classes,
         * because we use the singleton pattern.
         * 
         * You cann call this method from every class and store the instance by using:
         * 
         *  $variable = app\core\CRenderer::getInstance();
         * 
         * Note that you have to include renderer.php first.
         */
        static public function getInstance()
        {
            //check if we already created an instance
            if (null === self::$s_instance)
            {
                //if not -> create one
                self::$s_instance = new self;
            }
            
            //return always the same instance of our class, stored in $s_instance
            return self::$s_instance;
        }
        
        public function loadTemplate($_fileName = 'default.html')
        {
            //build the complete path for loading. e.g.: app/view/default.html
            $file = $this->m_templatePath . DIRECTORY_SEPARATOR . $_fileName; // FYI: http://alanhogan.com/tips/php/directory-separator-not-necessary
            
            // check, if you can load the given filepath + filename
            if(file_exists($file))
            {
                /*
                 * please read the following links -> ob_ functions are given by PHP
                 */
                
                ob_start();  // http://php.net/manual/de/function.ob-start.php
  
                include $file;
                
                /*
                 * write the outputbuffer of include $file into our $m_outputBuffer as a string
                 */
                $this->m_outputBuffer = ob_get_contents(); // http://php.net/manual/de/function.ob-get-contents.php

                ob_end_clean(); // http://php.net/manual/de/function.ob-end-clean.php
                
                return true;
            }

            return false;
        }
        
        public function assign($_assigns = array())
        {
            /*
             * parse the given $_assigns array. for example: array('title' => 'This is the default page', 'description' => 'Here comes the description')
             * first loop:
             *  $key would be 'title'
             *  $value would be 'This is the default page'
             * 
             * In loop progress we replace our {TITLE} marker from default.html
             * (which is now stored in $m_outputBuffer -> see loadTemplate() method) 
             * with the given values.
             */
            
            foreach($_assigns as $key => $value)
            {
                $this->m_outputBuffer = str_replace('{'.strtoupper($key).'}', $value, $this->m_outputBuffer);
            }
        }
        
        public function render($_fileName = '', $_assigns = array())
        {
            /*
             * The following condition statement makes it possible to call
             * our render() method without calling loadTemplate() and assign() before.
             * 
             * So it`s just a 'quick use' possibility.
             * 
             * For example we can use in our application.controller.php:
             * 
             *      $this->m_renderer->render('default.html', array('title' => $this->m_title, 'description' => $this->m_description));
             * 
             */
            if($_fileName !== '')
            {
                $this->loadTemplate($_fileName);
                
                if(!empty($_assigns))
                {
                    $this->assign($_assigns);
                }
            }
            
            echo $this->m_outputBuffer; // echo the string as plain HTML / XML / JSON whatever
        }

        private function __construct() //see properties of singleton pattern
        {
            
        }

        private function __clone() //see properties of singleton pattern
        {
            
        }

    }
    