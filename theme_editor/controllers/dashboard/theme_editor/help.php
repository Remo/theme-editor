<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

class DashboardThemeEditorHelpController extends Controller {

	public function view() {
		$this->set('subnav', array(array(View::url('/dashboard/theme_editor/themes'), t('Theme Setup')),array(View::url('/dashboard/theme_editor/help'), t('Help'), $globalSelected)));
	}

}

?>