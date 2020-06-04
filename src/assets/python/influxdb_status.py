from influxdb import DataFrameClient

try:
    user     = 'rt_sit'
    password = '8p6iE5ZB'
    host     = '192.168.217.159'
    port     = 8086
    dbname   = 'research_db'
    protocol = 'json'
    client   = DataFrameClient(host, port, user, password, dbname)
    print ('influxdb online')
except:
    print ('influxdb offline')
        
