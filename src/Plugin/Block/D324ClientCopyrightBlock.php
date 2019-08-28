<?php
/**
 * @file
 * Contains \Drupal\d324_copyright_block\Plugin\Block\D324ClientCopyrightBlock.
 */

namespace Drupal\d324_copyright_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'copyright' block for the client for use in the footer.
 *
 * @Block(
 *   id = "d324_client_copyright_block",
 *   admin_label = @Translation("D324 Client Copyright block"),
 *   category = @Translation("D324 Blocks")
 * )
 */
class D324ClientCopyrightBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $config = [
      'label_display' => FALSE,
      'd324_copyright_block_client_name' => 'Client Company, Inc.',
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
    $form['label_display']['#default_value'] = 0;
    $form['label_display']['#type'] = 'hidden';

    $form['d324_copyright_block_client_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Client Name'),
      '#description' => $this->t('The name of the client to display in the copyright block.'),
      '#default_value' => $config['d324_copyright_block_client_name'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['d324_copyright_block_client_name'] = $form_state->getValue('d324_copyright_block_client_name');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $clientname = $config['d324_copyright_block_client_name'];
    $year = date('Y');
    $copyrighttext = $this->t('Content © @year @clientname', array('@year' => $year, '@clientname' => $clientname));
    return array(
      '#type' => 'markup',
      '#markup' => $copyrighttext,
    );
  }
}
