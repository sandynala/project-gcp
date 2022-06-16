<?php
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Colors;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Template;

/**
 * @var Template $template
 * @var Survey   $survey
 * @var array   $assets
 * @var string $customCss
 */

?>
<?php foreach ($assets['css'] as $css): ?>
<survey-link rel="stylesheet" href="<?php echo $css; ?>" type="text/css"></survey-link>
<?php endforeach; ?>
<survey-style hidden>
    :host {
    --color-primary: <?php echo $survey->getDesignSettings('colors.primary.base'); ?>;
    --color-primary-dark: <?php echo Colors::darken($survey->getDesignSettings('colors.primary.base'), 20); ?>;
    --color-primary-light: <?php echo Colors::lignten($survey->getDesignSettings('colors.primary.base'), 88); ?>;
    --color-primary-alpha: <?php echo Colors::opacity($survey->getDesignSettings('colors.primary.base'), 0.25); ?>;
    --color-primary-contrast: <?php echo $survey->getDesignSettings('colors.primary.contrast'); ?>;

    --color-secondary: <?php echo $survey->getDesignSettings('colors.secondary.base'); ?>;
    --color-secondary-dark: <?php echo Colors::darken($survey->getDesignSettings('colors.secondary.base'), 20); ?>;
    --color-secondary-contrast: <?php echo $survey->getDesignSettings('colors.secondary.contrast'); ?>;
    --color-secondary-alpha: <?php echo Colors::opacity($survey->getDesignSettings('colors.secondary.base'), 0.25); ?>;
    --color-secondary-light: <?php echo Colors::lignten($survey->getDesignSettings('colors.secondary.base'), 88); ?>;

    --color-success: <?php echo $survey->getDesignSettings('colors.success.base'); ?>;
    --color-success-dark: <?php echo Colors::darken($survey->getDesignSettings('colors.success.base'), 20); ?>;
    --color-success-light: <?php echo Colors::lignten($survey->getDesignSettings('colors.success.base'), 33); ?>;

    --color-error: <?php echo $survey->getDesignSettings('colors.error.base'); ?>;
    --color-error-dark: <?php echo Colors::darken($survey->getDesignSettings('colors.error.base'), 20); ?>;
    --color-error-alpha: <?php echo Colors::opacity($survey->getDesignSettings('colors.error.base'), 0.25); ?>;
    --color-error-light: <?php echo Colors::lignten($survey->getDesignSettings('colors.error.base'), 90); ?>;

    --color-background: <?php echo $survey->getDesignSettings('colors.background.base'); ?>;
    --color-background-dark: <?php echo Colors::darken($survey->getDesignSettings('colors.background.base'), 20); ?>;
    --color-background-contrast: <?php echo $survey->getDesignSettings('colors.background.contrast'); ?>;
    --color-background-light: <?php echo Colors::lignten($survey->getDesignSettings('colors.background.base'), 95); ?>;

    --color-dark: <?php echo $survey->getDesignSettings('colors.dark.base'); ?>;
    --color-dark-contrast: <?php echo $survey->getDesignSettings('colors.dark.contrast'); ?>;
    --color-dark-alpha: <?php echo Colors::opacity($survey->getDesignSettings('colors.dark.base'), 0.05); ?>;

    --size: var(<?php printf('--size-%s', $survey->getDesignSettings('size')); ?>);
    --space: var(<?php printf('--space-%s', $survey->getDesignSettings('space')); ?>);
    --radius: var(<?php printf('--radius-%s', $survey->getDesignSettings('radius')); ?>);
    }
</survey-style>
<survey-style hidden><?php echo $customCss; ?></survey-style>
