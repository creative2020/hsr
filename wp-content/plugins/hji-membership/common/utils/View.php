<?php

namespace hji\common\utils;

class View
{
    public static function render($fileName, $vars = false)
    {
        $response = false;
        
        if (file_exists($fileName))
        {
            ob_start();

            if (!empty($vars))
            {
                extract($vars);
            }
            
            require($fileName);
                    
            $response = ob_get_contents();
                    
            ob_end_clean();
        }
        
        return $response;        
    }
}
