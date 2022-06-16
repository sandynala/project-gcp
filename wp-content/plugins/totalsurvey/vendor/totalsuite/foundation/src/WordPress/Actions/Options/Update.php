<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Options;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Options\UpdateOptions;

class Update extends Action
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
        $data = $this->request->getParsedBody();
        return UpdateOptions::invoke($this->options, $data)->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return true;
    }
}
