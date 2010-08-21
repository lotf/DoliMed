-- ===================================================================
-- Copyright (C) 2000-2006 Rodolphe Quiedeville <rodolphe@quiedeville.org>
-- Copyright (C) 2005-2008 Laurent Destailleur  <eldy@users.sourceforge.net>
--
-- This program is free software; you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation; either version 2 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program; if not, write to the Free Software
-- Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
--
-- $Id: llx_filemanager_roots.sql,v 1.1 2010/08/18 22:10:40 eldy Exp $
-- ===================================================================

create table llx_filemanager_roots
(
  rowid           integer AUTO_INCREMENT PRIMARY KEY,
  datec           datetime,
  rootlabel       varchar(64),
  rootpath		  text,
  note            text,
  position        integer,
  entity          integer
)type=innodb;