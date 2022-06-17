<?php

namespace Drupal\bonnie\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Bonnie entities.
 *
 * @ingroup bonnie
 */
interface BonnieInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Bonnie name.
   *
   * @return string
   *   Name of the Bonnie.
   */
  public function getName();

  /**
   * Sets the Bonnie name.
   *
   * @param string $name
   *   The Bonnie name.
   *
   * @return \Drupal\bonnie\Entity\BonnieInterface
   *   The called Bonnie entity.
   */
  public function setName($name);

  /**
   * Gets the Bonnie creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Bonnie.
   */
  public function getCreatedTime();

  /**
   * Sets the Bonnie creation timestamp.
   *
   * @param int $timestamp
   *   The Bonnie creation timestamp.
   *
   * @return \Drupal\bonnie\Entity\BonnieInterface
   *   The called Bonnie entity.
   */
  public function setCreatedTime($timestamp);
}
