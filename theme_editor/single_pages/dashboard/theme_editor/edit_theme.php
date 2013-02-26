<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$bt = Loader::helper('concrete/interface');

echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Editing Theme: ').$themeName, t('This is the editor screen where you edit theme files. Click Save to save changes.'), false, 'span14 offset2');

$ih = Loader::helper('concrete/interface');
$valt = Loader::helper('validation/token');

Loader::model('page_theme');

if ($_SESSION['theme_editor']['handle'] == "") {
?>
<div id="editor-wrapper">
<?php  echo t('You need to select a theme to edit from'); ?> <a href="/dashboard/theme_editor/themes"><?php  echo t('Theme Setup'); ?></a>!
</div>
<?php
}
else {

$theme = PageTheme::getByHandle($_SESSION['theme_editor']['handle']);
if (!is_object($theme)) {
	echo t('Invalid theme.');
	die();
}
$themeName = $theme->getThemeName();
$themeHandle = $theme->getThemeHandle();
$themeDirectory = $theme->getThemeDirectory();

$url = Loader::helper('concrete/urls');
$base = $url->getToolsURL('', 'theme_editor');
$path = $base . 'file_service';

?>

<div style="width:100px; height:500px;">

<?php
$filedir = DIR_FILES_THEMES.'/'.$_SESSION['theme_editor']['handle'];

$valid_ext[0] = "CSS";
$valid_ext[1] = "css";
$valid_ext[2] = "js";
$valid_ext[3] = "JS";
$valid_ext[4] = "php";
$valid_ext[5] = "PHP";
$valid_ext[6] = "txt";
$valid_ext[7] = "TXT";

if (is_readable($filedir)) {
chdir($filedir);
?>
<br /><br /><strong><?php  echo t('Select File:'); ?></strong><br /><br />
<?php
$filelist = $this->controller->directoryToArray($filedir, true);

foreach ($filelist as $file)
{
$filename = str_replace(DIR_FILES_THEMES, '', $file);
$filename = str_replace('/'.$themeHandle.'/', '', $filename);
$ext = substr(strrchr($file, '.'), 1);
if (in_array($ext,$valid_ext) && is_writable($file)) {
echo "<a style=\"font-size:11px;\" onclick=\"ToggleFileLink(this); filePath = this.id; LoadFile('$file','$themeDirectory','$themeHandle');\" id=\"$file\">".$filename."</a><br />";
}
}
}
?>

<script type="text/javascript">
var req;
var key;
var fileName;
var ext;

function Initialize() {
    try {
        req = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            req = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (oc) {
            req = null;
        }
    }
    if (!req && typeof XMLHttpRequest != "undefined") {
        req = new XMLHttpRequest();
    }
}
function LoadFile(key,directory,handle) {
    Initialize();
    var url = "<?php  echo $path; ?>?file="+key+"&dir="+directory+"&handle="+handle+"&method=load";
    ext = key.substr(key.lastIndexOf('.') + 1);
    if (req != null) {
        req.onreadystatechange = ProcessLoad;
        req.open("GET", url, true);
        req.send(null);
    }
}
function saveContent(key,contents) {
                var parameters = "contents=" + contents + "&file=" + key + "&method=save";
                var xmlHttpReq = null;
                // Mozilla/Safari
                if (window.XMLHttpRequest) {
                        xmlHttpReq = new XMLHttpRequest();
                }
                // IE
                else if (window.ActiveXObject) {
                        xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlHttpReq.open('POST', '<?php  echo $path; ?>');
                xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xmlHttpReq.setRequestHeader("Content-length", parameters.length);
                xmlHttpReq.setRequestHeader("Connection", "close");
                xmlHttpReq.onreadystatechange = function() {
                        if (xmlHttpReq.readyState == 4) {
                            alert("<?php  echo t('Saved!'); ?>");
                        }
                };
                xmlHttpReq.send(parameters);
}
function ProcessLoad() {
	document.getElementById("editor").innerHTML = ' <?php  echo t('Fetching file...'); ?> ';
    if (req.readyState == 4) {
        if (req.status == 200) {
            if (req.responseText == "") document.getElementById("error_message").innerHTML = "No response.";
            else {
            	//disableCodeMirror();
            	//clearTextArea();
            	document.getElementById("editor").innerHTML = req.responseText;
                LoadEditor(ext);
            }
        } else {
            document.getElementById("editor").innerHTML="Error:\n"+ req.status + "\n" +req.statusText;
        }
    }
}
</script>

  <style type="text/css" media="screen">

    #editor {
        margin: 81px 0 0 200px;
        padding: 0 0 1px 0;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: auto;
        font-family: 'Courier New', Courier, monospace;
    }

    #editor div {
    	font-family: 'Courier New', Courier, monospace;
    }

    #editor-toolbar {
        margin: 46px 0 0 200px;
        padding: 3px 0px 0px 3px;
    	background:#E8E8E8;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        border-bottom: 1px white;
    }

    #editor-status {
    	margin: 6px;
    	font-size: 11px;
    	font-weight:bold;
    	float:right;
    	width:100px;
    }

    .editor-button {
    	float:left;
    	height:22px;
    	width: 22px;
    	padding:2px;
    	margin:4px;
    	border: 1px solid #DDD;
    	text-align:middle;
    }

    .editor-button:hover {
    	border: 1px solid #007AF4;
    }

    #editor-theme {
    	margin: 0;
    	background: black;
    	color: white;
    }

  </style>
<div id="editor-toolbar">
<div id="editor-status">
<?php  echo t('Char:'); ?> <span id="charNum">0</span> <?php  echo t('Line:'); ?> <span id="lineNum">0</span>
</div>
<?php echo $bt->button_js(t("Save"), "save_file()", 'left', 'primary');?>&nbsp;
<?php echo $bt->button_js(t("Syntax"), "ToggleSyntax()", 'left');?>&nbsp;
<?php echo $bt->button_js(t("Wrapping"), "ToggleWrap()", 'left');?>&nbsp;
<?php echo $bt->button_js(t("Undo"), "UndoEdit()", 'left');?>
<?php echo $bt->button_js(t("Redo"), "RedoEdit()", 'left');?>
&nbsp;&nbsp;&nbsp;
<select id="editor-theme" onChange="setTheme(this.value);">
<option value="twilight">twilight</option>
<option value="clouds">clouds</option>
<option value="clouds_midnight">midnight</option>
<option value="cobalt">cobalt</option>
<option value="dawn">dawn</option>
<option value="eclipse">eclispse</option>
<option value="idle_fingers">idle</option>
<option value="kr_theme">kr theme</option>
<option value="mono_industrial">industrial</option>
<option value="monokai">monokai</option>
<option value="pastel_on_dark">pastel</option>
</select>
</div>
<pre id="editor" style="font-family: 'Courier New', Courier, monospace;">


<- <?php  echo t('Select a file to edit.'); ?>
</pre>

<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-twilight.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-clouds.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-clouds_midnight.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-cobalt.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-dawn.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-eclipse.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-idle_fingers.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-kr_theme.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-mono_industrial.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-monokai.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-pastel_on_dark.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/theme-twilight.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/mode-php.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/mode-javascript.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php  echo BASE_URL.DIR_REL; ?>/packages/theme_editor/libraries/ace/src/mode-css.js" type="text/javascript" charset="utf-8"></script>
<script>
var editor = "";
var wrapCheck = 0;
var syntaxCheck = 1;
var prevFileLink = "";
var curFileLink;
var filePath;

function ToggleFileLink(cFileLink) {
if(prevFileLink != "") {
document.getElementById(prevFileLink).style.fontWeight = 'normal';
}
cFileLink.style.fontWeight = 'bold';
prevFileLink = cFileLink.id;
}

var PhpMode = require("ace/mode/php").Mode;
var JavaScriptMode = require("ace/mode/javascript").Mode;
var CssMode = require("ace/mode/css").Mode;
var TextMode = require("ace/mode/text").Mode;

document.getElementById('editor-theme').style.visibility = "hidden";

function LoadEditor(ext) {
    editor = ace.edit("editor");

    document.getElementById('editor-theme').style.visibility  = "visible";
    document.getElementById('lineNum').innerHTML = "0";
	document.getElementById('charNum').innerHTML = "0";

    setTheme('twilight');

    if(ext=='php') {
    editor.getSession().setMode(new PhpMode());
    }
    else if(ext=='js') {
    editor.getSession().setMode(new JavaScriptMode());
    }
    else if(ext=='css') {
    editor.getSession().setMode(new CssMode());
    }
    else if(ext=='txt') {
    editor.getSession().setMode(new TextMode());
    }

    editor.getSession().on('change', statusUpdate);
    editor.getSession().selection.on('changeCursor', statusUpdate);
    editor.setShowPrintMargin(false);
};

function ToggleWrap() {

 if(editor != "") {
	if(wrapCheck == 0) {
		editor.getSession().setUseWrapMode(true);
		wrapCheck = 1;
	}
	else if(wrapCheck == 1) {
		editor.getSession().setUseWrapMode(false);
		wrapCheck = 0;
	}
 }
 else {
 alert('<?php  echo t('Please select a file to edit first.'); ?>');
 }

}

function UndoEdit() {

 if(editor != "") {
	editor.getSession().getUndoManager().undo();
 }
 else {
 alert('<?php  echo t('Please select a file to edit first.'); ?>');
 }

}

function RedoEdit() {

 if(editor != "") {
	editor.getSession().getUndoManager().redo();
 }
 else {
 alert('<?php  echo t('Please select a file to edit first.'); ?>');
 }

}

function ToggleSyntax() {

 if(editor != "") {
	if(syntaxCheck == 0) {
		if(ext=='php') {
		editor.getSession().setMode(new PhpMode());
		}
		else if(ext=='js') {
		editor.getSession().setMode(new JavaScriptMode());
		}
		else if(ext=='css') {
		editor.getSession().setMode(new CssMode());
		}
		else if(ext=='txt') {
		editor.getSession().setMode(new TextMode());
		}
		syntaxCheck = 1;
	}
	else if(syntaxCheck == 1) {
		editor.getSession().setMode(new TextMode());
		syntaxCheck = 0;
	}
 }
 else {
 alert('<?php  echo t('Please select a file to edit first.'); ?>');
 }

}

function setTheme(themeOpt) {

    if(themeOpt=='clouds') {
    	editor.setTheme("ace/theme/clouds");
    }
    else if(themeOpt=='clouds_midnight') {
    	editor.setTheme("ace/theme/clouds_midnight");
    }
    else if(themeOpt=='cobalt') {
    	editor.setTheme("ace/theme/cobalt");
    }
    else if(themeOpt=='dawn') {
    	editor.setTheme("ace/theme/dawn");
    }
    else if(themeOpt=='eclipse') {
    	editor.setTheme("ace/theme/eclipse");
    }
    else if(themeOpt=='idle_fingers') {
    	editor.setTheme("ace/theme/idle_fingers");
    }
    else if(themeOpt=='kr_theme') {
    	editor.setTheme("ace/theme/kr_theme");
    }
    else if(themeOpt=='mono_industrial') {
    	editor.setTheme("ace/theme/mono_industrial");
    }
    else if(themeOpt=='monokai') {
    	editor.setTheme("ace/theme/monokai");
    }
    else if(themeOpt=='pastel_on_dark') {
    	editor.setTheme("ace/theme/pastel_on_dark");
    }
    else if(themeOpt=='twilight') {
    	editor.setTheme("ace/theme/twilight");
    }
    else if(themeOpt = "") {
    	alert('<?php  echo t('Please select a file to edit first.'); ?>');
    }

}

function statusUpdate() {
curPos = editor.getCursorPosition();
document.getElementById('lineNum').innerHTML = curPos['row']+1;
document.getElementById('charNum').innerHTML = curPos['column']+1;
};

function save_file()
{
 if(editor != "") {
 	var contents = editor.getSession().getValue();
 	saveContent(filePath,escape(contents));
 }
 else {
 	alert('<?php  echo t('Please select a file to edit first.'); ?>');
 }
}

</script>

<?php  } ?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();?>