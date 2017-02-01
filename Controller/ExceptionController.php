<?php class ExceptionController extends Controller{
  function __construct(Exception $e){
    $msg  ="捕获异常:".$e->getMessage()."\n";
    $msg .='错误代码：'.$e->getCode()."\n";
    $msg .='错误文件：'.$e->getFile()."\n";
    $msg .='错误追踪：'."\n";
    $msg .=$e->getTraceAsString();
    $this->id="Exception";
    Session::set($this->id);
    parent::__construct();
    $this->error = array(
    'code'=>"001",
    'message'=>$msg,
    'errors'=>array()
    );
  }
}
