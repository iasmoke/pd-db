import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class SpreadService {

  constructor(
    private http: HttpClient
  ) { 

  }

  addSpread(user_id, spread_from, spread_to, spread_value) {
    console.log(spread_from,spread_to, spread_value);
    
    return this.http.post(
      './assets/php/add_spread.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'spread_from': spread_from,
          'spread_to': spread_to,
          'spread_value': spread_value
        }
      ),
      { responseType: 'text' }
    );
  }

  removeSpread(user_id, spread_name){
    console.log(user_id, spread_name);
    return this.http.post(
      './assets/php/remove_spread.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'spread_name': spread_name
        }
      ),
      { responseType: 'text' }
    );
  }
  

  getSpread(user_id){
    return this.http.post(
      './assets/php/get_spread.php',
      JSON.stringify(
      {
        'user_id': user_id
      }
      ),
      {responseType: 'text'}
    );
  }

  spreadUpdate( spread_from, spread_to, spread_value, user_id, spread_name) {
    return this.http.post(
      './assets/php/spread_update.php',
      JSON.stringify(
        {
          'spread_from': spread_from,
          'spread_to': spread_to,
          'spread_value': spread_value,
          'user_id' : user_id,
          'spread_name' : spread_name
        }
      ),
      { responseType: 'text' }
    );
  }
}