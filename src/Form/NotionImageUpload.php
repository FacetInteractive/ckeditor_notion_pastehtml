<?php

namespace Drupal\ckeditor_notion_pastehtml\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NotionImageUpload extends FormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * NotionImageUpload constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity manager service.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'notion_image_upload_form';
  }

  /**
   * Form to upload images from notion export.
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['notion_images_upload'] = [
      '#type' => 'managed_file',
      '#required' => TRUE,
      '#title' => $this->t('Upload Image'),
      '#description' => $this->t('Upload the images which are part of the notion HTML export.'),
      '#upload_location' => 'public://notion/',
      '#multiple' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * Submit handler to permanently save the uploaded image files.
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $files = $form_state->getValue('notion_images_upload');
    if (empty($files)) {
      $this->messenger()->addMessage($this->t('No files to upload'));
      return;
    }
    foreach ($files as $fid) {
      // Load the object of the file by it's fid.
      $file = $this->entityTypeManager->getStorage('file')->load($fid);
      // Set the status flag permanent of the file object.
      $file->setPermanent();
      // Save the file in database.
      $file->save();
    }
    $this->messenger()->addMessage($this->t('Files uploaded successfully'));
  }

}
