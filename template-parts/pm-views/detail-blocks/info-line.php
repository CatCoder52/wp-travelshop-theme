<?php

/**
 * @var array $args
 */

/**
 * @var Custom\MediaType\Reise $moc
 */
$moc = $args['moc'];

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $args['mo'];
?>

<div class="small mb-2">
    ID/Code: <?php echo $mo->id. ' '.$mo->code; ?>
    <?php
    /**
     * if the media object is cached, we display a short information about the content age
     */
    if($mo->isCached()){
        $cacheinfo = $mo->getCacheInfo();
        $cachetime = new DateTime($cacheinfo['date']);
        $cachetime->setTimezone(new DateTimeZone('Europe/Berlin'));
        echo '| Stand: '.$cachetime->format('d.m.Y H:i');
    }
    ?>
   |  Programmänderungen vorbehalten.
</div>
