<?php


form_security_validate('generate_data');

auth_reauthenticate();

$f_number_projects = gpc_get_int('number_projects');

$t_redirect_url = plugin_page('generate_data', true);
$t_result = true;
$t_error_message = '';

$t_generate = new TestProjectsGenerate($f_number_projects);
$t_generate->generate();

form_security_purge('generate_data');

layout_page_header(null, $t_result ? $t_redirect_url : null);
layout_page_begin('manage_overview_page.php');

if ($t_result) {
    # SUCCESS
    html_operation_successful($t_redirect_url);
} else {
    # ERROR
    html_operation_failure($t_redirect_url, $t_error_message);
}

layout_page_end();
