<div date-events-no-js="1">
    <b>События за период <?=$this->bDate?> - <?=$this->eDate?></b><br>
    <?foreach($this->events as $event):?>
        <?=$event->getName()?> &nbsp <?=$event->getDate()?> <br>
    <?endforeach?>
</div>