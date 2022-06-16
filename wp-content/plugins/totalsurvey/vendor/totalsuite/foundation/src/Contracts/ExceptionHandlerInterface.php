<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Contracts;
! defined( 'ABSPATH' ) && exit();



use Throwable;

/**
 * Interface ExceptionHandlerInterface
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Contracts
 */
interface ExceptionHandlerInterface
{
    /**
     * @param Throwable $e
     *
     * @return mixed
     */
    public function handle(Throwable $e);
}