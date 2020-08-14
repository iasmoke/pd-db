import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})

export class ListTtService {

  constructor(
    private http: HttpClient
  ) { }


  get_all() {
    return this.http.post(
      './assets/php/list_tt_get_all.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }
  edit_settings() {
    return this.http.post(
      './assets/php/register_user.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }
  add_td(){
    return this.http.post(
      './assets/php/register_user.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }
}
