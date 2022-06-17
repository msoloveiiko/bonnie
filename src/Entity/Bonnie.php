<?php

namespace Drupal\bonnie\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Bonnie entity.
 *
 * @ingroup bonnie
 *
 * @ContentEntityType(
 *   id = "bonnie",
 *   label = @Translation("Bonnie"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\bonnie\BonnieListBuilder",
 *     "views_data" = "Drupal\bonnie\Entity\BonnieViewsData",
 *     "translation" = "Drupal\bonnie\BonnieTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\bonnie\Form\BonnieForm",
 *       "add" = "Drupal\bonnie\Form\BonnieForm",
 *       "edit" = "Drupal\bonnie\Form\BonnieForm",
 *       "delete" = "Drupal\bonnie\Form\BonnieDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\bonnie\BonnieHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\bonnie\BonnieAccessControlHandler",
 *   },
 *   base_table = "bonnie",
 *   data_table = "bonnie_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer bonnie entities",
 *
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/bonnie/{bonnie}",
 *     "add-form" = "/admin/structure/bonnie/add",
 *     "edit-form" = "/admin/structure/bonnie/{bonnie}/edit",
 *     "delete-form" = "/admin/structure/bonnie/{bonnie}/delete",
 *     "collection" = "/admin/structure/bonnie",
 *   },
 *   field_ui_base_route = "bonnie.settings"
 * )
 */
class Bonnie extends ContentEntityBase implements BonnieInterface {

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

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Advertiser entity.'))
      ->setReadOnly(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'integer',
        'weight' => -6,
      ]);
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('From 2 to 100 letters'))
      ->setSettings([
        'max_length' => 100,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['email'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Email'))
      ->setDescription(t('user-_@company.'))
      ->setSettings([
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'email',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'email',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['mobile_number'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Mobile <br> number'))
      ->setDescription(t('xxxnnnnnnn'))
      ->setSettings([
        'max_length' => 10,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['message'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Message'))
      ->setSettings([
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_long',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_long',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['avatar'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Avatar'))
      ->setDescription(t('Allowed photo format png, jpg, jpeg. No more than 2MB'))
      ->setSettings([
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => '2097152',
        'alt_field' => 0,
        'alt_field_required' => FALSE,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['picture'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Picture'))
      ->setDescription(t('Allowed photo format png, jpg, jpeg. No more than 5MB'))
      ->setSettings([
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => '5242880',
        'alt_field' => 0,
        'alt_field_required' => FALSE,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'))
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'timestamp',
        'weight' => -6,
        'settings' => [
          'date_format' => 'custom',
          'custom_date_format' => 'M/d/Y H:i:s',
        ],
      ]);
    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
