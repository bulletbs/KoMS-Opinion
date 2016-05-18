<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Opinion extends Controller_Admin_Crud
{
    public $skip_auto_render = array(
        'delete',
        'status',
    );

    protected $_item_name = 'opinion';
    protected $_crud_name = 'Opinions';

    protected $_model_name = 'OpinionList';
    protected $_orderby_field = 'ordr';

    protected $_setorder_field = 'ordr';

    public $list_fields = array(
        'id',
        'titleLink',
    );

//    protected $_filter_fields = array(
//        'title' => array(
//            'label' => 'Найти',
//            'type'=>'text',
//            'oper'=>'like',
//        ),
//        'id' => array(
//            'label' => 'ID',
//            'type'=>'text',
//            'oper'=>'=',
//        ),
//    );

    public $_form_fields = array(
        'title' => array('type'=>'text'),
        'enable' => array('type'=>'checkbox'),
        'variants' => array(
            'type'=>'call_view',
            'data'=>'admin/opinion/variants',
        ),
    );

    protected $_advanced_list_actions = array(
        array(
            'action'=>'status',
            'label'=>'On/Off',
            'icon'=>array(
                'field'=>'enable',
                'values' => array(
                    '0' => 'eye-close',
                    '1' => 'eye-open',
                ),
            ),
        ),
    );



    public function action_index(){
//        $this->_filter_fields['title']['data'] = $this->_filter_values['title'];

        parent::action_index();
    }

    /**
     * Form preloader
     * @param $model
     * @param array $data
     * @return array|bool|void
     */
    protected function _processForm($model, $data = array()){
        if(!$model->id){
            $model->enable = true;
        }
        parent::_processForm($model);
    }

    /**
     * Saving Model Method
     * @param $model
     */
    protected function _saveModel($model){
        $model->values($_POST)->save();

        /* Save New Options */
        foreach(Arr::get($_POST,'newVariants', array()) as $variant){
            $newOption = ORM::factory('OpinionVariant')->values(array('title'=>$variant, 'opinion_id'=>$model->id));
            $newOption->save();
        }
        /* Save Present Options */
        foreach(Arr::get($_POST,'variants', array()) as $k=>$variant){
            $option = ORM::factory('OpinionVariant', $k)->values(array('title'=>$variant));
            $option->update();
        }
        /* Delete Options */
        foreach(Arr::get($_POST,'deleted', array()) as $variant)
            ORM::factory('OpinionVariant', $variant)->delete();
    }

    /**
     * On/Off item
     */
    public function action_status(){
        $article = ORM::factory($this->_model_name, $this->request->param('id'));
        if($article->loaded()){
            $article->flipStatus();
        }
        $this->redirect($this->_crud_uri . URL::query());
    }

    /**
     * Loading model to render form
     * @param null $id
     * @return ORM
     */
    protected function _loadModel($id = NULL){
        $model = ORM::factory($this->_model_name, $id);
        return $model;
    }
}
