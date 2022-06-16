<?php
! defined( 'ABSPATH' ) && exit();

/*
 * Plugin Name: TotalSurvey
 * Plugin URI: https://totalsuite.net/products/totalsurvey/
 * Description: TotalSurvey is a powerful WordPress survey plugin that helps you conduct surveys within a few seconds using the super intuitive and interactive editor, deliver high-quality results within seconds.
 * Version: 1.5.0
 * Author: TotalSuite
 * Author URI: https://totalsuite.net/
 * Text Domain: totalsurvey
 * Domain Path: languages
 * Requires at least: 4.8
 * Requires PHP: 7.0
 * Tested up to: 5.9.0
 *
 * @package TotalSurvey
 * @category Core
 * @author TotalSuite
 * @version 1.5.0
 */

// Environment
$env = require 'environment.php';

// Bootstrap
\TotalSurvey\Plugin::instance($env);
