<?php

namespace Drupal\get_timezone_location\Service;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Component\Datetime\Time;
use Drupal\Core\Config\ConfigFactory;

class CurrentTimeService {

    public function getCurrentTime() {
        $timezone = \Drupal::config('get_timezone_location.set_configuration_form')->get('timezone');
        $current_time = new DrupalDateTime('now', $timezone);
        return $current_time;
    }
}