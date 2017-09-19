<?php
/**
 * @file
 * Contains \Drupal\riccio\Plugin\Field\FieldFormatter\EntityReferenceRiccioFormatter
 */

namespace Drupal\riccio\Plugin\Field\FieldFormatter;


use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;
use Drupal\Core\Form\FormStateInterface;
use Drupal\riccio\Entity\Riccio;

/**
 * Plugin implementation of the 'entity reference flickity' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_reference_riccio",
 *   label = @Translation("Riccio"),
 *   description = @Translation("Display the referenced entities in a Riccio view."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityReferenceRiccioFormatter extends EntityReferenceEntityFormatter {

  /**
   * Returns a form to configure settings for the formatter.
   *
   * Invoked from \Drupal\field_ui\Form\EntityDisplayFormBase to allow
   * administrators to configure the formatter. The field_ui module takes care
   * of handling submitted form values.
   *
   * @param array $form
   *   The form where the settings form is being included in.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form elements for the formatter settings.
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $form = parent::settingsForm($form, $form_state);

    $form['riccio_options'] = array(
      '#title' => $this->t('Riccio options'),
      '#type' => 'select',
      '#options' => Riccio::getConfigList(),
      '#default_value' => $this->getSetting('riccio_options'),
      '#required' => TRUE
    );

    return $form;
  }

  /**
   * Returns a short summary for the current formatter settings.
   *
   * If an empty result is returned, a UI can still be provided to display
   * a settings form in case the formatter has configurable settings.
   *
   * @return string[]
   *   A short summary of the formatter settings.
   */
  public function settingsSummary() {

    $options = $this->getSetting('riccio_options');

    if (empty($options)) {
      $options = $this->t('None');
    }

    $summary = parent::settingsSummary();
    $summary[] = $this->t('Riccio options: ' . $options);

    return $summary;
  }

  /**
   * Builds a renderable array for a fully themed field.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $items
   *   The field values to be rendered.
   * @param string $langcode
   *   (optional) The language that should be used to render the field. Defaults
   *   to the current content language.
   *
   * @return array
   *   A renderable array for a themed field with its label and all its values.
   */
  public function view(FieldItemListInterface $items, $langcode = NULL) {

    $elements = parent::view($items, $langcode);
    $config = $this->getSetting('riccio_options');

    $elements['#theme'] = 'riccio';
    // Add Riccio data attribute and attach library.
    $elements['#attributes']['data-riccio-options'] = $config;
    $elements['#attached']['library'][] = 'riccio/riccio';

    // If not set and config is not empty, add riccio options.
    if (!isset($elements['#attached']['drupalSettings']['riccio'][$config]) && !empty($config)) {
      /** @var Riccio $entity */
      $entity = Riccio::load($config);
      $elements['#attached']['drupalSettings']['riccio'][$config] = $entity->getFormattedOptions();

      // Set cacheability metadata.
      if (isset($elements['#cache']['tags'])) {
        $elements['#cache']['tags'] = array_merge($elements['#cache']['tags'], $entity->getCacheTagsToInvalidate());
      }
      else {
        $elements['#cache']['tags'] = $entity->getCacheTagsToInvalidate();
      }
    }

    return $elements;
  }

  /**
   * Defines the default settings for this plugin.
   *
   * @return array
   *   A list of default settings, keyed by the setting name.
   */
  public static function defaultSettings() {

    return array(
        'riccio_options' => 'default'
      ) + parent::defaultSettings();
  }
}