FROM nginx:1.19.1-alpine as prod-stage
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

COPY ./dist/pizza-day-personal /ussr/share/nginx/html
EXPOSE 80
CMD [ "nginx", "-g", "daemon off;" ]

# ����� ����������
# ARG APP_DIR=app
# RUN mkdir -p ${APP_DIR}
# WORKDIR ${APP_DIR}

# ��������� ������������
# COPY package*.json ./
# RUN npm install
# ��� ������������� � ���������
# RUN npm install --production

# ����������� ������ �������
# COPY . .

# ����������� � �����, ������� ����� ������������ ���������� ����������
# EXPOSE 3000

# ������ �������
# CMD ["npm", "start"]