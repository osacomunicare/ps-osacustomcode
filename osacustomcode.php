<?php
/**
 * Modulo: OSA Custom Code for PrestaShop
 * Sviluppato da: OsaComunicare | https://osacomunicare.it | 800911329
 * Compatibilità: PrestaShop 8.x - 9.x
 * Descrizione: Gestione avanzata di Meta Tags, CSS e JavaScript.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class OsaCustomCode extends Module
{
    public function __construct()
    {
        $this->name = 'osacustomcode';
        $this->tab = 'administration';
        $this->version = '3.1.0';
        $this->author = 'DiaEvent';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('OSA Custom Code for PrestaShop');
        $this->description = $this->l('Inserimento professionale di Meta Tags, CSS e JavaScript in Head e Footer.');
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
        $keys = [
            'OSA_META_TAGS', 'OSA_CUSTOM_CSS', 'OSA_JS_HEAD', 
            'OSA_JS_FOOTER', 'OSA_HTML_FOOTER'
        ];
        foreach ($keys as $key) {
            Configuration::deleteByName($key);
        }
        return parent::uninstall();
    }

    /**
     * Stile dell'interfaccia di amministrazione (Dark Mode Editor)
     */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            return '<style>
                .osa-code-area { 
                    font-family: "Fira Code", "Courier New", monospace !important; 
                    background-color: #1e1e1e !important; 
                    color: #d4d4d4 !important; 
                    padding: 15px !important; 
                    border-left: 5px solid #ff9800 !important;
                    min-height: 280px !important;
                    font-size: 13px !important;
                    line-height: 1.6 !important;
                }
                .panel-heading { font-size: 16px !important; font-weight: bold !important; color: #333; }
                .help-block { font-style: italic; color: #666; }
            </style>';
        }
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submit' . $this->name)) {
            Configuration::updateValue('OSA_META_TAGS', Tools::getValue('OSA_META_TAGS'), true);
            Configuration::updateValue('OSA_CUSTOM_CSS', Tools::getValue('OSA_CUSTOM_CSS'), true);
            Configuration::updateValue('OSA_JS_HEAD', Tools::getValue('OSA_JS_HEAD'), true);
            Configuration::updateValue('OSA_JS_FOOTER', Tools::getValue('OSA_JS_FOOTER'), true);
            Configuration::updateValue('OSA_HTML_FOOTER', Tools::getValue('OSA_HTML_FOOTER'), true);
            $output .= $this->displayConfirmation($this->l('Configurazione OSA aggiornata con successo!'));
        }
        return $output . $this->renderForm();
    }

    public function renderForm()
    {
        $fields_form_head = [
            'form' => [
                'legend' => ['title' => $this->l('TASK 1: Configurazione HEADER (<head>)'), 'icon' => 'icon-terminal'],
                'input' => [
                    [
                        'type' => 'textarea',
                        'label' => $this->l('HTML / Meta Tags in <head>'),
                        'name' => 'OSA_META_TAGS',
                        'class' => 'osa-code-area',
                        'desc' => $this->l('Inserisci qui Tag di verifica, Dati Strutturati JSON-LD o Meta personalizzati.'),
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('Custom CSS in <head>'),
                        'name' => 'OSA_CUSTOM_CSS',
                        'class' => 'osa-code-area',
                        'desc' => $this->l('Inserisci solo il codice CSS (i tag <style> verranno aggiunti automaticamente).'),
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('JavaScript in <head>'),
                        'name' => 'OSA_JS_HEAD',
                        'class' => 'osa-code-area',
                        'desc' => $this->l('Script JS da caricare nell\'header (includi i tag <script>).'),
                    ],
                ],
                'submit' => ['title' => $this->l('Salva Task 1'), 'class' => 'btn btn-primary pull-right']
            ],
        ];

        $fields_form_footer = [
            'form' => [
                'legend' => ['title' => $this->l('TASK 2: Configurazione FOOTER (Prima di </body>)'), 'icon' => 'icon-code'],
                'input' => [
                    [
                        'type' => 'textarea',
                        'label' => $this->l('JavaScript before </body>'),
                        'name' => 'OSA_JS_FOOTER',
                        'class' => 'osa-code-area',
                        'desc' => $this->l('Script di tracking (Analytics, Pixel, ecc.). Includi <script>.'),
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('HTML before </body>'),
                        'name' => 'OSA_HTML_FOOTER',
                        'class' => 'osa-code-area',
                        'desc' => $this->l('Codice HTML per widget, chat o banner di terze parti.'),
                    ],
                ],
                'submit' => ['title' => $this->l('Salva Task 2'), 'class' => 'btn btn-primary pull-right']
            ],
        ];

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        
        $helper->fields_value = [
            'OSA_META_TAGS' => Configuration::get('OSA_META_TAGS'),
            'OSA_CUSTOM_CSS' => Configuration::get('OSA_CUSTOM_CSS'),
            'OSA_JS_HEAD' => Configuration::get('OSA_JS_HEAD'),
            'OSA_JS_FOOTER' => Configuration::get('OSA_JS_FOOTER'),
            'OSA_HTML_FOOTER' => Configuration::get('OSA_HTML_FOOTER'),
        ];

        return $helper->generateForm([$fields_form_head, $fields_form_footer]);
    }

    /**
     * Esecuzione Hook Header: Richiama i dati dal database e li inietta nel front-end
     */
    public function hookDisplayHeader()
    {
        $meta = Configuration::get('OSA_META_TAGS');
        $css  = Configuration::get('OSA_CUSTOM_CSS');
        $js   = Configuration::get('OSA_JS_HEAD');
        
        $output = $meta . $js;
        if (!empty($css)) {
            $output .= '<style>' . $css . '</style>';
        }
        return $output;
    }

    /**
     * Esecuzione Hook Footer: Inserisce i dati prima della chiusura del tag body
     */
    public function hookDisplayFooter()
    {
        return Configuration::get('OSA_JS_FOOTER') . Configuration::get('OSA_HTML_FOOTER');
    }
}
