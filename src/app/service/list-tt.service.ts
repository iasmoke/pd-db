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
  
  edit_outlet(edit_outlet) {
    return this.http.post(
      './assets/php/list_tt_edit.php',
      JSON.stringify(
        {
          edit_outlet:edit_outlet
        }
      ),
      { responseType: 'text' }
    );
  }
  
  add_outlet(new_outlet){
    return this.http.post(
      './assets/php/list_tt_add.php',
      JSON.stringify(
        {
          new_outlet:new_outlet
        }
      ),
      { responseType: 'text' }
    );
  }
}
