<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$bt = Loader::helper('concrete/interface');
$valt = Loader::helper('validation/token');
$themesDirectory = DIR_FILES_THEMES;

echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Theme Setup'), t('This is where you prepare themes for editing or restore them to their original state.'), false, 'span12 offset2');

?>
	<div style="margin:0px; padding:0px; width:100%; height:auto;">
	<h3><?php echo t('Currently Installed')?></h3>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="zebra-striped">
	<?php
	if (count($tArray) == 0) { ?>
        <tbody>
            <tr>
                <td><p><?php echo t('No themes are installed.')?></p></td>
            </tr>
		</tbody>
	<?php
	}
	elseif (!is_writable($themesDirectory)) { ?>
        <tbody>
            <tr>
                <td><p><?php  echo '<strong>'.$themesDirectory.'</strong>'.t(' directory is not writable. Please change permissions on that folder.<br /><br />')?></p></td>
            </tr>
		</tbody>
	<?php   } else {
		foreach ($tArray as $t) { ?>
            <tr <?php  if ($siteThemeID == $t->getThemeID()) { ?> class="ccm-theme-active" <?php  } ?>>

                <td>
					<div class="ccm-themes-thumbnail" style="padding:4px;background-color:#FFF;border-radius:3px;border:1px solid #DDD;">
						<?php echo $t->getThemeThumbnail()?>
					</div>
				</td>
                <td width="100%" style="vertical-align:middle;">

                    <p class="ccm-themes-name"><strong><?php echo $t->getThemeName()?></strong></p>
                    <p class="ccm-themes-description"><em><?php echo $t->getThemeDescription()?></em></p>
					<?php   if (!$this->controller->isPrepared($t->getThemeHandle())) { ?>
					<p class="ccm-themes-name"><strong style="color:red;"><?php  echo t('This theme is not prepared for editing.')?></strong></p>
					<?php   } else { ?>
					<p class="ccm-themes-name"><strong style="color:green;"><?php  echo t('This theme is prepared for editing.')?></strong></p>
					<?php  } ?>
					<?php   if (!$this->controller->isPrepared($t->getThemeHandle())) { ?>
					<?php  echo $bt->button(t("Prepare"), $this->url('/dashboard/theme_editor/themes', 'prepare', $t->getThemeHandle()), "left", "primary");?>
					<?php   } else { ?>
					<?php  echo $bt->button(t("Edit"), $this->url('/dashboard/theme_editor/edit_theme', $t->getThemeHandle()), "left", "primary");?>
					<?php  echo $bt->button(t("Restore"), $this->url('/dashboard/theme_editor/themes', 'restore', $t->getThemeHandle()), "left", "error");?>
					<?php  } ?>
					</td>
			</tr>
		<?php   }
	} ?>
	</table>
	</div>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();?>