<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Виджет "Меню админа"
 */
class Controller_Widgets_OpinionBlock extends Controller_System_Widgets {

    public $template = 'widgets/opinion_block';    // Шаблон виждета

    public function action_index()
    {
        $opinion = ORM::factory('OpinionList')->where('enable', '=', 1)->order_by(DB::expr('rand()'))->find();
        $this->template->set(array(
            'opinion' => $opinion,
            'variants' => $opinion->variants->find_all(),
        ));
    }

}