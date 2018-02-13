public static function getCustomerLicenseInfo($customerid = 0, $use_keyname = false) {
		$customerid = intval($customerid);

		if (! $customerid > 0) {
			$customerid = S::A()->id;

			if (! $customerid > 0){
				return false;
			}
		}


		$adapter = DatabaseServer::getPrimaryAdapter();

		$sql = "SELECT <redacted>";

		$results = $adapter->fetchAll($sql);

		$lic = array();

		$var = $use_keyname ? 'sKeyName' : 'sName';
		foreach($results as $r) {
			if($r['iUserID']) {
					$lic['seatsUsed'][$r[$var]]['Allocated']++;
					$lic['seatsPurchased'][$r[$var]]++;
					$lic['seatsUsed'][$r[$var]]['Users'][$r['iUserID']] = (int)$r['iUserID'];
			}	else {
					$lic['seatsAvailable'][$r[$var]]++;
					$lic['seatsPurchased'][$r[$var]]++;
			}
		}

		$results = $lic;
		return $results;
	}

