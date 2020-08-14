import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class SettingsUsersService {

  user_server: any;

  constructor(
    private http: HttpClient
  ) { }

  RunPy(user_id, backtest_id) {
    console.log(user_id, backtest_id);
    return this.http.post('http://' + this.user_server + '/research_tool/assets/python/trading_script/start_py.php',
      JSON.stringify(
        {
          user_id: user_id,
          backtest_id: backtest_id
        }
      ),
      { responseType: 'text' });
  }


  get_users() {
    return this.http.post(
      './assets/php/settings_users_get.php',
      JSON.stringify(
        {
          
        }
      ),
      { responseType: 'text' }
    )
  }

  update_user_settings(user_id,first_name,last_name,user_name,password,user_role) {
    return this.http.post(
      './assets/php/settings_users_update.php',
      JSON.stringify(
        {
          user_id:user_id,
          first_name:first_name,
          last_name:last_name,
          user_name:user_name,
          password:password,
          user_role:user_role
        }
      ),
      { responseType: 'text' }
    )
  }


}
