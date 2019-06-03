<?php

namespace Clay\Bootstrap;

use Collective\Html\FormBuilder as Form;
use Illuminate\View\Factory as View;
use Illuminate\Session\Store as Session;

class FieldBuilder
{
    protected $form;
    protected $view;
    protected $session;
    protected $templatesFolder = 'bootstrap/fields/';

    protected $defaultClass = [
        'default'     => 'form-control',
        'checkbox'    => '',
        'error_class' => 'has-error'
    ];

    public function __construct(Form $form, View $view, Session $session)
    {
        $this->form    = $form;
        $this->view    = $view;
        $this->session = $session;
    }

    public function getTemplatesFolder()
    {
        return $this->templatesFolder;
    }

    public function setTemplatesFolder($templatesFolder)
    {
        $this->templatesFolder = $templatesFolder;
    }

    public function getDefaultClass($type)
    {
        if (isset($this->defaultClass[$type])) {
            return $this->defaultClass[$type];
        }

        return $this->defaultClass['default'];
    }

    public function buildCssClasses($type, &$attributes)
    {
        $defaultClasses = $this->getDefaultClass($type);

        if (isset($attributes['class'])) {
            $attributes['class'] .= ' ' . $defaultClasses;
        } else {
            $attributes['class'] = $defaultClasses;
        }
    }

    public function buildLabel($name, array $attributes = array())
    {
        if (isset ($attributes['label'])) {
            return $attributes['label'];
        }

        if (\Lang::has('formlabels.' . $name)) {
            $label = \Lang::get('formlabels.' . $name);
        }
        elseif (\Lang::has('validation.attributes.' . $name)) {
            $label = \Lang::get('validation.attributes.' . $name);
        } else {
            $label = str_replace('_', ' ', $name);
        }

        return ucfirst(strtolower($label));
    }

    public function addEmptyOption($options)
    {
        // if an empty option has been added already then do nothing
        if (isset ($options[''])) {
            return $options;
        } else {
            return array('' => 'Select') + $options;
        }
    }

    public function buildControl($type, $name, $value = null, $attributes = array(), $options = array())
    {
        unset($attributes['label']);

        if (!isset($attributes['id'])) {
            $attributes['id'] = $name;
        }

        switch ($type) {
            case 'select':
                return $this->form->select($name, $this->addEmptyOption($options), $value, $attributes);
            case 'password':
                return $this->form->password($name, $attributes);
            case 'checkbox':
                return $this->form->checkbox($name, $value, isset($attributes['selected']) ? true : false, array_except($attributes, ['selected']));
            case 'textarea':
                return $this->form->textarea($name, $value, $attributes);
            default:
                return $this->form->input($type, $name, $value, $attributes);
        }
    }

    public function buildError($name)
    {
        $error = null;

        if ($this->session->has('errors')) {
            $errors = $this->session->get('errors');

            if ($errors->has($name)) {
                $error = $errors->first($name);
            }
        }

        return $error;
    }

    public function buildErrorClass($error)
    {
        return is_null($error) ? '' : (' ' . $this->getDefaultClass('error_class'));
    }

    public function buildTemplate($type)
    {
        $folder = $this->getTemplatesFolder();

        if (\File::exists(app_path() . '/views/'  . $folder . $type . '.blade.php')) {
            return $folder . $type;
        }

        return $folder . 'default';
    }

    public function input($type, $name, $value = null, $attributes = array(), $options = array())
    {
        $this->buildCssClasses($type, $attributes);

        $label       = $this->buildLabel($name, $attributes);
        $control     = $this->buildControl($type, $name, $value, $attributes, $options);
        $error       = $this->buildError($name);
        $error_class = $this->buildErrorClass($error);
        $template    = $this->buildTemplate($type);

        return $this->view->make($template, compact ('name', 'label', 'control', 'error', 'error_class'));
    }

    public function password($name, $attributes = array())
    {
        return $this->input('password', $name, null, $attributes);
    }

    public function select($name, $options, $value = null, $attributes = array())
    {
        return $this->input('select', $name, $value, $attributes, $options);
    }

    public function __call($method, $params)
    {
        array_unshift($params, $method);

        return call_user_func_array([$this, 'input'], $params);
    }

}
