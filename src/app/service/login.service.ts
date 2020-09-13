import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { AppComponent } from '../app.component';


@Injectable({

  providedIn: 'root'

})
export class LoginService {

  user_id: string = JSON.parse(localStorage.getItem('id_user_pd'));
  user_name: string = localStorage.getItem('user_name_pd');
  user_role: string = localStorage.getItem('user_role_pd')


  constructor(
    private http: HttpClient
  ) {
  }

  registerUser(user_form) {
    return this.http.post(
      './assets/php/register_user.php',
      JSON.stringify(
        {
          user_form: user_form
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

  getUsersSettingsDistribution(user_id) {
    return this.http.post(
      './assets/php/users_settings_distribution_get.php',
      JSON.stringify({
        'user_id': user_id,
      }
      ),
      { responseType: 'text' }
    );
  }

  toggleUsersSettingsDistribution(user_id,main_page,settings_page,list_tt_page,distribution_page) {
    return this.http.post(
      './assets/php/users_settings_distribution_toggle.php',
      JSON.stringify(
        {
          user_id: user_id,
          main_page:main_page,
          settings_page:settings_page,
          list_tt_page:list_tt_page,
          distribution_page:distribution_page

        }
      ),
      { responseType: 'text' }
    );
  }
}
