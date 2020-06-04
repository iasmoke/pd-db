import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { AppComponent } from '../app.component';


@Injectable({

  providedIn: 'root'

})
export class LoginService {




  user_id: string = JSON.parse(localStorage.getItem('user_id_rt'));
  user_name_title: string = localStorage.getItem('user_name_title');



  constructor(
    private http: HttpClient
  ) {
    console.log(this.user_id);
    console.log(this.user_name_title);


  }

  registerUser(user_form) {
    return this.http.post(
      './assets/php/register_user.php',
      JSON.stringify(
        {
          user_form:user_form
        }
      ),
      { responseType: 'text' }
    );
  }

  getLogin(user_name, password) {

    return this.http.post(
      './assets/php/login.php',
      JSON.stringify({

        'user_name': user_name,
        'password': password
      }
      ),
      { responseType: 'text' }
    );
  }

  getSettingsUser(user_id) {
    return this.http.post(
      './assets/php/user_settings_get.php',
      JSON.stringify({
        'user_id': user_id,
      }
      ),
      { responseType: 'text' }
    );
  }

}
