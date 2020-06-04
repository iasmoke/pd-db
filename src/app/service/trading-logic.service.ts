import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class TradingLogicService {
  constructor(
    private http: HttpClient
  ) { }

  tradingLogicGet(user_id, parameter_name) {
    return this.http.post(
      './assets/php/trading_logic_get.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'parameter_name': parameter_name
        }
      ),
      { responseType: 'text' }
    );
  }

  tradingLogicUpdate(value,user_id, value_name,parameter_name) {
    return this.http.post(
      './assets/php/trading_logic_update.php',
      JSON.stringify(
        {
          'value': value,
          'user_id': user_id,
          'value_name': value_name,
          'parameter_name': parameter_name
        }
      ),
      { responseType: 'text' }
    );
  }
}
