<?php

namespace TotalSurvey\Services;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Handlers\HandleDisplaySurvey;
use TotalSurvey\Validations\InArray;
use TotalSurveyVendors\League\Container\Container;
use TotalSurveyVendors\League\Container\ServiceProvider\AbstractServiceProvider;
use TotalSurveyVendors\Rakit\Validation\Validator;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

/**
 * Class ServiceProvider
 *
 * @package TotalSurvey
 */
class PluginServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        HandleDisplaySurvey::class,
        WorkflowRegistry::class,
        SurveyValidator::class,
        BlockRegistry::class,
    ];

    /**
     * @inheritDoc
     */
    public function register()
    {
        /**
         * @var Container $container
         */
        $container = $this->getContainer();

        // Blocks registry
        $container->share(BlockRegistry::class);

        // Handlers
        $container->add(HandleDisplaySurvey::class)
                  ->addArgument($container->get(Manager::class));

        // Workflow Registry
        $container->share(WorkflowRegistry::class);

        // Register custom validation rules
        $validator = $container->get(Validator::class);
        $validator->addValidator('in_array', new InArray());

        // Survey validator
        $container->share(SurveyValidator::class)
                  ->addArgument($container->get(Validator::class))
                  ->addArgument($container->get(BlockRegistry::class));
    }
}
