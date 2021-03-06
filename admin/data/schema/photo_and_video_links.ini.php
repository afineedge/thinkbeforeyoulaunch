<?php /* This is a PHP data file */ if (!@$LOADSTRUCT) { die("This is not a program file."); }
return array (
  '_detailPage' => '',
  '_disableAdd' => '0',
  '_disableErase' => '0',
  '_disableModify' => '0',
  '_disablePreview' => '0',
  '_disableView' => '1',
  '_filenameFields' => 'title',
  '_hideRecordsFromDisabledAccounts' => '0',
  '_indent' => '0',
  '_listPage' => '',
  '_maxRecords' => '',
  '_maxRecordsPerUser' => '',
  '_perPageDefault' => '25',
  '_previewPage' => '',
  '_requiredPlugins' => '',
  '_tableName' => 'photo_and_video_links',
  'listPageFields' => 'dragSortOrder, title, publishDate',
  'listPageOrder' => 'dragSortOrder DESC',
  'listPageSearchFields' => '_all_',
  'menuHidden' => '0',
  'menuName' => 'Photo and Video Links',
  'menuOrder' => '1438546761',
  'menuType' => 'multi',
  'num' => array(
    'order' => 1,
    'type' => 'none',
    'label' => 'Record Number',
    'isSystemField' => '1',
  ),
  'createdDate' => array(
    'order' => 2,
    'type' => 'none',
    'label' => 'Created',
    'isSystemField' => '1',
  ),
  'createdByUserNum' => array(
    'order' => 3,
    'type' => 'none',
    'label' => 'Created By',
    'isSystemField' => '1',
  ),
  'updatedDate' => array(
    'order' => 4,
    'type' => 'none',
    'label' => 'Last Updated',
    'isSystemField' => '1',
  ),
  'updatedByUserNum' => array(
    'order' => 5,
    'type' => 'none',
    'label' => 'Last Updated By',
    'isSystemField' => '1',
  ),
  'dragSortOrder' => array(
    'order' => 6,
    'label' => 'Order',
    'type' => 'none',
  ),
  'title' => array(
    'order' => 7,
    'label' => 'Title',
    'type' => 'textfield',
    'defaultValue' => '',
    'description' => '',
    'fieldWidth' => '',
    'isPasswordField' => '0',
    'isRequired' => '1',
    'isUnique' => '0',
    'minLength' => '',
    'maxLength' => '',
    'charsetRule' => '',
    'charset' => '',
  ),
  'publishDate' => array(
    'order' => 8,
    'label' => 'Publish Date',
    'type' => 'date',
    'indexed' => '0',
    'fieldPrefix' => '',
    'description' => '',
    'isRequired' => '0',
    'isUnique' => '0',
    'defaultDate' => '',
    'defaultDateString' => '2015-01-01 00:00:00',
    'showTime' => '0',
    'showSeconds' => '0',
    'use24HourFormat' => '0',
    'yearRangeStart' => '',
    'yearRangeEnd' => '',
  ),
  'description' => array(
    'order' => 9,
    'label' => 'Description',
    'type' => 'wysiwyg',
    'indexed' => '0',
    'fieldPrefix' => '',
    'description' => '',
    'defaultContent' => '',
    'allowUploads' => '1',
    'isRequired' => '0',
    'isUnique' => '0',
    'minLength' => '',
    'maxLength' => '',
    'fieldHeight' => '300',
    'allowedExtensions' => 'gif,jpg,png,wmv,mov,swf',
    'checkMaxUploadSize' => '1',
    'maxUploadSizeKB' => '5120',
    'checkMaxUploads' => '1',
    'maxUploads' => '25',
    'resizeOversizedImages' => '1',
    'maxImageHeight' => '800',
    'maxImageWidth' => '600',
    'createThumbnails' => '1',
    'maxThumbnailHeight' => '150',
    'maxThumbnailWidth' => '150',
    'createThumbnails2' => '0',
    'maxThumbnailHeight2' => '150',
    'maxThumbnailWidth2' => '150',
    'createThumbnails3' => '0',
    'maxThumbnailHeight3' => '150',
    'maxThumbnailWidth3' => '150',
    'createThumbnails4' => '0',
    'maxThumbnailHeight4' => '150',
    'maxThumbnailWidth4' => '150',
    'useCustomUploadDir' => '0',
    'customUploadDir' => '',
    'customUploadUrl' => '',
  ),
  '__separator001__' => array(
    'order' => 10,
    'label' => '',
    'type' => 'separator',
    'separatorType' => 'header bar',
    'separatorHeader' => 'File',
    'separatorHTML' => '<tr>
 <td colspan=\'2\'>
 </td>
</tr>',
  ),
  'photo_upload' => array(
    'order' => '11',
    'label' => 'Photo Upload',
    'type' => 'upload',
    'fieldPrefix' => '',
    'description' => '',
    'isRequired' => '0',
    'allowedExtensions' => 'gif,jpg,png',
    'checkMaxUploadSize' => '0',
    'maxUploadSizeKB' => '5120',
    'checkMaxUploads' => '0',
    'maxUploads' => '25',
    'resizeOversizedImages' => '0',
    'maxImageHeight' => '800',
    'maxImageWidth' => '600',
    'createThumbnails' => '0',
    'maxThumbnailHeight' => '150',
    'maxThumbnailWidth' => '150',
    'createThumbnails2' => '0',
    'maxThumbnailHeight2' => '150',
    'maxThumbnailWidth2' => '150',
    'createThumbnails3' => '0',
    'maxThumbnailHeight3' => '150',
    'maxThumbnailWidth3' => '150',
    'createThumbnails4' => '0',
    'maxThumbnailHeight4' => '150',
    'maxThumbnailWidth4' => '150',
    'useCustomUploadDir' => '0',
    'customUploadDir' => '',
    'customUploadUrl' => '',
    'infoField1' => '',
    'infoField2' => '',
    'infoField3' => '',
    'infoField4' => '',
    'infoField5' => '',
  ),
  '__separator002__' => array(
    'order' => 12,
    'label' => '',
    'type' => 'separator',
    'separatorType' => 'html',
    'separatorHeader' => '',
    'separatorHTML' => '<tr>
 <td colspan=\'2\'>
<strong style="font-size:16px">Or</strong>
 </td>
</tr>',
  ),
  'photo_url' => array(
    'order' => 13,
    'label' => 'Photo URL',
    'type' => 'textfield',
    'indexed' => '',
    'defaultValue' => '',
    'fieldPrefix' => '',
    'description' => '',
    'fieldWidth' => '',
    'isPasswordField' => '0',
    'isRequired' => '0',
    'isUnique' => '0',
    'minLength' => '',
    'maxLength' => '',
    'charsetRule' => '',
    'charset' => '',
  ),
  'youtube_video_id' => array(
    'order' => 14,
    'label' => 'YouTube Video ID',
    'type' => 'textfield',
    'indexed' => '0',
    'defaultValue' => '',
    'fieldPrefix' => '',
    'description' => '',
    'fieldWidth' => '',
    'isPasswordField' => '0',
    'isRequired' => '0',
    'isUnique' => '0',
    'minLength' => '',
    'maxLength' => '',
    'charsetRule' => '',
    'charset' => '',
  ),
  'vimeo_video_id' => array(
    'order' => 15,
    'label' => 'Vimeo Video ID',
    'type' => 'textfield',
    'indexed' => '',
    'defaultValue' => '',
    'fieldPrefix' => '',
    'description' => '',
    'fieldWidth' => '',
    'isPasswordField' => '0',
    'isRequired' => '0',
    'isUnique' => '0',
    'minLength' => '',
    'maxLength' => '',
    'charsetRule' => '',
    'charset' => '',
  ),
);
?>