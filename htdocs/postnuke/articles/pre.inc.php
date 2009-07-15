<?php
/* Copyright (C) 2003 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2009 Laurent Destailleur  <eldy@users.sourceforge.net>
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
 *		\file 		htdocs/postnuke/pre.inc.php
 *		\ingroup    postnuke
 *		\brief      File to manage left menu for postnuke module
 *		\version    $Id: pre.inc.php,v 1.2 2009/07/15 13:55:20 eldy Exp $
 */

define('NOCSRFCHECK',1);

$res=@include("../main.inc.php");
if (! $res) $res=@include("../../main.inc.php");	// If pre.inc.php is called by jawstats
if (! $res) $res=@include("../../../dolibarr/htdocs/main.inc.php");		// Used on dev env only
if (! $res) $res=@include("../../../../dolibarr/htdocs/main.inc.php");	// Used on dev env only


function llxHeader($head = "", $title="", $help_url = "")
{
	global $user, $conf, $langs;

	/*
	 *
	 *
	 */
	top_menu($head, $title);

	$menu = new Menu();

	$menu->add(DOL_URL_ROOT."/boutique/livre/", $langs->trans("Livres"));

	$menu->add(DOL_URL_ROOT."/boutique/auteur/", $langs->trans("Auteurs"));

	$menu->add(DOL_URL_ROOT."/boutique/editeur/", $langs->trans("Editeurs"));

	$menu->add(DOL_URL_ROOT."/product/categorie/", $langs->trans("Categories"));

	$menu->add(DOL_URL_ROOT."/product/promotion/", $langs->trans("Promotions"));

	$menu->add(DOL_URL_ROOT."/postnuke/index.php", $langs->trans("Editorial"));

	left_menu($menu->liste);
}
?>
