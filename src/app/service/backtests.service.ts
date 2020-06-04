import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class BacktestsService {

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


  getBacktestList(user_id) {
    return this.http.post(
      './assets/php/backtest_list_get.php',
      JSON.stringify(
        {
          user_id: user_id
        }
      ),
      { responseType: 'text' }
    )
  }


  addBacktestList(user_id) {
    return this.http.post(
      './assets/php/add_backtest_list.php',
      JSON.stringify(
        {
          user_id: user_id
        }
      ),
      { responseType: 'text' }
    )
  }
  addBacktestOne(user_id) {
    return this.http.post('./assets/php/add_backtest_one.php',
      JSON.stringify(
        {

          'user_id': user_id
        }
      ),
      { responseType: 'text' });
  }

  readErrorLog(user_id) {
    return this.http.post('./assets/php/read_log_error.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' });
  }
  readProgressStatus(user_id) {
    return this.http.post('./assets/php/read_progress_status.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' });
  }
  
  updateUsersSettings(user_id) {
    return this.http.post('./assets/php/update_users_settings.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' });
  }

  checkStatus(user_id) {
    return this.http.post('./assets/php/check_status.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' });
  }
  checkError(user_id) {
    return this.http.post('./assets/php/check_error.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' });
  }

  selectStatusResearchTrue(user_id) {
    return this.http.post('./assets/php/status_research_user_true.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' });
  }



  graphsSelectBacktestID(user_id, backtest_id) {
    return this.http.post('./assets/php/graphs_change_type_backtest_id.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'backtest_id': backtest_id
        }
      ),
      { responseType: 'text' });
  }
  graphsGetTypeBacktestID(user_id) {
    return this.http.post('./assets/php/graphs_get_select_type.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' });
  }

 
}