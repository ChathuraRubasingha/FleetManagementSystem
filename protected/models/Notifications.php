<?php

class Notifications extends CFormModel {

    public function chkAlertOnorOff() {

        $criteria = new CDbCriteria();
        $criteria->select = "Value";
        $criteria->condition = "Row = '4'";

        $alertStatus = NotificationConfiguration::model()->find($criteria);

        return ($alertStatus['Value']);
    }

    public function getAlertExeTime() {

        $criteria = new CDbCriteria();
        $criteria->select = "Value";
        $criteria->condition = "Row = '3'";

        $exeTime = NotificationConfiguration::model()->find($criteria);
        return ($exeTime['Value']);
    }

    public function getNonCriticalValue() 
    {

        $criteria = new CDbCriteria();

        $criteria->select = "Value";
        $criteria->condition = "Row = '2'";

        $nonCriticalPeriodDb = NotificationConfiguration::model()->find($criteria);

        return ($nonCriticalPeriodDb['Value']);
    }

    public function getCriticalValue() {

        $criteria = new CDbCriteria();

        $criteria->select = "Value";
        $criteria->condition = "Row = '1'";

        $criticalPeriodDb = NotificationConfiguration::model()->find($criteria);

        return ($criticalPeriodDb['Value']);
    }

    public function checkDashboardPermission() 
    {
        $flag = 0;
        $sendPermission = array();

        $roleID = Yii::app()->getModule('user')->user()->Role_ID;
        $locID = Yii::app()->getModule('user')->user()->Location_ID;
        $dashboardItem = DashboardItems::model()->getAllDashboardItems();
        $countDashboardItems = count($dashboardItem);
        for($i = 0; $i < $countDashboardItems; $i ++)
        {
           
            $item = $dashboardItem[$i]['Dashboard_Item_Name'];
            $PermissionArray = DashboardPermission::model()->getNotificationPermissionArray($roleID,$item);
            if(count($PermissionArray) > 0)
            {
                $sendPermission[0][$item] = "1";
            }
            else 
            {
                $sendPermission[0][$item] = "0";
            }
        }
        
       
        return $sendPermission;

    }

//    all

    public function getInsuranceAll($superuserstatus, $locID) {

        //  $superuserstatus = "0";

        if (($superuserstatus !== "1") && (!empty($locID))) {
            $Insurance = Yii::app()->db->createCommand(
                            "select ins.*, vr.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                    from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Current_Location_ID = l.Location_ID 
                    and now() between date_sub(ins.Valid_To, interval 30 day) and  ins.Valid_To and vl.Current_Location_ID ='$locID' order by ins.add_date asc")->queryAll();
            return $Insurance;
        } else {
            $Insurance = Yii::app()->db->createCommand(
                            "select ins.*, vr.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                    from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Current_Location_ID = l.Location_ID 
                    and now() between date_sub(ins.Valid_To, interval 30 day) and  ins.Valid_To order by ins.add_date asc")->queryAll();
            return $Insurance;
        }
    }

    public function getEmmissionAll($superuserstatus, $locID) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Emmission = Yii::app()->db->createCommand(
                            "select et.*, vr.*, l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount 
                             from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                             where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                             and now() between date_sub(et.Valid_To,interval 30 day) and  et.Valid_To and vl.Location_ID ='$locID' order by et.add_date asc")->queryAll();

            return $Emmission;
        } else {

            $Emmission = Yii::app()->db->createCommand(
                            "select et.*, vr.*, l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount
                     from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                     where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                     and now() between date_sub(et.Valid_To,interval 30 day) and  et.Valid_To order by et.add_date asc")->queryAll();
            return $Emmission;
        }
    }

    public function getFitnessAll($superuserstatus, $locID) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Fitness = Yii::app()->db->createCommand(
                            "select ft.*, vr.*, l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                            and  now() between date_sub(ft.Valid_To,interval 30 day) and ft.Valid_To and vl.Location_ID ='$locID' order by ft.add_date asc ")->queryAll();
            return $Fitness;
        } else {
            $Fitness = Yii::app()->db->createCommand(
                            "select ft.*, vr.*, l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                            and  now() between date_sub(ft.Valid_To,interval 30 day) and ft.Valid_To order by ft.add_date asc ")->queryAll();
            return $Fitness;
        }
    }

    public function getLicenceAll($superuserstatus, $locID) {

        if (($superuserstatus !== "1") && (!empty($locID))) {
            $License = Yii::app()->db->createCommand(
                            "select lic.*, vr.*, l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and now() between date_sub(lic.Valid_To,interval 30 DAY) and  lic.Valid_To and lic.Valid_To and vl.Location_ID ='$locID' order by lic.add_date asc")->queryAll();
            return $License;
        } else {
            $License = Yii::app()->db->createCommand(
                            "select lic.*, vr.*, l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and now() between date_sub(lic.Valid_To,interval 30 DAY) and  lic.Valid_To and lic.Valid_To order by lic.add_date asc")->queryAll();
            return $License;
        }
    }

    public function getVbookingAll($superuserstatus, $locID) {

        $username = Yii::app()->getModule('user')->user()->username;
        $user = TblUsers::model()->findByAttributes(array('username' => $username));
        $user_id = $user->id;

        if (($superuserstatus !== "1") && (!empty($locID))) {

//            $Vbooking = Yii::app()->db->createCommand(
//                            "select distinct vb.Booking_Request_ID, vb.*,datediff(now(),vb.add_date) as dateCount,
//                     u.username, vc.Category_Name
//                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
//                     where u.id = vb.User_ID  and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
//                     and vb.Booking_Status = 'Pending' and u.Location_ID = '$locID' and vb.User_ID='$user_id' order by vb.add_date asc ")->queryAll();
//            return $Vbooking;
//        } else {
//
//            $Vbooking = Yii::app()->db->createCommand(
//                            "select distinct vb.Booking_Request_ID, vb.*,datediff(now(),vb.add_date) as dateCount,
//                     u.username, vc.Category_Name 
//                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
//                     where u.id = vb.User_ID  and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
//                     and vb.Booking_Status = 'Pending' order by vb.add_date asc")->queryAll();
//            return $Vbooking;
//        }

            $cmd =  "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From,now()) as dateCount,
                     u.username, vc.Category_Name
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID  and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Pending' and u.Location_ID = '$locID' order by vb.From asc ";
            
            $Vbooking = Yii::app()->db->createCommand($cmd)->queryAll();
           
            return $Vbooking;
        } else {
            $cmd = "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From,now()) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID  and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Pending' order by vb.From asc";
            $Vbooking = Yii::app()->db->createCommand($cmd)->queryAll();
            //echo $cmd;exit;
            return $Vbooking;
        }
    }
    
        public function getApprovedVbookingAll($superuserstatus, $locID) {

        $username = Yii::app()->getModule('user')->user()->username;
        $user = TblUsers::model()->findByAttributes(array('username' => $username));
        $user_id = $user->id;

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Vbooking = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(now(),vb.add_date) as dateCount,
                     u.username, vc.Category_Name
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID  and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Approved' and u.Location_ID = '$locID' order by vb.add_date asc ")->queryAll();
            return $Vbooking;
        } else {

            $Vbooking = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(now(),vb.add_date) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID  and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Approved' order by vb.add_date asc")->queryAll();
            return $Vbooking;
        }
    }

    public function getRepairAll($superuserstatus, $locID) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $repair = Yii::app()->db->createCommand(
                            "select re.*, vr.*, vl.*, l.*, vg.*, datediff(now(),re.add_date) as dateCount 
                        from repair_estimate_details as re, ma_garages as vg, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where re.Vehicle_No = vr.Vehicle_No and re.Garage_ID = vg.Garage_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and re.Estimate_Status = 'Pending' and vl.Location_ID = '$locID' order by re.add_date asc ")->queryAll();
            return $repair;
        } else {

            $repair = Yii::app()->db->createCommand(
                            "select re.*, vr.*, vl.*, l.*, vg.*, datediff(now(),re.add_date) as dateCount 
                        from repair_estimate_details as re, ma_garages as vg, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where re.Vehicle_No = vr.Vehicle_No and re.Garage_ID = vg.Garage_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and re.Estimate_Status = 'Pending' order by re.add_date asc ")->queryAll();
            return $repair;
        }
    }

    public function getbatteryReplaceAll($superuserstatus, $locID) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $batteryReplacementPending = Yii::app()->db->createCommand(
                            "select bd.*, md.* , md.Full_Name as dName, bt.*, vr.*, l.*, vl.*, datediff(now(),bd.add_date) as dateCount
                        from battery_details as bd, ma_driver as md, ma_battery_type as bt, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                        where bd.Driver_ID = md.Driver_ID and bd.Battery_Type_ID = bt.Battery_Type_ID and bd.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                        and bd.Approved_Status = 'Pending' and vl.Location_ID = '$locID'")->queryAll();
            return $batteryReplacementPending;
        } else {

            $batteryReplacementPending = Yii::app()->db->createCommand(
                            "select bd.*, md.*, md.Full_Name as dName ,bt.*, vr.*, l.*, vl.*, datediff(now(),bd.add_date) as dateCount
                        from battery_details as bd, ma_driver as md, ma_battery_type as bt, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                        where bd.Driver_ID = md.Driver_ID and bd.Battery_Type_ID = bt.Battery_Type_ID and bd.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and bd.Approved_Status = 'Pending'")->queryAll();
            return $batteryReplacementPending;
        }
    }

    public function gettTireRpalcementAll($superuserstatus, $locID) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $tireReplacementPending = Yii::app()->db->createCommand(
                            "select trd.*, trt.*, trz.*, md.Full_Name as Dname, vr.*, l.*, vl.*, datediff(now(),trd.add_date) as dateCount 
                              from tyre_details as trd, ma_tyre_type as trt, ma_tyre_size as trz, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                              where trd.Tyre_Size_ID = trz.Tyre_Size_ID and trd.Tyre_Type_ID = trt.Tyre_Type_ID and trd.Vehicle_No = vr.Vehicle_No and trd.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                              and trd.Approved_Status = 'Pending'and vl.Location_ID = '$locID'")->queryAll();
            return $tireReplacementPending;
        } else {
            $tireReplacementPending = Yii::app()->db->createCommand(
                            "select trd.*, trt.*, trz.*, md.Full_Name as Dname, vr.*, l.*, vl.*, datediff(now(),trd.add_date) as dateCount 
                              from tyre_details as trd, ma_tyre_type as trt, ma_tyre_size as trz, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                              where trd.Tyre_Size_ID = trz.Tyre_Size_ID and trd.Tyre_Type_ID = trt.Tyre_Type_ID and trd.Vehicle_No = vr.Vehicle_No and trd.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                              and trd.Approved_Status = 'Pending'")->queryAll();
            return $tireReplacementPending;
        }
    }

    public function getFuelRequestAll($superuserstatus, $locID)
    {
        $fuelRequestPending = array();
        $cmd ='';
        if (($superuserstatus !== "1") && !empty($locID)) 
        {
            $cmd = "select fr.*, md.Full_Name as Dname, vr.*, l.*, datediff(now(),fr.add_date) as dateCount
                    from fuel_request_details as fr, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where fr.Vehicle_No = vr.Vehicle_No and fr.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Current_Location_ID = l.Location_ID and fr.Approve_Status = 'Pending' and vl.Current_Location_ID = '$locID' ";
           
            
        }
        else 
        {

            $cmd =" select fr.*, md.Full_Name as Dname, vr.*, l.*, datediff(now(),fr.add_date) as dateCount
                    from fuel_request_details as fr, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where fr.Vehicle_No = vr.Vehicle_No and fr.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Current_Location_ID = l.Location_ID and fr.Approve_Status = 'Pending'";
            
        }
        if($cmd !='')
        {
            $fuelRequestPending = Yii::app()->db->createCommand($cmd)->queryAll();
        }
        
        return $fuelRequestPending;
    }

//    end of all
//    
//    
//start of very delayed    

    public function getInsuaranceNonCritical($superuserstatus, $locID, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Insurance1 = Yii::app()->db->createCommand(
                            "select ins.*, vr.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                    from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                    and now() between date_sub(ins.Valid_To, interval 30 day) and  ins.Valid_To and vl.Location_ID ='$locID' 
                    and (((datediff(ins.Valid_To,now())) >= '$nonCriticalPeriod')) order by ins.add_date asc")->queryAll();
            return $Insurance1;
        } else {
            $Insurance1 = Yii::app()->db->createCommand(
                            "select ins.*, vr.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                    from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                    and now() between date_sub(ins.Valid_To, interval 30 day) and  ins.Valid_To
                    and (((datediff(ins.Valid_To,now())) >= '$nonCriticalPeriod')) order by ins.add_date asc")->queryAll();
            return $Insurance1;
        }
    }

    public function getEmmissionNonCritical($superuserstatus, $locID, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Emmission1 = Yii::app()->db->createCommand(
                            "select et.*, vr.*, l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount 
                             from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                             where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                             and now() between date_sub(et.Valid_To,interval 30 day) and  et.Valid_To and vl.Location_ID ='$locID' 
                             and (((datediff(et.Valid_To,now())) >= '$nonCriticalPeriod')) order by et.add_date asc")->queryAll();
            return $Emmission1;
        } else {

            $cmd ="select et.*, vr.*, l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount
                     from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                     where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                     and now() between date_sub(et.Valid_To,interval 30 day) and  et.Valid_To 
                     and (((datediff(et.Valid_To,now())) >= '$nonCriticalPeriod')) order by et.add_date asc";
           
            $Emmission1 = Yii::app()->db->createCommand($cmd)->queryAll();
            return $Emmission1;
        }
    }

    public function getFitnessNonCritical($superuserstatus, $locID, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Fitness1 = Yii::app()->db->createCommand(
                            "select ft.*, vr.*, l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                            and  now() between date_sub(ft.Valid_To,interval 30 day) and ft.Valid_To and vl.Location_ID ='$locID' 
                            and (((datediff(ft.Valid_To,now())) >= '$nonCriticalPeriod')) order by ft.add_date asc ")->queryAll();
            return $Fitness1;
        } else {
            $Fitness1 = Yii::app()->db->createCommand(
                            "select ft.*, vr.*, l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                            and  now() between date_sub(ft.Valid_To,interval 30 day) and ft.Valid_To 
                            and (((datediff(ft.Valid_To,now()))>= '$nonCriticalPeriod')) order by ft.add_date asc ")->queryAll();
            return $Fitness1;
        }
    }

    public function getLicenceNonCritical($superuserstatus, $locID, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {
            $License1 = Yii::app()->db->createCommand(
                            "select lic.*, vr.*, l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and now() between date_sub(lic.Valid_To,interval 30 DAY) and  lic.Valid_To and lic.Valid_To and vl.Location_ID ='$locID' 
                        and (((datediff(lic.Valid_To,now())) >= '$nonCriticalPeriod')) order by lic.add_date asc")->queryAll();
            return $License1;
        } else {
            $License1 = Yii::app()->db->createCommand(
                            "select lic.*, vr.*, l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and now() between date_sub(lic.Valid_To,interval 30 DAY) and  lic.Valid_To and lic.Valid_To 
                        and (((datediff(lic.Valid_To,now())) >= '$nonCriticalPeriod')) order by lic.add_date asc")->queryAll();
            return $License1;
        }
    }

    // get non critical bookings
    public function getPendingBookingNonCritical($superuserstatus, $locID, $Booking_Non_Critical) {

        $username = Yii::app()->getModule('user')->user()->username;
        $user = TblUsers::model()->findByAttributes(array('username' => $username));
        $user_id = $user->id;

        if (($superuserstatus !== "1") && (!empty($locID))) 
        {
            $Vbooking1 = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From, now()) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Pending' and u.Location_ID = '$locID' 
                     and ((datediff(vb.From, now()) >='$Booking_Non_Critical')) order by vb.add_date asc ")->queryAll();
            return $Vbooking1;
        } 
        else 
        {
            $cmd = "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From, now()) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Pending' 
                     and (((datediff(vb.From, now()) >='$Booking_Non_Critical'))) order by vb.add_date asc";
            //echo $cmd;exit;
            $Vbooking1 = Yii::app()->db->createCommand($cmd)->queryAll();
            return $Vbooking1;
        }
    }
    
        public function getApprovedVbookingNonCritical($superuserstatus, $locID, $Booking_Non_Critical) {

        $username = Yii::app()->getModule('user')->user()->username;
        $user = TblUsers::model()->findByAttributes(array('username' => $username));
        $user_id = $user->id;

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Vbooking1 = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From, now()) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Approved' and u.Location_ID = '$locID' 
                     and ((datediff(vb.From, now()) >='$Booking_Non_Critical')) order by vb.add_date asc ")->queryAll();
            return $Vbooking1;
        } else {

            $Vbooking1 = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From, now()) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Approved' 
                     and ((datediff(vb.From, now()) >='$Booking_Non_Critical')) order by vb.add_date asc")->queryAll();
            return $Vbooking1;
        }
    }

    public function getRepairNonCritical($superuserstatus, $locID, $criticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $repair1 = Yii::app()->db->createCommand(
                            "select re.*, vr.*, vl.*, l.*, vg.*, datediff(now(),re.add_date) as dateCount 
                        from repair_estimate_details as re, ma_garages as vg, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where re.Vehicle_No = vr.Vehicle_No and re.Garage_ID = vg.Garage_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and re.Estimate_Status = 'Pending' and vl.Location_ID = '$locID' 
                        and (((datediff(now(),re.add_date) <= '$criticalPeriod'))) order by re.add_date asc ")->queryAll();
            return $repair1;
        } else {

            $repair1 = Yii::app()->db->createCommand(
                            "select re.*, vr.*, vl.*, l.*, vg.*, datediff(now(),re.add_date) as dateCount 
                        from repair_estimate_details as re, ma_garages as vg, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where re.Vehicle_No = vr.Vehicle_No and re.Garage_ID = vg.Garage_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and re.Estimate_Status = 'Pending' 
                        and (((datediff(now(),re.add_date) <= '$criticalPeriod'))) order by re.add_date asc ")->queryAll();
            return $repair1;
        }
    }

    public function getBatteryReplacementNonCritical($superuserstatus, $locID, $criticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $batteryReplacementPending1 = Yii::app()->db->createCommand(
                            "select bd.*, md.* , md.Full_Name as dName, bt.*, vr.*, l.*, vl.*, datediff(now(),bd.add_date) as dateCount
                        from battery_details as bd, ma_driver as md, ma_battery_type as bt, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                        where bd.Driver_ID = md.Driver_ID and bd.Battery_Type_ID = bt.Battery_Type_ID and bd.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                        and bd.Approved_Status = 'Pending' and vl.Location_ID = '$locID' 
                        and (((datediff(now(),bd.add_date) <= '$criticalPeriod'))) order by bd.add_date asc ")->queryAll();
            return $batteryReplacementPending1;
        } else {

            $batteryReplacementPending1 = Yii::app()->db->createCommand(
                            "select bd.*, md.*, md.Full_Name as dName ,bt.*, vr.*, l.*, vl.*, datediff(now(),bd.add_date) as dateCount
                        from battery_details as bd, ma_driver as md, ma_battery_type as bt, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                        where bd.Driver_ID = md.Driver_ID and bd.Battery_Type_ID = bt.Battery_Type_ID and bd.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and bd.Approved_Status = 'Pending'
                        and (((datediff(now(),bd.add_date) <= '$criticalPeriod'))) order by bd.add_date asc")->queryAll();
            return $batteryReplacementPending1;
        }
    }

    public function getTireReplacementNonCritical($superuserstatus, $locID, $criticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $tireReplacementPending1 = Yii::app()->db->createCommand(
                            "select trd.*, trt.*, trz.*, md.Full_Name as Dname, vr.*, l.*, vl.*, datediff(now(),trd.add_date) as dateCount 
                              from tyre_details as trd, ma_tyre_type as trt, ma_tyre_size as trz, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                              where trd.Tyre_Size_ID = trz.Tyre_Size_ID and trd.Tyre_Type_ID = trt.Tyre_Type_ID and trd.Vehicle_No = vr.Vehicle_No and trd.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                              and trd.Approved_Status = 'Pending'and vl.Location_ID = '$locID'
                              and (((datediff(now(),trd.add_date) <= '$criticalPeriod'))) order by trd.add_date asc")->queryAll();
            return $tireReplacementPending1;
        } else {
            $tireReplacementPending1 = Yii::app()->db->createCommand(
                            "select trd.*, trt.*, trz.*, md.Full_Name as Dname, vr.*, l.*, vl.*, datediff(now(),trd.add_date) as dateCount 
                              from tyre_details as trd, ma_tyre_type as trt, ma_tyre_size as trz, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                              where trd.Tyre_Size_ID = trz.Tyre_Size_ID and trd.Tyre_Type_ID = trt.Tyre_Type_ID and trd.Vehicle_No = vr.Vehicle_No and trd.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                              and trd.Approved_Status = 'Pending'
                              and (((datediff(now(),trd.add_date) <= '$criticalPeriod'))) order by trd.add_date asc")->queryAll();
            return $tireReplacementPending1;
        }
    }

    public function getFuelRequestPendingNonCritical($superuserstatus, $locID, $criticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $fuelRequestPending1 = Yii::app()->db->createCommand(
                            "select fr.*, md.Full_Name as Dname, vr.*, l.*, datediff(now(),fr.add_date) as dateCount
                                from fuel_request_details as fr, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                                where fr.Vehicle_No = vr.Vehicle_No and fr.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                                and fr.Approve_Status = 'Pending' and vl.Location_ID = '$locID' 
                                and (((datediff(now(),fr.add_date) <= '$criticalPeriod'))) order by fr.add_date asc")->queryAll();
            return $fuelRequestPending1;
        } else {
$cmd = "select fr.*, md.Full_Name as Dname, vr.*, l.*, datediff(now(),fr.add_date) as dateCount
                                from fuel_request_details as fr, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                                where fr.Vehicle_No = vr.Vehicle_No and fr.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                                and fr.Approve_Status = 'Pending'
                                and (((datediff(now(),fr.add_date) <= '$criticalPeriod'))) order by fr.add_date asc";
 
$fuelRequestPending1 = Yii::app()->db->createCommand($cmd)->queryAll();
           
            return $fuelRequestPending1;
        }
    }

//    end of non Critical
//    
//    
//     startof warning

    public function getInsuaranceWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Insurance2 = Yii::app()->db->createCommand(
                            "select ins.*, vr.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                    from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                    and now() between date_sub(ins.Valid_To, interval 30 day) and  ins.Valid_To and vl.Location_ID ='$locID' 
                    and (( '$nonCriticalPeriod' > datediff(ins.Valid_To,now()) and datediff(ins.Valid_To,now())>'$criticalPeriod')) order by ins.add_date asc")->queryAll();
            return $Insurance2;
        } else {
            $Insurance2 = Yii::app()->db->createCommand(
                            "select ins.*, vr.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                    from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                    and now() between date_sub(ins.Valid_To, interval 30 day) and  ins.Valid_To
                    and (( '$nonCriticalPeriod' > datediff(ins.Valid_To,now()) and datediff(ins.Valid_To,now())>'$criticalPeriod')) order by ins.add_date asc")->queryAll();
            return $Insurance2;
        }
    }

    public function getEmmisionWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Emmission2 = Yii::app()->db->createCommand(
                            "select et.*, vr.*, l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount 
                             from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                             where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                             and now() between date_sub(et.Valid_To,interval 30 day) and  et.Valid_To and vl.Location_ID ='$locID' 
                             and (( '$nonCriticalPeriod' > datediff(et.Valid_To,now()) and datediff(et.Valid_To,now())>'$criticalPeriod')) order by et.add_date asc")->queryAll();
            return $Emmission2;
        } else {

            $Emmission2 = Yii::app()->db->createCommand(
                            "select et.*, vr.*, l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount
                     from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                     where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                     and now() between date_sub(et.Valid_To,interval 30 day) and  et.Valid_To 
                     and (( '$nonCriticalPeriod' > datediff(et.Valid_To,now()) and datediff(et.Valid_To,now())>'$criticalPeriod')) order by et.add_date asc")->queryAll();
            return $Emmission2;
        }
    }

    public function getFitenssWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Fitness2 = Yii::app()->db->createCommand(
                            "select ft.*, vr.*, l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                            and  now() between date_sub(ft.Valid_To,interval 30 day) and ft.Valid_To and vl.Location_ID ='$locID' 
                            and (( '$nonCriticalPeriod' > datediff(ft.Valid_To,now()) and datediff(ft.Valid_To,now())>'$criticalPeriod')) order by ft.add_date asc ")->queryAll();
            return $Fitness2;
        } else {
            $Fitness2 = Yii::app()->db->createCommand(
                            "select ft.*, vr.*, l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                            and  now() between date_sub(ft.Valid_To,interval 30 day) and ft.Valid_To 
                            and (( '$nonCriticalPeriod' > datediff(ft.Valid_To,now()) and datediff(ft.Valid_To,now())>'$criticalPeriod')) order by ft.add_date asc ")->queryAll();
            return $Fitness2;
        }
    }

    public function getLicenseWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {
            $License2 = Yii::app()->db->createCommand(
                            "select lic.*, vr.*, l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and now() between date_sub(lic.Valid_To,interval 30 DAY) and  lic.Valid_To and lic.Valid_To and vl.Location_ID ='$locID' 
                        and (( '$nonCriticalPeriod' > datediff(lic.Valid_To,now()) and datediff(lic.Valid_To,now())>'$criticalPeriod')) order by lic.add_date asc")->queryAll();
            return $License2;
        } else {
            $License2 = Yii::app()->db->createCommand(
                            "select lic.*, vr.*, l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and now() between date_sub(lic.Valid_To,interval 30 DAY) and  lic.Valid_To and lic.Valid_To 
                        and (( '$nonCriticalPeriod' > datediff(lic.Valid_To,now()) and datediff(lic.Valid_To,now())>'$criticalPeriod')) order by lic.add_date asc")->queryAll();
            return $License2;
        }
    }

    public function getPendingBookingWarning($superuserstatus, $locID, $Booking_Non_Critical, $Booking_Critical) {

        $username = Yii::app()->getModule('user')->user()->username;
        $user = TblUsers::model()->findByAttributes(array('username' => $username));
        $user_id = $user->id;

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Vbooking2 = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From, now()) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID  and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Pending' and u.Location_ID = '$locID' 
                     and ((  '$Booking_Non_Critical' > datediff(vb.From, now())  and datediff(vb.From, now()) >'$Booking_Critical')) order by vb.From asc ")->queryAll();
            return $Vbooking2;
        } else {

            $cmd =  "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From, now()) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Pending' 
                    and (('$Booking_Non_Critical' > datediff(vb.From, now())  and datediff(vb.From, now()) >'$Booking_Critical')) order by vb.From asc";
            $Vbooking2 = Yii::app()->db->createCommand($cmd)->queryAll();
           // echo $cmd;exit;
            return $Vbooking2;
        }
    }
    
//new

    public function getApprovedVbookingWarning($superuserstatus, $locID, $Booking_Non_Critical, $Booking_Critical) {

        $username = Yii::app()->getModule('user')->user()->username;
        $user = TblUsers::model()->findByAttributes(array('username' => $username));
        $user_id = $user->id;

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Vbooking2 = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(now(),vb.add_date) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID  and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Approved' and u.Location_ID = '$locID' 
                     and (( '$Booking_Non_Critical' > datediff(now(),vb.add_date) and datediff(now(),vb.add_date)>'$Booking_Critical')) order by vb.add_date asc ")->queryAll();
            return $Vbooking2;
        } else {

            $Vbooking2 = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(now(),vb.add_date) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Approved' 
                     and (( '$Booking_Non_Critical' > datediff(now(),vb.add_date) and datediff(now(),vb.add_date)>'$Booking_Critical')) order by vb.add_date asc")->queryAll();
            return $Vbooking2;
        }
    }    
    
    

    public function getPendingReapirWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $repair2 = Yii::app()->db->createCommand(
                            "select re.*, vr.*, vl.*, l.*, vg.*, datediff(now(),re.add_date) as dateCount 
                        from repair_estimate_details as re, ma_garages as vg, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where re.Vehicle_No = vr.Vehicle_No and re.Garage_ID = vg.Garage_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and re.Estimate_Status = 'Pending' and vl.Location_ID = '$locID' 
                        and (( '$nonCriticalPeriod' > datediff(now(),re.add_date) and datediff(now(),re.add_date)>'$criticalPeriod')) order by re.add_date asc ")->queryAll();
            return $repair2;
        } else {

            $repair2 = Yii::app()->db->createCommand(
                            "select re.*, vr.*, vl.*, l.*, vg.*, datediff(now(),re.add_date) as dateCount 
                        from repair_estimate_details as re, ma_garages as vg, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where re.Vehicle_No = vr.Vehicle_No and re.Garage_ID = vg.Garage_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and re.Estimate_Status = 'Pending' 
                        and (( '$nonCriticalPeriod' > datediff(now(),re.add_date) and datediff(now(),re.add_date)>'$criticalPeriod')) order by re.add_date asc ")->queryAll();
            return $repair2;
        }
    }

    public function getPendingBatteryReplacementWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $batteryReplacementPending2 = Yii::app()->db->createCommand(
                            "select bd.*, md.* , md.Full_Name as dName, bt.*, vr.*, l.*, vl.*, datediff(now(),bd.add_date) as dateCount
                        from battery_details as bd, ma_driver as md, ma_battery_type as bt, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                        where bd.Driver_ID = md.Driver_ID and bd.Battery_Type_ID = bt.Battery_Type_ID and bd.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                        and bd.Approved_Status = 'Pending' and vl.Location_ID = '$locID' 
                        and (( '$nonCriticalPeriod' > datediff(now(),bd.add_date) and datediff(now(),bd.add_date)>'$criticalPeriod')) order by bd.add_date asc ")->queryAll();
            return $batteryReplacementPending2;
        } else {

            $batteryReplacementPending2 = Yii::app()->db->createCommand(
                            "select bd.*, md.*, md.Full_Name as dName ,bt.*, vr.*, l.*, vl.*, datediff(now(),bd.add_date) as dateCount
                        from battery_details as bd, ma_driver as md, ma_battery_type as bt, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                        where bd.Driver_ID = md.Driver_ID and bd.Battery_Type_ID = bt.Battery_Type_ID and bd.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and bd.Approved_Status = 'Pending'
                        and (( '$nonCriticalPeriod' > datediff(now(),bd.add_date) and datediff(now(),bd.add_date)>'$criticalPeriod')) order by bd.add_date asc")->queryAll();
            return $batteryReplacementPending2;
        }
    }

    public function getPendingTireRepalcementWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $tireReplacementPending2 = Yii::app()->db->createCommand(
                            "select trd.*, trt.*, trz.*, md.Full_Name as Dname, vr.*, l.*, vl.*, datediff(now(),trd.add_date) as dateCount 
                              from tyre_details as trd, ma_tyre_type as trt, ma_tyre_size as trz, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                              where trd.Tyre_Size_ID = trz.Tyre_Size_ID and trd.Tyre_Type_ID = trt.Tyre_Type_ID and trd.Vehicle_No = vr.Vehicle_No and trd.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                              and trd.Approved_Status = 'Pending'and vl.Location_ID = '$locID'
                              and (( '$nonCriticalPeriod' > datediff(now(),trd.add_date) and datediff(now(),trd.add_date)>'$criticalPeriod')) order by trd.add_date asc")->queryAll();
            return $tireReplacementPending2;
        } else {
            $tireReplacementPending2 = Yii::app()->db->createCommand(
                            "select trd.*, trt.*, trz.*, md.Full_Name as Dname, vr.*, l.*, vl.*, datediff(now(),trd.add_date) as dateCount 
                              from tyre_details as trd, ma_tyre_type as trt, ma_tyre_size as trz, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                              where trd.Tyre_Size_ID = trz.Tyre_Size_ID and trd.Tyre_Type_ID = trt.Tyre_Type_ID and trd.Vehicle_No = vr.Vehicle_No and trd.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                              and trd.Approved_Status = 'Pending'
                              and (( '$nonCriticalPeriod' > datediff(now(),trd.add_date) and datediff(now(),trd.add_date)>'$criticalPeriod')) order by trd.add_date asc")->queryAll();
            return $tireReplacementPending2;
        }
    }

    public function getPendingFuelRequestWarning($superuserstatus, $locID, $criticalPeriod, $nonCriticalPeriod) {


        if (($superuserstatus !== "1") && (!empty($locID))) {

            $fuelRequestPending2 = Yii::app()->db->createCommand(
                            "select fr.*, md.Full_Name as Dname, vr.*, l.*, datediff(now(),fr.add_date) as dateCount
                                from fuel_request_details as fr, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                                where fr.Vehicle_No = vr.Vehicle_No and fr.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                                and fr.Approve_Status = 'Pending' and vl.Location_ID = '$locID' 
                                and (( '$nonCriticalPeriod' > datediff(now(),fr.add_date) and datediff(now(),fr.add_date)>'$criticalPeriod')) order by fr.add_date asc")->queryAll();
            return $fuelRequestPending2;
        } else {
            $cmd = "select fr.*, md.Full_Name as Dname, vr.*, l.*, datediff(now(),fr.add_date) as dateCount
                                from fuel_request_details as fr, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                                where fr.Vehicle_No = vr.Vehicle_No and fr.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                                and fr.Approve_Status = 'Pending'
                                and (( '$nonCriticalPeriod' > datediff(now(),fr.add_date) and datediff(now(),fr.add_date)>'$criticalPeriod')) order by fr.add_date asc";

            $fuelRequestPending2 = Yii::app()->db->createCommand($cmd)->queryAll();
            return $fuelRequestPending2;
        }
    }

//    end of warnings
//    
//    
//    start of critical
    public function getInsuaranceCritical($superuserstatus, $locID, $criticalPeriod) {


        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Insurance3 = Yii::app()->db->createCommand(
                            "select ins.*, vr.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                    from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                    and now() between date_sub(ins.Valid_To, interval 30 day) and  ins.Valid_To and vl.Location_ID ='$locID' 
                    and ((datediff(ins.Valid_To,now())) <= '$criticalPeriod') order by ins.add_date asc")->queryAll();
            return $Insurance3;
        } else {
            $Insurance3 = Yii::app()->db->createCommand(
                            "select ins.*, vr.*, l.*, vl.*, datediff(ins.Valid_To,now()) as remainingDays, datediff(ins.Valid_To,now()) as dateCount 
                    from insurance as ins, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                    where ins.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                    and now() between date_sub(ins.Valid_To, interval 30 day) and  ins.Valid_To
                    and ((datediff(ins.Valid_To,now())) <= '$criticalPeriod') order by ins.add_date asc")->queryAll();
            return $Insurance3;
        }
    }

    public function getEmissionCritical($superuserstatus, $locID, $criticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Emmission3 = Yii::app()->db->createCommand(
                            "select et.*, vr.*, l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount 
                             from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                             where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                             and now() between date_sub(et.Valid_To,interval 30 day) and  et.Valid_To and vl.Location_ID ='$locID' 
                             and (((datediff(et.Valid_To,now())) <= '$criticalPeriod')) order by et.add_date asc")->queryAll();
            return $Emmission3;
        } else {

            $cmd = "select et.*, vr.*, l.*, vl.*, datediff(et.Valid_To,now()) as remainingDays, datediff(et.Valid_To,now()) as dateCount
                     from emission_test as et, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                     where et.Vehicle_No = vr.Vehicle_No and vl.Vehicle_No = vr.Vehicle_No and vl.Location_ID = l.Location_ID 
                     and now() between date_sub(et.Valid_To,interval 30 day) and  et.Valid_To 
                     and (((datediff(et.Valid_To,now())) <= '$criticalPeriod')) order by et.add_date asc";
            
            $Emmission3 = Yii::app()->db->createCommand($cmd)->queryAll();
            return $Emmission3;
        }
    }

    public function getFitnessCritical($superuserstatus, $locID, $criticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Fitness3 = Yii::app()->db->createCommand(
                            "select ft.*, vr.*, l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                            and  now() between date_sub(ft.Valid_To,interval 30 day) and ft.Valid_To and vl.Location_ID ='$locID' 
                            and (((datediff(ft.Valid_To,now())) <= '$criticalPeriod')) order by ft.add_date asc ")->queryAll();
            return $Fitness3;
        } else {
            $Fitness3 = Yii::app()->db->createCommand(
                            "select ft.*, vr.*, l.*, vl.*, datediff(ft.Valid_To,now()) as remainingDays, datediff(ft.Valid_To,now()) as dateCount
                            from fitness_test as ft, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                            where ft.Vehicle_No = vr.Vehicle_No and ft.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                            and  now() between date_sub(ft.Valid_To,interval 30 day) and ft.Valid_To 
                            and (((datediff(ft.Valid_To,now())) <= '$criticalPeriod')) order by ft.add_date asc ")->queryAll();
            return $Fitness3;
        }
    }

    public function getLicenceCritical($superuserstatus, $locID, $criticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {
            $License3 = Yii::app()->db->createCommand(
                            "select lic.*, vr.*, l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and now() between date_sub(lic.Valid_To,interval 30 DAY) and  lic.Valid_To and lic.Valid_To and vl.Location_ID ='$locID' 
                        and (((datediff(lic.Valid_To,now())) <= '$criticalPeriod')) order by lic.add_date asc")->queryAll();
            return $License3;
        } else {
            $License3 = Yii::app()->db->createCommand(
                            "select lic.*, vr.*, l.*, vl.*, datediff(lic.Valid_To,now()) as remainingDays, datediff(lic.Valid_To,now()) as dateCount
                        from license as lic, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where lic.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and now() between date_sub(lic.Valid_To,interval 30 DAY) and  lic.Valid_To and lic.Valid_To 
                        and (((datediff(lic.Valid_To,now())) <= '$criticalPeriod')) order by lic.add_date asc")->queryAll();
            return $License3;
        }
    }

    public function getPendingBookingCritical($superuserstatus, $locID, $Booking_Critical) {

        $username = Yii::app()->getModule('user')->user()->username;
        $user = TblUsers::model()->findByAttributes(array('username' => $username));
        $user_id = $user->id;

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Vbooking3 = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From, now()) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Pending' and u.Location_ID = '$locID' 
                     and ((datediff(vb.From, now()) <='$Booking_Critical')) order by vb.add_date asc ")->queryAll();
            return $Vbooking3;
        } else {
            $cmd = "select distinct vb.Booking_Request_ID, vb.*,datediff(vb.From, now()) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Pending' 
                     and (((datediff(vb.From, now()) <='$Booking_Critical'))) order by vb.add_date asc";
            //echo $cmd;exit;

            $Vbooking3 = Yii::app()->db->createCommand($cmd)->queryAll();
            return $Vbooking3;
        }
    }
    
    //new
    
        public function getApprovedVbookingCritical($superuserstatus, $locID, $Booking_Critical) {

        $username = Yii::app()->getModule('user')->user()->username;
        $user = TblUsers::model()->findByAttributes(array('username' => $username));
        $user_id = $user->id;

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $Vbooking3 = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(now(),vb.add_date) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Approved' and u.Location_ID = '$locID' 
                     and ((datediff(now(),vb.add_date) <='$Booking_Critical')) order by vb.add_date asc ")->queryAll();
            return $Vbooking3;
        } else {

            $Vbooking3 = Yii::app()->db->createCommand(
                            "select distinct vb.Booking_Request_ID, vb.*,datediff(now(),vb.add_date) as dateCount,
                     u.username, vc.Category_Name 
                     from vehicle_booking as vb, tbl_users as u, ma_vehicle_registry as vr, ma_vehicle_category as vc, ma_location as l
                     where u.id = vb.User_ID and vc.Vehicle_Category_ID = vb.Vehicle_Category_ID and l.Location_ID = u.Location_ID
                     and vb.Booking_Status = 'Approved' 
                     and (((datediff(now(),vb.add_date) <='$Booking_Critical'))) order by vb.add_date asc")->queryAll();
            return $Vbooking3;
        }
    }

    public function getPendingRepairCritical($superuserstatus, $locID, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $repair3 = Yii::app()->db->createCommand(
                            "select re.*, vr.*, vl.*, l.*, vg.*, datediff(now(),re.add_date) as dateCount 
                        from repair_estimate_details as re, ma_garages as vg, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where re.Vehicle_No = vr.Vehicle_No and re.Garage_ID = vg.Garage_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and re.Estimate_Status = 'Pending' and vl.Location_ID = '$locID' 
                        and (((datediff(now(),re.add_date) >= '$nonCriticalPeriod'))) order by re.add_date asc ")->queryAll();
            return $repair3;
        } else {

            $repair3 = Yii::app()->db->createCommand(
                            "select re.*, vr.*, vl.*, l.*, vg.*, datediff(now(),re.add_date) as dateCount 
                        from repair_estimate_details as re, ma_garages as vg, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl 
                        where re.Vehicle_No = vr.Vehicle_No and re.Garage_ID = vg.Garage_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and re.Estimate_Status = 'Pending' 
                        and (((datediff(now(),re.add_date) >= '$nonCriticalPeriod'))) order by re.add_date asc ")->queryAll();
            return $repair3;
        }
    }

    public function getBatteryReplacementCritical($superuserstatus, $locID, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $batteryReplacementPending3 = Yii::app()->db->createCommand(
                            "select bd.*, md.* , md.Full_Name as dName, bt.*, vr.*, l.*, vl.*, datediff(now(),bd.add_date) as dateCount
                        from battery_details as bd, ma_driver as md, ma_battery_type as bt, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                        where bd.Driver_ID = md.Driver_ID and bd.Battery_Type_ID = bt.Battery_Type_ID and bd.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                        and bd.Approved_Status = 'Pending' and vl.Location_ID = '$locID' 
                        and (((datediff(now(),bd.add_date) >='$nonCriticalPeriod'))) order by bd.add_date asc ")->queryAll();
            return $batteryReplacementPending3;
        } else {

            $batteryReplacementPending3 = Yii::app()->db->createCommand(
                            "select bd.*, md.*, md.Full_Name as dName ,bt.*, vr.*, l.*, vl.*, datediff(now(),bd.add_date) as dateCount
                        from battery_details as bd, ma_driver as md, ma_battery_type as bt, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                        where bd.Driver_ID = md.Driver_ID and bd.Battery_Type_ID = bt.Battery_Type_ID and bd.Vehicle_No = vr.Vehicle_No and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                        and bd.Approved_Status = 'Pending'
                        and (((datediff(now(),bd.add_date) >='$nonCriticalPeriod'))) order by bd.add_date asc")->queryAll();
            return $batteryReplacementPending3;
        }
    }

    public function getTireReplacementCritical($superuserstatus, $locID, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $tireReplacementPending3 = Yii::app()->db->createCommand(
                            "select trd.*, trt.*, trz.*, md.Full_Name as Dname, vr.*, l.*, vl.*, datediff(now(),trd.add_date) as dateCount 
                              from tyre_details as trd, ma_tyre_type as trt, ma_tyre_size as trz, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                              where trd.Tyre_Size_ID = trz.Tyre_Size_ID and trd.Tyre_Type_ID = trt.Tyre_Type_ID and trd.Vehicle_No = vr.Vehicle_No and trd.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                              and trd.Approved_Status = 'Pending'and vl.Location_ID = '$locID'
                              and (((datediff(now(),trd.add_date) >='$nonCriticalPeriod'))) order by trd.add_date asc")->queryAll();
            return $tireReplacementPending3;
        } else {
            $tireReplacementPending3 = Yii::app()->db->createCommand(
                            "select trd.*, trt.*, trz.*, md.Full_Name as Dname, vr.*, l.*, vl.*, datediff(now(),trd.add_date) as dateCount 
                              from tyre_details as trd, ma_tyre_type as trt, ma_tyre_size as trz, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                              where trd.Tyre_Size_ID = trz.Tyre_Size_ID and trd.Tyre_Type_ID = trt.Tyre_Type_ID and trd.Vehicle_No = vr.Vehicle_No and trd.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID 
                              and trd.Approved_Status = 'Pending'
                              and (((datediff(now(),trd.add_date)  >='$nonCriticalPeriod'))) order by trd.add_date asc")->queryAll();
            return $tireReplacementPending3;
        }
    }

    public function getFuelRequestCritical($superuserstatus, $locID, $nonCriticalPeriod) {

        if (($superuserstatus !== "1") && (!empty($locID))) {

            $fuelRequestPending3 = Yii::app()->db->createCommand(
                            "select fr.*, md.Full_Name as Dname, vr.*, l.*, datediff(now(),fr.add_date) as dateCount
                                from fuel_request_details as fr, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                                where fr.Vehicle_No = vr.Vehicle_No and fr.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                                and fr.Approve_Status = 'Pending' and vl.Location_ID = '$locID' 
                                and (((datediff(now(),fr.add_date) >='$nonCriticalPeriod'))) order by fr.add_date asc")->queryAll();
            return $fuelRequestPending3;
        } else {
$cmd = "select fr.*, md.Full_Name as Dname, vr.*, l.*, datediff(now(),fr.add_date) as dateCount
                                from fuel_request_details as fr, ma_driver as md, ma_vehicle_registry as vr, ma_location as l, vehicle_location as vl
                                where fr.Vehicle_No = vr.Vehicle_No and fr.Driver_ID = md.Driver_ID and vr.Vehicle_No = vl.Vehicle_No and vl.Location_ID = l.Location_ID
                                and fr.Approve_Status = 'Pending'
                                and (((datediff(now(),fr.add_date) >='$nonCriticalPeriod'))) order by fr.add_date asc";

            $fuelRequestPending3 = Yii::app()->db->createCommand($cmd)->queryAll();
            return $fuelRequestPending3;
        }
    }
    
    //////////////////////////
    
    
    public function getBookingDelayValues()
    {
        $criteria = new CDbCriteria();

        $criteria->select = "Row, Value, Configuration_Name";

        $bookingDelays = NotificationConfiguration::model()->findAll($criteria);

        return $bookingDelays;
    }

}

?>
