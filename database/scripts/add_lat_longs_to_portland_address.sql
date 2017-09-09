-- All of this needs to be done in Postgres after you have loaded in the
-- the addresses from the csv

-- Add a geom column to your address 
SELECT AddGeometryColumn ('public','portland_addresses','geom',4326,'POINT',2);

-- Set the SRID
SELECT UpdateGeometrySRID('portland_addresses','geom',4326);

-- Set the values for the geom from the x and y fields
UPDATE portland_addresses 
SET geom = ST_Transform(ST_GeomFromText('POINT('|| x ||' '|| y ||')', 2269), 4326);

-- Add our new lat/lng fields
ALTER table portland_addresses ADD COLUMN lat FLOAT;
ALTER table portland_addresses ADD COLUMN lng FLOAT;

-- Set the values of our new lat/lng fields from the geom field
UPDATE portland_addresses SET lat = ST_Y(geom), lng = ST_X(geom);

-- Done!
