<?php
include("./config.php");
include("./models/firebaseRDB.php");
date_default_timezone_set('Asia/Manila');
Class StockIn {
    private $firebaseApiKey = 'AIzaSyBABVyjXFYyEfHTPVsF-s06XpA8ZcuMKrs';
    private $firebaseProjectId = 'db-pharmacy';
    private $firebaseDatabaseUrl = 'https://db-pharmacy-default-rtdb.firebaseio.com/';

    // Firebase Realtime Database endpoint
    public $firebaseEndpoint = 'https://db-pharmacy-default-rtdb.firebaseio.com/orders.json';

    // Make the GET request
    public $response;
    // 
    // Check if the request was successful
    public function get_sales(){
        $db = new firebaseRDB($this->firebaseDatabaseUrl);
        $stock = $db->retrieve("stock-in");
        $stock = json_decode($stock,1);

        $orders = $db->retrieve("orders");
        $orders = json_decode($orders,1);
        $toReturn = [];
        $year = $_SESSION['selected_year'];




        // return var_dump($year);
        // $this->yearSale($orders,$year,$stock);
        $generatedDaily = [];
        foreach ($this->generateDates($year) as $key => $value) {
            $generatedDaily = array($key => $value) + $generatedDaily;
        }
        $generatedWeekly = $this->generateWeeks($year);
        $generatedMonthly = $this->generateMonths($year);
        return $this->yearSale($orders,$year,$stock,$generatedDaily,$generatedWeekly,$generatedMonthly);
        
        // return $data;
    }
    

    public function generateDates($year){
        // Set the start date to the first day of the provided year
        $endDate = new DateTime();
        if($year != date("Y")){
            $endDate = new DateTime($year.'-12-31');
        }
        $startDate = new DateTime($year . '-01-01');

        // Set the end date to the present date
        

        // Create an array to store the generated dates
        $dates = array();

        // Generate dates from start date until end date
        while ($startDate <= $endDate) {
            $dates[$startDate->format('F j, Y')] = [
                'profit' => 0,
                'expenses' => 0,
                'sales' => 0
            ] ;
            $startDate->modify('+1 day');
        }

        return $dates;
    }

    public function generateWeeks($year){
        // Set the start date to the first day of the provided year
        $startDate = new DateTime($year . '-01-01');

        // Set the end date to the present date
        $endDate = new DateTime();
        if($year != date("Y")){
            $endDate = new DateTime($year.'-12-31');
        }

        // Create an array to store the generated weeks
        $weeks = array();

        // Generate weeks from start date until end date
        while ($startDate <= $endDate) {
            $weekNumber = $startDate->format('W');
            $weeks[$startDate->format('W-Y')] = [
                'profit' => 0,
                'expenses' => 0,
                'sales' => 0
            ];
            $startDate->modify('+1 week');
        }

        return $weeks;
    }

    public function generateMonths($year){
        // Set the start date to the first day of the provided year
        $startDate = new DateTime($year . '-01-01');

        // Set the end date to the present date
        $endDate = new DateTime();
        if($year != date("Y")){
            $endDate = new DateTime($year.'-12-31');
        }

        // Create an array to store the generated months
        $months = array();

        // Generate months from start date until end date
        while ($startDate <= $endDate) {
            $monthNumber = $startDate->format('m');
            $months[$startDate->format('F')] = [
                'profit' => 0,
                'expenses' => 0,
                'sales' => 0
            ];
            $startDate->modify('first day of next month');
        }

        return $months;
    }

    public function yearSale($order,$year,$stock,$generatedDaily,$generatedWeekly,$generatedMonthly){
        $toReturnYear = [];
        // $toReturnYear[] = $year;
        $profit = 0;
        $expenses = 0;
        $sales = 0;
        $check = [];
        if($order != null){
            foreach ($order as $key => $value) {
                if(strpos($value['dateDelivered'],$year) !== false){
                    $date = new DateTime($value['dateDelivered']);
                    $week = $date->format('W-Y');
                    $monthly = $date->format('F');
                    $profit = $profit + $value['totalPay'];
                    $check[] = [$value['dateDelivered'],$value['fullName'],$value['totalPay'],$value['status'],$value['itemName'],$key];
                    $generatedDaily[$value['dateDelivered']]['profit'] = $generatedDaily[$value['dateDelivered']]['profit'] + $value['totalPay'];
                    $generatedDaily[$value['dateDelivered']]['sales'] = $generatedDaily[$value['dateDelivered']]['sales'] + $value['totalPay'];
                    $generatedWeekly[$week]['profit'] = $generatedWeekly[$week]['profit'] + $value['totalPay'];
                    $generatedWeekly[$week]['sales'] = $generatedWeekly[$week]['sales'] + $value['totalPay'];
                    $generatedMonthly[$monthly]['profit'] = $generatedMonthly[$monthly]['profit'] + $value['totalPay'];
                    $generatedMonthly[$monthly]['sales'] = $generatedMonthly[$monthly]['sales'] + $value['totalPay'];
                }
                
            }
        }
        if($stock != null){
            foreach ($stock as $key => $value) {
                if(strpos($value['dateDelivered'],$year) !== false){
                    $date = new DateTime($value['dateDelivered']);
                    $week = $date->format('W-Y');
                    $monthly = $date->format('F');
                    $expenses = $expenses + intval($value['total']);
                    $generatedDaily[$value['dateDelivered']]['expenses'] = $generatedDaily[$value['dateDelivered']]['expenses'] + $value['total'];
                    $generatedDaily[$value['dateDelivered']]['sales'] = $generatedDaily[$value['dateDelivered']]['sales'] - $value['total'];
                    $generatedWeekly[$week]['expenses'] = $generatedWeekly[$week]['expenses'] + $value['total'];
                    $generatedWeekly[$week]['sales'] = $generatedWeekly[$week]['sales'] - $value['total'];
                    $generatedMonthly[$monthly]['expenses'] = $generatedMonthly[$monthly]['expenses'] + $value['total'];
                    $generatedMonthly[$monthly]['sales'] = $generatedMonthly[$monthly]['sales'] - $value['total'];
                
                }
            }
        }
        
        $sales = $profit - $expenses;
        $toReturnYear[$year]['profit'] = $profit;
        $toReturnYear[$year]['expenses'] = $expenses;
        $toReturnYear[$year]['sales'] = $sales;
        // $toReturnYear[] = $check;
        return [$generatedDaily,$generatedWeekly,$generatedMonthly,$toReturnYear];
    }
    // Decode the JSON response
}


?>