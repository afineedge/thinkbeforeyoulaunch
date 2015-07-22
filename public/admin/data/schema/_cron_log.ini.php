<?php /* This is a PHP data file */ if (!@$LOADSTRUCT) { die("This is not a program file."); }
return array (
  '_detailPage' => '',
  '_disableAdd' => '1',
  '_disableErase' => '0',
  '_disableModify' => '0',
  '_disablePreview' => '1',
  '_disableView' => '1',
  '_filenameFields' => 'num',
  '_hideRecordsFromDisabledAccounts' => '0',
  '_indent' => '0',
  '_listPage' => '',
  '_maxRecords' => '',
  '_maxRecordsPerUser' => '',
  '_perPageDefault' => '100',
  '_previewPage' => '',
  '_requiredPlugins' => '',
  '_tableName' => '_cron_log',
  'listPageFields' => 'createdDate, activity, summary, completed, function, output, runtime',
  'listPageOrder' => 'createdDate DESC',
  'listPageSearchFields' => '_all_
Completed|completed|match',
  'menuHidden' => '1',
  'menuName' => 'Background Tasks Log',
  'menuOrder' => '1350523094',
  'menuType' => 'multi',
  'tableHidden' => '1',
  'num' => array(
    'order' => 1,
    'type' => 'none',
    'label' => 'Record Number',
    'isSystemField' => '1',
  ),
  'createdDate' => array(
    'order' => 2,
    'label' => 'Date/Time',
    'type' => 'none',
    'isSystemField' => '1',
  ),
  'activity' => array(
    'order' => 3,
    'label' => 'Activity',
    'type' => 'textfield',
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
  'summary' => array(
    'order' => 4,
    'label' => 'Summary',
    'type' => 'textfield',
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
  'completed' => array(
    'order' => 5,
    'label' => 'Completed',
    'type' => 'checkbox',
    'fieldPrefix' => '',
    'checkedByDefault' => '0',
    'description' => '',
    'checkedValue' => 'Yes',
    'uncheckedValue' => 'No',
  ),
  '__separator001__' => array(
    'order' => 6,
    'label' => '',
    'type' => 'separator',
    'separatorType' => 'blank line',
    'separatorHeader' => '',
    'separatorHTML' => '<tr>
 <td colspan=\'2\'>
 </td>
</tr>',
  ),
  'function' => array(
    'order' => 7,
    'label' => 'Function',
    'type' => 'textfield',
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
  'output' => array(
    'order' => '8',
    'label' => 'Output',
    'type' => 'textbox',
    'defaultContent' => '',
    'fieldPrefix' => '',
    'description' => '',
    'isRequired' => '0',
    'isUnique' => '0',
    'minLength' => '',
    'maxLength' => '',
    'fieldHeight' => '300',
    'autoFormat' => '1',
  ),
  'runtime' => array(
    'order' => '9',
    'label' => 'Runtime',
    'type' => 'textfield',
    'defaultValue' => '',
    'fieldPrefix' => '',
    'description' => 'seconds',
    'fieldWidth' => '50',
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