require 'havenondemand'
client = HODClient.new('APIKEY')

## Train predictor
serviceName = 'carsService'
predictionField = 'color'
filePathTrainPredictor = './data_sets/train_predictor.csv'
dataTrainPredictor = {file: File.new(filePathTrainPredictor, 'rb'), prediction_field: predictionField, service_name: serviceName}

r_trainPredictor= client.post('trainpredictor', dataTrainPredictor, async=true)
puts r_trainPredictor.json()

## Check status of train prediction
puts r_trainPredictor.status().json()

## Predict
filePathPredict = './data_sets/predict.csv'
format = 'csv'
dataPredict = {file: File.new(filePathPredict, 'rb'), service_name: serviceName, format: format}

r_predict = client.post('predict', dataPredict)
puts r_predict.json()

## Recommend
filePathRecommend = './data_sets/recommend.json'
requiredLabel = 'blue'
recommendationsAmount = 3
dataRecommend = {file: File.new(filePathRecommend, 'rb'), service_name: serviceName, required_label: requiredLabel}

r_recommend = client.post('recommend', dataRecommend)
puts r_recommend.json()
