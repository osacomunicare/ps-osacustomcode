<?php
/**
 * Modulo: OSA Custom Code
 * Sviluppato da: OsaComunicare | https://osacomunicare.it
 * Versione: 1.1.0 (DiaEvent Definitive)
 * 2023-2026 OsaComunicare
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    OsaComunicare <info@osacomunicare.it>
 * @copyright 2023-2026 OsaComunicare
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @link      https://osacomunicare.it
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class OsaCustomCode extends Module
{
    protected $storage_path;

    public function __construct()
    {
        $this->name = 'osacustomcode';
        $this->tab = 'administration';
        $this->version = '1.1.0';
        $this->author = 'OsaComunicare';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('OSA Custom Code');
        $this->description = $this->l('Inserimento professionale di CSS, Meta Tag e JavaScript con salvataggio su File System.');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->storage_path = _PS_MODULE_DIR_ . $this->name . '/code/';
    }

    public function install()
    {
        if (!file_exists($this->storage_path)) {
            mkdir($this->storage_path, 0755, true);
        }

        if (!file_exists($this->storage_path . 'index.php')) {
            file_put_contents($this->storage_path . 'index.php', '<?php header("Location: ../"); exit;');
        }

        return parent::install() && 
            $this->registerHook('displayHeader') && 
            $this->registerHook('displayFooter') && 
            $this->registerHook('displayBackOfficeHeader');
    }

    private function getCodeFile($key)
    {
        $file = $this->storage_path . $key . '.txt';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    private function saveCodeFile($key, $content)
    {
        if (!file_exists($this->storage_path)) {
            mkdir($this->storage_path, 0755, true);
        }
        $clean_content = stripslashes($content);
        return file_put_contents($this->storage_path . $key . '.txt', $clean_content);
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            return '<style>
                /* Identità Visiva OSA */
                .panel { border-top: 5px solid #5F8C5E !important; }
                .panel-heading { color: #5F8C5E !important; text-transform: uppercase !important; font-weight: bold !important; }
                .btn-default.pull-right { background-color: #5F8C5E !important; border-color: #5F8C5E !important; color: white !important; text-shadow: none !important; }
                .btn-default.pull-right:hover { background-color: #4a6d49 !important; }
                
                /* Area Codice */
                .osa-code-area { 
                    font-family: "Courier New", Courier, monospace !important; 
                    background-color: #f1f2f6 !important; 
                    border-left: 5px solid #5F8C5E !important;
                    min-height: 180px !important;
                    font-size: 13px !important;
                    color: #2c3e50 !important;
                }
                .help-block { font-style: italic; color: #666 !important; }
            </style>';
        }
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submitOsaSave')) {
            $this->saveCodeFile('css_global', $_POST['OSA_CSS_G']);
            $this->saveCodeFile('head_html', $_POST['OSA_H_HT']);
            $this->saveCodeFile('head_js', $_POST['OSA_H_JS']);
            $this->saveCodeFile('body_html', $_POST['OSA_B_HT']);
            $this->saveCodeFile('body_js', $_POST['OSA_B_JS']);
            
            $output .= $this->displayConfirmation($this->l('Impostazioni OSA salvate con successo.'));
        }

        return $output . $this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = array();

        // SEZIONE CSS
        $fields_form[0]['form'] = array(
            'legend' => array('title' => $this->l('Personalizzazione CSS'), 'icon' => 'icon-paint-brush'),
            'input' => array(
                array(
                    'type' => 'textarea',
                    'label' => $this->l('CSS GLOBALE'),
                    'name' => 'OSA_CSS_G',
                    'class' => 'osa-code-area',
                    'desc' => $this->l('Inserisci il CSS (senza tag <style>).')
                ),
            ),
            'submit' => array('title' => $this->l('Salva tutto'), 'class' => 'btn btn-default pull-right')
        );

        // SEZIONE HEADER
        $fields_form[1]['form'] = array(
            'legend' => array('title' => $this->l('Iniezione Header'), 'icon' => 'icon-arrow-up'),
            'input' => array(
                array(
                    'type' => 'textarea',
                    'label' => $this->l('META TAGS / HTML'),
                    'name' => 'OSA_H_HT',
                    'class' => 'osa-code-area',
                    'desc' => $this->l('Tag <meta>, link o HTML da inserire nel <head>.')
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('JAVASCRIPT HEADER'),
                    'name' => 'OSA_H_JS',
                    'class' => 'osa-code-area',
                    'desc' => $this->l('Includi i tag <script>.')
                ),
            ),
            'submit' => array('title' => $this->l('Salva tutto'), 'class' => 'btn btn-default pull-right')
        );

        // SEZIONE BODY
        $fields_form[2]['form'] = array(
            'legend' => array('title' => $this->l('Iniezione Body / Footer'), 'icon' => 'icon-code'),
            'input' => array(
                array(
                    'type' => 'textarea',
                    'label' => $this->l('HTML BODY'),
                    'name' => 'OSA_B_HT',
                    'class' => 'osa-code-area',
                    'desc' => $this->l('Codice HTML da inserire a fine pagina.')
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('JAVASCRIPT BODY'),
                    'name' => 'OSA_B_JS',
                    'class' => 'osa-code-area',
                    'desc' => $this->l('Includi i tag <script>.')
                ),
            ),
            'submit' => array('title' => $this->l('Salva tutto'), 'class' => 'btn btn-default pull-right')
        );

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->submit_action = 'submitOsaSave';
        
        $helper->fields_value = array(
            'OSA_CSS_G' => $this->getCodeFile('css_global'),
            'OSA_H_HT'  => $this->getCodeFile('head_html'),
            'OSA_H_JS'  => $this->getCodeFile('head_js'),
            'OSA_B_HT'  => $this->getCodeFile('body_html'),
            'OSA_B_JS'  => $this->getCodeFile('body_js'),
        );

        return $helper->generateForm($fields_form);
    }

    public function hookDisplayHeader()
    {
        $css = $this->getCodeFile('css_global');
        $html_head = $this->getCodeFile('head_html');
        $js_head = $this->getCodeFile('head_js');

        $output = $html_head . $js_head;
        if (!empty($css)) {
            $output .= "\n" . '<style type="text/css">' . "\n" . $css . "\n" . '</style>' . "\n";
        }

        return $output;
    }

    public function hookDisplayFooter()
    {
        return $this->getCodeFile('body_html') . $this->getCodeFile('body_js');
    }
}
