<?php
/**
 * @file
 * Contains \Drupal\riccio\RiccioInterface
 */

namespace Drupal\riccio\Entity;


use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining a Riccio configuration entity.
 * @package Drupal\riccio\Entity
 */
interface RiccioInterface extends ConfigEntityInterface {

  /**
   * Gets the options as saved in database.
   *
   * @return array
   *   The options array as saved in database.
   */
  public function getOptions();

  /**
   * Gets the options formatted as Riccio options.
   *
   * @return array
   *   The options array ready to use as Riccio options.
   */
  public function getFormattedOptions();

  /**
   * Gets the configuration list.
   *
   * @return array
   *   An array of Riccio config entities. The config ID is the key and the
   *   config label the value.
   */
  public static function getConfigList();
}