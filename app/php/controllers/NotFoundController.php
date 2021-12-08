<?php

namespace php\controllers;

use php\core\Controller;

class NotFoundController extends Controller
{

    public function action_index()
    {
        $this->view->generate('error_404.php', $this->view->template_view);
    }
}
