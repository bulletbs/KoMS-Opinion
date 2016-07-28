<?php defined('SYSPATH') or die('No direct script access.');?>
<h1>Голос народа на <?php echo KoMS::config()->project['name']?></h1>
<p>На этой странице представлены все голосования портала ЯКиев, прошедшие и текущие.</p>
<?foreach($opinions as $opinion):?>
    <div class="opinion_variants">
        <h3><?php echo $opinion->title?></h3>
        <div class="opinion_description">Всего голосов: <?php echo $opinion->calcTotalAmount()?> <?php echo !$opinion->enable ? '<span>Голосование завершено</span>' : HTML::anchor(Route::get('opinion')->uri(array('action'=>'vote', 'id'=>$opinion->id)), 'Проголосовать', array('class'=>'pure-button pure-button-primary'))?></div>
        <?foreach($opinion->variants->find_all() as $variant_key=>$variant):?>
            <ul>
                <li class="title"><?php echo $variant_key+1?>. <?php echo $variant->title?> <span class="amount">(голосов: <?php echo $variant->amount?>)</span></li>
                <li class="graph"><div style="width: <?php echo $variant->calculatePercent($opinion->calcTotalAmount())?>%;"></div></li>
                <li class="percent"><?php echo $variant->calculatePercent($opinion->calcTotalAmount())?>%</li>
            </ul>
        <?endforeach;?>
        <br>
        <hr>
    </div>
<?endforeach?>

