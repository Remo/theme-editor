<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Documentation'), false, false, 'span12 offset2');
?>

<table width="100%" cellpadding="10" cellspacing="20" border="0">

<tr>

<td valign="top" align="left">

<a name="disclaimer"></a>
<h2 style="color:#FF0000;"><?php  echo t('Serious Disclaimer')?></h2>
<p><strong><em><?php  echo t('IMPORTANT')?>:</em></strong> <?php  echo t('The disclaimer is at the beginning of this documentation for a very important reason. The Theme Editor gives you and your authorized users the ability to edit any of the files in your theme directory, thus potentially damaging your site layout and possibly rendering it inaccessible.')?> <strong><?php  echo t('ALWAYS BACKUP')?></strong> <?php  echo t('your site\'s files and database before doing any editing. I will not and cannot be held responsible for anything that happens to your site by using the Theme Editor. I will not entertain support requests of that nature. What you do with the Theme Editor is your responsibility. If you cannot handle that responsibility, please refrain from using this addon.')?></p>

<br /><br />

<a name="permissions"></a>
<h2><?php  echo t('About Permissions')?></h2>
<p><?php  echo t('I')?> <strong><?php  echo t('strongly')?></strong> <?php  echo t('suggest that you remove permissions for the Theme Editor page to anyone but the Super Administrator. You can set these permissions via your Sitemap by checking the box for "Show System Pages", clicking on the Theme Editor page and selecting Permissions.')?></p>

<br /><br />

<a name="prepare"></a>
<h2><?php  echo t('On Preparing Themes')?></h2>
<p><?php  echo t('Themes must be "prepared" before editing to ensure that original author updates do not overwrite your edits and that you will always be able to restore the original theme files.')?>
<br /><br />
<strong><?php  echo t('The Process:')?></strong>
</p>
<ol>
<li><?php  echo t('During install of the Theme Editor package, a database table is added that copies the PageThemes table and allows the addon to flag if the theme is ready to edit.')?></li>
<li><?php  echo t('The theme\'s folder and all of it\'s files are copied into the /themes folder of your site\'s root directory. This overwrites original author theme files but does not change them, allowing you to restore to the original easily in the case that something goes wrong.')?></li>
<li><?php  echo t('The theme is flagged in the database as prepared. You\'re now able to edit the theme files.')?></li>
</ol>

<br /><br />

<a name="edit"></a>
<h2><?php  echo t('Editing Themes')?></h2>
<p>
<?php  echo t('When you begin editing a theme, you\'ll see a screen with the editor and a list of theme files on the left.')?><br /><br />
<?php  echo t('Click on a filename on the left to begin editing that file. The file will load into the editor.')?><br /><br />
<?php  echo t('The current line and character number are displayed in the top right.')?><br /><br />
<strong><?php  echo t('NOTE: Standard text editor keyboard commands will work.')?></strong><br /><br />
<?php  echo t('The toolbar above the editor is displayed as follows:')?><br /><br />
<ol>
<li><strong><?php  echo t('Save:')?></strong> <?php  echo t('This will save the current file being edited.')?><br /><br /></li>
<li><strong><?php  echo t('Syntax Highlighting:')?></strong> <?php  echo t('Toggles syntax highlighting. The type of file is automatically detected and syntax is highlighted by default.')?><br /><br /></li>
<li><strong><?php  echo t('Word Wrap:')?></strong> <?php  echo t('Toggles line wrapping within the editor.')?><br /><br /></li>
<li><strong><?php  echo t('Undo:')?></strong> <?php  echo t('Will undo recent changes within the editor.')?><br /><br /></li>
<li><strong><?php  echo t('Redo:')?></strong> <?php  echo t('Will redo recent changes within the editor.')?></li>
</ol>
</p>

<br /><br />

<a name="restore"></a>
<h2><?php  echo t('Restoring Themes')?></h2>
<p><?php  echo t('This feature is used to restore a theme to it\'s original state.')?>
<br /><br />
<strong><?php  echo t('The Process:')?></strong>
</p>
<ol>
<li><?php  echo t('The theme\'s folder in the /themes folder of your site\'s root directory is deleted. This removes your modified theme files and restores the theme to the original author\'s version.')?></li>
<li><?php  echo t('The theme is flagged in the database as ready to prepare.')?></li>
<li><strong><?php  echo t('Note: This is an irreversible process. Once done, you can prepare the theme again and make new updates, but any updates you made to the theme before restoring will be gone.')?></strong></li>
</ol>

<br /><br />

<a name="uninstall"></a>
<h2><?php  echo t('Uninstalling')?></h2>
<p><?php  echo t('When you uninstall the Theme Editor, the changes you made to themes are not removed. To remove changes, you need to "Restore" the original them from the Theme Editor main page. Ultimately, you can also delete the them folder from /themes.')?>
</p>

<br /><br />

<a name="trouble"></a>
<h2><?php  echo t('Troubleshooting')?></h2>
<p><?php  echo t('None of my theme changes are taking effect?')?>
</p>
<ol>
<li><?php  echo t('Make sure that theme is active for your site.')?></li>
<li><?php  echo t('Clear your browser cache.')?></li>
<li><?php  echo t('Clear your site cache.')?></li>
</ol>

<br /><br />

<a name="support"></a>
<h2><?php  echo t('Support')?></h2>
<p><?php  echo t('Support for this addon can be found')?> <a href="http://www.concrete5.org/marketplace/addons/theme_editor/support/" target="_blank"><?php  echo t('on concrete5.org')?></a> <?php  echo t('or by emailing')?> <a href="mailto:lucas@lucasanderson.com">lucas@lucasanderson.com</a> <?php  echo t('directly. As always, I try to respond to support requests within 2 business days. Support is offered to the original addon purchaser only. As mentioned in the disclaimer above, I do not entertain support for any theme problems on your site that happen due to using the Theme Editor. I will, however, make sure the Theme Editor works as advertised.')?></p>


<br /><br />

<a name="license"></a>
<h2><?php  echo t('License')?></h2>
<p><?php  echo t('This software is licensed under the terms described in the concrete5.org marketplace. Please find the add-on there for the')?> <a href="http://www.concrete5.org/marketplace/addons/theme_editor/license/" target="_blank"><?php  echo t('latest license copy')?></a>. <?php  echo t('In English, it reads:')?> <em><?php  echo t('You own your copy for use on')?> <strong><?php  echo t('one (1) site')?></strong> <?php  echo t('and the development environment for it. Use it on another site, you should buy it again. Don\'t sue us.')?></em>
<br /><br />
<?php  echo t('License infringement is a serious issue for myself and many developers in the community. I enact strict monitoring of the use of my add-ons to make sure only legal copies are being used.')?>
</p>

<br /><br />

<a name="credits"></a>
<h2><?php  echo t('Credits')?></h2>
<p><a href="http://www.concrete5.org/profile/-/view/14/" target="_blank">Lucas Anderson</a> <?php  echo t('is the author of the Theme Editor.')?></p>

</td>

<td width="200" valign="top" align="left" style="border-left: 1px solid #cccccc;">
<h2><?php  echo t('Table of Contents')?></h2>

<ul>
<li><a href="#permissions"><?php  echo t('About Permissions')?></a></li>

<li><a href="#prepare"><?php  echo t('On Preparing Themes')?></a></li>

<li><a href="#edit"><?php  echo t('Editing Themes')?></a></li>

<li><a href="#restore"><?php  echo t('Restoring Themes')?></a></li>

<li><a href="#uninstall"><?php  echo t('Uninstalling')?></a></li>

<li><a href="#trouble"><?php  echo t('Troubleshooting')?></a></li>

<li><a href="#support"><?php  echo t('Support')?></a></li>

<li><a href="#license"><?php  echo t('License')?></a></li>

<li><a href="#credits"><?php  echo t('Credits')?></a></li>
</ul>
</td>

</table>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();?>