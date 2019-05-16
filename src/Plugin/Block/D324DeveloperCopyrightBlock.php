<?php
/**
 * @file
 * Contains \Drupal\d324_copyright_block\Plugin\Block\D324DeveloperCopyrightBlock.
 */

namespace Drupal\d324_copyright_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
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

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $config = [
      'label_display' => FALSE,
      'd324_copyright_block_developer_name' => 'T324',
      'd324_copyright_block_developer_url' => 'https://www.t324.com',
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

    $form['d324_copyright_block_developer_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Developer Name'),
      '#description' => $this->t('The name of the developer to display in the copyright block.'),
      '#default_value' => $config['d324_copyright_block_developer_name'],
    ];

    $form['d324_copyright_block_developer_url'] = [
      '#type' => 'url',
      '#title' => $this->t('Developer URL'),
      '#description' => $this->t('The URL of the developer website'),
      '#default_value' => $config['d324_copyright_block_developer_url'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $developername = $config['d324_copyright_block_developer_name'];
    $developerurl = $config['d324_copyright_block_developer_url'];
    $year = date('Y');
    $copyrighttext = $this->t('Tech and Design © 2003-@year ', array('@year' => $year));
    $developerurl = Url::fromUri($developerurl);
    $t324_link = Link::fromTextAndUrl($developername, $developerurl);
    $t324_link = $t324_link->toRenderable();
    $t324_link['#attributes'] = array(
      'title' => 'T324 : Web Sites - Hosting - Marketing - Technology',
      'class' => ['no-ext'],
    );
    $copyrighttext .= render($t324_link);
    return array(
      '#type' => 'markup',
      '#markup' => $copyrighttext,
    );
  }
}
