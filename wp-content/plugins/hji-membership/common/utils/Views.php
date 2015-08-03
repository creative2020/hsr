<?php
/**
 * This class first looks in theme's folder
 * then in the views, therefore allowing overwriting
 * of templates.
 */

namespace hji\common\utils;

use \hji\membership\Membership;
use \hji\common\utils\View as BaseView;

require_once(Membership::$dir . '/common/utils/View.php');


class Views
{
    protected $vars = false;
    protected $viewsDir = false;

    function __construct($viewsDir)
    {
        $this->viewsDir = $viewsDir;
    }


    public function set($name, $value)
    {
        $this->vars[$name] = $value;
    }


    public function get($name)
    {
        return (isset($this->vars[$name])) ? $this->vars[$name] : null;
    }


    public function render($fileName, $vars = false)
    {
        // check if template exists in theme's folder

        $viewPath = locate_template($fileName . '.phtml');

        if ($viewPath == '')
        {
            $viewPath = $this->viewsDir . '/' . $fileName . '.phtml';
        }

        $vars = ($vars) ? $vars : $this->vars;

        return BaseView::render($viewPath, $vars);
    }
} 