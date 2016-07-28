<?php defined('SYSPATH') or die('No direct script access.');

class Model_OpinionList extends ORM{
    protected $_table_name = 'opinion_list';
    protected $_reload_on_wakeup   = FALSE;

    protected $_stats;
    protected $_total_amount;

    protected $_is_voted;

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
     * Set user vote to opinion
     * @param $variant
     * @throws Validation_Exception
     */
    public function vote($variant){
        $validation = Validation::factory($_POST)
            ->rules('variant', array(
                array(array($this, 'votedValidation'), array(':validation', ':value')),
                array(array($this, 'variantExistsValidation'), array(':validation', ':value')),
            ));
        ;
        if(!$validation->check())
            throw new Validation_Exception($validation);

        ORM::factory('OpinionAnswer')->values(array(
            'opinion_id' => $this->id,
            'variant_id' => $variant,
            'user_id' => Auth::instance()->logged_in('login') ? Auth::instance()->get_user()->id : NULL,
            'ip' => $_SERVER['REMOTE_ADDR'],
        ))->save();
    }

    /**
     * Check if opinion voted already
     * @return bool
     */
    public function isVoted(){
        if(is_null($this->_is_voted)){
            /**
             * @var $answers ORM
             */
            $answers = $this->answers->where('ip','=',$_SERVER['REMOTE_ADDR']);
            if(Auth::instance()->logged_in('login'))
                $answers->and_where('user_id', '=', Auth::instance()->get_user()->id);
            $this->_is_voted = $answers->count_all() > 0;
        }
        return $this->_is_voted;
    }

    /**
     * @param Validation $validation
     */
    public function votedValidation($validation){
        if($this->isVoted())
            $validation->error('variant', 'voted_earlier');
    }

    /**
     * Check if variant with ID exists in this opinion
     * @param $variant
     * @return bool
     */
    protected function variantExists($variant){
        return $this->variants
            ->where('id', '=', $variant)
            ->count_all() > 0;
    }

    /**
     * @param $validation
     */
    public function variantExistsValidation($validation, $value){
        if(!$this->variantExists($value))
            $validation->error('variant', 'variant_not_found');
    }


    /**
     * Getting opinion votes statistics
     * @return mixed
     */
    public function getOpinionStats(){
        if(is_null($this->_stats))
            $this->_stats = $this->variants
                ->select(array('id', 'amount'))
                ->find_all()
                ->as_array('id', 'amount');
        return $this->_stats;
    }

    /**
     * Calculate total amoun of votes
     * @return number
     */
    public function calcTotalAmount(){
        if(is_null($this->_stats))
            $this->getOpinionStats();
        if(is_null($this->_total_amount))
            $this->_total_amount = array_sum($this->_stats);
        return $this->_total_amount;
    }

    /**
     * Flip opinion status
     */
    public function flipStatus(){
        $this->enable = $this->enable == 0 ? 1 : 0;
        $this->update();
    }

    /**
     * Returns opinion results URI
     * @return string
     * @throws Kohana_Exception
     */
    public function getResultsUri(){
        $uri = Route::get('opinion')->uri(array(
            'action' => 'result',
            'id' => $this->id,
        ));
        return $uri;
    }

    /**
     * Returns opinion vote URI
     * @return string
     * @throws Kohana_Exception
     */
    public function getVoteUri(){
        $uri = Route::get('opinion')->uri(array(
            'action' => 'vote',
            'id' => $this->id,
        ));
        return $uri;
    }

    public function __get($name){
        if($name == 'titleLink'){
            return HTML::anchor($this->getResultsUri(), $this->title, array('target'=>'_blank'));
        }
        return parent::__get($name);
    }
}