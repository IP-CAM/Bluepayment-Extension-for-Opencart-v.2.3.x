<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-payment" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if (isset($message_warning)): ?>
            <?php if (is_array($message_warning)): ?>
                <?php foreach ($message_warning as $message): ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $message; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $message_warning; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($message_success)): ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $message_success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="introduction">
                    <div class="introduction--row">
                        <div class="introduction--logo_container">
                            <img src="/admin/view/image/bluepayment/logo.svg" class="introduction--logo" alt="Blue Media" />
                        </div>
                        <div class="introduction--col">
                            <div class="introduction--check"></div>
                            <div class="introduction--content">
                                <?php echo $prepare_regulations; ?><br />
                                <a href="https://developers.bluemedia.pl/legal-geek?mtm_campaign=opencart_legalgeek&mtm_source=opencart_backoffice&mtm_medium=cta"
                                   target="_blank"><?php echo $introduction_learn; ?></a>
                            </div>
                        </div>
                        <div class="introduction--col">
                            <div class="introduction--check"></div>
                            <div class="introduction--content">
                                <a href="https://platnosci.bm.pl/?pk_campaign=opencart_panel&pk_source=opencart_panel&pk_medium=cta"
                                   class="introduction--link" target="_blank"><?php echo $fee; ?></a><br />
                            </div>
                        </div>
                    </div>

                    <h2><?php echo $introduction_title; ?></h2>

                    <div class="introduction--row">
                        <div class="introduction--col">
                            <div class="introduction--num">1</div>
                            <div class="introduction--content introduction--content__padding">
                                <?php echo $introduction_first_step; ?><br />
                                <a href="https://platnosci.bm.pl/?pk_campaign=opencart_panel&pk_source=opencart_panel&pk_medium=cta"
                                   class="introduction--link" target="_blank"><?php echo $introduction_register; ?></a>
                            </div>
                        </div>
                        <div class="introduction--col">
                            <div class="introduction--num">2</div>
                            <div class="introduction--content introduction--content__padding"><?php echo $introduction_second_step; ?></div>
                        </div>
                        <div class="introduction--col">
                            <div class="introduction--num">3</div>
                            <div class="introduction--content introduction--content__padding"><?php echo $introduction_third_step; ?></div>
                        </div>
                    </div>

                    <p class="introduction--learn-more">
                        <a href="https://developers.bluemedia.pl/online/wdrozenie-krok-po-kroku?mtm_campaign=opencart_developers_aktywacja_platnosci&mtm_source=opencart_backend&mtm_medium=hyperlink"
                           target="_blank" class="introduction--link"><?php echo $introduction_learn; ?></a>
                        <?php echo $introduction_learn2; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_module_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $url_action; ?>" method="POST" enctype="multipart/form-data" id="form-bluepayment" class="form-horizontal">
                    <input type="hidden" name="action" value="save">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab-settings" data-toggle="tab"><?php echo $tab_settings; ?></a>
                        </li>
                        <?php if (!empty($logs)): ?>
                            <li>
                                <a href="#tab-logs" data-toggle="tab"><?php echo $tab_logs; ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-settings">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-bluepayment-status"><?php echo $enabled_label; ?></label>
                                <div class="col-sm-10">
                                    <select name="bluepayment_status" id="input-bluepayment-status" class="form-control">
                                        <?php if ($bluepayment_status == 1): ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                            <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php else: ?>
                                            <option value="1"><?php echo $text_enabled; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php endif; ?>
                                    </select>

                                    <?php if (isset($error_bluepayment_status)): ?>
                                        <div class="text-danger"><?php echo $error_bluepayment_status; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-bluepayment-test-mode"><?php echo $test_mode; ?></label>
                                <div class="col-sm-10">
                                    <select name="bluepayment_test_mode" id="input-bluepayment-test-mode" class="form-control">
                                        <?php if ($bluepayment_test_mode == 1): ?>
                                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                                            <option value="0"><?php echo $text_no; ?></option>
                                        <?php else: ?>
                                            <option value="1"><?php echo $text_yes; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_no; ?></option>
                                        <?php endif; ?>
                                    </select>
                                    <p class="help-block"><?php echo $helper_test_mode; ?></p>
                                    <?php if (isset($error_bluepayment_test_mode)): ?>
                                        <div class="text-danger"><?php echo $error_bluepayment_test_mode; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i>
                                <?php echo $helper_test_mode_alert_1; ?><br />
                                <?php echo $helper_test_mode_alert_2; ?> <a href="https://developers.bluemedia.pl/kontakt?mtm_campaign=opencart_developers_formularz&mtm_source=opencart_backoffice&mtm_medium=hiperlink" target="_blank"><?php echo $helper_test_mode_alert_3; ?></a>.
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-bluepayment-success-status"><?php echo $success_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="bluepayment_status_success" class="form-control">
                                        <?php foreach ($order_statuses as $order_status): ?>
                                            <?php if ($order_status['order_status_id'] == $bluepayment_status_success): ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($error_bluepayment_status_success)): ?>
                                        <div class="text-danger"><?php echo $error_bluepayment_status_success; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-bluepayment-pending-status"><?php echo $pending_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="bluepayment_status_pending" id="input-bluepayment-pending-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status): ?>
                                            <?php if ($order_status['order_status_id'] == $bluepayment_status_pending): ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                    </select>
                                    <?php if (isset($error_bluepayment_status_pending)): ?>
                                        <div class="text-danger"><?php echo $error_bluepayment_status_pending; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-bluepayment-failed-status"><?php echo $failed_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="bluepayment_status_failed" id="input-bluepayment-failed-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status): ?>
                                            <?php if ($order_status['order_status_id'] == $bluepayment_status_failed): ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach ?>
                                    </select>
                                    <?php if (isset($error_bluepayment_status_failed)): ?>
                                        <div class="text-danger"><?php echo $error_bluepayment_status_failed; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $currency_settings; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <ul class="nav nav-tabs currencies-list">
                                        <?php foreach($currencies as $currency): ?>
                                        <li>
                                            <a href="#tab-currency-<?php echo $currency['code']; ?>" data-toggle="tab"><?php echo $currency['title']; ?></a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>

                                    <div class="tab-content currencies-panels">
                                        <?php foreach($currencies as $currency): ?>
                                            <div class="tab-pane" id="tab-currency-<?php echo $currency['code']; ?>">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-bluepayment-service-id-<?php echo $currency['code']; ?>">
                                                        <?php echo $service_id; ?>
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="text"
                                                               name="bluepayment_currency[<?php echo $currency['code']; ?>][service_id]"
                                                               id="input-bluepayment-service-id-<?php echo $currency['code']; ?>"
                                                               value="<?php
                                                                    echo isset(${"bluepayment_currency_" . $currency['code'] . "_service_id"})
                                                                    ? ${"bluepayment_currency_" . $currency['code'] . "_service_id"}
                                                                    : ''
                                                                ?>"
                                                               class="form-control"
                                                        >
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label" for="input-bluepayment-shared-key-<?php echo $currency['code']; ?>">
                                                        <?php echo $shared_key; ?>
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="text"
                                                               name="bluepayment_currency[<?php echo $currency['code']; ?>][shared_key]"
                                                               id="input-bluepayment-shared-key-<?php echo $currency['code']; ?>"
                                                               value="<?php
                                                                    echo isset(${"bluepayment_currency_" . $currency['code'] . "_shared_key"})
                                                                    ? ${"bluepayment_currency_" . $currency['code'] . "_shared_key"}
                                                                    : ''
                                                                ?>"

                                                               class="form-control"
                                                        >
                                                    </div>
                                                </div>
                                                <input type="hidden" name="bluepayment_currency[<?php echo $currency['code']; ?>][custom_name]" value="<?php echo $currency['title']; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($logs)): ?>
                        <div class="tab-pane" id="tab-logs">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="input-log-file-status"><?php echo $select_log_file; ?></label>
                                        <div class="col-sm-5">
                                            <select name="log_file_select" id="input-log-select" class="form-control js-log-select">
                                                <?php foreach ($log_files as $name => $path): ?>
                                                    <option value="<?php echo $path; ?>" selected="selected"><?php echo $name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="<?php echo $download; ?>" data-toggle="tooltip" title="<?php echo $download_module_logs; ?>" class="btn btn-warning js-log-download" data-href="<?php echo $download; ?>"><i class="fa fa-download"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="well well-sm js-log-content" style="overflow-wrap:break-word;">
                                        <?php foreach ($logs as $log): ?>
                                            <?php echo $log; ?> <br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('.js-log-select').on('change', function() {
        let logContentEl = $('.js-log-content'),
            logDownloadButtonEl = $('.js-log-download'),
            currentDownloadHref = logDownloadButtonEl.data('href'),
            selectedOption = $('.js-log-select option:selected').prop('value'),
            refreshLogUri = '<?php echo $refresh_log_uri|convert_encoding('UTF-8', 'HTML-ENTITIES'); ?>' + '&selected_log_file=' + selectedOption;

        $.ajax({
            url: refreshLogUri,
            dataType: 'json',
            beforeSend: function() {
                logContentEl.html('<?php echo $info_log_loading; ?>');
            },
            success: function(response) {
                let log = response.logs.join('<br>');

                logContentEl.html(log);
                logDownloadButtonEl.attr('href', currentDownloadHref + '&selected_log_file=' + selectedOption);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
});
</script>
<?php echo $footer; ?>
