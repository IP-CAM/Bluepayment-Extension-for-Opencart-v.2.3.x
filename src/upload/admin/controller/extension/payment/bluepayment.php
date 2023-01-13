<?php

require_once DIR_SYSTEM . '/library/bluemedia-sdk-php/index.php';

use Psr\Log\LogLevel;

class ControllerExtensionPaymentBluepayment extends Controller
{
    const STATUS_PENDING = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_FAILED = 10;

    private $ext_path;
    private $inputs = [
        'bluepayment_status',
        'bluepayment_test_mode',
        'bluepayment_status_pending',
        'bluepayment_status_success',
        'bluepayment_status_failed',
    ];

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->load->library('bluepayment/Helper/Logger');
        $this->load->library('bluepayment/Dictionary/BluepaymentDictionary');

        $this->ext_path = $this->BluepaymentDictionary->getExtensionPath();
    }

    public function index()
    {
        $this->load->model('localisation/currency');
        $this->load->model('setting/setting');
        $this->load->language($this->ext_path);
        $this->load->model('localisation/order_status');
        $this->load->model('extension/payment/bluepayment');
        $this->load->library('bluepayment/Validator/AdminFormValidator');

        $this->model_extension_payment_bluepayment->checkUpdate();

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addScript('view/javascript/bluepayment/bluepayment.js');
        $this->document->addStyle('view/css/bluepayment/bluepayment.css');

        if ($this->request->server['REQUEST_METHOD'] === 'POST') {
            $this->request->post['bluepayment_currency'] = $this->prepareCurrenciesData(
                $this->request->post['bluepayment_currency']
            );

            $data = $this->AdminFormValidator->validate();

            if (empty($data)) {
                $this->model_setting_setting->editSetting('bluepayment', $this->request->post);

                $this->session->data['message_success'] = $this->language->get('text_success');
                $this->Logger->log(
                    LogLevel::INFO,
                    '[BM Bluepayment] Module settings updated with data',
                    [
                        'POST' => json_encode($this->request->post)
                    ]
                );

                $this->response->redirect(
                    $this->url->link($this->ext_path, 'token=' . $this->session->data['token'], true)
                );
            }
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['download'] = $this->url->link(
            $this->ext_path . '/downloadLog', 'token=' . $this->session->data['token'], true
        );

        if (isset($this->session->data['message_warning'])) {
            $data['message_warning'] = $this->session->data['message_warning'];

            unset($this->session->data['message_warning']);
        }

        if (isset($this->session->data['message_success'])) {
            $data['message_success'] = $this->session->data['message_success'];

            unset($this->session->data['message_success']);
        }

        $data += $this->Logger->getRecentLog();
        $data += $this->generateBreadcrumbs();
        $data += $this->fillFormFields();
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $data['currencies'] = $this->model_localisation_currency->getCurrencies();
        $data['log_files'] = $this->Logger->getFormattedFileList();
        $data['refresh_log_uri'] = $this->url->link(
            $this->ext_path  . '/refreshLog', 'token=' . $this->session->data['token'], true
        );
        $data['url_action'] = $this->url->link('extension/payment/bluepayment', 'token=' . $this->session->data['token'], true);

        $data = $this->loadLanguageData($data);

        $this->response->setOutput($this->load->view($this->ext_path, $data));
    }

    public function install()
    {
        $this->load->model('extension/payment/bluepayment');
        $this->model_extension_payment_bluepayment->install();
    }

    public function uninstall()
    {
        $this->load->model('extension/payment/bluepayment');
        $this->model_extension_payment_bluepayment->uninstall();
    }

    public function refreshLog()
    {
        $this->Logger->refreshLog();
    }

    public function downloadLog()
    {
        $this->Logger->download();
    }

    private function prepareCurrenciesData($currencies)
    {
        return array_filter($currencies, function ($currency) {
            return empty($currency['service_id']) === false || empty($currency['shared_key']) === false;
        });
    }

    private function generateBreadcrumbs()
    {
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        ];
        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        ];

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link($this->ext_path, 'token=' . $this->session->data['token'], true)
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link($this->ext_path, 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
            ];
        }

        return $data;
    }

    private function fillFormFields()
    {
        $data = [];

        foreach ($this->inputs as $input) {
            if (isset($this->request->post[$input])) {
                $data[$input] = $this->request->post[$input];
            } else {
                $data[$input] = $this->config->get($input);
            }
        }

        if (isset($this->request->post['bluepayment_currency'])) {
            $currency_settings = $this->request->post['bluepayment_currency'];
        } else {
            $currency_settings = $this->config->get('bluepayment_currency');
        }

        if (!empty($currency_settings)) {
            foreach ($currency_settings as $currency_code => $currency_setting) {
                $data['bluepayment_currency_' . $currency_code . '_service_id'] = $currency_setting['service_id'];
                $data['bluepayment_currency_' . $currency_code . '_shared_key'] = $currency_setting['shared_key'];
            }
        }

        return $data;
    }

    private function loadLanguageData($data)
    {
        // Load language
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['cancel'] = $this->language->get('cancel');

        $data['info_log_loading'] = $this->language->get('info_log_loading');
        $data['heading_title'] = $this->language->get('heading_title');
        $data['prepare_regulations'] = $this->language->get('prepare_regulations');
        $data['fee'] = $this->language->get('fee');
        $data['introduction_title'] = $this->language->get('introduction_title');
        $data['introduction_first_step'] = $this->language->get('introduction_first_step');
        $data['introduction_register'] = $this->language->get('introduction_register');
        $data['introduction_second_step'] = $this->language->get('introduction_second_step');
        $data['introduction_third_step'] = $this->language->get('introduction_third_step');
        $data['introduction_learn'] = $this->language->get('introduction_learn');
        $data['introduction_learn2'] = $this->language->get('introduction_learn2');
        $data['tab_settings'] = $this->language->get('tab_settings');
        $data['tab_logs'] = $this->language->get('tab_logs');
        $data['download_module_logs'] = $this->language->get('download_module_logs');
        $data['text_success'] = $this->language->get('text_success');
        $data['text_module_edit'] = $this->language->get('text_module_edit');
        $data['currency_settings'] = $this->language->get('currency_settings');
        $data['info_log_loading'] = $this->language->get('info_log_loading');
        $data['log_file_download_error'] = $this->language->get('log_file_download_error');
        $data['error_empty_status'] = $this->language->get('error_empty_status');
        $data['at_least_one_currency_settings_required'] = $this->language->get('at_least_one_currency_settings_required');
        $data['currency_settings_both_values_required'] = $this->language->get('currency_settings_both_values_required');
        $data['currency_settings_service_id_integer_required'] = $this->language->get('currency_settings_service_id_integer_required');
        $data['error_empty_field'] = $this->language->get('error_empty_field');
        $data['error_integer_field'] = $this->language->get('error_integer_field');
        $data['payment_status_not_defined'] = $this->language->get('payment_status_not_defined');
        $data['enabled_label'] = $this->language->get('enabled_label');
        $data['test_mode'] = $this->language->get('test_mode');
        $data['pending_status'] = $this->language->get('pending_status');
        $data['success_status'] = $this->language->get('success_status');
        $data['failed_status'] = $this->language->get('failed_status');
        $data['service_id'] = $this->language->get('service_id');
        $data['shared_key'] = $this->language->get('shared_key');
        $data['select_log_file'] = $this->language->get('select_log_file');
        $data['helper_test_mode'] = $this->language->get('helper_test_mode');
        $data['helper_test_mode_alert_1'] = $this->language->get('helper_test_mode_alert_1');
        $data['helper_test_mode_alert_2'] = $this->language->get('helper_test_mode_alert_2');
        $data['helper_test_mode_alert_3'] = $this->language->get('helper_test_mode_alert_3');

        return $data;
    }
}
