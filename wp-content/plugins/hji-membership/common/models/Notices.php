<?php

namespace hji\common\models;

class Notices
{
    const INFO = 1;
    const ERROR = 2;
    
    public function __construct()
    {
        $this->notices = array();
    }
    
    public function addNotice($notice, $severity = Notices::INFO)
    {
        $severity = !empty($severity) ? $severity : Notices::INFO;
        
        if (empty($this->notices[$severity]))
        {
            $this->notices[$severity] = array();
        }
        
        array_push($this->notices[$severity], $notice);
    }
    
    public function getNotices($severity = Notices::INFO)
    {
        $severity = !empty($severity) ? $severity : Notices::INFO;

        return !empty($this->notices[$severity]) ? $this->notices[$severity] : false;
    }
}
