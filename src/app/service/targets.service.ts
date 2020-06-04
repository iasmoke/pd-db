import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';



@Injectable({
  providedIn: 'root'
})
export class TargetsService {
  constructor(private http: HttpClient) {

  }
  // uploadFile(formData){
  //   const url = './assets/php/file_target.php';
  //   return this.http.post(url,formData,{
  //     reportProgress: true,
  //     observe: 'events'
  //   });
  // }


  getTargets(user_id) {

    return this.http.post(
      './assets/php/get_targets.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' }
    );
  }

  getTargetSetting(user_id, select_type) {

    return this.http.post(
      './assets/php/get_target_setting.php',
      JSON.stringify(
        {
          'user_id': user_id,
          'select_type' : select_type
         
        }
      ),
      { responseType: 'text' }
    );
  }

  targetUpdateSet(user_id, target_name, parameter_name, value_name, start_value, stop_value, step_value, type ) {
    return this.http.post(
      './assets/php/target_set_update.php',
      JSON.stringify(
        {
          'start_value': start_value,
          'stop_value': stop_value,
          'step_value': step_value,
          'type' : type,
          'user_id': user_id,
          'target_name': target_name,
          'parameter_name': parameter_name,
          'value_name' : value_name
        }
      ),
      { responseType: 'text' }
    );
  }

  targetSelect(user_id, target_name) {
    return this.http.post(
      './assets/php/target_select.php',
      JSON.stringify(
      {
        'user_id': user_id,
        'target_name': target_name
      }
      ),
      { responseType: 'text' }
    );
  }

  addTarget(new_target,file_name, user_id,file_py,def_target) {
    return this.http.post(
      './assets/php/add_new_target.php',
      JSON.stringify(
      {
        new_target: new_target,
        file_name:file_name,
        user_id:user_id,
        file_py:file_py,
        def_target:def_target
      }
      ),
      { responseType: 'text' }
    );
  }

  targetSetAdd(user_id, target_name) {
    return this.http.post(
      './assets/php/target_set_add.php',
      JSON.stringify(
      {
        'user_id': user_id,
        'target_name': target_name
      }
      ),
      { responseType: 'text' }
    );
  }

  targetGetSelect(user_id) {

    return this.http.post(
      './assets/php/target_get_select.php',
      JSON.stringify(
        {
          'user_id': user_id
        }
      ),
      { responseType: 'text' }
    );
  }

  autoFillFile(autoFill){
    const url = './assets/php/auto_fill_file_target.php';
    return this.http.post(url,autoFill,{
      reportProgress: true,
      observe: 'events'
    });
  }

  autoFill(file_name) {
    return this.http.post(
      './assets/php/auto_fill_target.php',
      JSON.stringify(
        {
          'file_name': file_name
        }
      ),
      { responseType: 'text' }
    );
  }

  targetSetSelectSettings(user_id) {
    return this.http.post(
      './assets/php/target_set_get_settings.php',
      JSON.stringify(
      {
        'user_id': user_id
        
      }
      ),
      { responseType: 'text' }
    );
  }
}
