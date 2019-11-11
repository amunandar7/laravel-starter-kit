<?php

namespace App\Http\Forms\Fields;

/**
 * Form Builder input types
 *
 * Reference: http://kristijanhusak.github.io/laravel-form-builder/
 *
 * @author Achmad Munandar
 */
class Types
{
    const TEXT     = 'text';
    const PASSWORD = 'password';
    const HIDDEN   = 'hidden';
    const TEXTAREA = 'textarea';
    const EMAIL    = 'email';
    const NUMBER   = 'number';
    const FILE     = 'file';
    const READONLY = 'static';

    /**
     * Bootstrap datetimepicker plugin (date only)
     *
     * docs : https://eonasdan.github.io/bootstrap-datetimepicker/
     *
     * the attribute are:
     * - minDate (String date) / (String date)
     * - maxDate (String date) / (String date)
     * - viewMode (String viewMode) - 'decades','years','months','days'
     * - daysOfWeekDisabled (Array days) - number of day. sunday = 0
     *
     */
    const DATETIMEPICKER = 'datetimepicker';

    /**
     * Bootstrap datetimepicker plugin (time only)
     *
     * docs : https://eonasdan.github.io/bootstrap-datetimepicker/
     *
     */

    /**
     * Bootstrap datetimepicker plugin (date only)
     *
     * docs : https://eonasdan.github.io/bootstrap-datetimepicker/
     *
     * the attribute are:
     * - minDate (String date) / (String date)
     * - maxDate (String date) / (String date)
     * - viewMode (String viewMode) - 'decades','years','months','days'
     * - daysOfWeekDisabled (Array days) - number of day. sunday = 0
     *
     */
    const DATEPICKER = 'datepicker';

    /**
     * Bootstrap datetimepicker plugin (time only)
     *
     * docs : https://eonasdan.github.io/bootstrap-datetimepicker/
     *
     */
    const TIMEPICKER = 'timepicker';

    /**
     * Bootstrap datetimepicker plugin (hour only)
     *
     * docs : https://eonasdan.github.io/bootstrap-datetimepicker/
     *
     */
    const HOURPICKER = 'hourpicker';

    /**
     * This is classic select dropdown
     *
     * the attributes are:
     *
     * 1. choices (Array) (Default: []) - key value pairs used for options in the select
     *
     * 2. empty_value (String) (Default: null) - If provided, added to the start of select as empty value
     *
     * 3. selected (String / Array/ Closure) (Default: null) - Option that needs to be selected. If not provided, Form class will try to fetch it from passed model.
     * - array is used when ‘multiple’ attribute is set
     * - Closure is used for modifying model data before passed to view. Useful when fetching relationship data to pluck only data that is needed.
     */
    const SELECT = 'select';

    /**
     * Select2 is a jQuery based replacement for select boxes. It supports searching, remote data sets, and pagination (infinite scrolling) of results.
     *
     * the attributes are:
     *
     * 1. choices (Array) (Default: []) - key value pairs used for options in the select
     *
     * 2. empty_value (String) (Default: null) - If provided, added to the start of select as empty value
     *
     * 3. selected (String / Array/ Closure) (Default: null) - Option that needs to be selected. If not provided, Form class will try to fetch it from passed model.
     * - array is used when ‘multiple’ attribute is set
     * - Closure is used for modifying model data before passed to view. Useful when fetching relationship data to pluck only data that is needed.
     *
     * 4. ajax (String) - key of select2
     * 
     */
    const SELECT2 = 'select2';

    /**
     * For take image, the result is base64 string
     * 
     * the attributes are:
     * - width (int) [optional] - in pixel
     * - height (int) [optional] - in pixel
     * - max_size (int) [optional] - in MB
     * - extentions (Array) [optional] - available extentions
     */
    const IMAGE = 'image';

    /**
     * Repeated type field is basically same field doubled, with a name change.
     *
     * Beside inherited, there are some additional options available:
     * - type (String) (Default: password) - Field type to be used
     * - second_name (String) (Default: {FIELD_NAME}_confirmation) - Name of the second field, if empty, uses the default name with _confirmation appended.
     * - first_options (Array) (Default: []) - Options for the first field
     * - second_options (Array) (Default: []) - Options for the second field
     */
    const REPEATED = 'repeated';
    const CHECKBOX = 'checkbox';

    /**
     * CkEditor type field is text editor using plugin ckeditor js
     */
    const CKEDITOR = 'ckeditor';

}