<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Validators;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\Rakit\Validation\Rule;

/**
 * Class StringRule
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Validators
 */
class StringRule extends Rule
{
    protected $message = 'The :attribute is not a valid string';

    /**
     * @param $value
     *
     * @return bool
     */
    public function check($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $value = trim($value);

        if (empty($value)) {
            return false;
        }

        return (bool)preg_match('/[\w\s]/u', $value);
    }
}