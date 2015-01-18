<?php
/*
** Zabbix
** Copyright (C) 2001-2015 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


$sysmapWidget = new CWidget();

// create header buttons
$createForm = new CForm('get');
$createForm->cleanItems();
$createForm->addItem(new CSubmit('form', _('Create map')));
$createForm->addItem(new CButton('form', _('Import'), 'redirect("conf.import.php?rules_preset=map")'));

$sysmapWidget->addPageHeader(_('CONFIGURATION OF NETWORK MAPS'), $createForm);

// create form
$sysmapForm = new CForm();
$sysmapForm->setName('frm_maps');

$sysmapWidget->addHeader(_('Maps'));
$sysmapWidget->addHeaderRowNumber();

// create table
$sysmapTable = new CTableInfo(_('No maps found.'));
$sysmapTable->setHeader(array(
	new CCheckBox('all_maps', null, "checkAll('".$sysmapForm->getName()."', 'all_maps', 'maps');"),
	make_sorting_header(_('Name'), 'name', $this->data['sort'], $this->data['sortorder']),
	make_sorting_header(_('Width'), 'width', $this->data['sort'], $this->data['sortorder']),
	make_sorting_header(_('Height'), 'height', $this->data['sort'], $this->data['sortorder']),
	_('Edit')
));

foreach ($this->data['maps'] as $map) {
	$sysmapTable->addRow(array(
		new CCheckBox('maps['.$map['sysmapid'].']', null, null, $map['sysmapid']),
		new CLink($map['name'], 'sysmap.php?sysmapid='.$map['sysmapid']),
		$map['width'],
		$map['height'],
		new CLink(_('Edit'), 'sysmaps.php?form=update&sysmapid='.$map['sysmapid'].'#form')
	));
}

// append table to form
$sysmapForm->addItem(array(
	$this->data['paging'],
	$sysmapTable,
	$this->data['paging'],
	get_table_header(
	new CActionButtonList(
		'action',
		'maps',
		array(
			'map.export' => array('name' => _('Export')),
			'map.massdelete' => array('name' => _('Delete'), 'confirm' => _('Delete selected maps?'))
		)
	))
));

// append form to widget
$sysmapWidget->addItem($sysmapForm);

return $sysmapWidget;
