<?php

namespace Clay\Bootstrap;

use Collective\Html\FormBuilder as BaseFormBuilder;
use Str;

class FormBuilder extends BaseFormBuilder
{

    protected $novalidate = false;

    public function setNovalidate($value)
    {
        $this->novalidate = $value;
    }

    public function getNovalidate()
    {
        return $this->novalidate;
    }

    /**
     * Open up a new HTML form.
     *
     * @param  array  $options
     * @return string
     */
    public function open(array $options = array())
    {
        if ($this->getNovalidate()) {
            $options[] = 'novalidate';
        }

        return parent::open($options);
    }

    /**
     * Get the protected model attribute without the need of reflection
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Create an number input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     * @return string
     */
    public function number($name, $value = null, $options = array())
    {
        return $this->input('number', $name, $value, $options);
    }

    /**
     * Create an tel input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     * @return string
     */
    public function tel($name, $value = null, $options = array())
    {
        return $this->input('tel', $name, $value, $options);
    }

    /**
     * Create a date input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     * @return string
     */
    public function date($name, $value = null, $options = array())
    {
        return $this->input('date', $name, $value, $options);
    }

    /**
     * Create a time input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     * @return string
     */
    public function time($name, $value = null, $options = array())
    {
        return $this->input('time', $name, $value, $options);
    }

    /**
     * Create a list of radios.
     * This function is very similar to Form::select
     * But, of course, it creates radios instead of options.
     *
     * <code>
     *      // Create a list of radio elements with their labels
     *      echo Form::radio_list('status', array('active' => 'Active', 'inactive' => 'Inactive'));
     *
     * </code>
     *
     * @param  string $name
     * @param  array  $options
     * @param  string $selected
     * @param  array  $attributes
     * @return string
     */
    public function radios($name, $options = array(), $selected = null, $attributes = array())
    {
        $selected = $this->getValueAttribute($name, $selected);

        if (in_array('inline', $attributes)) {
            $class = 'radio-inline';
            unset ($attributes['inline']);
        } else {
            $class = 'radio';
        }

        $html = "";

        foreach ($options as $value => $display) {
            $id = $name . '_' . Str::slug($value);
            $html  .= '<label class="' . $class . '">'
                   . $this->radio($name, $value, $selected == $value, array ('id' => $id))
                   . $display
                   . '</label>';
        }

        return $html;
    }

    /**
     * Create a list of checkboxes.
     * This function is similar to Form::select
     * But, of course, it creates checkboxes instead of options.
     *
     * <code>
     *      // Create a list of checkbox elements with their labels
     *      echo Form::checkbox_list('status', array('active' => 'Active', 'inactive' => 'Inactive'));
     *
     * </code>
     *
     * @param  string $name
     * @param  array  $options
     * @param  string $selected
     * @param  array  $attributes (set an inline key attribute with any value for inline checkboxes)
     * @return string
     */
    public function checkboxes($name, $options = array(), $selected = null, $attributes = array())
    {

        $selected = $this->getValueAttribute($name, $selected);

        if (is_null($selected)) $selected = array();

        if (in_array('inline', $attributes)) {
            $class = 'checkbox-inline';
            unset ($attributes[ 'inline']);
        } else {
             $class = 'checkbox';
        }

        $html = "";

        foreach ($options as $value => $text) {
            $checked = is_array($selected) && in_array($value, $selected);
            $id = $name . '_' . Str::slug($value);
            $html .= '<label class="' . $class . '">'
                  . $this->checkbox($name . '[]', $value, $checked, array ('id' => $id))
                  . $text . '</label> ';
        }

        return $html;
    }

}
