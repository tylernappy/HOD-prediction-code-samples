# Note: This file is not meant to be run all at once. Comment out API calls (not variables) which are not being used.
# Perform these steps in order:
# 1) Call the Train Predictor API
# 2) Call the Status API
# 3) Call the Predict API
# 4) Call the Recommend API
require 'json'

require 'havenondemand'
client = HODClient.new('1bc18f2e-93bd-48c7-901a-c935001a8b14', 'v2')

## Train predictor
modelName = 'testNew1'
predictionField = 'color'
predictorType = 'classification'
filePathTrainPredictor = './data_sets/train_predictor.csv' # uncomment if using .csv
# filePathTrainPredictor = './data_sets/train_predictor.json' # uncomment if using .json
dataTrainPredictor = {file: File.new(filePathTrainPredictor, 'rb'), prediction_field: predictionField, model_name: modelName, predictor_type: predictorType}

# r_trainPredictor= client.post('trainpredictor', dataTrainPredictor, async=true)
# puts r_trainPredictor.json()
#
# ## Check status of train prediction
# puts r_trainPredictor.result().json()

## Predict
# filePathPredict = './data_sets/predict.csv' # uncomment if using .csv
filePathPredict = './data_sets/predict.json' # uncomment if using .json
# format = 'csv' # uncomment if wanted response is .csv
format = 'json' # uncomment if wanted response is .json
fields = JSON.generate({"fields"=>[
    {"name"=>"year","type"=>"INTEGER"},
  	{"name"=>"state","type"=>"RICH_TEXT"},
  	{"name"=>"model","type"=>"RICH_TEXT"},
  	{"name"=>"color","type"=>"RICH_TEXT"}
  ]
})
dataPredict = {file: File.new(filePathPredict, 'rb'), model_name: modelName, format: format, fields: fields}

r_predict = client.post('predict', dataPredict)
puts r_predict.json()
#
# ## Recommend
# filePathRecommend = './data_sets/recommend.json'
# requiredLabel = 'blue'
# recommendationsAmount = 3
# dataRecommend = {file: File.new(filePathRecommend, 'rb'), service_name: serviceName, required_label: requiredLabel}
#
# r_recommend = client.post('recommend', dataRecommend)
# puts r_recommend.json()
