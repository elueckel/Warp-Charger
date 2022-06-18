<?php

declare(strict_types=1);
	class WARP2Charger extends IPSModule	{

		public function Create() {
			//Never delete this line!
			parent::Create();

			parent::Create();

			$this->RegisterPropertyString("ChargerAddress", "");
			$this->RegisterPropertyString("UserName", "");
			$this->RegisterPropertyString("Password", "");
			$this->RegisterPropertyInteger("Timer", "0");

			$this->RegisterTimer("WARP Charger", 0, "WC_Update(\$_IPS['TARGET']);");

			if (IPS_VariableProfileExists("WC.iec61851_state") == false) {
				IPS_CreateVariableProfile("WC.iec61851_state", 1);
				IPS_SetVariableProfileIcon("WC.iec61851_state", "Information");
				IPS_SetVariableProfileAssociation("WC.iec61851_state", 0, $this->Translate('A: Not Connected'), "", -1);
				IPS_SetVariableProfileAssociation("WC.iec61851_state", 1, $this->Translate('B: Connected'), "", -1);
				IPS_SetVariableProfileAssociation("WC.iec61851_state", 2, $this->Translate('C: Loading'), "", -1);
				IPS_SetVariableProfileAssociation("WC.iec61851_state", 3, $this->Translate('D: Loading with airification'), "", -1);
				IPS_SetVariableProfileAssociation("WC.iec61851_state", 4, $this->Translate('E/F: Error'), "", -1);
			}

			if (IPS_VariableProfileExists("WC.charger_state") == false) {
				IPS_CreateVariableProfile("WC.charger_state", 1);
				IPS_SetVariableProfileIcon("WC.charger_state", "Information");
				IPS_SetVariableProfileAssociation("WC.charger_state", 0, $this->Translate('Not Connected'), "", -1);
				IPS_SetVariableProfileAssociation("WC.charger_state", 1, $this->Translate('Waiting for charger clearance'), "", -1);
				IPS_SetVariableProfileAssociation("WC.charger_state", 2, $this->Translate('Ready for charging'), "", -1);
				IPS_SetVariableProfileAssociation("WC.charger_state", 3, $this->Translate('Charging'), "", -1);
				IPS_SetVariableProfileAssociation("WC.charger_state", 4, $this->Translate('Error'), "", -1);
			}

			if (IPS_VariableProfileExists("WC.contactor_state") == false) {
				IPS_CreateVariableProfile("WC.contactor_state", 1);
				IPS_SetVariableProfileIcon("WC.contactor_state", "Electricity");
				IPS_SetVariableProfileAssociation("WC.contactor_state", 0, $this->Translate('Not current carrying before and after contactor'), "", -1);
				IPS_SetVariableProfileAssociation("WC.contactor_state", 1, $this->Translate('Current carrying before, but not after contactor'), "", -1);
				IPS_SetVariableProfileAssociation("WC.contactor_state", 2, $this->Translate('Not current carrying before, but after contactor'), "", -1);
				IPS_SetVariableProfileAssociation("WC.contactor_state", 3, $this->Translate('Current carrying before and after contactor'), "", -1);
			}

			if (IPS_VariableProfileExists("WC.allowed_charging_current") == false) {
				IPS_CreateVariableProfile("WC.allowed_charging_current", 1);
				IPS_SetVariableProfileIcon("WC.allowed_charging_current", "Electricity");
				IPS_SetVariableProfileText("WC.allowed_charging_current", "", " mA");
			}

			if (IPS_VariableProfileExists("WC.error_state") == false) {
				IPS_CreateVariableProfile("WC.error_state", 1);
				IPS_SetVariableProfileIcon("WC.error_state", "Information");
				IPS_SetVariableProfileAssociation("WC.error_state", 0, $this->Translate('OK'), "", -1);
				IPS_SetVariableProfileAssociation("WC.error_state", 1, $this->Translate('Switch Error'), "", -1);
				IPS_SetVariableProfileAssociation("WC.error_state", 2, $this->Translate('Callibration Error'), "", -1);
				IPS_SetVariableProfileAssociation("WC.error_state", 3, $this->Translate('Contactor Error'), "", -1);
				IPS_SetVariableProfileAssociation("WC.error_state", 4, $this->Translate('Communication Error'), "", -1);
			}

			if (IPS_VariableProfileExists("WC.lock_state") == false) {
				IPS_CreateVariableProfile("WC.lock_state", 1);
				IPS_SetVariableProfileIcon("WC.lock_state", "Lock");
				IPS_SetVariableProfileAssociation("WC.lock_state", 0, $this->Translate('Initialization'), "", -1);
				IPS_SetVariableProfileAssociation("WC.lock_state", 1, $this->Translate('Open'), "", -1);
				IPS_SetVariableProfileAssociation("WC.lock_state", 2, $this->Translate('Closing'), "", -1);
				IPS_SetVariableProfileAssociation("WC.lock_state", 3, $this->Translate('Closed'), "", -1);
				IPS_SetVariableProfileAssociation("WC.lock_state", 4, $this->Translate('Opening'), "", -1);
				IPS_SetVariableProfileAssociation("WC.lock_state", 5, $this->Translate('Error'), "", -1);
			}

			if (IPS_VariableProfileExists("WC.time_sine_state_change") == false) {
				IPS_CreateVariableProfile("WC.time_sine_state_change", 1);
				IPS_SetVariableProfileIcon("WC.time_sine_state_change", "Clock");
				IPS_SetVariableProfileText("WC.time_sine_state_change", "", $this->Translate("Minutes"));
			}

			if (IPS_VariableProfileExists("WC.kWh") == false) {
				IPS_CreateVariableProfile("WC.kWh", 2);
				IPS_SetVariableProfileIcon("WC.kWh", "Clock");
				IPS_SetVariableProfileText("WC.kWh", "", " kWh");
			}

			$this->RegisterVariableInteger("Current_State", $this->translate("iec 61851 Current State"), "WC.iec61851_state");
            $this->RegisterVariableInteger("Charger_State", $this->translate("Charger State"), "WC.charger_state");
            $this->RegisterVariableInteger("Contactor_State", $this->translate("Contactor State"), "WC.contactor_state");
            $this->RegisterVariableInteger("Contactor_Error", $this->translate("Contactor Error Code"));
            $this->RegisterVariableInteger("Allowed_Charging_Current", $this->translate("Allowed Charging Current"), "WC.allowed_charging_current");
            $this->RegisterVariableInteger("Error_State", $this->translate("Error State"), "WC.error_state");
            $this->RegisterVariableInteger("Lock_State", $this->translate("Lock State"), "WC.lock_state");
            //$this->RegisterVariableString("Time_Since_State_Change", $this->translate("Minutes Since State Change"));

            $this->RegisterVariableFloat("Current_Charge_Power", $this->translate("Energy Current Charge Power"), "~Watt.14490");
            $this->RegisterVariableFloat("Energy_Since_Reset", $this->translate("Energy Since Reset"), "WC.kWh");
            $this->RegisterVariableFloat("Energy_Since_Production", $this->translate("Energy Since Production"), "WC.kWh");

			$this->RegisterVariableBoolean("Trigger_Start_Charging", $this->translate("_Start Charging"), "~Switch");
			$this->RegisterVariableBoolean("Trigger_Stop_Charging", $this->translate("_Stop Charging"), "~Switch");
			$this->RegisterVariableInteger("Max_Charging_Current", $this->translate("_Maximum Charge Current"));

			$this->EnableAction("Trigger_Start_Charging");
			$this->RegisterMessage(IPS_GetObjectIDByIdent("Trigger_Start_Charging", $this->InstanceID), VM_UPDATE);

			$this->EnableAction("Trigger_Stop_Charging");
			$this->RegisterMessage(IPS_GetObjectIDByIdent("Trigger_Stop_Charging", $this->InstanceID), VM_UPDATE);

			$this->EnableAction("Max_Charging_Current");
            $this->RegisterMessage(IPS_GetObjectIDByIdent("Max_Charging_Current", $this->InstanceID), VM_UPDATE);

		}

		public function Destroy() {
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges() {
			//Never delete this line!
			parent::ApplyChanges();
			
			$TimerMS = $this->ReadPropertyInteger("Timer") * 1000;
			$this->SetTimerInterval("WARP Charger",$TimerMS);
		}

		public function Update() {
			$this->SendDebug("Request Data", "Timed Data Receiver", 0);
			$this->GetState();
			$this->GetMeterReading();
		}

		public function GetData($APIEndPoint) {

			$ChargerAddress = $this->ReadPropertyString("ChargerAddress");
			$UserName = $this->ReadPropertyString("UserName");
			$Password = $this->ReadPropertyString("Password");
			
			$URL = 'http://'.$ChargerAddress.$APIEndPoint;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $URL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
			curl_setopt($ch, CURLOPT_USERNAME, $UserName);
			curl_setopt($ch, CURLOPT_PASSWORD, $Password);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC | CURLAUTH_DIGEST);
			$Result = curl_exec($ch);

			$http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
			$Error = curl_error($ch);

			if ($http_code == "200") {
				$this->SendDebug("Request Data","Login OK - HTTP code recveied: ".$http_code, 0);
				$this->SetBuffer("JSON_Result_Charger",$Result);
			}
			else if ($http_code == "401") {
				$this->SendDebug("Request Data","Login Failure - Check Username or Password - HTTP code recveied: ".$http_code, 0);
			}
			else if ($http_code == "0") {
				$this->SendDebug("Request Data","General Failure - Check charger IP - HTTP code recveied: ".$http_code, 0);
			}

		}

		public function GetState() {

			$this->GetData($APIEndPoint = "/evse/state");
			$JSON_Result_Charger = $this->GetBuffer("JSON_Result_Charger");
			$this->SetBuffer("JSON_Result_Charger","");
			$this->SendDebug($this->Translate("Charger State"), $JSON_Result_Charger, 0);

			$DataPointsState = json_decode($JSON_Result_Charger,true);
			SetValue($this->GetIDForIdent("Current_State"),$DataPointsState["iec61851_state"]);
            SetValue($this->GetIDForIdent("Charger_State"), $DataPointsState["charger_state"]);
            SetValue($this->GetIDForIdent("Contactor_State"), $DataPointsState["contactor_state"]);
			SetValue($this->GetIDForIdent("Contactor_Error"), $DataPointsState["contactor_error"]);
			SetValue($this->GetIDForIdent("Error_State"), $DataPointsState["error_state"]);
			SetValue($this->GetIDForIdent("Lock_State"), $DataPointsState["lock_state"]);
		}

		public function GetMeterReading() {

			$this->GetData($APIEndPoint = "/meter/values");
			$JSON_Result_Charger = $this->GetBuffer("JSON_Result_Charger");
			$this->SetBuffer("JSON_Result_Charger","");
			$this->SendDebug($this->Translate("Meter Reading"), $JSON_Result_Charger, 0);

			$DataPointMeter = json_decode($JSON_Result_Charger,true);
			SetValue($this->GetIDForIdent("Current_Charge_Power"),$DataPointMeter["power"]);
            SetValue($this->GetIDForIdent("Energy_Since_Reset"), $DataPointMeter["energy_rel"]);
            SetValue($this->GetIDForIdent("Energy_Since_Production"), $DataPointMeter["energy_abs"]);
		}

		public function MessageSink($TimeStamp, $SenderID, $Message, $Data)	{

			//$this->SendDebug($this->Translate("Sender"), $SenderID, 0);
			$this->SetBuffer("SenderID", $SenderID);

			switch ($SenderID) {
				case $this->GetIDForIdent("Trigger_Start_Charging"):
					if (GetValue($SenderID) == true) {
						SetValue($SenderID, false);
						$this->SendDebug($this->Translate("Command Received"), $this->Translate("Start Charging"), 0);
						$this->TriggerCharger($APIEndPoint = "/evse/start_charging",$Payload = "");
					} elseif (GetValue($SenderID) == false) {
                    	//$this->SendDebug($this->Translate("Command Received"), $this->Translate("Start Charging is false"), 0);
                    	exit;
                	}
				break;

				case $this->GetIDForIdent("Trigger_Stop_Charging"):
					if (GetValue($SenderID) == true) {
						SetValue($SenderID, false);
						$this->SendDebug($this->Translate("Command Received"), $this->Translate("Stop Charging"), 0);
						$this->TriggerCharger($APIEndPoint = "/evse/stop_charging",$Payload = "");
					} elseif (GetValue($SenderID) == false) {
						//$this->SendDebug($this->Translate("Command Received"), $this->Translate("Stop Charging is false"), 0);
						exit;
					}
				break;

				case $this->GetIDForIdent("Max_Charging_Current"):
					$Maximum_Charging_Current = GetValue($this->GetIDForIdent("Max_Charging_Current"));
					$this->SendDebug($this->Translate("Command Received"), $this->Translate("Change Maximum Charging Current to: ").$Maximum_Charging_Current, 0);
                    $this->TriggerCharger($APIEndPoint = "/evse/global_current_update", $Payload = $Maximum_Charging_Current);
				break;


			}

		}

		public function TriggerCharger($APIEndPoint, $Payload) {

			$this->SendDebug("Send Command", "Contacting Charger ".$APIEndPoint." Payload: ".$Payload, 0);

			$ChargerAddress = $this->ReadPropertyString("ChargerAddress");
            $UserName = $this->ReadPropertyString("UserName");
            $Password = $this->ReadPropertyString("Password");

			if ($Payload == "") {
				$Payload = "{}";
				$data_JSON = $Payload;
			} else {
				$data_JSON = json_encode($Payload);
			}  

            $URL = 'http://'.$ChargerAddress.$APIEndPoint;
			
            $ch = curl_init();
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch, CURLOPT_URL, $URL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$headers = array(); 
			$headers[] = 'Content-Type: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
            curl_setopt($ch, CURLOPT_USERNAME, $UserName);
            curl_setopt($ch, CURLOPT_PASSWORD, $Password);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_JSON);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC | CURLAUTH_DIGEST);
            $Result = curl_exec($ch);

            $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE );
			$this->SendDebug($this->Translate("Send Command"), $this->Translate("HTTP CODE: ").$http_code, 0);
            $Error = curl_error($ch);

			if ($APIEndPoint == "/evse/start_charging") {
				$Command = "start";
			}
			else {
				$Command = "stop";
			}

            if ($http_code == "200") {
                $this->SendDebug("Send Command", "Login OK - Command sent: ".$Command." charging - HTTP code recveied: ".$http_code, 0);
            } elseif ($http_code == "401") {
                $this->SendDebug("Send Command", "Login Failure - Check Username or Password - HTTP code recveied: ".$http_code, 0);
            } elseif ($http_code == "0") {
                $this->SendDebug("Send Command", "General Failure - Check charger IP - HTTP code recveied: ".$http_code, 0);
            }

		}

		public function RequestAction($Ident, $Value) {
			$this->SetValue($Ident, $Value);
		}

		public function TurnArchivingOn() {
            $archiveID = IPS_GetInstanceListByModuleID('{43192F0B-135B-4CE7-A0A7-1475603F3060}')[0];
			$Current_Charge_Power_Id = $this->GetIDForIdent("Current_Charge_Power");
            $Energy_Since_Reset_Id = $this->GetIDForIdent("Energy_Since_Reset");
            $Energy_Since_Production_Id = $this->GetIDForIdent("Energy_Since_Production");
         
			AC_SetLoggingStatus($archiveID, $Current_Charge_Power_Id, true);
            AC_SetAggregationType($archiveID, $Current_Charge_Power_Id, 0);
            AC_SetLoggingStatus($archiveID, $Energy_Since_Reset_Id, true);
            AC_SetAggregationType($archiveID, $Energy_Since_Reset_Id, 1);
            AC_SetLoggingStatus($archiveID, $Energy_Since_Production_Id, true);
            AC_SetAggregationType($archiveID, $Energy_Since_Production_Id, 1);
            IPS_ApplyChanges($archiveID);
        }

	}
