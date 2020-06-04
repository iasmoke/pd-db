import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class Features {

  constructor(private http: HttpClient) {

  }

  uploadFile(formData) {

    const url = './assets/php/file_feature.php';
    return this.http.post(url, formData, {
      reportProgress: true,
      observe: 'events'
    });
  }

  getFeaturesName(user_id) {
    return this.http.post(
      './assets/php/features_name_get.php',
      JSON.stringify(
        {
          'user_id': user_id

        }
      ),
      { responseType: 'text' }
    );
  }

  get_feature_set_name(user_id) {
    return this.http.post(
      './assets/php/feature_set_name.php',
      JSON.stringify(
        {
          'user_id': user_id

        }
      ),
      { responseType: 'text' }
    );
  }

  getFeaturesSetSettings(user_id, feature_name) {
    return this.http.post(
      './assets/php/features_set_settings_get.php',
      JSON.stringify(
        {
          user_id: user_id,
          feature_name: feature_name
        }
      ),
      { responseType: 'text' }
    );
  }

  getFeaturesSetting(user_id) {
    return this.http.post(
      './assets/php/features_setting_get.php',
      JSON.stringify(
        {
          'user_id': user_id

        }
      ),
      { responseType: 'text' }
    );
  }

  FeaturesSetUpdate(user_id, feature_name, parameter_name,value_name, start_value, stop_value, step_value, type) {
    
    return this.http.post(
      './assets/php/features_set_setting_update.php',
      JSON.stringify(
        {
          'start_value': start_value,
          'stop_value': stop_value,
          'step_value': step_value,
          'type' : type,
          'user_id': user_id,
          'feature_name': feature_name,
          'parameter_name': parameter_name,
          'value_name' : value_name
        }
      ),
      { responseType: 'text' }
    );
  }

  featureSelect(user_id, features_array) {
    return this.http.post(
      './assets/php/feature_select.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'features_array': features_array
        }
      ),
      { responseType: 'text' }
    );
  }

  featureInsert(user_id, feature_name) {
    return this.http.post(
      './assets/php/features_set_add_select.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'feature_name': feature_name
        }
      ),
      { responseType: 'text' }
    );
  }

  featureSetDelete(user_id, feature_name) {
    return this.http.post(
      './assets/php/features_set_delete.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'feature_name': feature_name

        }
      ),
      { responseType: 'text' }
    );
  }

  addFeature(new_feature, file_name, user_id, def_feature,file_py) {
    return this.http.post(
      './assets/php/add_new_feature.php',
      JSON.stringify(
        {
          new_feature: new_feature,
          file_name: file_name,
          user_id: user_id,
          def_feature:def_feature,
          file_py:file_py
        }
      ),
      { responseType: 'text' }
    );
  }

  autoFillFile(autoFill){
    const url = './assets/php/auto_fill_file_feature.php';
    return this.http.post(url,autoFill,{
      reportProgress: true,
      observe: 'events'
    });
  }

  autoFill(file_name) {
    return this.http.post(
      './assets/php/auto_fill_feature.php',
      JSON.stringify(
        {
          'file_name': file_name
        }
      ),
      { responseType: 'text' }
    );
  }

}
