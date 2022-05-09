<?php

namespace App\Traits;


use Freshbitsweb\LaravelGoogleAnalytics4MeasurementProtocol\Facades\GA4;
use Exception;
//use Google_Client;
//use Google_Service_AnalyticsReporting;
//use Google_Service_AnalyticsReporting_DateRange;
//use Google_Service_AnalyticsReporting_GetReportsRequest;
//use Google_Service_AnalyticsReporting_Metric;
//use Google_Service_AnalyticsReporting_ReportRequest;


trait GoogleAnalytics4
{
    public function postEvent($data)
    {
        try{
            $test = GA4::postEvent($data);
            return $test;
        }catch(Exception $e){
            return false;
        }

    }

//    public function result()
//    {
//        $analytics = $this->initializeAnalytics();
//        $response = $this->getReport($analytics);
//        dd($response);
//        return $this->printResults($response);
//    }
//
//    public function initializeAnalytics()
//    {
//
//        // Use the developers console and download your service account
//        // credentials in JSON format. Place them in this directory or
//        // change the key file location if necessary.
//        $KEY_FILE_LOCATION = storage_path(). '/service-account-credentials.json';
//
//        // Create and configure a new client object.
//        $client = new Google_Client();
//        $client->setApplicationName("Hello Analytics Reporting");
//        $client->setAuthConfig($KEY_FILE_LOCATION);
//        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
//        $analytics = new Google_Service_AnalyticsReporting($client);
//
//        return $analytics;
//    }
//
//    public function getReport($analytics) {
//
//        // Replace with your view ID, for example XXXX.
//        $VIEW_ID = "257770106";
//
//        // Create the DateRange object.
//        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
//        $dateRange->setStartDate("7daysAgo");
//        $dateRange->setEndDate("today");
//
//        // Create the Metrics object.
//        $sessions = new Google_Service_AnalyticsReporting_Metric();
//        $sessions->setExpression("addToCarts");
//        $sessions->setAlias("addToCarts");
//
//        // Create the ReportRequest object.
//        $request = new Google_Service_AnalyticsReporting_ReportRequest();
//        $request->setViewId($VIEW_ID);
//        $request->setDateRanges($dateRange);
//        $request->setMetrics(array($sessions));
//
//        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
//        $body->setReportRequests( array( $request) );
//        return $analytics->reports->batchGet( $body );
//    }
//
//    public function printResults($reports) {
//        for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
//            $report = $reports[ $reportIndex ];
//            $header = $report->getColumnHeader();
//            $dimensionHeaders = $header->getDimensions();
//            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
//            $rows = $report->getData()->getRows();
//
//            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
//                $row = $rows[ $rowIndex ];
//                $dimensions = $row->getDimensions();
//                $metrics = $row->getMetrics();
//                for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
//                    print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
//                }
//
//                for ($j = 0; $j < count($metrics); $j++) {
//                    $values = $metrics[$j]->getValues();
//                    for ($k = 0; $k < count($values); $k++) {
//                        $entry = $metricHeaders[$k];
//                        print($entry->getName() . ": " . $values[$k] . "\n");
//                    }
//                }
//            }
//        }
//    }
}
