<?php

namespace Drupal\ckeditor_notion_pastehtml\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "ckeditornotionpastehtml" plugin.
 *
 * @CKEditorPlugin(
 *   id = "pastefromnotion",
 *   label = @Translation("CKEditor Notion Paste HTML"),
 *   module = "ckeditor_notion_pastehtml"
 * )
 */
class NotionPasteHtml extends CKEditorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'ckeditor_notion_pastehtml') . '/js/plugins/pastefromnotion/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    $path = drupal_get_path('module', 'ckeditor_notion_pastehtml') . '/js/plugins/pastefromnotion';
    return [
      'PasteFromNotion' => [
        'label' => $this->t('Paste From Notion'),
        'image' => $path . '/icons/notion.png',
      ],
    ];
  }

}
