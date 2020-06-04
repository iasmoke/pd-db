import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class DataService {

  disabledOpenGraph = false;

  constructor(
    private http: HttpClient
  ) { }


  getCurrentData(user_id) {
    return this.http.post(
      './assets/php/get_current_data.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' }
    );
  }

  getDataType() {
    return this.http.post(
      './assets/php/data_get_type_data.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }

   select1Null(user_id) {
    return this.http.post(
      './assets/php/data_type_data_select_null.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' }
    );
  }

  select2Null(user_id) {
    return this.http.post(
      './assets/php/data_type_timeframe_select_null.php',
      JSON.stringify(
        {
          'user_id': user_id
      
        }
      ),
      { responseType: 'text' }
    );
  }

  select3Null(user_id) {
    return this.http.post(
      './assets/php/data_ticker_select_null.php',
      JSON.stringify(
        {
          'user_id': user_id
         
        }
      ),
      { responseType: 'text' }
    );
  }


   select4Null(user_id) {
    return this.http.post(
      './assets/php/data_source_select_null.php',
      JSON.stringify(
        {
          'user_id': user_id
         
        }
      ),
      { responseType: 'text' }
    );
  }

  getTimeFrameType(user_id, data_type) {
    console.log(data_type);
    
    return this.http.post(
      './assets/php/data_get_time_type.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'data_type': data_type
        }
      ),
      { responseType: 'text' }
    );
  }

  getTicker(user_id, data_type, timeframe_type) {
    return this.http.post(
      './assets/php/data_get_ticker.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'data_type': data_type,
          'timeframe_type': timeframe_type
        }
      ),
      { responseType: 'text' }
    );
  }

  getTimeFrame(user_id, data_type, timeframe_type, ticker) {
    return this.http.post(
      './assets/php/data_get_source.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'data_type': data_type,
          'timeframe_type': timeframe_type,
          'ticker': ticker
        }
      ),
      { responseType: 'text' }
    );
  }

  getSource(user_id,data_type,timeframe_type,ticker,source){
    return this.http.post(
      './assets/php/data_get_timeframe.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'data_type': data_type,
          'timeframe_type': timeframe_type,
          'ticker': ticker,
          'source': source
        }
      ),
      { responseType: 'text' }
    );
  }

  changeTime(user_id,timeframe){
    return this.http.post(
      './assets/php/data_change_timefrime.php',
      JSON.stringify({
        'user_id':user_id,
        'timeframe':timeframe
      }),
      {responseType:'text'}
    );
  }

  getDate(user_id, parameter_name) {
    console.log(user_id, parameter_name);

    return this.http.post(
      './assets/php/get_date.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'parameter_name': parameter_name
        }
      ),
      { responseType: 'text' }
    );
  }


  dateUpdate(user_id, parameter_value, parameter_name) {
    console.log(user_id, parameter_value, parameter_name);

    return this.http.post(
      './assets/php/date_update.php',
      JSON.stringify(
        {

          'user_id': user_id,
          'parameter_value': parameter_value,
          'parameter_name': parameter_name
        }
      ),
      { responseType: 'text' }
    );
  }

  getDateDB(data_type, timeframe_type, ticker, source, timeframe){
    return this.http.post(
      './assets/php/data_get_dateDB.php',
      JSON.stringify(
        {
         
          'data_type': data_type,
          'timeframe_type': timeframe_type,
          'ticker': ticker,
          'source': source,
          'timeframe': timeframe
        }
      ),
      { responseType: 'text' }
    );
  }
  dataGraph(start_date, end_date,user_id, data_type,ticker, source, timeframe){
    return this.http.post(
      './assets/php/data_graph.php',
      JSON.stringify(
        {
          start_date:start_date,
          end_date:end_date,
          user_id:user_id,
          data_type: data_type,
          ticker: ticker,
          source: source,
          timeframe: timeframe
        }
      ),
      { responseType: 'text' }
    );
  }

  statusDB(){
    return this.http.post(
      './assets/php/influxdb_db.php',
      JSON.stringify(
        { 
        }
      ),
      { responseType: 'text' }
    );
  }

}
