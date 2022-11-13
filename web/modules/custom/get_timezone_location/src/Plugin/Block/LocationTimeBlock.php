<?php

namespace Drupal\get_timezone_location\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\get_timezone_location\Service\CurrentTimeService;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * GEP User register to download.
 *
 * @Block(
 *  id = "location_time_block",
 *  admin_label = @Translation("Timezone Block"),
 *  category = @Translation("Gets time according to the timezone"),
 * )
 */
class LocationTimeBlock extends BlockBase implements ContainerFactoryPluginInterface  {

    /**
     * @var $timezone Drupal\get_timezone_location\Service\CurrentTimeService
     */
    protected $timezone;

    /**
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param Drupal\get_timezone_location\Service\CurrentTimeService $timezone
    */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, CurrentTimeService $timezone) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->timezone = $timezone;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     *
     * @return static
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('get_timezone_location.current_time_service')
        );
    }

    /**
     * {@inheritdoc}
    */
    public function build() {
        $city = \Drupal::config('get_timezone_location.set_configuration_form')->get('city');
        return [
            '#markup' => '<h1>Hi '.$this->timezone->getCurrentTime().'and city '.$city.' </h1>',
        ];
    }

    /**
     * {@inheritdoc}
    */
    public function getCacheMaxAge() {
        return 0;
    }

}