# 1) Скрипт должен содержать импорты необходимых для расчета таргета или фичи библиотек
import library1
import library2

# 2) Скрипт должен содержать базовые настройки перебора параметров для автозаполнения полей при создании таргета или фичи в следующем формате:
parameters = [{
               "target_name"/"feature_name": "name",                                           # имя таргета или фичи
               "description": "Some text that describes the idea of your target or feature.",  # краткое описание идеи
               "parameter":[{
                            "parameter_name":"parameter1",                                     # имя параметра
                            "variable_name":"parameter1",                                      # имя переменной параметра
                            "start_value":10,                                                  # стартовое значение
                            "end_value":100,                                                   # конечное значение
                            "step_value":10,                                                   # шаг перебора
                            "type":"int"                                                       # тип параметра ('int, 'float', 'boolean')
                            },
                            {
                            "parameter_name":"parameter2",
                            "variable_name":"parameter2",
                            "start_value":0.1,
                            "end_value":5.0,
                            "step_value":0.5,
                            "type":"float"
                            }]              
              }]

# 3) Скрипт должен содержать основную функцию под именем "run", которая принимает на вход 2 переменные: df_data и dic_parameters.
'''
df_data - pandas.DataFrame с колонками:
datetime,           open,       high,       low,        close,  volume
2018-01-10 17:45,   1.19793,    1.19846,    1.19793,    1.1982, 584

dic_parameters - словарь, в котором ключи - variable_name из переменной parameters, значения - значение переменной для данной итеррации
'''
# 4)  Функция должна возвращать один параметр df_data
'''
Возвращаемый параметр в формате pandas.DataFrame должен содержать в себе колонку с индексами равной колонке с индексами дат входящей переменной df_data
и колонки 'open_buy', 'close_buy', 'open_sell', 'close_sell', сигнал в которых равен 0 или 1 на каждую соответсвующую дату
'''
def run(df_data, dic_parameters):
    parameter1 = dic_parameters['parameter1']
    parameter2 = dic_parameters['parameter2']
    ...
    return df_data[['open_buy', 'close_buy', 'open_sell', 'close_sell']]

