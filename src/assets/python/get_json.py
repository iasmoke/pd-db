import ast
import sys
import json

dic_params = ast.literal_eval(sys.argv[1])
filename = dic_params['filename']

target_module = __import__(filename.replace('.py',''))
print (json.dumps(target_module.parameters))
