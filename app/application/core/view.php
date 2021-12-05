<?php

namespace application\core;

class View
{
    public $template_view = 'template_view.php'; // Общий вид по умолчанию

    function generate($content_view, $template_view, $data = null)
    {
        include 'application/views/' . $template_view;
    }
}