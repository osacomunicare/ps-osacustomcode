<?php
/**
 * Modulo: OSA Custom Code for PrestaShop
 * Sviluppato da: OsaComunicare | https://osacomunicare.it | 800911329
 * Compatibilità: PrestaShop 8.x - 9.x
 * Descrizione: Gestione avanzata di Meta Tags, CSS e JavaScript.
 */

if (!defined('_PS_VERSION_')) { exit; }

class OsaCustomCode extends Module
{
    public function __construct()
    {
        $this->name = 'osacustomcode';
        $this->tab = 'administration';
        $this->version = '1.1.0';
        $this->author = 'OsaComunicare';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('OSA Custom Code for PrestaShop');
        $this->description = $this->l('Inserimento professionale di CSS, Header Code e Body Scripts.');
        $this->ps_versions_compliancy = ['min' => '8.0.0', 'max' => '9.9.9'];
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayFooter') &&
            $this->registerHook('displayBackOfficeHeader');
    }

    public function uninstall()
    {
        $keys = ['OSA_CSS_GLOBAL', 'OSA_HDR_HTML', 'OSA_HDR_JS', 'OSA_BDY_HTML', 'OSA_BDY_JS'];
        foreach ($keys as $key) { Configuration::deleteByName($key); }
        return parent::uninstall();
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            return '<style>
                .osa-code-area { 
                    font-family: "Fira Code", "Courier New", monospace !important; 
                    background-color: #ffffff !important; 
                    color: #333333 !important; 
                    padding: 15px !important; 
                    border: 1px solid #ccc !important;
                    border-left: 6px solid #5F8C5E !important; 
                    min-height: 280px !important;
                    line-height: 1.5 !important;
                    margin-bottom: 10px;
                }
                .nav-tabs li a { font-weight: bold !important; color: #555 !important; text-transform: uppercase; }
                .nav-tabs li.active a { border-bottom: 3px solid #5F8C5E !important; color: #5F8C5E !important; }
                .panel-heading { background-color: #f9f9f9 !important; font-weight: bold !important; border-bottom: 1px solid #ddd !important; }
                .help-block { color: #666 !important; font-style: italic; }
            </style>';
        }
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submit' . $this->name)) {
            $keys = ['OSA_CSS_GLOBAL', 'OSA_HDR_HTML', 'OSA_HDR_JS', 'OSA_BDY_HTML', 'OSA_BDY_JS'];
            foreach ($keys as $key) {
                Configuration::updateValue($key, Tools::getValue($key), true);
            }
            $output .= $this->displayConfirmation($this->l('Configurazione salvata correttamente.'));
        }
        return $output . $this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = [];
        $tabs = [
            'css_tab'  => $this->l('CSS'),
            'hdr_tab'  => $this->l('HEADER'),
            'bdy_tab'  => $this->l('BODY'),
        ];

        // --- SCHEDA CSS ---
        $fields_form[0]['form'] = [
            'legend' => ['title' => $this->l('Personalizzazioni CSS'), 'icon' => 'icon-css3'],
            'input' => [
                [
                    'type' => 'textarea', 
                    'label' => $this->l('Direttive CSS Globali'), 
                    'name' => 'OSA_CSS_GLOBAL', 
                    'class' => 'osa-code-area', 
                    'tab' => 'css_tab', 
                    'desc' => $this->l('Inserisci il codice CSS senza tag <style>. Impatta su tutto il sito.')
                ],
            ],
            'submit' => ['title' => $this->l('Salva modifiche'), 'class' => 'btn btn-primary pull-right'],
            'tabs' => $tabs
        ];

        // --- SCHEDA HEADER ---
        $fields_form[1]['form'] = [
            'legend' => ['title' => $this->l('Iniezione codice nell\'Header'), 'icon' => 'icon-header'],
            'input' => [
                [
                    'type' => 'textarea', 
                    'label' => $this->l('Codice Personalizzato (HTML/Meta)'), 
                    'name' => 'OSA_HDR_HTML', 
                    'class' => 'osa-code-area', 
                    'tab' => 'hdr_tab'
                ],
                [
                    'type' => 'textarea', 
                    'label' => $this->l('Script Java (JavaScript)'), 
                    'name' => 'OSA_HDR_JS', 
                    'class' => 'osa-code-area', 
                    'tab' => 'hdr_tab', 
                    'desc' => $this->l('Inserire script completi di tag <script>.')
                ],
            ],
            'submit' => ['title' => $this->l('Salva modifiche'), 'class' => 'btn btn-primary pull-right'],
            'tabs' => $tabs
        ];

        // --- SCHEDA BODY ---
        $fields_form[2]['form'] = [
            'legend' => ['title' => $this->l('Iniezione codice nel Body'), 'icon' => 'icon-code'],
            'input' => [
                [
                    'type' => 'textarea', 
                    'label' => $this->l('Codice Personalizzato (HTML)'), 
                    'name' => 'OSA_BDY_HTML', 
                    'class' => 'osa-code-area', 
                    'tab' => 'bdy_tab'
                ],
                [
                    'type' => 'textarea', 
                    'label' => $this->l('Script Java (JavaScript)'), 
                    'name' => 'OSA_BDY_JS', 
                    'class' => 'osa-code-area', 
                    'tab' => 'bdy_tab', 
                    'desc' => $this->l('Ideale per pixel di tracciamento e script fine pagina.')
                ],
            ],
            'submit' => ['title' => $this->l('Salva modifiche'), 'class' => 'btn btn-primary pull-right'],
            'tabs' => $tabs
        ];

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->show_toolbar = false;
        
        $helper->fields_value = [
            'OSA_CSS_GLOBAL' => Configuration::get('OSA_CSS_GLOBAL'),
            'OSA_HDR_HTML'   => Configuration::get('OSA_HDR_HTML'),
            'OSA_HDR_JS'     => Configuration::get('OSA_HDR_JS'),
            'OSA_BDY_HTML'   => Configuration::get('OSA_BDY_HTML'),
            'OSA_BDY_JS'     => Configuration::get('OSA_BDY_JS'),
        ];

        return $helper->generateForm($fields_form);
    }

    public function hookDisplayHeader() {
        $html = Configuration::get('OSA_HDR_HTML') . Configuration::get('OSA_HDR_JS');
        $css  = Configuration::get('OSA_CSS_GLOBAL');
        if (!empty($css)) { $html .= '<style>' . $css . '</style>'; }
        return $html;
    }

    public function hookDisplayFooter() {
        return Configuration::get('OSA_BDY_HTML') . Configuration::get('OSA_BDY_JS');
    }
}
