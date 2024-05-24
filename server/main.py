from joblib import load
from sklearn.naive_bayes import GaussianNB
from sklearn.preprocessing import StandardScaler
import pandas as pd
import numpy as np

from fastapi import FastAPI, Response
from starlette.status import HTTP_422_UNPROCESSABLE_ENTITY, HTTP_200_OK
from fastapi.middleware.cors import CORSMiddleware
from typing import Optional
from pydantic import BaseModel

import openmeteo_requests

import requests_cache
from retry_requests import retry

# request body
class Weather_info(BaseModel):
    year: int
    month: int
    day: int
    cloud: float
    humidity: float
    pressure: float
    rainfall: float
    temperature: float

#  Suburb list and their coordinate
suburbs = {
    "aberdeen": [22.247778, 114.151667],
    "admiralty": [22.279636, 114.165487],
    "ap lei chau": [22.241667, 114.155556],
    "big wave bay": [22.245833, 114.2475],
    "braemar hill": [22.286418, 114.206442],
    "causeway bay": [22.28066, 114.18096],
    "central chung wan": [22.281944, 114.158056],
    "chai wan": [22.2642,114.2365],
    "chung hom kok": [22.21728, 114.20467],
    "cyberport": [22.261806, 114.130214],
    "deep water bay": [22.241661, 114.182619],
    "east mid-levels": [22.2833,114.1500],
    "fortress hill": [22.28858, 114.19417],
    "happy valley": [22.266667, 114.183333],
    "jardine\'s lookout": [22.26827, 114.19244],
    "kennedy town": [22.2813, 114.1277],
    "lung fu shan": [22.2799, 114.1351],
    "mid-levels": [22.28262, 114.14261],
    "mount davis": [22.277028, 114.124789],
    "north point": [22.287111, 114.191667],
    "pok fu lam": [22.260017, 114.137703],
    "quarry bay": [22.28313, 114.21279],
    "repulse bay": [22.2366, 114.1974],
    "sai wan ho": [22.281612, 114.222101],
    "sai wan": [22.285, 114.132],
    "sai ying pun": [22.28591, 114.14283],
    "sandy bay": [22.266667, 114.125667],
    "shau kei wan": [22.27945, 114.23022],
    "shek o": [22.230556, 114.251944],
    "shek tong tsui": [22.2866, 114.1352],
    "sheung wan": [22.28524, 114.15139],
    "siu sai wan": [22.2617, 114.2492],
    "so kon po": [22.27414, 114.18937],
    "stanley": [22.216667, 114.216667],
    "tai hang": [22.2820, 114.1925],
    "tai tam": [22.23789, 114.22368],
    "tin hau": [22.2824, 114.1925],
    "victoria park": [22.281944, 114.188056],
    "victoria peak": [22.275556, 114.143889],
    "wan chai": [22.279722, 114.171667],
    "west mid-levels": [22.2849,114.1458],
    "wong chuk hang": [22.24818, 114.16765]
}

# Call API for weather data suburbs list above ^^^
# parameter:
# get_data(suburb=suburbs[suburb_name])
def get_data(suburb):
    # Setup the Open-Meteo API client with cache and retry on error
    cache_session = requests_cache.CachedSession('.cache', expire_after = 3600)
    retry_session = retry(cache_session, retries = 5, backoff_factor = 0.2)
    openmeteo = openmeteo_requests.Client(session = retry_session)

    # All required weather variables
    # The order of variables in hourly or daily is important to assign them correctly below
    url = "https://api.open-meteo.com/v1/forecast"
    params = {
	    "latitude": suburb[0],
	    "longitude": suburb[1],
	    "hourly": ["temperature_2m", "relative_humidity_2m", "rain", "pressure_msl", "cloud_cover"],
	    "daily": ["rain_sum", "wind_speed_10m_max"],
	    "timezone": "auto",
	    "forecast_days": 9
    }

    # Send request
    weather_forecast = openmeteo.weather_api(url, params=params)[0]

    # Process hourly data. The order of variables needs to be the same as requested.
    hourly = weather_forecast.Hourly()
    hourly_temperature_2m = hourly.Variables(0).ValuesAsNumpy()
    hourly_relative_humidity_2m = hourly.Variables(1).ValuesAsNumpy()
    hourly_rain = hourly.Variables(2).ValuesAsNumpy()
    hourly_pressure_msl = hourly.Variables(3).ValuesAsNumpy()
    hourly_cloud_cover = hourly.Variables(4).ValuesAsNumpy()

    hourly_data = {"date": pd.date_range(
	    start = pd.to_datetime(hourly.Time(), unit = "s"),
	    end = pd.to_datetime(hourly.TimeEnd(), unit = "s"),
	    freq = pd.Timedelta(seconds = hourly.Interval()),
	    inclusive = "left"
    )}

    hourly_data["temperature_2m"] = hourly_temperature_2m
    hourly_data["relative_humidity_2m"] = hourly_relative_humidity_2m
    hourly_data["rain"] = hourly_rain
    hourly_data["pressure_msl"] = hourly_pressure_msl
    hourly_data["cloud_cover"] = hourly_cloud_cover

    # Process general data. The order of variables needs to be the same as requested.
    general = weather_forecast.Daily()
    general_rain_sum = general.Variables(0).ValuesAsNumpy()
    general_wind_speed_max = general.Variables(1).ValuesAsNumpy()

    general_data = {"date": pd.date_range(
        start = pd.to_datetime(general.Time(), unit = "s"),
        end = pd.to_datetime(general.TimeEnd(), unit = "s"),
        freq = pd.Timedelta(seconds = general.Interval()),
        inclusive = "left"
    )}
    general_data["rain_sum"] = general_rain_sum
    general_data["wind_speed_max"] = general_wind_speed_max

    general_dataframe = pd.DataFrame(data = general_data)
    general_dataframe["date"] = general_dataframe["date"].dt.strftime('%d-%b')

    # Extract data from API for prediction
    data = pd.DataFrame()

    hourly_data = {
        "year": hourly_data["date"].year,
        "month": hourly_data["date"].month,
        "day": hourly_data["date"].day,
        "time": hourly_data["date"].time,
        "cloud": hourly_data["cloud_cover"],
        "humidity": hourly_data["relative_humidity_2m"], 
        "pressure": hourly_data["pressure_msl"], 
        "rainfall": hourly_data["rain"],
        "temperature": hourly_data["temperature_2m"]
    }
    hourly_dataframe = pd.DataFrame(data=hourly_data, index=None)

    # Daily prediction data
    daily_dataframe = pd.DataFrame()

    for i in hourly_dataframe["day"].unique():
        j = hourly_dataframe[hourly_dataframe["day"]==i]
        a = {
            "year": j["year"].head(n=1),
            "month": j["month"].head(n=1),
            "day": i,
            "cloud": np.max(j["cloud"]),
            "humidity": np.mean(j["humidity"]), 
            "pressure": np.mean(j["pressure"]), 
            "rainfall": np.sum(j["rainfall"]),
            "temperature": np.mean(j["temperature"])
        }
        a = pd.DataFrame(a)
        daily_dataframe = pd.concat([daily_dataframe,a], ignore_index=True)

    return (general_dataframe, daily_dataframe, hourly_dataframe)

# Get daily information weather code and maximum temperature
def get_7_day_weather_forecast_data(suburb):
    # Setup the Open-Meteo API client with cache and retry on error
    cache_session = requests_cache.CachedSession('.cache', expire_after = 3600)
    retry_session = retry(cache_session, retries = 5, backoff_factor = 0.2)
    openmeteo = openmeteo_requests.Client(session = retry_session)

    # All required weather variables
    # The order of variables in hourly or daily is important to assign them correctly below
    url = "https://api.open-meteo.com/v1/forecast"
    params = {
	    "latitude": suburb[0],
	    "longitude": suburb[1],
	    "daily": ["weather_code", "temperature_2m_max"],
	    "timezone": "auto",
	    "forecast_days": 9
    }

    # Send request
    weather_forecast = openmeteo.weather_api(url, params=params)[0]

    #  Process daily data. The order of variables needs to be the same as requested.
    daily = weather_forecast.Daily()
    daily_weather_code = daily.Variables(0).ValuesAsNumpy()
    daily_temperature_max = daily.Variables(1).ValuesAsNumpy()

    daily_data = {"date": pd.date_range(
	    start = pd.to_datetime(daily.Time(), unit = "s"),
	    end = pd.to_datetime(daily.TimeEnd(), unit = "s"),
	    freq = pd.Timedelta(seconds = daily.Interval()),
	    inclusive = "left"
    )}
    
    daily_data["weather_code"] = daily_weather_code.astype(np.int32)
    daily_data["temperature_max"] = daily_temperature_max.astype(np.int32)

    daily_dataframe = pd.DataFrame(data = daily_data)

    daily_dataframe["day_of_week"] = daily_dataframe["date"].dt.strftime('%A')
    daily_dataframe["date"] = daily_dataframe["date"].dt.strftime('%d-%b')
    
    return (daily_dataframe)

# Load the model and scalar
clf = load("..\\model\\weather_classifier.joblib") 
sca = load("..\\model\\weather_standard_scaler.joblib")

origins = ["*"]

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)



# APIs
# Predict 1 time
@app.get("/flood_prediction")
async def weather_prediction(weather: Weather_info):
    
    input = sca.transform([[
        weather.year,
        weather.month,
        weather.day,
        weather.cloud,
        weather.humidity,
        weather.pressure,
        weather.rainfall,
        weather.temperature,
    ]])

    prediction = clf.predict(input)
    
    return {"result":bool(prediction[0])}
    
# Predict in 7 seven days
@app.get("/flood_prediction_in_seven_days/{suburb_name}")
async def weather_prediction_in_seven_days(suburb_name: str, response: Response):

    if (suburb_name not in suburbs.keys()):
        response.status_code = HTTP_422_UNPROCESSABLE_ENTITY
        return {"detail": "Invalid suburb name"}
    
    _, daily_data,_ = get_data(suburb=suburbs[suburb_name])

    input = sca.transform(daily_data)
    output = clf.predict(input)
    daily_data["flood_prediction"] = output

    return daily_data.to_dict("list")

# Predict for the rest of current date
@app.get("/flood_prediction_current_date/{suburb_name}")
async def flood_prediction_current_date(suburb_name: str, response: Response):

    if (suburb_name not in suburbs.keys()):
        response.status_code = HTTP_422_UNPROCESSABLE_ENTITY
        return {"detail": "Invalid suburb name"}
    
    _, _, hourly_data = get_data(suburb=suburbs[suburb_name])
    hourly_data = hourly_data[hourly_data["day"]==hourly_data["day"][0]]

    input = sca.transform(hourly_data.drop("time",axis=1))
    output = clf.predict(input)
    hourly_data["flood_prediction"] = output
    
    result = {
        "result": []
    }

    for i in hourly_data.values:
        if (i[9] == 1):
            return {"result": "Flood happen at "+ i[3].strftime('%H:%M:%S')}

    return {"result": "No Flooding Forecast"}

# General weather forecast
@app.get("/general_weather_forcast/{suburb_name}")
async def general_weather_forcast(suburb_name: str, response: Response):

    if (suburb_name not in suburbs.keys()):
        response.status_code = HTTP_422_UNPROCESSABLE_ENTITY
        return {"detail": "Invalid suburb name"}
    
    general_data, _, _ = get_data(suburb=suburbs[suburb_name])

    return general_data.to_dict("list")

# General weather forecast
@app.get("/7_day_weather_forecast/{suburb_name}")
async def general_weather_forcast(suburb_name: str, response: Response):

    if (suburb_name not in suburbs.keys()):
        response.status_code = HTTP_422_UNPROCESSABLE_ENTITY
        return {"detail": "Invalid suburb name"}
    
    general_data = get_7_day_weather_forecast_data(suburb=suburbs[suburb_name])

    return general_data.to_dict("list")
