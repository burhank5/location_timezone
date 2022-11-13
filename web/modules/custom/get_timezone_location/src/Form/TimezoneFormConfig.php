<?php

namespace Drupal\get_timezone_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\State;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Landing page configs.
 */
class TimezoneFormConfig extends ConfigFormBase {
  const SETTINGS = 'get_timezone_location.set_configuration_form';

  /**
   * Drupal states API object.
   *
   * @var \Drupal\Core\State\State
   */
  protected $state;

  /**
   * {@inheritdoc}
   */
  public function __construct(State $state) {
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('state')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'set_city_timezone';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    $form['country'] = [
      '#type' => 'textfield',
      '#description' => $this->t('Enter your Country'),
      '#default_value' => $config->get('country'),
      '#title' => $this->t('Enter your Country'),
      '#required' => TRUE,
    ];

    $form['city'] = [
        '#type' => 'textfield',
        '#description' => $this->t('Enter your City'),
        '#default_value' => $config->get('city'),
        '#title' => $this->t('Enter your City'),
        '#required' => TRUE,
    ];

    $form['timezone'] = [
        '#type' => 'select',
        '#description' => $this->t('Select your timezone'),
        '#options' => array('select' => t('--- SELECT ---'), 'America/Chicago' => t('America/Chicago'), 'America/New_York' => t('America/New_York'), 'Asia/Tokyo' => t('Asia/Tokyo'), 'Asia/Dubai' => t('Asia/Dubai'), 'Asia/Kolkata' => t('Asia/Kolkata'), 'Europe/Amsterdam' => t('Europe/Amsterdam'), 'Europe/Oslo' => t('Europe/Oslo'), 'Europe/London' => t('Europe/London')),
        '#default_value' => $config->get('timezone'),
        '#title' => $this->t('Select your Timezone'),
        '#required' => TRUE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->state->set('country', $form_state->getValue('country'));
    $this->state->set('city', $form_state->getValue('city'));
    $this->state->set('timezone', $form_state->getValue('timezone'));
    $key = $form_state->getValue('timezone');
    $this->configFactory()
      ->getEditable(static::SETTINGS)
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form['timezone']['#options'][$key])
      ->save();
    parent::submitForm($form, $form_state);

    $this->messenger()->addStatus($this->t('The configuration is saved successfully.'));
  }

}
