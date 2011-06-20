<?php
/* Copyright (C) 2003      Eric Seigne          <erics@rycks.com>
 * Copyright (C) 2003,2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2008 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2004      Sebastien Di Cintio  <sdicintio@ressource-toi.org>
 * Copyright (C) 2004      Benoit Mortier       <benoit.mortier@opensides.be>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */

/**
 *      \file       htdocs/submiteverywhere/admin/submiteverywheresetuppage.php
 *      \ingroup    submiteverywhere
 *      \brief      Page to setup module SubmitEverywhere
 *      \version    $Id: submiteverywheresetuppage.php,v 1.7 2011/06/20 19:34:16 eldy Exp $
 */

$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include("../main.inc.php");
if (! $res && file_exists("../../main.inc.php")) $res=@include("../../main.inc.php");
if (! $res && file_exists("../../../main.inc.php")) $res=@include("../../../main.inc.php");
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include("../../../dolibarr/htdocs/main.inc.php");     // Used on dev env only
if (! $res && file_exists("../../../../dolibarr/htdocs/main.inc.php")) $res=@include("../../../../dolibarr/htdocs/main.inc.php");   // Used on dev env only
if (! $res && file_exists("../../../../../dolibarr/htdocs/main.inc.php")) $res=@include("../../../../../dolibarr/htdocs/main.inc.php");   // Used on dev env only
if (! $res) die("Include of main fails");
require_once(DOL_DOCUMENT_ROOT."/lib/admin.lib.php");
require_once(DOL_DOCUMENT_ROOT."/core/class/html.formadmin.class.php");
dol_include_once("/submiteverywhere/lib/submiteverywhere.lib.php");


$langs->load("admin");
$langs->load("submiteverywhere@submiteverywhere");

if (!$user->admin) accessforbidden();

$mesg='';
$error=0;

$listoftargets=array(
'dig'=>array('label'=>$langs->trans("Dig"),'titlelength'=>10,'descshortlength'=>256,'desclonglength'=>2000),
'email'=>array('label'=>$langs->trans("Email"),'titlelength'=>10,'descshortlength'=>256,'desclonglength'=>0),
'facebook'=>array('label'=>$langs->trans("Facebook"),'titlelength'=>10,'descshortlength'=>256,'desclonglength'=>2000),
'linkedin'=>array('label'=>$langs->trans("LinkedIn"),'titlelength'=>10,'descshortlength'=>256,'desclonglength'=>2000),
'twitter'=>array('label'=>$langs->trans("Twitter"),'titlelength'=>10,'descshortlength'=>256,'desclonglength'=>2000),
'web'=>array('label'=>$langs->trans("GenericWebSite"),'titlelength'=>10,'descshortlength'=>256,'desclonglength'=>2000),
//'sms'=>array('label'=>$langs->trans("Email"),'titlelength'=>10,'descshortlength'=>140,'desclonglength'=>-1),
);



/*
 * Action
 */

if ($_POST["action"] == 'add' || $_POST["modify"])
{
    if (GETPOST('label') == '')
    {
        $error++;
        $errors[]=$langs->trans("ErrorFieldRequired",$langs->transnoentitiesnoconv("Label"));
    }
    if (GETPOST('type') == '')
    {
        $error++;
        $errors[]=$langs->trans("ErrorFieldRequired",$langs->transnoentitiesnoconv("Type"));
    }
    if (GETPOST('titlelength') == '')
    {
        $error++;
        $errors[]=$langs->trans("ErrorFieldRequired",$langs->transnoentitiesnoconv("TitleLength"));
    }
    if (GETPOST('descshortlength') == '')
    {
        $error++;
        $errors[]=$langs->trans("ErrorFieldRequired",$langs->transnoentitiesnoconv("DescShortLength"));
    }
    if (GETPOST('desclonglength') == '')
    {
        $error++;
        $errors[]=$langs->trans("ErrorFieldRequired",$langs->transnoentitiesnoconv("DescLongLength"));
    }

    if (! $error)
    {
        $sql = "INSERT INTO ".MAIN_DB_PREFIX."submitew_targets (label,targetcode,langcode,titlelength,descshortlength,desclonglength)";
    	$sql.= " VALUES ('".$db->escape(GETPOST('label'))."', '".$db->escape(GETPOST('type'))."', '".$db->escape(GETPOST('lang_id'))."',";
    	$sql.= " '".$db->escape(GETPOST('titlelength'))."', '".$db->escape(GETPOST('descshortlength'))."', '".$db->escape(GETPOST('desclonglength'))."'";
    	$sql.= ")";
        $resql=$db->query($sql);
    	if ($resql)
        {
            $_POST['label']='';
            $_POST['type']='';
        }
        else
        {
            if ($db->lasterrno == 'DB_ERROR_RECORD_ALREADY_EXISTS')
            {
                $langs->load("errors");
                $errors[]=$langs->trans("ErrorRefAlreadyExists");
            }
            else  {
            	dol_print_error($db);
                $error++;
            }
        }
    }
}

if (GETPOST("action")=='delete')
{
    $sql = "DELETE FROM ".MAIN_DB_PREFIX."submitew_targets";
    $sql.= " WHERE rowid = ".GETPOST('id','int',1);
	$resql=$db->query($sql);
	if ($resql)
	{
	}
	else
	{
	    dol_print_error($db);
	    $error++;
	}
}


/*
 * View
 */

$htmladmin=new FormAdmin($db);

llxHeader();

$linkback='<a href="'.DOL_URL_ROOT.'/admin/modules.php">'.$langs->trans("BackToModuleList").'</a>';
print_fiche_titre($langs->trans("SubmitEveryWhereSetup"), $linkback, 'setup');
print '<br>';

print $langs->trans("DescSubmitEveryWhere").'<br><br>'."\n";


print_fiche_titre($langs->trans("AddTarget"),'','');

// Form to add entry
print '<form name="externalrssconfig" action="'.$_SERVER["PHP_SELF"].'" method="post">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';

print '<table class="nobordernopadding" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("TargetType").'</td>';
print '<td>'.$langs->trans("TargetLang").'</td>';
print '<td>'.$langs->trans("Label").'</td>';
print '<td>'.$langs->trans("TitleLength").'</td>';
print '<td>'.$langs->trans("DescShortLength").'</td>';
print '<td>'.$langs->trans("DescLongLength").'</td>';
print '</tr>';

print '<tr class="liste_titre">';
// Type
print '<td width="200" align="left">';
print '<select class="flat" name="type" id="type">'."\n";
print '<option value="">&nbsp;</option>'."\n";
foreach($listoftargets as $key => $val)
{
    print '<option value="'.$key.'">'.$val['label'].'</option>'."\n";
}
print '</select>';
print '</td>';
// Language
print '<td align="left">';
print $htmladmin->select_language($langs->defaultlang);
print '</td>';
// Label
print '<td width="200">';
print '<input type="text" name="label" value="'.($_POST["label"]?$_POST["label"]:'').'">';
print '</td>';
// Title
print '<td><input type="text" name="titlelength" id="titlelength" value="" size="4" disabled="disabled"></td>';
print '<td><input type="text" name="descshortlength" id="descshortlength" value="" size="4" disabled="disabled"></td>';
print '<td><input type="text" name="desclonglength" id="desclonglength" value="" size="4" disabled="disabled"></td>';
print '</tr>';

print '<tr><td colspan="6" align="center"><br>';
print '<input type="submit" class="button" value="'.$langs->trans("Add").'">';
print '<input type="hidden" name="action" value="add">';
print '</td>';
print '</tr>';

print '</table>';
print '</form>';


print '<br>';


// Jquery interactions
print '<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery("#type").change(function(){
        if (jQuery("#type").val()==\'\') {
            jQuery("#titlelength").attr("disabled","disabled"); jQuery("#descshortlength").attr("disabled","disabled"); jQuery("#desclonglength").attr("disabled","disabled");
            jQuery("#titlelength").val(\'\'); jQuery("#descshortlength").val(\'\'); jQuery("#desclonglength").val(\'\');
        };
    ';
foreach($listoftargets as $key => $val)
{
    print 'if (jQuery("#type").val()==\''.$key.'\') {
        jQuery("#titlelength").removeAttr("disabled"); jQuery("#descshortlength").removeAttr("disabled"); jQuery("#desclonglength").removeAttr("disabled");
        jQuery("#titlelength").val('.$val['titlelength'].'); jQuery("#descshortlength").val('.$val['descshortlength'].'); jQuery("#desclonglength").val('.$val['desclonglength'].');
    } '."\n";
}
print '
    });
});
</script>
';


dol_htmloutput_mesg('',$errors,'error');



print_fiche_titre($langs->trans("ListOfAvailableTargets"),'','');

print '<table class="nobordernopadding" width="100%">';

$sql ="SELECT rowid, label, targetcode, langcode, url, login, pass, comment, position, titlelength, descshortlength, desclonglength";
$sql.=" FROM ".MAIN_DB_PREFIX."submitew_targets";
$sql.=" ORDER BY label";

dol_syslog("Get list of targets sql=".$sql,LOG_DEBUG);
$resql=$db->query($sql);
if ($resql)
{
	$num =$db->num_rows($resql);
	$i=0;

    print '<tr class="liste_titre">';
    print '<td width="200">'.$langs->trans("TargetType").'</td>';
    print '<td>'.$langs->trans("TargetLang").'</td>';
    print '<td width="200">'.$langs->trans("Label").'</td>';
    print '<td>'.$langs->trans("Length").'</td>';
    print '<td>'.$langs->trans("Login").'</td>';
    print '<td>'.$langs->trans("Password").'</td>';
    print '<td width="16px">&nbsp;</td>';
    print '</tr>';

	while ($i < $num)
	{
		$obj = $db->fetch_object($resql);

		print "<form name=\"updatetarget".$i."\" action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">";
		print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
        print '<input type="hidden" name="rowid" value="'.$obj->rowid.'">';

		$var=!$var;
		print "<tr ".$bc[$var].">";
        print '<td>';
        $s=picto_from_targetcode($obj->targetcode);
        print $s;
        print '</td>';
        print '<td>';
        $s=picto_from_langcode($obj->langcode);
        print $s;
        print '</td>';
		print '<td><input type="text" name="label'.$i.'" value="'.$obj->label.'"></td>';
        print '<td>'.$obj->titlelength.'/'.$obj->descshortlength.'/'.$obj->desclonglength.'</td>';
        print '<td><input type="text" name="login'.$i.'" value="'.$obj->login.'" size="8"></td>';
        print '<td><input type="password" name="pass'.$i.'" value="'.$obj->pass.'" size="8"></td>';
        print '<td nowrap="nowrap">';
        print '<input type="submit" name="submit" value="'.$langs->trans("Save").'" class="button"> &nbsp; ';
        print '<a href="'.$_SERVER["PHP_SELF"].'?action=delete&id='.$obj->rowid.'">'.img_picto($langs->trans("Delete"),'delete').'</a>';
        print "</tr>";

		print "</form>";

		$i++;
	}
}
else
{
	dol_print_error($db);
}

print '</table>'."\n";


$db->close();

llxFooter('$Date: 2011/06/20 19:34:16 $ - $Revision: 1.7 $');
?>
