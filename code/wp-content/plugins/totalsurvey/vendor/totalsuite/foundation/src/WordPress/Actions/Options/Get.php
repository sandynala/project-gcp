<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Options;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Options\GetOptions;

class Get extends Action
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * ResetOptions constructor.
     *
     * @param Options $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function execute(): Response
    {
        return GetOptions::invoke($this->options)->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return true;
    }
}
