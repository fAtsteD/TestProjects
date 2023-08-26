<?php

auth_reauthenticate();

layout_page_header('Generate Data');
layout_page_begin('manage_overview_page.php');
print_manage_menu(plugin_page('generate_data'));

?>
<div class="col-md-12 col-xs-12">
    <div class="space-10"></div>
    <form action="<?php echo plugin_page('generate_data_update') ?>" method="post">
        <?php echo form_security_field('generate_data') ?>
        <div class="widget-box widget-color-blue2">
            <div class="widget-header widget-header-small">
                <h4 class="widget-title lighter">
                    Generate Data
                </h4>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <div class="form-container">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-striped">
                                <tbody>
                                    <tr>
                                        <th class="category" width="15%">
                                            Generate projects
                                        </th>
                                        <td width="85%">
                                            <input id="number_projects" name="number_projects" type="number" class="form-control" step="1" min="1">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="widget-toolbox padding-8 clearfix">
                    <input type="submit" class="btn btn-primary btn-white btn-round" value="Generate">
                </div>
            </div>
        </div>
    </form>
</div>

<?php
layout_page_end();
