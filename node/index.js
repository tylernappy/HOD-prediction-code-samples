var havenondemand = require('havenondemand')
var client = new havenondemand.HODClient('APIKEY')
var util = require('util')

// Train predictor
var serviceName = 'carsService'
var predictionField = 'color'
var filePathTrainPredictor = './data_sets/train_predictor.csv'
var jobID
var dataTrainPredictor = {file: filePathTrainPredictor, prediction_field: predictionField, service_name: serviceName}

client.call('trainpredictor', dataTrainPredictor, true, function(err1, resp1, body1) {
  jobID = resp1.body.jobID
  console.log(jobID)
})

// Check status of train prediction
client.getJobStatus(jobID, function(err, resp, body) {
  console.log(util.inspect(resp.body, false, null))
})

// Predict
var filePathPredict = './data_sets/predict.csv'
var format = 'csv'
var dataPredict = {file: filePathPredict, service_name: serviceName, format: format}

client.call('predict', dataPredict, function(err, resp, body) {
  console.log("predict")
  console.log(util.inspect(resp.body, false, null))
})

// Recommend
var filePathRecommend = './data_sets/recommend.json'
var requiredLabel = 'blue'
var recommendationsAmount = 3
var dataRecommend = {file: filePathRecommend, service_name: serviceName, required_label: requiredLabel}

client.call('recommend', dataRecommend, function(err, resp, body) {
  console.log("Recommend")
  console.log(util.inspect(resp.body, false, null))
})
