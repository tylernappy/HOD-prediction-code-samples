<?
include './php/vendor/havenondemand/havenondemand/lib/hodclient.php';
$hodClient = new HODClient('APIKEY');

// Train predictor
$serviceName = 'carsService';
$predictionField = 'color';
$filePathTrainPrediction = './data_sets/train_predictor.csv';
$jobID = '';
$dataTrainPredictor = array(
  'file' => $filePathTrainPrediction,
  'prediction_field' => $predictionField,
  'service_name' => $serviceName
);

$hodClient->PostRequest($dataTrainPredictor, HODApps::TRAIN_PREDICTOR, REQ_MODE::ASYNC, 'requestCompletedWithJobId');

// Check status of train prediction
 $hodClient->GetJobStatus($jobID, 'requestCompletedWithContent');

 // Predict
 $filePathPredict = './data_sets/predict.csv';
 $format = 'csv';
 $dataPredict = array(
   'file' => $filePathPredict,
   'service_name' => $serviceName,
   'format' => $format
 );

$hodClient->PostRequest($dataPredict, HODApps::PREDICT, REQ_MODE::SYNC, 'requestCompletedWithContent');

// Recommend
$filePathRecommend = './data_sets/recommend.json';
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
