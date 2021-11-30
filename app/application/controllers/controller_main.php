<?php
namespace application\controllers;

use application\core\Controller;

class Controller_main extends Controller
{
    function action_index()
    {
        $this->view->generate('main_view.php', $this->view->template_view);
    }
}