<?php

namespace Drupal\abyss\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Book entity entity.
 *
 * @ingroup abyss
 *
 * @ContentEntityType(
 *   id = "book_entity",
 *   label = @Translation("Book entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\abyss\BookEntityListBuilder",
 *     "views_data" = "Drupal\abyss\Entity\BookEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\abyss\Form\BookEntityForm",
 *       "add" = "Drupal\abyss\Form\BookEntityForm",
 *       "edit" = "Drupal\abyss\Form\BookEntityForm",
 *       "delete" = "Drupal\abyss\Form\BookEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\abyss\BookEntityHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\abyss\BookEntityAccessControlHandler",
 *   },
 *   base_table = "book_entity",
 *   translatable = FALSE,
 *   admin_permission = "administer book entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/book_entity/{book_entity}",
 *     "add-form" = "/book_entity/add",
 *     "edit-form" = "/book_entity/{book_entity}/edit",
 *     "delete-form" = "/book_entity/{book_entity}/delete",
 *     "collection" = "/book_entity",
 *   },
 *   field_ui_base_route = "book_entity.settings"
 * )
 */
class BookEntity extends ContentEntityBase implements BookEntityInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    //User name
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Abyss entity.'))
      ->setSettings([
        'max_length' => 100,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);


    //User email
    $fields['email'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Email'))
      ->setDescription(t('The email of the Abyss entity.'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'email',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);


    //User phone
    $fields['phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Phone'))
      ->setDescription(t('The phone of the Abyss entity.'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'phone',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'phone',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);


    // Response text
    $fields['response'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Response'))
      ->setDescription(t('The response of the Abyss entity.'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string_long',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_long',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);


    // Response image
    $fields['response_image'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Response image'))
      ->setDescription(t('The response image of the Abyss entity.'))
      ->setDefaultValue('')
      ->setSettings([
        'validate_is_image' => [],
        'file_extensions' => 'jpeg jpg png',
        'file_size' => '2097152',
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'image',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(FALSE);


    // User avatar image
    $fields['avatar'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Avatar image'))
      ->setDescription(t('The avatar image of the Abyss entity.'))
      ->setDefaultValue('')
      ->setSettings([
        'validate_is_image' => [],
        'file_extensions' => 'jpeg jpg png',
        'file_size' => '5242880',
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'image',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(FALSE);


    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
