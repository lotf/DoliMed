<?php
/* Copyright (C) 2010-2011 Regis Houssin       <regis@dolibarr.fr>
 * Copyright (C) 2010-2011 Laurent Destailleur <eldy@users.sourceforge.net>
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
 *
 */
?>

<!-- BEGIN PHP TEMPLATE predefinedproductline_view.tpl.php -->
<tr <?php echo 'id="row-'.$line->id.'" '.$bcdd[$var]; ?>>
	<?php if (! empty($conf->global->MAIN_VIEW_LINE_NUMBER)) { ?>
	<td align="center"><?php echo ($i+1); ?></td>
	<?php } ?>
	<td><div id="<?php echo $line->id; ?>"></div>
	<?php
	echo $form->textwithtooltip($text,$description,3,'','',$i,0,($line->fk_parent_line?img_picto('', 'rightarrow'):''));

	// Show range
	print_date_range($line->date_start, $line->date_end);

	// Add description in form
	if ($conf->global->PRODUIT_DESC_IN_FORM)
	{
		print ($line->description && $line->description!=$line->product_label)?'<br>'.dol_htmlentitiesbr($line->description):'';
	}
	?>
	</td>

	<td align="right" nowrap="nowrap"><?php echo vatrate($line->tva_tx,'%',$line->info_bits); ?></td>

	<td align="right" nowrap="nowrap"><?php echo price($line->subprice); ?></td>

	<td align="right" nowrap="nowrap">
	<?php if ((($line->info_bits & 2) != 2) && $line->special_code != 3) echo $line->qty;
		else echo '&nbsp;';	?>
	</td>

	<?php if (!empty($line->remise_percent) && $line->special_code != 3) { ?>
	<td align="right"><?php echo dol_print_reduction($line->remise_percent,$langs); ?></td>
	<?php } else { ?>
	<td>&nbsp;</td>
	<?php } ?>

	<?php if ($line->special_code == 3)	{ ?>
	<td align="right" nowrap="nowrap"><?php echo $langs->trans('Option'); ?></td>
	<?php } else { ?>
	<td align="right" nowrap="nowrap"><?php echo price($line->total_ht); ?></td>
	<?php } ?>

	<?php if ($this->statut == 0  && $user->rights->$element->creer) { ?>
	<td align="center">
		<?php if (($line->info_bits & 2) == 2) { ?>
		<?php } else { ?>
		<a href="<?php echo $_SERVER["PHP_SELF"].'?id='.$this->id.'&amp;action=editline&amp;lineid='.$line->id.'#'.$line->id; ?>">
		<?php echo img_edit(); ?>
		</a>
		<?php } ?>
	</td>

	<td align="center">
		<a href="<?php echo $_SERVER["PHP_SELF"].'?id='.$this->id.'&amp;action=ask_deleteline&amp;lineid='.$line->id; ?>">
		<?php echo img_delete(); ?>
		</a>
	</td>

	<?php if ($num > 1) { ?>
	<td align="center" class="tdlineupdown">
		<?php if ($i > 0) { ?>
		<a class="lineupdown" href="<?php echo $_SERVER["PHP_SELF"].'?id='.$this->id.'&amp;action=up&amp;rowid='.$line->id; ?>">
		<?php echo img_up(); ?>
		</a>
		<?php } ?>
		<?php if ($i < $num-1) { ?>
		<a class="lineupdown" href="<?php echo $_SERVER["PHP_SELF"].'?id='.$this->id.'&amp;action=down&amp;rowid='.$line->id; ?>">
		<?php echo img_down(); ?>
		</a>
		<?php } ?>
	</td>
	<?php } else { ?>
	<td align="center" class="tdlineupdown">&nbsp;</td>
	<?php } ?>
<?php } else { ?>
	<td colspan="3">&nbsp;</td>
<?php } ?>

</tr>
<!-- END PHP TEMPLATE predefinedproductline_view.tpl.php -->
