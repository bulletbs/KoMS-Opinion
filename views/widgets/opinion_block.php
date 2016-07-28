<?php defined('SYSPATH') or die('No direct script access.');?>


<div class="titledPanelBlock">
    <div class="titledPanelHeader">
        <h4>Голос города</h4>
    </div>
    <div class="titledPanelContent">
        <section>
            <b><?php echo $opinion->title?>?</b><br>
            <br>
            <?php echo Form::open($opinion->getVoteUri(), array('class'=>'pure-form'))?>
            <?foreach($variants as $variant):?>
                <?php echo Form::label('variant', Form::radio('variant', $variant->id, !isset($selected)?$selected=TRUE:FALSE).' '.$variant->title, array('class'=>'row'))?>
            <?endforeach;?>
                <br>
                <input type="submit" class="pure-button pure-button-success">
                <?php echo HTML::anchor($opinion->getResultsUri(), 'Результаты', array('class'=>'pure-button'))?>
            <?php echo Form::close()?>
        </section>
    </div>
</div>
