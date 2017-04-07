<?php
namespace FA\Controller;
use Yee\Foundation\Controller;
use Yee\Foundation\View;

class defaultController extends Controller
{

  function IndexAction()
  {
      $view = new View($this->APP);
      $view->world = "world";
      $view->render('index');
  }
}

