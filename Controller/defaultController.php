<?php
/**
 *
 */
class defaultController extends Controller
{

  function index()
  {
    $this->add("message","welcome!\n");
  }
  function modelTest(){
    $model = new Model;
    $res = $model->query("SHOW TABLES");
    $this->data([
      "tables"=>$res->fetchAll()
    ]);
  }
}
 ?>
