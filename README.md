pucara-web
===========

### Datos ###

```
UPDATE `meteorological_forecast` SET `mine_id` = '1';
UPDATE `aeronautical_forecast` SET `mine_id` = '1';
UPDATE `maritime_forecast` SET `mine_id` = '1';
UPDATE `road` SET `mine_id` = '1';
UPDATE `link` SET `mine_id` = '1';
UPDATE `weather_trend` SET `mine_id` = '1';
```

### ck editor ###

```
bin/console ckeditor:install
bin/console assets:install
```

## compose local ##

´´´
version: '3'
services:
  app:
    environment:
      - SYMFONY_ENV=stage
    volumes:
      - /home/ubuntu/.ssh:/root/.ssh
´´´