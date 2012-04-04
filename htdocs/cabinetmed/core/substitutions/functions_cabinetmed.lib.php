<?php
/* Copyright (C) 2011 Laurent Destailleur         <eldy@users.sourceforge.net>
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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 * or see http://www.gnu.org/
 */

/**
 *	\file			htdocs/cabinetmed/core/modules/substitutions/functions_cabinetmed.lib.php
 *	\brief			A set of functions for Dolibarr
 *					This file contains functions for plugin cabinetmed.
 */


/**
 * 		Function called to complete substitution array (before generating on ODT, or a personalized email)
 * 		functions xxx_completesubstitutionarray are called by make_substitutions() if file
 * 		is inside directory htdocs/core/substitutions
 *
 *		@param	array		$substitutionarray	Array with substitution key=>val
 *		@param	Translate	$langs				Output langs
 *		@param	Object		$object				Object to use to get values
 * 		@return	void							The entry parameter $substitutionarray is modified
 */
function cabinetmed_completesubstitutionarray(&$substitutionarray,$langs,$object)
{
	global $conf,$db;

	dol_include_once('/cabinetmed/class/cabinetmedcons.class.php');
    dol_include_once('/cabinetmed/class/cabinetmedexambio.class.php');
    dol_include_once('/cabinetmed/class/cabinetmedexamother.class.php');

    $langs->load("cabinetmed@cabinetmed");

    $isbio=0;
    $isother=0;

    $outcome=new CabinetmedCons($db);
    $result1=$outcome->fetch(GETPOST('idconsult'));

    if (GETPOST('idbio') > 0)
    {
        $exambio=new CabinetmedExamBio($db);
        $result2=$exambio->fetch(GETPOST('idbio'));
        $isbio=1;
    }

    if (GETPOST('idradio') > 0)
    {
        $examother=new CabinetmedExamOther($db);
        $result3=$examother->fetch(GETPOST('idradio'));
        $isother=1;
    }

    if ($isother || $isbio) $substitutionarray['examshows']=$langs->transnoentitiesnoconv("ExamsShow");
    else $substitutionarray['examshows']='';

    if ($isother)
    {
        $substitutionarray['examother_title']=$langs->transnoentitiesnoconv("BilanImage").':';
        $substitutionarray['examother_principal_and_conclusion']=$examother->examprinc.' : '.$examother->concprinc;
        $substitutionarray['examother_principal']=$examother->examprinc;
        $substitutionarray['examother_conclusion']=$examother->concprinc;
    }
    else
    {
        $substitutionarray['examother_title']='';
        $substitutionarray['examother_principal_and_conclusion']='';
        $substitutionarray['examother_principal']='';
        $substitutionarray['examother_conclusion']='';
    }
    if ($isbio)
    {
        if (! empty($exambio->conclusion)) $substitutionarray['exambio_title']=$langs->transnoentitiesnoconv("BilanBio").':';
        else $substitutionarray['exambio_title']='';
        $substitutionarray['exambio_conclusion']=$exambio->conclusion;
    }
    else
    {
        $substitutionarray['exambio_title']='';
        $substitutionarray['exambio_conclusion']='';
    }

    $substitutionarray['outcome_comment']=GETPOST('outcome_comment');
    $substitutionarray['outcome_reason']=$outcome->motifconsprinc;
    $substitutionarray['outcome_diagnostic']=$outcome->diaglesprinc;
    if (! empty($outcome->traitementprescrit))
    {
        $substitutionarray['treatment_title']=$langs->transnoentitiesnoconv("TreatmentSugested");
        $substitutionarray['outcome_treatment']=$outcome->traitementprescrit;
    }
    else
    {
        $substitutionarray['treatment_title']='';
        $substitutionarray['outcome_treatment']='';
    }
}
