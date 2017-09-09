#! /bin/bash

# This is a simple transformation step to the csv file available
# at: http://gis-pdx.opendata.arcgis.com/datasets/address/data
# 
# It will make sure we only get the following fields from the file:
# - OBJECTID
# - ADD_NUM_CH
# - STR_PREDIR
# - STR_NAME
# - STR_TYPE_C
# - STR_NM_FUL
# - UNIT_VALUE
# - ADD_FULL
# - CITY
# - STATE
# - STATE_ABBR
# - ZIP_CODE
# - JURIS
# - X
# - Y

cat Address.csv | cut -d, -f1,4,6-8,10-16,18,24,25 > portland_address_abbr.csv
