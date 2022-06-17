<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template;

/**
 * @var string $apiBase
 * @var string $nonce
 * @var Template $template
 * @var Survey $survey
 * @var string $customCss
 */
?>
<template class="totalsurvey-template">
    <!--  style   -->
    <?php echo $template->view('partials/style') ?>

    <?php echo $before; ?>

    <!--  survey  -->
    <survey
            inline-template
            :survey="<?php echo htmlentities(json_encode($survey), ENT_QUOTES) ?>"
            nonce="<?php echo $nonce; ?>"
            :api-base="'<?php echo esc_attr($apiBase); ?>'"
            id="survey">
        <div class="survey" :class="{'is-done': isFinished}" <?php language_attributes(); ?>>
            <h1 class="survey-title" v-html="survey.name"><?php echo $survey->name ?></h1>
            <p class="survey-description" v-html="survey.description"><?php echo $survey->description ?></p>
            <div class="loader" :class="{'is-loading': isLoading}"></div>

            <?php echo $template->view('partials/progress', ['survey' => $survey]) ?>
            <?php echo $template->view('partials/error', ['survey' => $survey]) ?>
            <?php echo $template->view('partials/sections', ['survey' => $survey]) ?>

        </div>
    </survey>

    <?php echo $after; ?>
</template>
