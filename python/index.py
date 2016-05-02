# Note: This file is not meant to be run all at once. Comment out API calls (not variables) which are not being used.
# Perform these steps in order:
# 1) Call the Train Predictor API
# 2) Call the Status API
# 3) Call the Predict API
# 4) Call the Recommend API

from havenondemand.hodclient import *
client = HODClient('APIKEY')

## Train predictor
serviceName = 'carsService'
predictionField = 'color'
filePathTrainPredictor = './data_sets/train_predictor.csv' # uncomment if using .csv
# filePathTrainPredictor = './data_sets/train_predictor.json' # uncomment if using .json
jobID = ''
dataTrainPredictor = {'file': filePathTrainPredictor, 'prediction_field': predictionField, 'service_name': serviceName}

r_async = client.post_request(dataTrainPredictor, HODApps.TRAIN_PREDICTOR, async=True)
jobID = r_async['jobID']
print jobID

## Check status of train prediction
response = client.get_job_status(jobID)
print response

## Predict
filePathPredict = './data_sets/predict.csv' # uncomment if using .csv
# filePathPredict = './data_sets/predict.json' # uncomment if using .json
format = 'csv' # uncomment if wanted response is .csv
# format = 'json' # uncomment if wanted response is .json
dataPredict = {'file': filePathPredict, 'service_name': serviceName, 'format': format}

r_predict = client.post_request(dataPredict, HODApps.PREDICT, async=False)
print r_predict

## Recommend
filePathRecommend = './data_sets/recommend.json'
requiredLabel = 'blue'
recommendationsAmount = 3
dataRecommend = {'file': filePathRecommend, 'service_name': serviceName, 'required_label': requiredLabel}

r_recommend = client.post_request(dataRecommend, HODApps.RECOMMEND, async=False)
print r_recommend
