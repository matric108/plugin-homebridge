<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
    include_file('desktop', '404', 'php');
    die();
}
$deamonRunningMaster = homebridge::deamonRunning();
echo '<form class="form-horizontal">';
echo '<fieldset>';
echo '<div class="form-group">';
echo '<label class="col-sm-4 control-label">{{Démon homebridge}}</label>';
if (!$deamonRunningMaster) {
	echo '<div class="col-sm-1"><span class="label label-danger tooltips" style="font-size : 1em;">NOK</span></div>';
} else {
	echo '<div class="col-sm-1"><span class="label label-success" style="font-size : 1em;">OK</span></div>';
}
echo '</div>';
if (exec('sudo cat /etc/sudoers')<>"") {
?>

    <div class="form-group">
        <label class="col-lg-4 control-label">{{Installer/Mettre à jour les dépendances}}</label>
        <div class="col-lg-3">
            <a class="btn btn-danger" id="bt_installDeps"><i class="fa fa-check"></i> {{Lancer}}</a>
        </div>
    </div>
    <?php }else{?>
    <div class="form-group">
        <label class="col-lg-4 control-label">{{Installation automatique impossible}}</label>
        <div class="col-lg-8">
            {{Veuillez lancer la commande suivante :}} wget http://127.0.0.1/jeedom/plugins/homebridge/ressources/install.sh -v -O install.sh; ./install.sh
        </div>
    </div>
    <?php }?>
    <div class="form-group">
		<label class="col-sm-4 control-label">{{Gestion du démon}}</label>
		<div class="col-sm-8">
			<a class="btn btn-success" id="bt_starthomebridgeDemon"><i class='fa fa-play'></i> {{(Re)démarrer}}</a>
			<a class="btn btn-danger" id="bt_stophomebridgeDemon"><i class='fa fa-stop'></i> {{Arrêter}}</a>
		</div>
	</div>
    </fieldset>
</form>
<script>
$('#bt_installDeps').on('click',function(){
    bootbox.confirm('{{Etes-vous sûr de vouloir installer/mettre à jour les dépendances ? }}', function (result) {
      if (result) {
		  $('#md_modal').dialog({title: "{{Installation / Mise à jour}}"});
          $('#md_modal').load('index.php?v=d&plugin=homebridge&modal=update.homebridge').dialog('open');
    }
});
});

$('#bt_stophomebridgeDemon').on('click', function() {
	stophomebridgeDemon();
});

$('#bt_starthomebridgeDemon').on('click', function() {
	starthomebridgeDemon();
});
		
function stophomebridgeDemon() {
$.ajax({// fonction permettant de faire de l'ajax
    type: "POST", // methode de transmission des données au fichier php
    url: "plugins/homebridge/core/ajax/homebridge.ajax.php", // url du fichier php
    data: {
    	action: "stopDeamon"
    },
    dataType: 'json',
    error: function(request, status, error) {
    	handleAjaxError(request, status, error);
    },
    success: function(data) { // si l'appel a bien fonctionné
    if (data.state != 'ok') {
    	$('#div_alert').showAlert({message: data.result, level: 'danger'});
    	return;
    }
    $('#div_alert').showAlert({message: 'Le démon a été correctement arreté', level: 'success'});
    $('#ul_plugin .li_plugin[data-plugin_id=homebridge]').click();
    }
});

}

function starthomebridgeDemon() {
    $.ajax({// fonction permettant de faire de l'ajax
    type: "POST", // methode de transmission des données au fichier php
    url: "plugins/homebridge/core/ajax/homebridge.ajax.php", // url du fichier php
    data: {
    	action: "startDeamon"
    },
    dataType: 'json',
    error: function(request, status, error) {
    	handleAjaxError(request, status, error);
    },
    success: function(data) { // si l'appel a bien fonctionné
    if (data.state != 'ok') {
    	$('#div_alert').showAlert({message: data.result, level: 'danger'});
    	return;
    }
    $('#div_alert').showAlert({message: 'Le démon a été correctement lancé', level: 'success'});
    $('#ul_plugin .li_plugin[data-plugin_id=homebridge]').click();
    }
});
}
</script>