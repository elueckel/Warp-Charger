<?php

declare(strict_types=1);
	class WARPCharger extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();

			parent::Create();

			$this->RegisterPropertyString("ChargerAddress", "");
			$this->RegisterPropertyString("UserName", "");
			$this->RegisterPropertyString("Password", "");
			$this->RegisterPropertyInteger("Timer", "0");

			$this->RegisterPropertyBoolean("DataPointBasic", 1);
			$this->RegisterPropertyBoolean("DataPointHardware", 0);
			$this->RegisterPropertyBoolean("DataPointSpecific", 0);


			$this->RegisterTimer("WARP Charger", 0, "WC_GetData(\$_IPS['TARGET']);");
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();

			$this->RegisterVariableInteger("Current_State", $this->translate("Current State"));
			$this->RegisterVariableInteger("Vehicle_State", $this->translate("Vehicle State"));
			$this->RegisterVariableInteger("Contactor_State", $this->translate("Contactor State"));
			$this->RegisterVariableInteger("Contactor_Error", $this->translate("Contactor Error"));
			$this->RegisterVariableInteger("Charge_Release", $this->translate("Allowed Charging Current"));
			$this->RegisterVariableInteger("Allowed_Charging_Current", $this->translate("Current State"));
			$this->RegisterVariableInteger("Error_State", $this->translate("Error State"));
			$this->RegisterVariableInteger("Lock_State", $this->translate("Lock State"));
			$this->RegisterVariableString("Time_Since_State_Change", $this->translate("Time Since State Change"));

			$this->RegisterVariableInteger("Current_Charge_Power", $this->translate("Current Charge Power"));
			$this->RegisterVariableInteger("Energy_Since_Reset", $this->translate("Energy Since Reset"));
			$this->RegisterVariableInteger("Energy_Since_Production", $this->translate("Energy Sinde Production"));

			$this->RegisterVariableInteger("DC_Fault_Current_State", $this->translate("DC Fault Current State"));

			$TimerMS = $this->ReadPropertyInteger("Timer") * 1000;
			$this->SetTimerInterval("WARP Charger",$TimerMS);

		}

		public function GetData($APIEndPoint) {

			$ChargerAddress = $this->ReadPropertyString("ChargerAddress");
			$UserName = $this->ReadPropertyString("UserName");
			$Password = $this->ReadPropertyString("Password");

			//$APIEndPoint = "/evse/state";
			
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
				$this->SendDebug("Request Data","Login OK - Data: ".$Result, 0);
				$this->SetBuffer("JSON_Result_Charger",$Result);
			}
			else if ($http_code == "401") {
				$this->SendDebug("Request Data","Login Failure - Check Username or Password", 0);
			}
			else if ($http_code == "0") {
				$this->SendDebug("Request Data","General Failure - Check charger ID", 0);
			}

			

		}

		public function GetState() 
		{
			$this->GetData($APIEndPoint = "/evse/state");
			$JSON_Result_Charger = $this->GetBuffer("JSON_Result_Charger");
			$this->SetBuffer("JSON_Result_Charger","");
			$this->SendDebug($this->Translate("Charger State"), $JSON_Result_Charger, 0);

			$DataPoints = json_decode($JSON_Result_Charger,true);
			SetValue($this->GetIDForIdent("Current_State"),$DataPoints["iec61851_state"]);


		}

		public function MessageSink($TimeStamp, $SenderID, $Message, $Data)
		{
			$this->SendDebug($this->Translate("Sender"), $SenderID, 0);
			$this->SetBuffer("SenderID", $SenderID);

			SetBuffer(SenderID, $SenderID);	
			$this->SetData();		
		}

		public function SetData() {

			$SenderID = GetBuffer(SenderID);


		}
	}