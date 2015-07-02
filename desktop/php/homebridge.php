<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
$eqLogics=eqLogic::byType('homebridge');
sendVarToJS('eqType', 'homebridge');
?>

<div class="row row-overflow">
    <div class="col-md-2">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un équipement}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
                foreach ($eqLogics as $eqLogic) {
                    echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true,true) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
	    <legend>{{Mes commandes Homebridge}}
	    </legend>
	    <div class="eqLogicThumbnailContainer">
	      <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
	         <center>
	            <i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;"></i>
	        </center>
	        <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
	    </div>
	    <?php
	foreach ($eqLogics as $eqLogic) {
		echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
		echo "<center>";
		echo '<img src="plugins/homebridge/doc/images/homebridge_icon.png" height="105" width="95" />';
		echo "</center>";
		echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
		echo '</div>';
	}
	?>
	</div>
	</div>
    <div class="col-md-10 eqLogic" id="homebridge" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
        <form class="form-horizontal">
            <fieldset>
                <legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}<i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i></legend>
                <div class="form-group">
                    <label class="col-md-2 control-label">{{Nom de la commande homebridge}}</label>
                    <div class="col-md-3">
                        <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                        <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de la commande homebridge}}"/>
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-md-2 control-label" >{{Activer}}</label>
                    <div class="col-md-1">
                        <input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" size="16" checked/>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-md-2 control-label" >{{Module de la commande}}</label>
                    <div class="col-md-6">
                    	<input class="eqLogicAttr form-control input-sm" data-l1key="configuration" data-l2key="eqLogic" style="margin-top : 5px;" />
    					<a class="btn btn-default btn-sm cursor listEquipement" data-input="configuration" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" >{{Commande On}}</label>
                    <div class="col-md-6">
                    	<input class="eqLogicAttr form-control input-sm" data-l1key="configuration" data-l2key="cmdOn" style="margin-top : 5px;" />
    					<a class="btn btn-default btn-sm cursor listEquipementAction" data-input="configuration" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" >{{Commande Off}}</label>
                    <div class="col-md-6">
                    	<input class="eqLogicAttr form-control input-sm" data-l1key="configuration" data-l2key="cmdOff" style="margin-top : 5px;" />
    					<a class="btn btn-default btn-sm cursor listEquipementAction" data-input="configuration" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" >{{Commande Level}}</label>
                    <div class="col-md-6">
                    	<input class="eqLogicAttr form-control input-sm" data-l1key="configuration" data-l2key="cmdLevel" style="margin-top : 5px;" />
    					<a class="btn btn-default btn-sm cursor listEquipementAction" data-input="configuration" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" >{{Commande Etat}}</label>
                    <div class="col-md-6">
                    	<input class="eqLogicAttr form-control input-sm" data-l1key="configuration" data-l2key="cmdState" style="margin-top : 5px;" />
    					<a class="btn btn-default btn-sm cursor listEquipementInfo" data-input="configuration" style="margin-left : 5px;"><i class="fa fa-list-alt "></i> {{Rechercher équipement}}</a>
                    </div>
                </div>
                
            </fieldset> 
        </form>
		<form class="form-horizontal">
            <fieldset>
                <div class="form-actions">
                    <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
                    <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
                </div>
            </fieldset>
        </form>

    </div>
</div>

<?php include_file('desktop', 'homebridge', 'js', 'homebridge'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>