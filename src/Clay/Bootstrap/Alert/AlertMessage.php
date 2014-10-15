<?php

namespace Bootstrap\Alert;

use \Bootstrap\Alert\AlertWrapper as Wrapper;

class AlertMessage
{

    protected $wrapper;
    protected $message;

    protected static $alerts = array();
    protected static $counter = 0;

    protected $id;

    public function __construct(Wrapper $wrapper, $type, $message, $parameters = array())
    {
        $this->wrapper = $wrapper;
        $this->message = array(
            'message' => $this->wrapper->getText($message, $parameters),
            'type'    => $type,
            'details' => '',
            'html'    => '',
            'list'    => array(),
            'buttons' => array()
        );
        $this->wrapper->addMessage($this);
        $this->wrapper->push();
    }

    public function getMessage()
    {
        return $this->message;
    }

    // Chaining Methods

    public function details($details)
    {
        $this->message['details'] = $details;
        $this->wrapper->push();

        return $this;
    }

    public function button($text, $route, $class = 'default', $parameters = array())
    {
        $this->message['buttons'][] = array(
            'text'  => $this->wrapper->getText($text, $parameters),
            'route' => $route,
            'class' => $class
        );
        $this->wrapper->push();

        return $this;
    }

    public function html($html)
    {
        $this->message['html'] = $html;
        $this->wrapper->push();

        return $this;
    }

    public function view($view, $data = array())
    {
        return $this->html($this->wrapper->view($view, $data));
    }

    public function items($items)
    {
        if ( ! is_array($items)) $items = $items->all();
        $this->message['items'] = $items;
        $this->wrapper->push();

        return $this;
    }

}
