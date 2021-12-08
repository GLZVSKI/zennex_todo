<?php

namespace php\core;

class View
{
    public $template_view = 'template.php'; // Общий вид по умолчанию

    function generate($content_view, $template_view, $data = null)
    {
        include 'php/views/' . $template_view;
    }
}
