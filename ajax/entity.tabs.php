<?php
/*
 * @version $Id$
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2009 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 --------------------------------------------------------------------------
 */

// ----------------------------------------------------------------------
// Original Author of file: Julien Dombre
// Purpose of file:
// ----------------------------------------------------------------------

$NEEDED_ITEMS=array('contract','document','entity', 'rulesengine', 'rule.ocs', 'rule.right',
                    'profile','user');

define('GLPI_ROOT', '..');
include (GLPI_ROOT . "/inc/includes.php");
header("Content-Type: text/html; charset=UTF-8");
header_nocache();

if (!isset($_POST["id"])) {
   exit();
}

$entity = new Entity();
$ocsrule = new OcsAffectEntityRule;
$ldaprule = new RightAffectRule;

if (!isset($_POST["start"])) {
   $_POST["start"]=0;
}

$entity->check($_POST["id"],'r');

if ($_POST["id"]>=0) {
   switch($_REQUEST['glpi_tab']) {
      case -1 :
         showEntityUser($_POST['target'],$_POST["id"]);
         showDocumentAssociated(ENTITY_TYPE,$_POST["id"]);
         $ldaprule->showAndAddRuleForm($_POST['target'],$_POST["id"]);
         if ($CFG_GLPI["use_ocs_mode"]) {
            $ocsrule->showAndAddRuleForm($_POST['target'],$_POST["id"]);
         }
         showEntityAdvancedOptions($_POST['target'],$_POST["id"]);
         displayPluginAction(ENTITY_TYPE,$_POST["id"],$_REQUEST['glpi_tab']);
         break;

      case 2 :
         showEntityUser($_POST['target'],$_POST["id"]);
         break;

      case 3 :
         $ldaprule->showAndAddRuleForm($_POST['target'],$_POST["id"]);
         if ($CFG_GLPI["use_ocs_mode"]) {
            $ocsrule->showAndAddRuleForm($_POST['target'],$_POST["id"]);
         }
         break;

      case 4 :
         showEntityAdvancedOptions($_POST['target'],$_POST["id"]);
         break;

      case 5 :
         showDocumentAssociated(ENTITY_TYPE,$_POST["id"]);
         break;

      default :
         if (!displayPluginAction(ENTITY_TYPE,$_POST["id"],$_REQUEST['glpi_tab'])) {
         }
   }
}

ajaxFooter();

?>