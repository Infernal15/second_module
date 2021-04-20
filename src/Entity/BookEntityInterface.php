<?php

namespace Drupal\abyss\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Book entity entities.
 *
 * @ingroup abyss
 */
interface BookEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Book entity name.
   *
   * @return string
   *   Name of the Book entity.
   */
  public function getName();

  /**
   * Sets the Book entity name.
   *
   * @param string $name
   *   The Book entity name.
   *
   * @return \Drupal\abyss\Entity\BookEntityInterface
   *   The called Book entity entity.
   */
  public function setName($name);

  /**
   * Gets the Book entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Book entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Book entity creation timestamp.
   *
   * @param int $timestamp
   *   The Book entity creation timestamp.
   *
   * @return \Drupal\abyss\Entity\BookEntityInterface
   *   The called Book entity entity.
   */
  public function setCreatedTime($timestamp);

}
