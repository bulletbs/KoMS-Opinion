<?php defined('SYSPATH') or die('No direct script access.');

class Model_OpinionList extends ORM{
    protected $_table_name = 'opinion_list';
    protected $_reload_on_wakeup   = FALSE;

    protected $_has_many = array(
        'variants' => array(
            'model'       => 'OpinionVariant',
            'foreign_key' => 'opinion_id',
        ),
        'answers' => array(
            'model'       => 'OpinionAnswer',
            'foreign_key' => 'opinion_id',
        ),
    );

    public function labels(){
        return array(
            'id'=>'ID',
            'title'=>'Title',
            'titleLink'=>'Title',
            'enable'=>'Enabled',
            'ordr'=>'Order',
        );
    }


    /**
     * Flip opinion status
     */
    public function flipStatus(){
        $this->enable = $this->enable == 0 ? 1 : 0;
        $this->update();
    }

    /**
     * Returns opinion URI
     * @return string
     * @throws Kohana_Exception
     */
    public function getUri(){
        $uri = Route::get('opinion')->uri(array(
            'action' => 'result',
            'id' => $this->id,
        ));
        return $uri;
    }

    public function __get($name){
        if($name == 'titleLink'){
            return HTML::anchor($this->getUri(), $this->title);
        }
        return parent::__get($name);
    }
}