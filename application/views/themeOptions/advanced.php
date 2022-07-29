<div role="tabpanel" class="tab-pane <?php echo Yii::app()->getConfig('debug') > 1 ? '' : 'd-none'; ?>" id="advanced">
    <div class="alert alert-info alert-dismissible" role="alert">
        <button href="#" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        <p><?php eT('All fields below (except CSS framework name) must be either a valid JSON array or the string "inherit".'); ?></p>
    </div>

    <div class="alert alert-warning alert-dismissible" role="alert">
        <button href="#" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
        <p><strong><?php eT('Warning!'); ?></strong> <?php eT("Don't touch the values below unless you know what you're doing."); ?></p>
    </div>

    <?php
    $actionBaseUrl = 'themeOptions/update/';
    $actionUrlArray = ['id' => $model->id];

    if ($model->sid) {
        unset($actionUrlArray['id']);
        $actionUrlArray['sid'] = $model->sid;
        $actionUrlArray['surveyd'] = $model->sid;
        $actionUrlArray['gsid'] = $model->gsid;
        $actionBaseUrl = 'themeOptions/updateSurvey/';
    }
    if ($model->gsid) {
        unset($actionUrlArray['id']);
        $actionBaseUrl = 'themeOptions/updateSurveyGroup/';
        $actionUrlArray['gsid'] = $model->gsid;
        $actionUrlArray['id'] = $model->id;
    }

    $actionUrl = Yii::app()->getController()->createUrl($actionBaseUrl, $actionUrlArray);
    ?>
    <div class="container-fluid">
        <div class="row ls-space margin bottom-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 h4">
                        <?php printf(gT("Upload an image (maximum size: %d MB):"), getMaximumFileUploadSize() / 1024 / 1024); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo TbHtml::form(['admin/themes/sa/upload'], 'post', ['id' => 'uploadimage', 'name' => 'uploadimage', 'enctype' => 'multipart/form-data']); ?>
                        <span id="fileselector">
                            <label class="btn btn-outline-secondary col-8" for="upload_image">
                                <input class="d-none" id="upload_image" name="upload_image" type="file">
                                <i class="fa fa-upload ls-space margin right-10"></i><?php eT("Upload"); ?>
                            </label>
                        </span>

                        <input type='hidden' name='templatename' value='<?php echo $model->template_name; ?>'/>
                        <input type='hidden' name='templateconfig' value='<?php echo $model->id; ?>'/>
                        <input type='hidden' name='action' value='templateuploadimagefile'/>
                        <?php echo TbHtml::endForm() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="progress">
                        <div id="upload_progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                            <span class="sr-only">0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <hr/>
        </div>
        <div class="row">
            <div class="container-fluid">
                <?php $form = $this->beginWidget(
                    'TbActiveForm',
                    [
                        'id'                   => 'template-options-form',
                        'enableAjaxValidation' => false,
                        'htmlOptions'          => ['class' => 'form '],
                        'action'               => $actionUrl
                    ]
                ); ?>
                <p class="note"><?php echo sprintf(gT('Fields with %s are required.'), '<span class="required">*</span>'); ?></p>
                <?php echo $form->errorSummary($model); ?>


                <?php echo $form->hiddenField($model, 'template_name'); ?>
                <?php echo $form->hiddenField($model, 'sid'); ?>
                <?php echo $form->hiddenField($model, 'gsid'); ?>
                <?php echo $form->hiddenField($model, 'uid'); ?>

                <?php echo CHtml::hiddenField('optionInheritedValues', json_encode($optionInheritedValues)); ?>
                <?php echo CHtml::hiddenField('optionCssFiles', json_encode($optionCssFiles)); ?>
                <?php echo CHtml::hiddenField('optionCssFramework', json_encode($optionCssFramework)); ?>
                <?php echo CHtml::hiddenField('translationInheritedValue', gT("Inherited value:") . ' '); ?>

                <div class="row">
                    <div class="mb-3">
                        <?php echo $form->labelEx($model, 'files_css'); ?>
                        <?php echo $form->textArea($model, 'files_css', ['rows' => 6, 'cols' => 50]); ?>
                        <?php echo $form->error($model, 'files_css'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <?php echo $form->labelEx($model, 'files_js'); ?>
                        <?php echo $form->textArea($model, 'files_js', ['rows' => 6, 'cols' => 50]); ?>
                        <?php echo $form->error($model, 'files_js'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <?php echo $form->labelEx($model, 'files_print_css'); ?>
                        <?php echo $form->textArea($model, 'files_print_css', ['rows' => 6, 'cols' => 50]); ?>
                        <?php echo $form->error($model, 'files_print_css'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <?php echo $form->labelEx($model, 'options'); ?>
                        <?php echo $form->textArea($model, 'options', ['rows' => 6, 'cols' => 50]); ?>
                        <?php echo $form->error($model, 'options'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <?php echo $form->labelEx($model, 'cssframework_name'); ?>
                        <?php echo $form->textField($model, 'cssframework_name', ['size' => 45, 'maxlength' => 45]); ?>
                        <?php echo $form->error($model, 'cssframework_name'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <?php echo $form->labelEx($model, 'cssframework_css'); ?>
                        <?php echo $form->textArea($model, 'cssframework_css', ['rows' => 6, 'cols' => 50]); ?>
                        <?php echo $form->error($model, 'cssframework_css'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <?php echo $form->labelEx($model, 'cssframework_js'); ?>
                        <?php echo $form->textArea($model, 'cssframework_js', ['rows' => 6, 'cols' => 50]); ?>
                        <?php echo $form->error($model, 'cssframework_js'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <?php echo $form->labelEx($model, 'packages_to_load'); ?>
                        <?php echo $form->textArea($model, 'packages_to_load', ['rows' => 6, 'cols' => 50]); ?>
                        <?php echo $form->error($model, 'packages_to_load'); ?>
                    </div>
                </div>
                <div class="row buttons d-none">
                    <?php echo TbHtml::submitButton($model->isNewRecord ? gT('Create') : gT('Save'), ['class' => 'btn-success']); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>