<?php
	
class javascript_Core {
	
        protected static $javascripts = array();
	
        public static function add($javascripts = array())	
        {	
                if ( ! is_array($javascripts))	
                        $javascripts = array($javascripts);
	
                foreach ($javascripts as $key => $javascript)	
                {	
                        self::$javascripts[] = $javascript;	
                }	
        }
	
        public static function remove($javascripts = array())	
		{	
                foreach (self::$javascripts as $key => $javascript)
                {
                        if (in_array($javascript, $javascripts))
                                unset(self::$javascripts[$key]);
                }
        }
        
        public static function render()	
        {
                foreach (array_unique( self::$javascripts ) as $key => $javascript)
                {
                    if (substr($javascript, 0, 4) == 'http')
                        echo '<script type="text/javascript" src="'.$javascript.'"></script>';
                    else
                        echo html::script('js/' . $javascript . '.js');
                }
        }
		public static function renderOnce($script)	
        {
                
            echo html::script('js/' . $script . '.js');
                
        }
}