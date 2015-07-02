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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class homebridge extends eqLogic {

    /*     * ***********************Methode static*************************** */
    
    public static function updatehomebridge() {
		log::remove('homebridge_update');
		$cmd = 'sudo /bin/bash ' . dirname(__FILE__) . '/../../ressources/install.sh';
		$cmd .= ' >> ' . log::getPathToLog('homebridge_update') . ' 2>&1 &';
		exec($cmd);
	}
	
    public static function cron() {
        if (!self::deamonRunning()) {
            self::runDeamon();
        }
    }
	
	public static function runDeamon() {
		if (!file_exists('/opt/homebridge/config.json')) {
			$response = array();
			$platform = array();
			$response['description']="Configuration Jeedom";
			$platform['platform']="Jeedom";
			$platform['name']="Jeedom";
			$platform['jeedom_ip']="127.0.0.1";
			$platform['jeedom_port']=config::byKey('internalPort');
			$platform['jeedom_url']=config::byKey('internalComplement') ;
			$platform['jeedom_api_key']=config::byKey('api');
			$response['platforms']=array();
			$response['platforms'][]=$platform;
			$response['accessories']=array();
			$fp = fopen('/opt/homebridge/config.json', 'w');
			fwrite($fp, json_encode($response));
			fclose($fp);
		}
		
        log::add('homebridge', 'info', 'Lancement du démon homebridge');
        $cmd = 'nice -n 19 /usr/bin/nodejs /opt/homebridge/app.js';	
        
        log::add('homebridge', 'info', 'Lancement démon homebridge : ' . $cmd);
        $result = exec('nohup ' . $cmd . ' >> ' . log::getPathToLog('homebridge') . ' 2>&1 &');
        if (!self::deamonRunning()) {
            sleep(10);
            if (!self::deamonRunning()) {
                log::add('homebridge', 'error', 'Impossible de lancer le démon homebridge', 'unableStartDeamon');
                return false;
            }
        }
        message::removeAll('homebridge', 'unableStartDeamon');
        log::add('homebridge', 'info', 'Démon homebridge lancé');
    }

    public static function deamonRunning() {
        $result = exec("ps -eo pid,command | grep 'app.js' | grep -v grep | awk '{print $1}'");
        if ($result == 0) {
            return false;
        }
        return true;
    }

    public static function stopDeamon() {
        if (!self::deamonRunning()) {
            return true;
        }
        $pid = exec("ps -eo pid,command | grep 'app.js' | grep -v grep | awk '{print $1}'");
        exec('kill ' . $pid);
        $check = self::deamonRunning();
        $retry = 0;
        while ($check) {
            $check = self::deamonRunning();
            $retry++;
            if ($retry > 10) {
                $check = false;
            } else {
                sleep(1);
            }
        }
        exec('kill -9 ' . $pid);
        $check = self::deamonRunning();
        $retry = 0;
        while ($check) {
            $check = self::deamonRunning();
            $retry++;
            if ($retry > 10) {
                $check = false;
            } else {
                sleep(1);
            }
        }

        return self::deamonRunning();
    }
	
	public function getModulesList($_options) {
			
		$modules=array();
		$eqLogics = eqLogic::byType('homebridge');
		$i=0;
		foreach ($eqLogics as $eqLogic) {
			$modules[$i]['name']=$eqLogic->getName();
			$modules[$i]['commands']['on']=str_replace('#', '', $eqLogic->getConfiguration('cmdOn'));
			$modules[$i]['commands']['off']=str_replace('#', '', $eqLogic->getConfiguration('cmdOff'));
			$modules[$i]['commands']['level']=str_replace('#', '', $eqLogic->getConfiguration('cmdLevel'));
			$modules[$i]['state']=str_replace('#', '', $eqLogic->getConfiguration('cmdState'));
			$i++;
		}
		
		return $modules;

    }
	

    /*     * *********************Methode d'instance************************* */

    public function preUpdate() {
        if ($this->getConfiguration('homebridge_id') == '') {
            //throw new Exception(__('Le client id ne peut être vide', __FILE__));
        }
        		
	}

    public function getShowOnChild() {
        return true;
    }

}

class homebridgeCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    public function dontRemoveCmd() {
        return true;
    }

    public function execute($_options = array()) {
        return $this->getValue();
    }

    /*     * **********************Getteur Setteur*************************** */
}

?>