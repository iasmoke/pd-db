import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class TelegramSendService {

  constructor(
    private http:HttpClient
  ) { }

  telegram_send_get_list_type_department(){
    return this.http.post(
      './assets/php/telegram_send_get_list_type_department.php',
      JSON.stringify(
        {

        }
      ),
      { responseType: 'text' }
    );
  }

  telegram_send_get_list_all_person(type_department){
    return this.http.post(
      './assets/php/telegram_send_get_list_all_person.php',
      JSON.stringify(
        {
          type_department:type_department,
        }
      ),
      { responseType: 'text' }
    );
  }

  telegram_send_get_department_list(type_department){
    return this.http.post(
      './assets/php/telegram_send_get_department_list.php',
      JSON.stringify(
        {
          type_department:type_department,
        }
      ),
      { responseType: 'text' }
    );
  }

  telegram_send_get_department_list_person(type_department,department){
    return this.http.post(
      './assets/php/telegram_send_get_department_list_person.php',
      JSON.stringify(
        {
          type_department:type_department,
          department:department
        }
      ),
      { responseType: 'text' }
    );
  }

  telegram_send_get_list_cities(){
    return this.http.post(
      './assets/php/telegram_send_get_list_cities.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }

  telegram_send_get_list_person_by_cities(array_city){
    return this.http.post(
      './assets/php/telegram_send_get_list_person_by_cities.php',
      JSON.stringify(
        {
          array_city:array_city
        }
      ),
      { responseType: 'text' }
    );
  }

  telegram_send_get_person_by_number_tt(array_number_td){
    return this.http.post(
      './assets/php/telegram_send_get_person_by_number_tt.php',
      JSON.stringify(
        {
          array_number_td:array_number_td
        }
      ),
      { responseType: 'text' }
    );
  }

  telegram_send_get_position_td(){
    return this.http.post(
      './assets/php/telegram_send_get_position_td.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }

  telegram_send_get_all_person_position (type_department,position){
    return this.http.post(
      './assets/php/telegram_send_get_all_person_position.php',
      JSON.stringify(
        {
          type_department:type_department,
          position:position
        }
      ),
      { responseType: 'text' }
    );
  }

  add_TOKEN_user(user_id,user_name,TOKEN_id,TOKEN_name){
    return this.http.post(
      './assets/php/telegram_add_token.php',
      JSON.stringify(
        {
          user_id:user_id,
          user_name:user_name,
          TOKEN_id:TOKEN_id,
          TOKEN_name:TOKEN_name,
        }
      ),
      { responseType: 'text' }
    );
  }

  get_my_token(user_id){
    return this.http.post(
      './assets/php/telegram_get_token_name.php',
      JSON.stringify(
        {
          user_id:user_id
        }
      ),
      { responseType: 'text' }
    );
  }


  get_type_department(){
    return this.http.post(
      './assets/php/telegram_get_type_department.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }
  get_department_trade_dot(city){
    return this.http.post(
      './assets/php/telegram_get_department.php',
      JSON.stringify(
        {
          city:city
        }
      ),
      { responseType: 'text' }
    );
  }
    get_position(){
    return this.http.post(
      './assets/php/telegram_get_trade_dot_position.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }


  get_data_send_bot(department){
    return this.http.post(
      './assets/php/telegram_get_data_send.php',
      JSON.stringify(
        {
          department:department
        }
      ),
      { responseType: 'text' }
    );
  }

  get_department_office(type_department){
    return this.http.post(
      './assets/php/telegram_get_department_office.php',
      JSON.stringify(
        {
          type_department:type_department
        }
      ),
      { responseType: 'text' }
    );
  }
}
