-- ============================================================================
-- Copyright (C) 2002-2003 Rodolphe Quiedeville <rodolphe@quiedeville.org>
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
-- along with this program. If not, see <http://www.gnu.org/licenses/>.
--
-- ============================================================================

create table llx_c_payment_term
(
  rowid           integer PRIMARY KEY,
  code            varchar(16),
  sortorder       smallint,
  active          tinyint DEFAULT 1,
  libelle         varchar(255),
  libelle_facture text,
  fdm             tinyint,    -- reglement fin de mois
  nbjour          smallint,
  decalage		  smallint,
  module          varchar(32) NULL
)ENGINE=innodb;
