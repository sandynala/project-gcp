<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template;

/**
 * @var Template $template
 * @var Survey $survey
 */
$thankYouBlocks = $survey->getThankYouBlocks();
?>
<section-item uid="thankyou" inline-template @reload="reload($event)">
    <transition name="fade">
        <section class="section thankyou" v-show="isVisible">
            <p v-if="lastEntry.customThankYouMessage" v-html="lastEntry.customThankYouMessage"></p>
            <template v-else>
            <?php foreach ($thankYouBlocks as $block): ?>
                <?php echo $block->render(); ?>
            <?php endforeach; ?>
            </template>
            <button type="button" @click="reload()" class="button -primary" v-if="canRestart"><?php echo __('Submit another entry', 'totalsurvey') ?></button>
        </section>
    </transition>
</section-item>
