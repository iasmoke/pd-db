import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class TelegramSendService {

  constructor(
    private http:HttpClient
  ) { }

  get_city(){
    return this.http.post(
      './assets/php/telegram_get_city.php',
      JSON.stringify(
        {

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
