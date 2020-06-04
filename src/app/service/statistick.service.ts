import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class StatistickService {

  backtest_id:any;

  constructor(
    private http:HttpClient
  ) {}

  getStatistickTable( backtest_id) {
    console.log(backtest_id);
    return this.http.post(
      './assets/php/statistick_table_get.php',
      JSON.stringify(
        {
          'backtest_id':backtest_id
        }
      ),
      { responseType: 'text' }
    );
  }

  getBacktestId(user_id){
    return this.http.post(
      './assets/php/statistick_backtest_id_get.php',
      JSON.stringify(
        {
          user_id: user_id
          
        }
      ),
      { responseType: 'text' }
    );
  }
  selectBacktestId(user_id,backtest_id){
    return this.http.post(
      './assets/php/statistick_select_backtest_id.php',
      JSON.stringify(
        {
          user_id: user_id,
          backtest_id:backtest_id
          
        }
      ),
      { responseType: 'text' }
    );
  }

  getGraphOpen(backtest_id:number, code){
    return this.http.post(
      './assets/php/statistick_graph_open.php',
      JSON.stringify(
        {
          backtest_id: backtest_id,
          code:code
          
        }
      ),
      { responseType: 'text' }
    );
  }
  getSelectBacktestId (user_id){
    return this.http.post(
      './assets/php/statistick_get_select_type.php',
      JSON.stringify(
        {
          user_id: user_id
          
        }
      ),
      { responseType: 'text' }
    );
  }
  
}
