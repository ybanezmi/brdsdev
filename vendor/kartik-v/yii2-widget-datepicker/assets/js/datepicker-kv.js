/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015
 * @package yii2-widgets
 * @subpackage yii2-widget-datepicker
 * @version 1.3.3
 *
 * Extension to bootstrap datepicker to use noconflict approach
 * so that the plugin does not conflict with other jquery plugins
 * of similar name
 *
 * Built for Yii Framework 2.0
 * Author: Kartik Visweswaran
 * Year: 2015
 * For more Yii related demos visit http://demos.krajee.com
 */
(function ($) {
    $.fn.kvDatepicker = $.fn.datepicker.noConflict();
})(window.jQuery);
