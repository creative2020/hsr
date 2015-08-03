<?php
namespace hji\common\interfaces;


abstract class AbstractSettingsModel
{
    protected static $__CLASS__ = __CLASS__;
    protected static $instance;

    // Plugin's settings key

    protected $settingsKey = false;

    // Array of option groups keys. Each key represents settings on a single page

    protected $optionGroupsKeys;

    // All loaded settings

    protected $settings = false;


    /**
     * @param      $pluginSlug
     * @param bool $settingsKey - overwrites settings key
     */
    function __construct($pluginSlug, $settingsKey = false)
    {
        if ($settingsKey)
        {
            $this->settingsKey = $settingsKey;
        }
        else
        {
            $this->settingsKey = 'hji-' . $pluginSlug . '-settings';
        }
    }


    static function getInstance()
    {
        $class = static::getClass();

        if (static::$instance === null)
        {
            static::$instance = new $class;
        }

        return static::$instance;
    }


    private static function getClass()
    {
        if (static::$__CLASS__ == __CLASS__)
        {
            die("You MUST provide a <code>protected static \$__CLASS__ = __CLASS__;</code> statement in your Singleton-class!");
        }

        return static::$__CLASS__;
    }


    function loadOptions()
    {
        if ($this->settingsKey)
        {
            $this->settings = get_option($this->settingsKey);
        }
    }


    function getOptions($optionGroupKey = false)
    {
        if ($optionGroupKey)
        {
            return (isset($this->settings[$optionGroupKey]))
                    ? $this->settings[$optionGroupKey] : false;
        }
        
        return $this->settings;
    }


    function getOption($optionName, $optionGroupKey = false)
    {
        if ($this->optionGroupsKeys)
        {
            if (!$optionGroupKey)
            {
                trigger_error('$optionGroupKey is required.', E_USER_ERROR);
                return;
            }
            else if (!in_array($optionGroupKey, $this->optionGroupsKeys))
            {
                trigger_error('Option Group Key "'. $optionGroupKey . '" doesn\'t exist in ' . self::getClass() .'::optionGroupsKeys.', E_USER_ERROR);
            }
            else
            {
                return (isset($this->settings[$optionGroupKey][$optionName]))
                    ? $this->settings[$optionGroupKey][$optionName] : false;
            }
        }
        else if ($optionGroupKey)
        {
            trigger_error('Option Group Key "'. $optionGroupKey . '" doesn\'t exist in ' . self::getClass() .'::optionGroupsKeys.', E_USER_ERROR);
            return;
        }

        return (isset($this->settings[$optionName]))
            ? $this->settings[$optionName] : false;
    }


    function setOptions($newOptions, $optionGroupKey = false)
    {
        // if optionGroupKeys are set, then require a key
        // otherwise there is a chance of an error to overwrite all settings

        if ($this->optionGroupsKeys)
        {
            if (!$optionGroupKey)
            {
                trigger_error('$optionGroupKey is required.', E_USER_ERROR);
                return;
            }
            else if (!in_array($optionGroupKey, $this->optionGroupsKeys))
            {
                trigger_error('Option Group Key "'. $optionGroupKey . '" doesn\'t exist in ' . self::getClass() .'::optionGroupsKeys.', E_USER_ERROR);
                return;
            }

            $this->settings[$optionGroupKey] = $newOptions;
        }
        else
        {
            $this->settings = $newOptions;
        }

        update_option($this->settingsKey, $this->settings);
    }


    function getInputName($optionName, $optionGroupKey = false)
    {
        if ($this->optionGroupsKeys)
        {
            if (!$optionGroupKey)
            {
                trigger_error('$optionGroupKey is required.', E_USER_ERROR);
                return;
            }
            else if (!in_array($optionGroupKey, $this->optionGroupsKeys))
            {
                trigger_error('Option Group Key "'. $optionGroupKey . '" doesn\'t exist in ' . self::getClass() .'::optionGroupsKeys.', E_USER_ERROR);
                return;
            }

            return $this->settingsKey . '[' . $optionGroupKey .']' . '[' . $optionName .']';
        }

        return $this->settingsKey . '[' . $optionName .']';
    }
} 