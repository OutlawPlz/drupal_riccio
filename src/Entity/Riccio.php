<?php
/**
 * @file
 * Contains \Drupal\riccio\Entity\Riccio
 */

namespace Drupal\riccio\Entity;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\Annotation\ConfigEntityType;

/**
 * Defines the Riccio configuration entity.
 *
 * @ConfigEntityType(
 *   id = "riccio",
 *   label = @Translation("Riccio configuration"),
 *   handlers = {
 *     "list_builder" = "Drupal\riccio\RiccioListBuilder",
 *     "form" = {
 *       "add" = "Drupal\riccio\Form\RiccioForm",
 *       "edit" = "Drupal\riccio\Form\RiccioForm",
 *       "delete" = "Drupal\riccio\Form\RiccioDeleteForm"
 *     }
 *   },
 *   config_prefix = "riccio",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/user-interface/riccio/{riccio}",
 *     "add-form" = "/admin/config/user-interface/riccio/add",
 *     "edit-form" = "/admin/config/user-interface/riccio/{riccio}/edit",
 *     "delete-form" = "/admin/config/user-interface/riccio/{riccio}/delete",
 *     "collection" = "/admin/config/user-interface/riccio"
 *   }
 * )
 */
class Riccio extends ConfigEntityBase implements RiccioInterface {

  /**
   * The machine name of this Riccio configuration.
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of this Riccio configuration.
   * @var string
   */
  protected $label;

  /**
   * An array of Riccio options.
   * @var array
   */
  protected $options;

  /**
   * Gets the options as saved in database.
   *
   * @return array
   *   The options array as saved in database.
   */
  public function getOptions() {

    return $this->options;
  }

  /**
   * Gets the options formatted as Riccio options.
   *
   * @return array
   *   The options array ready to use as Riccio options.
   */
  public function getFormattedOptions() {

    $options = $this->options;

    // If perRow is empty, set it to true.
    $options['perRow'] = isset($options['perRow']) ? $options['perRow'] : TRUE;
    // If mediaQueries is empty, set it to true,
    $options['mediaQueries'] = $options['mediaQueries'] ? $options['mediaQueries'] : TRUE;

    return $options;
  }

  /**
   * Gets the configuration list.
   *
   * @return array
   *   An array of Riccio config entities. The config ID is the key and the
   *   config label the value.
   */
  public static function getConfigList() {

    $entities = Riccio::loadMultiple();
    $config_list = array();

    /** @var RiccioInterface $entity */
    foreach ($entities as $entity) {
      $config_list[$entity->get('id')] = $entity->get('label');
    }

    return $config_list;
  }
}
