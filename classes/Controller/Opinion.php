<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Котроллер для вывода главной страницы НОВОСТЕЙ
 */

class Controller_Opinion extends Controller_System_Page
{
    public $skip_auto_content_apply = array(
        'vote',
    );

    public function before(){
        parent::before();
    }

    public function action_index(){

    }

    public function action_result(){

    }

    public function action_vote(){

    }
}