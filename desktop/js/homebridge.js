
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


$("#homebridge").delegate(".listEquipement", 'click', function() {
    var el = $(this);
    jeedom.eqLogic.getSelectModal({}, function(result) {
        var calcul = el.closest('div').find('.eqLogicAttr[data-l1key=configuration]');
        
        calcul.atCaret('insert', result.human);
    });
});

$("#homebridge").delegate(".listEquipementInfo", 'click', function() {
    var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function(result) {
        var calcul = el.closest('div').find('.eqLogicAttr[data-l1key=configuration]');
        
        calcul.atCaret('insert', result.human);
    });
});

$("#homebridge").delegate(".listEquipementAction", 'click', function() {
    var el = $(this);
    jeedom.cmd.getSelectModal({cmd: {type: 'action'}}, function(result) {
        var calcul = el.closest('div').find('.eqLogicAttr[data-l1key=configuration]');
        
        calcul.atCaret('insert', result.human);
    });
});

