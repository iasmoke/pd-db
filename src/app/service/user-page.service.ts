import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class UserPageService {

  constructor(
    private http:HttpClient
  ) { }

  copyTarget(user_id,target_name,target_name_copy){
    return this.http.post(
      './assets/php/user_page_target_copy.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'target_name': target_name,
          'target_name_copy': target_name_copy
        }
      ),
      { responseType: 'text' }
    );
  }
    
  getTargets(user_id) {

    return this.http.post(
      './assets/php/user_page_target_get.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' }
    );
  }

  getFeatures(user_id) {

    return this.http.post(
      './assets/php/user_page_feature_get.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' }
    );
  }

  clickTarget(user_id,target_name) {
    return this.http.post(
      './assets/php/user_page_target_settings.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'target_name':target_name
        }
      ),
      { responseType: 'text' }
    );
  }

  clickFeature(user_id,feature_name) {
    return this.http.post(
      './assets/php/user_page_feature_settings.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'feature_name':feature_name
        }
      ),
      { responseType: 'text' }
    );
  }

  backtestIdGet(user_id) {
    console.log(user_id);
    return this.http.post(
      './assets/php/user_page_backtest_id.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' }
    );
  }

  backtestSettingsGet(user_id,backtest_id) {
    console.log(user_id,backtest_id);
    return this.http.post(
      './assets/php/user_page_backtest_settings.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'backtest_id':backtest_id
        }
      ),
      { responseType: 'text' }
    );
  }

  targetUpdate(user_id,target_name,settings){
  console.log(user_id,target_name,settings);
  return this.http.post(
    './assets/php/user_page_target_update.php',
    JSON.stringify(
      {
        user_id: user_id,
        target_name: target_name,
        settings: settings
      }
    ),
    { responseType: 'text' }
  );
}

featureUpdate(user_id,feature_name,settings){
  console.log(user_id,feature_name,settings);
  return this.http.post(
    './assets/php/user_page_feature_update.php',
    JSON.stringify(
      {
        user_id: user_id,
        feature_name: feature_name,
        settings: settings
      }
    ),
    { responseType: 'text' }
  );
}
}
