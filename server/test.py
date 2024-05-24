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


suburbs = {
    "aberdeen": [22.247778, 114.151667],
    "admiralty": [22.279636, 114.165487],
    "ap Lei Chau": [22.241667, 114.155556],
    "big Wave Bay": [22.245833, 114.2475],
    "braemar hill": [22.286418, 114.206442],
    "causeway bay": [22.28066, 114.18096],
    "central/chung wan": [22.281944, 114.158056],
    "chai wan": [22.2642,114.2365],
    "chung hom hok": [22.21728, 114.20467],
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

cache_session = requests_cache.CachedSession('.cache', expire_after = 3600)
retry_session = retry(cache_session, retries = 5, backoff_factor = 0.2)
openmeteo = openmeteo_requests.Client(session = retry_session)

# All required weather variables
# The order of variables in hourly or daily is important to assign them correctly below
url = "https://api.open-meteo.com/v1/forecast"
params = {
	"latitude": suburbs["aberdeen"][0],
	"longitude": suburbs["aberdeen"][1],
	"hourly": ["temperature_2m", "relative_humidity_2m", "rain", "pressure_msl", "cloud_cover"],
	"daily": ["rain_sum", "wind_speed_10m_max"],
	"timezone": "auto",
	"forecast_days": 7
}

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
general_wind_speed_10m_max = general.Variables(1).ValuesAsNumpy()

general_data = {"date": pd.date_range(
    start = pd.to_datetime(general.Time(), unit = "s"),
    end = pd.to_datetime(general.TimeEnd(), unit = "s"),
    freq = pd.Timedelta(seconds = general.Interval()),
    inclusive = "left"
)}
general_data["rain_sum"] = general_rain_sum
general_data["wind_speed_10m_max"] = general_wind_speed_10m_max

general_dataframe = pd.DataFrame(data = general_data)

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
hourly_data = pd.DataFrame(data=hourly_data)

# Daily prediction data
daily_data = pd.DataFrame()

for i in hourly_data["day"].unique():
    j = hourly_data[hourly_data["day"]==int(i)]
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
    daily_data = pd.concat([daily_data,a], ignore_index=True)

# print(hourly_data,"\n")  
# print(daily_data)

# print(hourly_data[hourly_data["day"]==hourly_data["day"][0]].drop("time", axis = 1))
# print(hourly_data)

# for i in hourly_data.values:
#     print(i[3])

general_dataframe["date"] = general_dataframe["date"].dt.strftime('%d-%b')
print(general_dataframe)