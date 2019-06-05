<?php
/**
 * @file
 * Contains \Drupal\d324_copyright_block\Plugin\Block\D324DeveloperCopyrightBlock.
 */

namespace Drupal\d324_copyright_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'copyright' block for the developer for use in the footer
 *
 * @Block(
 *   id = "d324_developer_copyright_block",
 *   admin_label = @Translation("D324 Developer Copyright block"),
 *   category = @Translation("D324 developer copyright block for footer")
 * )
 */
class D324DeveloperCopyrightBlock extends BlockBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $config = [
      'label_display' => FALSE,
      'd324_copyright_block_developer_url' => 'https://www.t324.com',
      'd324_copyright_block_developer_link_title' => 'T324 - Website Development & Marketing',
    ];
    return $config;
  }

  /**
   * {@inheritdoc}
   *
   * Creates a generic configuration form for all block types. Individual
   * block plugins can add elements to this form by overriding
   * BlockBase::blockForm(). Most block plugins should not override this
   * method unless they need to alter the generic form elements.
   *
   * @see \Drupal\Core\Block\BlockBase::blockForm()
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['label']['#type'] = 'hidden';
    $form['label_display']['#type'] = 'hidden';

    $form['d324_copyright_block_developer_url'] = [
      '#type' => 'url',
      '#title' => $this->t('Developer URL'),
      '#description' => $this->t('The URL of the developer website'),
      '#default_value' => $config['d324_copyright_block_developer_url'],
    ];

    $form['d324_copyright_block_developer_link_title'] = [
      '#type' => 'url',
      '#title' => $this->t('Developer Link Title Text'),
      '#description' => $this->t('The title attribute of the developer website link'),
      '#default_value' => $config['d324_copyright_block_developer_link_title'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $developerlinktitle = $config['d324_copyright_block_developer_link_title'];
    $developerurl = Url::fromUri($config['d324_copyright_block_developer_url']);
    $copyrighttext = $this->t('Tech and Design © 2003-@year ', array('@year' => date('Y')));
    $developer_logo = [
      '#theme' => 'd324_copyright_logo',
      '#file' => drupal_get_path('module', 'd324_copyright_block') . '/assets/svg/logo.svg'
    ];
    $rendered_logo = \Drupal::service('renderer')->render($developer_logo);
    $developer_link = [
      '#type' => 'link',
      '#title' => [
        '#markup' => Markup::create($rendered_logo),
      ],
      '#url' => $developerurl,
      '#attributes' => [
        'title' => $developerlinktitle,
        'class' => ['no-ext', 'd324-copyright-block__developer-link'],
        'target' => '_blank',
      ],
    ];
    $rendered_link = \Drupal::service('renderer')->render($developer_link);
    $copyrighttext .= $rendered_link;
    return array(
      '#type' => 'markup',
      '#markup' => Markup::create($copyrighttext),
      '#attached' => [
        'library' => 'd324_copyright_block/style',
      ],
    );
  }
}
