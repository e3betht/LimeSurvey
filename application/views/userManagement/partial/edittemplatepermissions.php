<?php

Yii::app()->getController()->renderPartial(
    '/layouts/partial_modals/modal_header',
    ['modalTitle' => gT('Theme template permission')]
);
?>

<?= TbHtml::form(
    array("userManagement/saveThemePermissions"),
    'post',
    array('name' => 'UserManagement--modalform', 'id' => 'UserManagement--modalform')
); ?>
<div class="modal-body">
    <div class="container">
        <input type="hidden" name="userid" value="<?php echo $oUser->uid; ?>"/>
        <div class="mb-3">
            <button id="UserManagement--action-userthemepermissions-select-all" class="btn btn-outline-secondary">
                <?php eT('Select all'); ?>
            </button>
            <button id="UserManagement--action-userthemepermissions-select-none" class="btn btn-outline-secondary">
                <?php eT('Select none'); ?>
            </button>
        </div>
        <table class="table">
            <tr>
                <th><?php eT('Theme name'); ?></th>
                <th><?php eT('Access'); ?></th>
            </tr>
            <?php foreach ($aTemplates as $aTemplate) { ?>
                <tr>
                    <td><?= $aTemplate['folder'] ?></td>
                    <td>
                        <?php $this->widget('yiiwheels.widgets.switch.WhSwitch', array(
                            'name' => 'TemplatePermissions[' . $aTemplate['folder'] . ']',
                            'id' => $aTemplate['folder'] . '_use',
                            'value' => $aTemplate['value'],
                            'onLabel' => gT('On'),
                            'offLabel' => gT('Off'),
                            'htmlOptions' => ['class' => 'UserManagement--themepermissions-themeswitch']
                        ));
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
</div>
<div class="modal-footer modal-footer-buttons row ls-space margin top-25">
    <button class="btn btn-cancel selector--exitForm" id="exitForm"><?= gT('Cancel') ?></button>
    <button type="button" class="btn btn-primary selector--submitForm" id="submitForm">
        <?=gT('Save')?>
    </button>
</div>
</form>

