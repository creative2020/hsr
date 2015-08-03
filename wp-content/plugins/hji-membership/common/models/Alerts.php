<?php
/**
 * Front-end version of Notices
 */

namespace hji\common\models;


class Alerts
{
    const INFO      = 'info';
    const ERROR     = 'error';
    const SUCCESS   = 'success';
    const WARNING   = 'warning';


    function __construct()
    {
        $this->alerts = array();
    }


    public function addAlert($alert, $severity = Alerts::INFO, $dismiss = false)
    {
        $severity = !empty($severity) ? $severity : Alerts::INFO;

        if (empty($this->alerts[$severity]))
        {
            $this->alerts[$severity] = array();
        }

        $properties = array(
            'message'   => $alert,
            'dismiss'   => $dismiss
        );

        array_push($this->alerts[$severity], $properties);
    }


    public function getAlerts($severity = Alerts::INFO)
    {
        $severity = !empty($severity) ? $severity : Alerts::INFO;

        return !empty($this->alerts[$severity]) ? $this->alerts[$severity] : false;
    }
} 