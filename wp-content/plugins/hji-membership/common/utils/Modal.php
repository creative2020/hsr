<?php

namespace hji\common\utils;


use hji\membership\Membership;

class Modal
{
    static public function getModal($atts)
    {
        $default_atts = array(
            'id'        => uniqid('hji-modal-'),
            'title'     => false,
            'content'   => '',
            'close_btn' => true,
            'save_btn'  => true,
            'close_btn_text' => 'Close',
            'save_btn_text'  => 'Save',
            'save_btn_id'    => uniqid('save-btn-'),
        );

        $atts = array_merge($default_atts, $atts);

        (is_array($atts)) ? extract($atts) : $content = $atts;

        ob_start();

        include(Membership::$dir . '/common/views/modal.phtml');

        $modal = ob_get_contents();
        ob_end_clean();

        return $modal;
    }
}