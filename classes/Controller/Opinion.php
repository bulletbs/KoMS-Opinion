<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Котроллер для вывода главной страницы НОВОСТЕЙ
 */

class Controller_Opinion extends Controller_System_Page
{
    public $skip_auto_content_apply = array(
//        'vote',
    );

    public function before(){
        parent::before();
        $this->styles[] = "assets/opinion/css/opinion.css";
        $this->breadcrumbs->add('Голосование', Route::get('opinion')->uri());
    }

    public function action_index(){
        $opinions = ORM::factory('OpinionList');

        $count = clone ($opinions);
        $pagination = Pagination::factory(array(
            'total_items' => $count->count_all(),
            'group' => 'wallpapers',
        ))->route_params(array(
            'controller' => Request::current()->controller(),
        ));

        $this->template->content->set(array(
            'opinions'=>$opinions->find_all(),
            'pagination'=>$pagination,
        ));
    }

    /**
     * Вывод страницы голосования, с возможностю проголосовать
     * @throws HTTP_Exception_404
     * @throws Kohana_Exception
     */
    public function action_vote(){
        $id = Request::current()->param('id');
        $opinion = ORM::factory('OpinionList', $id);
        if(!$id || !$opinion->loaded())
            throw new HTTP_Exception_404;

        if(Request::current()->method() == Request::POST){
            try{
                $variant = Arr::get($_POST, 'variant');
                $opinion->vote($variant);
                $this->redirect(Route::get('opinion')->uri(array('action'=>'result', 'id'=>$id)));
            }
            catch(Validation_Exception $e){
                $errors = $e->array->errors('opinion');
                $this->template->content->set('errors', $errors);
            }
        }

        $this->template->content->set(array(
            'opinion' => $opinion,
            'variants' => $opinion->variants->find_all(),
        ));
    }

    /**
     * Вывод страницы голосования с результатами
     * @throws HTTP_Exception_404
     * @throws Kohana_Exception
     */
    public function action_result(){
        $id = Request::current()->param('id');
        $opinion = ORM::factory('OpinionList', $id);
        if(!$id || !$opinion->loaded())
            throw new HTTP_Exception_404;

        $this->template->content->set(array(
            'opinion' => $opinion,
        ));
    }
}