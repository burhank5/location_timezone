<?php

namespace Drupal\get_timezone_location\Service;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Component\Datetime\Time;
use Drupal\Core\Config\ConfigFactory;

class CurrentTimeService {

    /**
     * Configuration Factory.
     *
     * @var \Drupal\Core\Config\ConfigFactory
    */
    protected $configFactory;

    /**
     * Constructor.
    */
    public function __construct(ConfigFactory $configFactory) {
        $this->configFactory = $configFactory;
    }

    public function getCurrentTime() {
        //Getting current timezone from config
        $config = $this->configFactory->get('get_timezone_location.set_configuration_form');
        $timezone = $config->get('timezone');

        $current_time = new DrupalDateTime('now', $timezone);
        $current_time_with_format = $current_time->format('jS F Y - h:i A'); //Format date according to the required format
        return $current_time_with_format;
    }
}