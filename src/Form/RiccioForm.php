<?php
/**
 * @files
 * Contains \Drupal\riccio\Form\RiccioForm
 */

namespace Drupal\riccio\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form handler for the Riccio configuration add and edit forms.
 */
class RiccioForm extends EntityForm {

  /**
   * Gets the actual form array to be built.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @return array
   *   The form structure.
   */
  public function form(array $form, FormStateInterface $form_state) {

    /** @var \Drupal\riccio\Entity\RiccioInterface $entity */
    $entity = $this->entity;
    $options = $entity->get('options');
    $form = parent::form($form, $form_state);

    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => EntityTypeInterface::ID_MAX_LENGTH,
      '#default_value' => $entity->get('label'),
      '#description' => $this->t(''),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $entity->get('id'),
      '#maxlength' => EntityTypeInterface::ID_MAX_LENGTH,
      '#machine_name' => array(
        'exists' => '\Drupal\riccio\Entity\Riccio::load',
        'source' => array('label')
      ),
      '#disabled' => !$entity->isNew(),
      '#description' => $this->t('')
    );

    $form['item_selector'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Item selector'),
      '#default_value' => $options['itemSelector'],
      '#description' => $this->t('It\'s a valid CSS selector of your grid items. Riccio cuts this elements and print them into the grid item rows.')
    );

    $form['pop_selector'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Pop selector'),
      '#default_value' => $options['popSelector'],
      '#description' => $this->t('It\'s a valid CSS selector of your grid pops. Riccio cuts this elements and print them into the grid pop rows.')
    );

    $form['per_row_from_css'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Calculate perRow from CSS'),
      '#default_value' => $options['perRowFromCss'],
      '#description' => $this->t('If set to true Riccio gets this options from your CSS. This way you can change the layout of your grid in CSS using the media queries.'),
    );

    $form['per_row'] = array(
      '#type' => 'number',
      '#title' => $this->t('Per row'),
      '#default_value' => $options['perRow'],
      '#description' => $this->t('If you\'re not using media queries set this option to the number of items you want to display in a row.')
    );

    $form['media_queries_from_css'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Calculate perRow from CSS'),
      '#default_value' => $options['mediaQueriesFromCss'],
      '#description' => $this->t('If set to true Riccio gets this options from your CSS. This way you can change the layout of your grid in CSS using the media queries.'),
    );

    $form['media_queries'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Media queries'),
      '#default_value' => $options['mediaQueries'],
      '#description' => $this->t('One media query per row. An array of strings representing media queries.')
    );

    return $form;
  }

  /**
   * Form submission handler for the 'save' action.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @return int
   *   Either SAVED_NEW or SAVED_UPDATED, depending on the operation performed.
   */
  public function save(array $form, FormStateInterface $form_state) {

    /** @var \Drupal\riccio\Entity\RiccioInterface $entity */
    $entity = $this->entity;

    $entity->set('options', array(
      'itemSelector' => $form_state->getValue('item_selector'),
      'popSelector' => $form_state->getValue('pop_selector'),
      'perRowFromCss' => $form_state->getValue('per_row_from_css'),
      'perRow' => $form_state->getValue('per_row'),
      'mediaQueriesFromCss' => $form_state->getValue('media_queries_from_css'),
      'mediaQueries' => $form_state->getValue('media_queries')
    ));

    $status = parent::save($form, $form_state);

    $replacement = array(
      '@label' => $entity->get('label')
    );

    if ($status == SAVED_NEW) {
      drupal_set_message($this->t('Configuration <em>@label</em> has been created.', $replacement));
    }
    elseif ($status == SAVED_UPDATED) {
      drupal_set_message($this->t('Configuration <em>@label</em> has been updated.', $replacement));
    }

    $form_state->setRedirect('entity.riccio.collection');

    return $status;
  }
}