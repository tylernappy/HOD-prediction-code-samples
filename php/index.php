<?
// Note: This file is not meant to be run all at once. Comment out API calls (not variables) which are not being used.
// Perform these steps in order:
// 1) Call the Train Predictor API
// 2) Call the Status API
// 3) Call the Predict API
// 4) Call the Recommend API

include './php/vendor/havenondemand/havenondemand/lib/hodclient.php';
$hodClient = new HODClient('APIKEY');

// Train predictor
$serviceName = 'carsService';
$predictionField = 'color';
$filePathTrainPredictor = '../data_sets/train_predictor.csv'; // uncomment if using .csv
// $filePathTrainPredictor = '../data_sets/train_predictor.json'; // uncomment if using .json
$jobID = '';
$dataTrainPredictor = array(
  'file' => $filePathTrainPredictor,
  'prediction_field' => $predictionField,
  'service_name' => $serviceName
);

$hodClient->PostRequest($dataTrainPredictor, HODApps::TRAIN_PREDICTOR, REQ_MODE::ASYNC, 'requestCompletedWithJobId');

// Check status of train prediction
$hodClient->GetJobStatus($jobID, 'requestCompletedWithContent');

 // Predict
$filePathPredict = '../data_sets/predict.csv'; // uncomment if using .csv
// $filePathPredict = '../data_sets/predict.json'; // uncomment if using .json
$format = 'csv'; // uncomment if wanted response is .csv
// $format = 'json'; // uncomment if wanted response is .json
 $dataPredict = array(
   'file' => $filePathPredict,
   'service_name' => $serviceName,
   'format' => $format
 );

$hodClient->PostRequest($dataPredict, HODApps::PREDICT, REQ_MODE::SYNC, 'requestCompletedWithContent');

// Recommend
$filePathRecommend = '../data_sets/recommend.json';
$requiredLabel = 'blue';
$recommendationsAmount = 3;
$dataRecommend = array(
  'file' => $filePathRecommend,
  'service_name' => $serviceName,
  'required_label' => $requiredLabel
);

$hodClient->PostRequest($dataRecommend, HODApps::RECOMMEND, REQ_MODE::SYNC, 'requestCompletedWithContent');

// Callback functions
function requestCompletedWithContent($response) {
  print_r($response);
}

function requestCompletedWithJobId($response) {
  $jobID = $response;
  echo $jobID;
}
?>
