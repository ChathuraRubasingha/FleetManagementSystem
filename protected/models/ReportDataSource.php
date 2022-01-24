<?php

class ReportDataSource
{
    public function ArrayVehicleInventry($MaLocation,$VehicleCategory)
    {
        $Result=array();	
        //--Selected GN Level Report--
        if($MaLocation!='' AND $VehicleCategory!='')
        {

            $cm='
            SELECT
            l.Location_ID,
            l.Location_Name,
            l.Telephone,
            vc.Vehicle_Category_ID,
            vc.Category_Name,
            vr.Vehicle_Category_ID,
            vr.Vehicle_No,
            mo.Model,
            m.Make,
            vr.Chassis_No,
            vr.Engine_No
            FROM
            ma_location l,
            ma_vehicle_category vc,
            ma_vehicle_registry vr,
            ma_model mo,
            ma_make m
            WHERE
                l.Location_ID=vc.Vehicle_Category_ID AND
                vc.Vehicle_Category_ID=vr.Vehicle_Category_ID AND
                vr.Vehicle_Category_ID="'.$VehicleCategory.'"';
            $array = Yii::app()->db->createCommand($cm)->queryAll();
                            //print_r($cm);exit;
            return($array);	

        }
        else if ($VehicleCategory=='' )
        {
            $cm='
            SELECT
                l.Location_ID,
                l.Location_Name,
                l.Telephone,
                vc.Vehicle_Category_ID,
                vc.Category_Name,
                vr.Vehicle_Category_ID,
                vr.Vehicle_No,
                vr.Model,
                vr.Make,
                vr.Chassis_No,
                vr.Engine_No
            FROM
                ma_location l,
                ma_vehicle_category vc,
                ma_vehicle_registry vr
            WHERE
                    l.Location_ID="'.$MaLocation.'"';
        $array = Yii::app()->db->createCommand($cm)->queryAll();
			//print_r($cm);exit;
			return($array);	
    }


}



public function ArrayVehicleDetails($Vehicle_No)
{
	$cmd = 'SELECT 
	VR.Vehicle_No, 
	VC.Category_Name, 
	VR.Purchase_Value, 
	VR.Purchase_Date, 
	VR.Engine_No, 
	VR.Chassis_No,
	VR.Vehicle_image,
	FT.Fuel_Type, 
	TS.Tyre_Size, 
	TT.Tyre_Type, 
	VR.No_of_Tyres, 
	ma.Make,
	mo.Model, 
	BT.Battery_Type, 
	VS.Vehicle_Status, 
	VR.Service_Mileage, 
	VR.Servicing_Period, 
	VR.Fuel_Consumption,
	VR.Fitness_test, 
	ATY.Allocation_Type, 
	VR.odometer
	FROM ma_vehicle_registry VR 
	INNER JOIN ma_vehicle_category VC ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
	INNER JOIN ma_fuel_type FT ON VR.Fuel_Type_ID = FT.Fuel_Type_ID
	INNER JOIN ma_tyre_size TS ON VR.Tyre_Size_ID = TS.Tyre_Size_ID
	INNER JOIN ma_make ma ON ma.Make_ID = VR.Make_ID
	INNER JOIN ma_model mo ON mo.Model_ID = VR.Model_ID
	INNER JOIN ma_tyre_type TT ON VR.Tyre_Type_ID = TT.Tyre_Type_ID
	INNER JOIN ma_battery_type BT ON VR.Battery_Type_ID = BT.Battery_Type_ID
	LEFT JOIN ma_vehicle_status VS ON VR.Vehicle_Status_ID = VS.Vehicle_Status_ID
	INNER JOIN ma_allocation_type ATY ON VR.Allocation_Type_ID = ATY.Allocation_Type_ID
	WHERE VR.Vehicle_No = "'.$Vehicle_No.'" ';
	
	$array = Yii::app()->db->createCommand($cmd)->queryAll();
	return($array);	
}


	public function ArrayRegulataryReqReminders()
	{
		$cmd="Select Vehicle_No,Vehicle_Category_ID,Make,Model,'Service','EmissionTest','FitnessTest','Licence' from ma_vehicle_registry";
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
		return($array);	
	}

	public function ArrayVehicleCategory($vCatID)
	{
		
		
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);
		
        if ($superuserstatus != 1)
        {
            $cmd = 'SELECT VR.Vehicle_No, format(VR.Purchase_Value,2) as "Purchase_Value", VR.Purchase_Date, VR.Engine_No,
            VR.Chassis_No, mo.Model, ma.Make, A.Allocation_Type, VR.odometer, VS.Vehicle_Status,
            VC.Category_Name,ml.Location_Name 
            FROM ma_vehicle_registry VR INNER JOIN ma_allocation_type A 
			ON VR.Allocation_Type_ID = A.Allocation_Type_ID
            left JOIN ma_vehicle_status VS 
			ON VR.Vehicle_Status_ID = VS.Vehicle_Status_ID
            INNER JOIN ma_vehicle_category VC  
			ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            inner join ma_model mo on mo.Model_ID = VR.Model_ID
            inner join ma_make ma on ma.Make_ID = VR.Make_ID 
            INNER JOIN vehicle_location vl ON vl.Vehicle_No = VR.Vehicle_No
			INNER JOIN ma_location ml ON ml.Location_ID = vl.Location_ID

            WHERE  vl.Current_Location_ID ="'.$LocId.'" and VR.Vehicle_Category_ID = "'.$vCatID.'"
            ORDER BY Allocation_Type';
        }
        else
        {
            $cmd = 'SELECT VR.Vehicle_No, format(VR.Purchase_Value,2) as "Purchase_Value", VR.Purchase_Date, VR.Engine_No,
            VR.Chassis_No, mo.Model, ma.Make, A.Allocation_Type, VR.odometer, VS.Vehicle_Status,
            VC.Category_Name,ml.Location_Name 
            FROM ma_vehicle_registry VR INNER JOIN ma_allocation_type A 
            ON VR.Allocation_Type_ID = A.Allocation_Type_ID
            left JOIN ma_vehicle_status VS
            ON VR.Vehicle_Status_ID = VS.Vehicle_Status_ID
            INNER JOIN ma_vehicle_category VC
            ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            inner join ma_model mo on mo.Model_ID = VR.Model_ID
            inner join ma_make ma on ma.Make_ID = VR.Make_ID
			INNER JOIN vehicle_location vl ON vl.Vehicle_No = VR.Vehicle_No
			INNER JOIN ma_location ml ON ml.Location_ID = vl.Location_ID
            
			WHERE VR.Vehicle_Category_ID = "'.$vCatID.'"
            ORDER BY Allocation_Type';
        }

	
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
	
		return($array);	
	}
	
	
	public function ArrayVehicleStatus($vStatusID)
	{
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        if ($superuserstatus != 1)
        {
            $cmd = 'SELECT VR.Vehicle_No, format(VR.Purchase_Value,2) as Purchase_Value, VR.Purchase_Date, VR.Engine_No,
            VR.Chassis_No, mo.Model, ma.Make, A.Allocation_Type, VR.odometer, VS.Vehicle_Status,
            VC.Category_Name
            FROM ma_vehicle_registry VR INNER JOIN ma_allocation_type A ON VR.Allocation_Type_ID = A.Allocation_Type_ID
            left JOIN ma_vehicle_status VS  ON VR.Vehicle_Status_ID = VS.Vehicle_Status_ID
            INNER JOIN ma_vehicle_category VC  ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            inner join ma_model mo on mo.Model_ID = VR.Model_ID
            inner join ma_make ma on ma.Make_ID = VR.Make_ID
            INNER JOIN vehicle_location vl ON vl.Vehicle_No = VR.Vehicle_No

            WHERE  vl.Current_Location_ID ="'.$LocId.'" and VS.Vehicle_Status_ID = "'.$vStatusID.'"
            ORDER BY Allocation_Type,Make,Model,Vehicle_No';
        }
        else
        {
            $cmd = 'SELECT VR.Vehicle_No, format(VR.Purchase_Value,2) as Purchase_Value, VR.Purchase_Date, VR.Engine_No,
            VR.Chassis_No, mo.Model, ma.Make, A.Allocation_Type, VR.odometer, VS.Vehicle_Status,
            VC.Category_Name
            FROM ma_vehicle_registry VR INNER JOIN ma_allocation_type A
            ON VR.Allocation_Type_ID = A.Allocation_Type_ID
            left JOIN ma_vehicle_status VS
            ON VR.Vehicle_Status_ID = VS.Vehicle_Status_ID
            INNER JOIN ma_vehicle_category VC
            ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            inner join ma_model mo on mo.Model_ID = VR.Model_ID
            inner join ma_make ma on ma.Make_ID = VR.Make_ID
            WHERE VS.Vehicle_Status_ID = "'.$vStatusID.'"
            ORDER BY Allocation_Type,Make,Model,Vehicle_No';
        }

	
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
	
		return($array);	
	}
	
        public function ArrayVehicleBooking($vFromDate, $vToDate, $bookingStatus)
        {
            $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
            $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

            $select = "select
                    prof.firstname as 'username',
                    if (vb.Booking_Status ='Assigned' || Booking_Status ='Completed', ba.Vehicle_No, vb.Vehicle_No) as 'Vehicle_No',
                    if(vb.Booking_Status ='Assigned' || Booking_Status ='Completed', d.Full_Name, '') as 'Full_Name',
                    vc.Category_Name,
                    if (vb.Booking_Status ='Assigned' || Booking_Status ='Completed', ba.New_Booking_Request_Date, vb.From) as 'From',
                    if (vb.Booking_Status ='Assigned' || Booking_Status ='Completed', ba.New_Booking_To_Date, vb.To) as 'To',
                    ba.No_of_Pessengers,
                    vb.Booking_Status,vb.Description,
                    date(vb.Requested_Date) as 'Requested_Date',
                    ba.Mileage,
                    ba.In_Time,
                    ba.Out_Time,
                    vb.Place_from,
                    vb.Place_to ";
            $select2 = "select
                prof.firstname as 'username',
                vb.Vehicle_No,
                d.Full_Name,
                vc.Category_Name,
                date(vb.Requested_Date) as 'Requested_Date',
                vb.From,
                vb.To,
                vb.No_of_Passengers,
                vb.Booking_Status,vb.Description,
                vb.Place_from,
                vb.Place_to ";
            
            $from = " from vehicle_booking vb ";
            
            $join = " left join booking_approval ba on ba.Booking_Approval_ID = vb.Booking_Approval_ID
                    inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vb.Vehicle_Category_ID
                    left join ma_driver d on d.Driver_ID = ba.Driver_ID
                    inner join tbl_users usr on usr.id = vb.User_ID
                    inner join tbl_profiles prof on prof.user_id = usr.id";
            
            $where =" WHERE (vb.From >= '$vFromDate'  AND vb.To <= '$vToDate') ";
            $order = " ORDER BY vb.Booking_Status, vb.From ";
            
            
            if($bookingStatus =='All')
            {
                if ($superuserstatus != 1)
                {
                    $where .=" and vl.Current_Location_ID ='$LocId' ";
                    $join .= " INNER JOIN vehicle_location vl ON vl.Vehicle_No =vb.Vehicle_No ";                    
                }                
            }
            elseif($bookingStatus =='Assigned' || $bookingStatus =='Completed' || $bookingStatus =='Rejected')
            {
                if ($superuserstatus != 1)
                {
                    $where .= " and vl.Current_Location_ID ='$LocId' and vb.Booking_Status ='$bookingStatus' ";
                    $join .= " INNER JOIN vehicle_location vl ON vl.Vehicle_No =vb.Vehicle_No ";                    			
                }
                else
                {
                    $where .= " and vb.Booking_Status ='$bookingStatus' ";                    
                }
            }
            elseif($bookingStatus =='Disapproved' || $bookingStatus =='Pending' || $bookingStatus=='Approved')
            {
                $select = $select2;
                
                if ($superuserstatus != 1)
                {
                    $where .= " and  vl.Current_Location_ID ='$LocId' and vb.Booking_Status ='$bookingStatus' ";
                    $join .= " INNER JOIN vehicle_location vl ON vl.Vehicle_No =vb.Vehicle_No ";
                }
                else
                {
                    $select = $select2;
                    $where .= " and vb.Booking_Status ='$bookingStatus' ";
                }   
            }
            $cmd = $select.$from.$join.$where.$order;		
            $array = Yii::app()->db->createCommand($cmd)->queryAll();	
            return($array);	
	}
	
	public function Arrayinsurance($vFromDate,$vToDate,$vCategory)
	{
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        if ($superuserstatus != 1)
        {
            $cmd = 'Select
            VC.Category_Name,
            VR.Vehicle_No,
            IC.Insurance_Company_Name,
            IT.Insurance_Type,
            format(I.Amount,2) as Amount,
            format(I.Sum_Insured,2) as Sum_Insured,
            I.Date_of_Insurance,
            I.Valid_To
            From insurance I
            Inner Join ma_vehicle_registry VR On I.Vehicle_No = VR.Vehicle_No
            Inner Join ma_vehicle_category VC On VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            Inner Join ma_insurance_type IT on I.Insurance_Type_ID =  IT.Insurance_Type_ID
            Inner Join ma_insurance_company IC on I.Insurance_Company_ID = IC.Insurance_Company_ID

             INNER JOIN vehicle_location vl ON vl.Vehicle_No = VR.Vehicle_No

            WHERE (VR.Vehicle_Category_ID="'.$vCategory.'" AND vl.Current_Location_ID ="'.$LocId.'"  AND I.Valid_To BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';

        }
        else
        {
            $cmd = 'Select
            VC.Category_Name,
            VR.Vehicle_No,
            IC.Insurance_Company_Name,
            IT.Insurance_Type,
            format(I.Amount,2) as Amount,
            format(I.Sum_Insured,2) as Sum_Insured,
            I.Date_of_Insurance,
            I.Valid_To
            From insurance I
            Inner Join ma_vehicle_registry VR On I.Vehicle_No = VR.Vehicle_No
            Inner Join ma_vehicle_category VC On VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            Inner Join ma_insurance_type IT on I.Insurance_Type_ID =  IT.Insurance_Type_ID
            Inner Join ma_insurance_company IC on I.Insurance_Company_ID = IC.Insurance_Company_ID
            WHERE (VR.Vehicle_Category_ID="'.$vCategory.'" AND I.Valid_To BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';

        }

		//(vehicle_booking.From BETWEEN '".$vFromDate."' AND '".$vtoDate."') OR (vehicle_booking.To BETWEEN       '".$vFromDate."' AND '".$vToDate."'))";
	
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
	
		return($array);	
	}
	
	public function ArrayEmissionTest($valFrom,$valTo)
	{
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        if ($superuserstatus != 1)
        {
            $cmd = 'SELECT ET.Vehicle_No,
            VC.Category_Name,
            ET.Valid_From,
            ET.Valid_To,
            EC.Company_Name,
            FORMAT(ET.Amount,2) as "Amount"
            FROM emission_test ET
            INNER JOIN ma_emission_test_company EC ON ET.Emission_Test_Company_ID = EC.Emission_Test_Company_ID
            INNER JOIN ma_vehicle_registry VR ON ET.Vehicle_No = VR.Vehicle_No
            INNER JOIN ma_vehicle_category VC ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            INNER JOIN vehicle_location vl ON vl.Vehicle_No = ET.Vehicle_No

            WHERE  vl.Current_Location_ID ="'.$LocId.'" and  ET.Valid_To BETWEEN "'.$valFrom.'" AND "'.$valTo.'"';
        }
        else
        {
            $cmd = 'SELECT ET.Vehicle_No,
            VC.Category_Name,
            ET.Valid_From,
            ET.Valid_To,
            EC.Company_Name,
            FORMAT(ET.Amount,2) as "Amount"
            FROM emission_test ET
            INNER JOIN ma_emission_test_company EC ON ET.Emission_Test_Company_ID = EC.Emission_Test_Company_ID
            INNER JOIN ma_vehicle_registry VR ON ET.Vehicle_No = VR.Vehicle_No
            INNER JOIN ma_vehicle_category VC  ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            WHERE ET.Valid_To BETWEEN "'.$valFrom.'" AND "'.$valTo.'"';
        }

	
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
	
		return($array);	
	}
	
	public function ArrayRevenueLicense($valFrom,$valTo)
	{

        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

		$cmd = 'SELECT
		l.Vehicle_No,VC.Category_Name As Category,
		l.Date_of_License,
		format(l.Amount,2) as Amount,
		l.Valid_From,
		l.Valid_To
		FROM license l
		INNER JOIN vehicle_location vl ON vl.Vehicle_No = l.Vehicle_No  
		INNER JOIN ma_vehicle_registry VR ON VR.Vehicle_No=vl.Vehicle_No 
		INNER JOIN ma_vehicle_category VC ON VC.Vehicle_Category_ID = VR.Vehicle_Category_ID';
		
		if ($superuserstatus != 1)
        {
			$cmd =$cmd. ' WHERE vl.Current_Location_ID ="'.$LocId.'" and l.Valid_To BETWEEN "'.$valFrom.'" AND "'.$valTo.'"';
		}
        else
        {
            $cmd =$cmd.' WHERE l.Valid_To BETWEEN "'.$valFrom.'" AND "'.$valTo.'"';
        }
		
		 $cmd =$cmd.'ORDER BY VC.Category_Name,l.Valid_To';
	
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
	
		return($array);		
	}
	
	
	
	
	public function ArrayUserwiseBooking($valFrom,$valTo, $user)
	{

            $cmd = 'select
            usr.username,
            if (vb.Booking_Status ="Approved" || Booking_Status ="Completed", ba.Vehicle_No, vb.Vehicle_No) as "Vehicle_No",
            if(vb.Booking_Status ="Approved" || Booking_Status ="Completed", d.Full_Name, "") as "Full_Name",
            vc.Category_Name,
            vb.From,
            vb.To,vb.Description,
            vb.Requested_Date ,
            ba.No_of_Pessengers,
            vb.Booking_Status,
            ba.Mileage,
            ba.In_Time,
            ba.Out_Time,
            vb.Place_from,
            vb.Place_to from

                vehicle_booking vb
                left join booking_approval ba on ba.Booking_Approval_ID = vb.Booking_Approval_ID

                inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vb.Vehicle_Category_ID
                inner join ma_driver d on d.Driver_ID = ba.Driver_ID
                inner join tbl_users usr on usr.id = vb.User_ID

                WHERE User_ID ="'.$user.'"and (vb.From BETWEEN "'.$valFrom.'" AND "'.$valTo.'") ORDER BY vb.From';

			
			$array = Yii::app()->db->createCommand($cmd)->queryAll();
	
		return($array);	
		
	}
	
	public function ArrayMileageInfo($vCatID)
	{
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        if ($superuserstatus != 1)
        {
           /* $criteria->mergeWith(array('join'=>'LEFT JOIN vehicle_location vl ON vl.Vehicle_No = t.Vehicle_No', 'condition'=>'vl.Location_ID ='.$LocId,));
            $criteria->compare('vl.Location_ID',$this->Location_ID,true);*/

            $cmd ='SELECT
            VR.Vehicle_No,
            VR.Engine_No,
            VR.Chassis_No,
            ma.Make,
            mo.Model,
            FT.Fuel_Type,
            BT.Battery_Type,
            VR.Service_Mileage,
            VR.Servicing_Period,
            VR.odometer,
            VC.Category_Name
            FROM
            ma_vehicle_registry VR
            INNER JOIN ma_make ma ON ma.Make_ID = VR.Make_ID
            INNER JOIN ma_model mo ON mo.Model_ID = VR.Model_ID
            INNER JOIN ma_fuel_type FT ON VR.Fuel_Type_ID = FT.Fuel_Type_ID
            INNER JOIN ma_battery_type BT ON VR.Battery_Type_ID = BT.Battery_Type_ID
            INNER JOIN ma_vehicle_category VC ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            INNER JOIN vehicle_location vl ON vl.Vehicle_No = VR.Vehicle_No
            WHERE (VR.Vehicle_Category_ID =  "'.$vCatID.'") and vl.Current_Location_ID ="'.$LocId.'" ORDER BY VR.Service_Mileage DESC, VR.odometer';

        }
        else
        {
            $cmd ='SELECT
            VR.Vehicle_No,
            VR.Engine_No,
            VR.Chassis_No,
            ma.Make,
            mo.Model,
            FT.Fuel_Type,
            BT.Battery_Type,
            VR.Service_Mileage,
            VR.Servicing_Period,
            VR.odometer,
            VC.Category_Name
            FROM
            ma_vehicle_registry VR
            INNER JOIN ma_make ma ON ma.Make_ID = VR.Make_ID
            INNER JOIN ma_model mo ON mo.Model_ID = VR.Model_ID
            INNER JOIN ma_fuel_type FT ON VR.Fuel_Type_ID = FT.Fuel_Type_ID
            INNER JOIN ma_battery_type BT ON VR.Battery_Type_ID = BT.Battery_Type_ID
            INNER JOIN ma_vehicle_category VC ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID

            WHERE (VR.Vehicle_Category_ID =  "'.$vCatID.'") ORDER BY VR.Service_Mileage DESC, VR.odometer';
        }

	
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
	
		return($array);	
	}
	
	public function ArrayVehicleAllocation($vA_ID)
	{
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        if ($superuserstatus != 1)
        {
            $cmd = 'SELECT
            VR.Vehicle_No,
            VC.Category_Name,
            ma.Make,
            mo.Model,
            VS.Vehicle_Status,VR.Number_of_Passenger,
            VR.Fitness_test,
            AT.Allocation_Type
            FROM ma_vehicle_registry VR
            INNER JOIN ma_vehicle_category VC ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            left JOIN ma_vehicle_status VS ON VR.Vehicle_Status_ID = VS.Vehicle_Status_ID
            INNER JOIN ma_allocation_type AT ON VR.Allocation_Type_ID = AT.Allocation_Type_ID
            INNER JOIN ma_make ma ON ma.Make_ID = VR.Make_ID
            INNER JOIN ma_model mo ON mo.Model_ID = VR.Model_ID
            INNER JOIN vehicle_location vl ON vl.Vehicle_No = VR.Vehicle_No

            WHERE(vl.Current_Location_ID ="'.$LocId.'" and VR.Allocation_Type_ID = "'.$vA_ID.'")
            ORDER BY Category_Name'
                ;

        }
        else
        {
            $cmd = 'SELECT
            VR.Vehicle_No,
            VC.Category_Name,
            ma.Make,
            mo.Model,
            VS.Vehicle_Status,
            VR.Fitness_test,VR.Number_of_Passenger,
            AT.Allocation_Type
            FROM ma_vehicle_registry VR
            INNER JOIN ma_vehicle_category VC ON VR.Vehicle_Category_ID = VC.Vehicle_Category_ID
            left JOIN ma_vehicle_status VS ON VR.Vehicle_Status_ID = VS.Vehicle_Status_ID
            INNER JOIN ma_allocation_type AT ON VR.Allocation_Type_ID = AT.Allocation_Type_ID
            INNER JOIN ma_make ma ON ma.Make_ID = VR.Make_ID
            INNER JOIN ma_model mo ON mo.Model_ID = VR.Model_ID
            WHERE(VR.Allocation_Type_ID = "'.$vA_ID.'")
            ORDER BY Category_Name'
            ;

        }

		$array = Yii::app()->db->createCommand($cmd)->queryAll();
	
		return($array);	
	}
	
	public function ArrayVehicleRepaire($Vehicle_No, $vFromDate, $vToDate)
	{
		$cmd = 'SELECT 
		R.Repaired_Date AS "Repaired Date", 
		G.Garage_Name AS "Garage",
		format(R.Repair_Cost,2)  AS "Repair Cost",
		format(E.Total_Estimate,2) as "Estimate",
		E.Estimate_Date as "Estimate Date" 
		FROM
		vehicle_repair_details R	
		INNER JOIN ma_garages G ON G.Garage_ID = R.Garage_ID
		INNER JOIN repair_estimate_details E ON E.Estimate_ID = R. 	Estimate_ID
		WHERE (R.Vehicle_No = "'.$Vehicle_No.'" AND R.Repaired_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';
		
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
		return($array);	
	}

	public function ArrayVehicleService($Vehicle_No, $vFromDate, $vToDate)
	{
		$cmd = 'SELECT
		S.Service_Date AS "Service Date", 
		SS.Srvice_Station_Name AS "Service Station", 
		ST.Service_Type AS "Service Type", 
		S.Meter_Reading AS "Meter Reading", 
		S.Next_Service_Date AS "Next Service Date",
		S.Next_Service_Milage AS "Next Service Milage",
		S.Driving_Distance AS "Driving Distance", 
		FORMAT(S.Estimate_Cost,2) AS "Service Cost",FORMAT(S.Other_Costs,2) AS "Other Cost" 
		FROM
		services S
		LEFT JOIN ma_service_station SS ON S.Service_Station_ID = SS.Service_Station_ID
		LEFT JOIN ma_service_type ST ON S.Service_Type_ID = ST.Service_Type_ID
		WHERE (S.Vehicle_No = "'.$Vehicle_No.'" AND S.Service_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';
		
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
		return($array);	
	}
	

	public function ArrayVehicleLicense_Maintenance($Vehicle_No, $vFromDate, $vToDate)
	{
		$cmd = 'SELECT
		Date_of_License AS "Date of License", 
		Valid_From AS "Valid From", 
		Valid_To AS "Valid To",
		FORMAT(Amount,2) as Amount
		FROM
		license L
		WHERE (L.Vehicle_No = "'.$Vehicle_No.'" AND L.Date_of_License BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';
		
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
		return($array);	
	}

public function ArrayVehicleFitness_Maintenance($Vehicle_No, $vFromDate, $vToDate)
{
	$cmd = 'SELECT
	Fitness_Test_Date AS "Date of Fitness Test",
	Valid_From AS "Valid From",
	Valid_To AS "Valid To",
	Fitness_Test_Result AS "Fitness Test Result",
	FORMAT(Amount,2) as Amount
	FROM fitness_test FT
    WHERE (FT.Vehicle_No = "'.$Vehicle_No.'" AND FT.Fitness_Test_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';
	
	$array = Yii::app()->db->createCommand($cmd)->queryAll();
	return($array);	
}

public function ArrayVehicleEmissionTest_Maintenance($Vehicle_No, $vFromDate, $vToDate)
{
	$cmd = 'SELECT
	Emission_Test_Date AS "Date of Emission Test",
	Valid_From AS "Valid From", 
	Valid_To AS "Valid To",
	Emission_Test_Result AS "Emission Test Result",
	FORMAT(Amount,2) AS Amount
	FROM emission_test ET
    WHERE (ET.Vehicle_No = "'.$Vehicle_No.'" AND ET.Emission_Test_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';
	
	$array = Yii::app()->db->createCommand($cmd)->queryAll();
	return($array);	
}

	public function ArrayVehicleInsurance_Maintenance($Vehicle_No, $vFromDate, $vToDate)
	{
		$cmd = 'SELECT
		I.Date_of_Insurance AS "Date of Insurance",
		I.Valid_From AS "Valid From", 
		I.Valid_To AS "Valid To",
		IC.Insurance_Company_Name AS "Company Name", 
		IT.Insurance_Type AS "Insurance Type",
		FORMAT(I.Amount,2) AS "Insurance Amount",
		FORMAT(I.Sum_Insured,2) AS "Sum Insured"
		FROM
		insurance I
		INNER JOIN ma_insurance_company IC ON I.Insurance_Company_ID = IC.Insurance_Company_ID
		INNER JOIN ma_insurance_type IT ON I.Insurance_Type_ID = IT.Insurance_Type_ID
		WHERE (I.Vehicle_No = "'.$Vehicle_No.'" AND I.Date_of_Insurance BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';
		
		$array = Yii::app()->db->createCommand($cmd)->queryAll();
		return($array);	
	}

public function ArrayVehicleBattery_Maintenance($Vehicle_No, $vFromDate, $vToDate)
{
	$cmd = 'SELECT
	BD.Replace_Date AS "Replace Date",
	BT.Battery_Type AS "Battery Type",
	BD.Approved_Date AS "Approved Date",
	BD.Approved_By AS "Approved By",
	BD.Replace_Status AS "Replace Status",
	FORMAT(BD.Cost,2) AS Cost
    FROM
	battery_details BD
	INNER JOIN ma_battery_type BT ON BD.Battery_Type_ID = BT.Battery_Type_ID
    WHERE (BD.Vehicle_No = "'.$Vehicle_No.'" AND BD.Replace_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';
	
	$array = Yii::app()->db->createCommand($cmd)->queryAll();
	return($array);	
}

public function ArrayVehicleTyre_Maintenance($Vehicle_No, $vFromDate, $vToDate)
{
	$cmd = 'SELECT
	TD.Replace_Date AS "Replace Date",
	TT.Tyre_Type AS "Tyre Type",
	TS.Tyre_Size AS "Tyre Size",
	TD.Approved_Status AS "Approved Status",
	TD.Replace_Status AS "Replace Status",
	FORMAT(TD.Cost,2) as Cost
    FROM
	tyre_details TD
	INNER JOIN ma_tyre_type TT ON TD.Tyre_Type_ID = TT.Tyre_Type_ID
	INNER JOIN ma_tyre_size TS ON TD.Tyre_Size_ID = TS.Tyre_Size_ID
    WHERE (TD.Vehicle_No = "'.$Vehicle_No.'" AND TD.Replace_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'")';
	
	$array = Yii::app()->db->createCommand($cmd)->queryAll();
	return($array);	
}	

public function ArrayFittnessTest($Valid_From,$Valid_To)
{
    $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
    $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

    if ($superuserstatus != 1)
    {
        $cmd = 'SELECT FT.Vehicle_No,VR.Purchase_Value, VR.Purchase_Date ,VC.Category_Name, VR.Engine_No ,VR.Chassis_No,mo.Model,ma.Make ,FT.Garage_ID, FT.Valid_From, FT.Valid_To, VR.Fitness_test
        FROM fitness_test FT
        INNER JOIN ma_vehicle_registry VR ON FT.Vehicle_No = VR.Vehicle_No
        INNER JOIN ma_vehicle_category VC ON VC.Vehicle_Category_ID = VR.Vehicle_Category_ID
        INNER JOIN ma_make ma ON ma.Make_ID = VR.Make_ID
        INNER JOIN ma_model mo ON mo.Model_ID = VR.Model_ID
         INNER JOIN vehicle_location vl ON vl.Vehicle_No = FT.Vehicle_No
        where vl.Current_Location_ID ="'.$LocId.'" and VR.Fitness_test ="Yes" And FT.Valid_To BETWEEN "'.$Valid_From.'" AND "'.$Valid_To.'" ORDER BY VC.Category_Name,FT.Valid_To';
    }
    else
    {
        $cmd = 'SELECT FT.Vehicle_No,VR.Purchase_Value, VR.Purchase_Date ,VC.Category_Name, VR.Engine_No ,VR.Chassis_No,mo.Model,ma.Make ,FT.Garage_ID, FT.Valid_From, FT.Valid_To, VR.Fitness_test
        FROM fitness_test FT
        INNER JOIN ma_vehicle_registry VR ON FT.Vehicle_No = VR.Vehicle_No
        INNER JOIN ma_vehicle_category VC ON VC.Vehicle_Category_ID = VR.Vehicle_Category_ID
        INNER JOIN ma_make ma ON ma.Make_ID = VR.Make_ID
        INNER JOIN ma_model mo ON mo.Model_ID = VR.Model_ID
        where VR.Fitness_test ="Yes" And FT.Valid_To BETWEEN "'.$Valid_From.'" AND "'.$Valid_To.'" ORDER BY VC.Category_Name,FT.Valid_To';
    }

	$array = Yii::app()->db->createCommand($cmd)->queryAll();
	return($array);	
}
############################For fuel constumption reports #########################################################################
	public function ArrayFuelConsumptionbyVehicle($Vehicle_No, $vFromDate, $vToDate)
	{
		$cmd = "SELECT
		 FP.Fuel_Pumped_Date AS 'Date',
		 FP.Fuel_Amount AS 'Volumn(L)     (a)',
		 format(FP.Payable_Amount,2) AS 'Amount(Rs)      (b)',
		 FR.Meter_Reading AS 'Starting Odometer      (c)',
		 FP.Distance_Driven AS 'Distance Driven(km)        (d)',
		 format((FP.Fuel_Amount * 100 / FP.Distance_Driven),2) AS 'Liters per 100km(L/100km)    (a*100)/d'
         FROM fuel_providing_details FP INNER JOIN
         fuel_request_details FR ON FP.Fuel_Request_ID = FR.Fuel_Request_ID
         WHERE
		 (FP.Vehicle_No = '".$Vehicle_No."' AND FP.Fuel_Pumped_Date BETWEEN '".$vFromDate."' AND '".$vToDate."' AND FP.Distance_Driven IS NOT NULL) ORDER BY FP.Fuel_Pumped_Date DESC";
		  $array = Yii::app()->db->createCommand($cmd)->queryAll();
	    return($array);			
		
	}
	public function ArrayFuelConsumptionbyVehicleInSummary($Vehicle_No, $vFromDate, $vToDate)
	{
		$cmd = 'SELECT
		 SUM(FP.Fuel_Amount) AS "Total Volume(L)",
		 format(SUM(FP.Payable_Amount),2) AS "Total Amount(Rs)",
		 SUM(FP.Distance_Driven) AS "Total Distance Driven(km)",
		 format(SUM(FP.Fuel_Amount * 100 / FP.Distance_Driven),2) AS "Total LPKM"
         FROM fuel_providing_details FP
         WHERE
		 (FP.Vehicle_No = "'.$Vehicle_No.'" AND FP.Fuel_Pumped_Date BETWEEN "'.$vFromDate.'" AND "'.$vToDate.'" AND FP.Distance_Driven IS NOT NULL)';
		  $array = Yii::app()->db->createCommand($cmd)->queryAll();
	    return($array);		
	}
	
	public function ArrayFuelConsumptionbyVehicleAll($vFromDate, $vToDate)
	{
		$cmd = "SELECT
		 FP.Vehicle_No AS 'Vehicle No.',
		 SUM(FP.Fuel_Amount) AS 'Volumn(L)     (a)',
		 format(SUM(FP.Payable_Amount),2) AS 'Amount(Rs)      (b)',
		 SUM(FP.Distance_Driven) AS 'Distance Driven(km)        (d)',
		 format(SUM(FP.Fuel_Amount * 100 / FP.Distance_Driven),2) AS 'Liters per 100km(L/100km)    (a*100)/d'
         FROM fuel_providing_details FP
         WHERE
		 (FP.Fuel_Pumped_Date BETWEEN'".$vFromDate."' AND '".$vToDate."' AND FP.Distance_Driven IS NOT NULL) GROUP BY FP.Vehicle_No ORDER BY SUM(FP.Fuel_Amount * 100 / FP.Distance_Driven) DESC";
		  $array = Yii::app()->db->createCommand($cmd)->queryAll();
		 return($array);			
		
	}
	################# For Driver Performance Report ##########################################################################################
	public function ArrayFuelDriverPerformance($vFromDate, $vToDate)
	{
        $LocId = (Yii::app()->getModule('user')->user()->Location_ID);
        $superuserstatus = (Yii::app()->getModule('user')->user()->superuser);

        if ($superuserstatus != 1)
        {
            $cmd = "SELECT d.Full_Name AS 'Driver Name' ,
             d.NIC,
             SUM(dr.Rate_By_Accident) AS 'Rate in Accident',
             SUM(dr.Rate_By_Service) AS 'Rate in Service Replacement',
             SUM(dr.Rate_By_Battery) AS 'Rate in Battery Replacement',
             SUM(dr.Rate_By_Tire) AS 'Rate in Tire Replacement',
             SUM(dr.Rate_By_Accident) + SUM(dr.Rate_By_Service) + SUM(dr.Rate_By_Battery) + SUM(dr.Rate_By_Tire) AS 'Rate in Total'
             FROM driver_rating dr INNER JOIN ma_driver d ON dr.Driver_ID = d.Driver_ID
             WHERE (d.Location_ID =$LocId and dr.Date_Rated BETWEEN'".$vFromDate."' AND '".$vToDate."')
             GROUP BY dr.Driver_ID ORDER BY SUM(dr.Rate_By_Accident) + SUM(dr.Rate_By_Service) + SUM(dr.Rate_By_Battery) + SUM(dr.Rate_By_Tire) DESC";
        }
        else
        {
            $cmd = "SELECT ma_driver.Full_Name AS 'Driver Name' ,
             ma_driver.NIC,
             SUM(driver_rating.Rate_By_Accident) AS 'Rate in Accident',
             SUM(driver_rating.Rate_By_Service) AS 'Rate in Service Replacement',
             SUM(driver_rating.Rate_By_Battery) AS 'Rate in Battery Replacement',
             SUM(driver_rating.Rate_By_Tire) AS 'Rate in Tire Replacement',
             SUM(driver_rating.Rate_By_Accident) + SUM(driver_rating.Rate_By_Service) + SUM(driver_rating.Rate_By_Battery) + SUM(driver_rating.Rate_By_Tire) AS 'Rate in Total'
             FROM driver_rating INNER JOIN ma_driver ON driver_rating.Driver_ID = ma_driver.Driver_ID
             WHERE (driver_rating.Date_Rated BETWEEN'".$vFromDate."' AND '".$vToDate."')
             GROUP BY driver_rating.Driver_ID ORDER BY SUM(driver_rating.Rate_By_Accident) + SUM(driver_rating.Rate_By_Service) + SUM(driver_rating.Rate_By_Battery) + SUM(driver_rating.Rate_By_Tire) DESC";

        }
     	 $array = Yii::app()->db->createCommand($cmd)->queryAll();
		 return($array);			
		
	}
	
	public function ArrayDriverPerformancebyDriver($Driver_ID, $vFromDate, $vToDate)
	{
		$cmd = "SELECT 
		 Date_Rated AS 'Date Rated',
		 Rate_By_Accident AS 'Rate in Accident', 
		 Rate_By_Service AS 'Rate in Service Replacement',
		 Rate_By_Battery AS 'Battery Replacement',
		 Rate_By_Tire AS 'Rate in Tire Replacement'
         FROM driver_rating
		 WHERE (Date_Rated BETWEEN'".$vFromDate."' AND '".$vToDate."' AND Driver_ID ='".$Driver_ID."')
         ORDER BY Date_Rated DESC";
         
     	 $array = Yii::app()->db->createCommand($cmd)->queryAll();
		 return($array);			
		
	}
	public function ArrayDriverPerformancebyDriverInSummary($Driver_ID, $vFromDate, $vToDate)
	{
		$cmd = "SELECT 
		 SUM(driver_rating.Rate_By_Accident) AS 'Total Rate in Accident',
		 SUM(driver_rating.Rate_By_Service) AS 'Total Rate in Service Replacement', 
         SUM(driver_rating.Rate_By_Battery) AS 'Total Rate in Battery Replacement', 
		 SUM(driver_rating.Rate_By_Tire) AS 'Total Rate in Tire Replacement',
		 SUM(driver_rating.Rate_By_Accident) + SUM(driver_rating.Rate_By_Service) + SUM(driver_rating.Rate_By_Battery) + SUM(driver_rating.Rate_By_Tire) AS 'Rate in Total'
		 FROM driver_rating
		 WHERE (Date_Rated BETWEEN'".$vFromDate."' AND '".$vToDate."' AND Driver_ID ='".$Driver_ID."')";
                  
     	 $array = Yii::app()->db->createCommand($cmd)->queryAll();
		 return($array);			
		
	}

	public function ArrayBookingForVehicle($Vehicle_No, $Valid_From, $Valid_To){
       
       $cm = "select vb.Place_from, vb.Place_to, ba.Vehicle_No, vb.Booking_Status, date(vb.Requested_Date) as Requested_Date, date(ba.Approved_Date) as Approved_Date, vb.Approved_By, u.username as req_by, 
       md.Full_Name, date(ba.New_Booking_Request_Date)as FromDate, date(ba.New_Booking_To_Date) as New_Booking_To_Date, vb.Description, ba.Mileage, ba.In_Time, ba.Out_Time as Out_Time		
       from booking_approval as ba
       
       inner join ma_driver md on ba.Driver_ID = md.Driver_ID
       inner join vehicle_booking vb on vb.Booking_Approval_ID = ba.Booking_Approval_ID
       inner join tbl_users u on u.id = vb.User_ID
       inner join ma_vehicle_registry vr on vr.Vehicle_No = ba.Vehicle_No
       inner join ma_vehicle_category vc on vc.Vehicle_Category_ID = vr.Vehicle_Category_ID
       inner join ma_location l on l.Location_ID = u.Location_ID
       where 
       vb.Booking_Status = ('Completed')
       and (date(vb.From) between '$Valid_From' and '$Valid_To')
       and ba.Vehicle_No = '$Vehicle_No'
       order by ba.New_Booking_To_Date asc" ; 
	   
	   

       $array = Yii::app()->db->createCommand($cm)->queryAll();
       
       return $array;
    
}  

    public function ArrayAccidentDetailsVehiclewise($vNo, $fromDate, $toDate) 
    {
        $cmd = "SELECT a.Accident_ID, d.Complete_Name, a.Accident_Place, a.Date_and_Time, a.Details, a.Police_Station, a.Address, a.Police_Report_No,
                 a.Accident_Type, format(ed.Damage_Estimate,2) as Damage_Estimate, ed.Estimated_Date, i.Insurance_Company_Name, format(cd.Claime_Amount,2) as Claime_Amount,
                 cd.Claime_Date, format(cd.Driver_Claim_Amount,2) as Driver_Claim_Amount, cd.Driver_Claim_Date, cd.Thirdparty_Name, format(cd.Thirdparty_Claim_Amount,2) as Thirdparty_Claim_Amount, cd.Thirdparty_Claim_Date 
                 FROM accident a
                 INNER JOIN ma_driver d on d.Driver_ID = a.Driver_ID
                 INNER JOIN estimate_details ed on ed.Accident_ID = a.Accident_ID
                 INNER JOIN claime_details cd on cd.Estimate_ID = ed.Estimate_ID
                 INNER JOIN ma_insurance_company i on i.Insurance_Company_ID = cd.Insurance_Company_ID
                 
                 WHERE a.Vehicle_No = '$vNo' and date(a.Date_and_Time) between '$fromDate' and '$toDate'
                 
                ";
        
        $array = Yii::app()->db->createCommand($cmd)->queryAll();
       
       return $array;
    }
	
}