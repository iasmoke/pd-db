import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class MainService {

  constructor(
    private http: HttpClient
  ) { }

  admin_main_table_get() {
    return this.http.post(
      './assets/php/admin_main_table_get.php',
      JSON.stringify(
        {}
      ),
      { responseType: 'text' }
    );
  }

  admin_main_delete_employee(id_person) {
    return this.http.post(
      './assets/php/admin_main_delete_employee.php',
      JSON.stringify(
        {
          id_person: id_person
        }
      ),
      { responseType: 'text' }
    );
  }

  admin_main_add_employee(new_form, time_create, user_name_create_employee) {
    console.log(new_form);
    return this.http.post(
      './assets/php/admin_main_add_employee.php',
      JSON.stringify(
        {
          new_form: new_form,
          time_create: time_create,
          user_name_create_employee: user_name_create_employee
        }
      ),
      { responseType: 'text' }
    );
  }
  admin_main_update_employee(user_name, form_edit_employee, time_last_change) {
    return this.http.post(
      './assets/php/admin_main_update_employee.php',
      JSON.stringify(
        {
          user_name: user_name,
          form_edit_employee: form_edit_employee,
          time_last_change: time_last_change
        }
      ),
      { responseType: 'text' }
    );
  }
  admin_get_attraction_channel(date){
    return this.http.post(
      './assets/php/admin_get_attraction_channel.php',
      JSON.stringify(
        {
          date: date
        }
      ),
      { responseType: 'text' }
    );
  }


  user_hr_get_main_table(user_name_create_employee) {
    return this.http.post(
      './assets/php/user_hr_get_main_table.php',
      JSON.stringify(
        {
          user_name_create_employee: user_name_create_employee
        }
      ),
      { responseType: 'text' }
    );
  }

  user_hr_main_add_employee(newPerson, dateTimeNow, user_name) {
    return this.http.post(
      './assets/php/user_hr_main_add_employee.php',
      JSON.stringify(
        {
          newPerson: newPerson,
          dateTimeNow: dateTimeNow,
          user_name: user_name
        }
      ),
      { responseType: 'text' }
    );
  }



  user_hr_main_update_employee(user_name, editPerson, dateTimeNow, id_person) {
    return this.http.post(
      './assets/php/user_hr_main_update_employee.php',
      JSON.stringify(
        {
          user_name: user_name,
          editPerson: editPerson,
          dateTimeNow: dateTimeNow,
          id_person:id_person
        }
      ),
      { responseType: 'text' }
    );
  }

  get_id_tt() {
    return this.http.post(
      './assets/php/get_id_tt.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }

  user_mt_main_table_get(name_test, passing_date) {
    return this.http.post(
      './assets/php/user_mt_main_table_get.php',
      JSON.stringify(
        {
          name_test: name_test,
          passing_date: passing_date
        }
      ),
      { responseType: 'text' }
    );
  }

  user_mt_update_employee(user_name, form_edit_employee, id_person, date_now) {
    return this.http.post(
      './assets/php/user_mt_get_main_update_employee.php',
      JSON.stringify(
        {
          user_name: user_name,
          form_edit_employee: form_edit_employee,
          id_person: id_person,
          date_now: date_now
        }
      ),
      { responseType: 'text' }
    );
  }

  user_pi_get_table_main() {
    return this.http.post(
      './assets/php/user_pi_get_main_table.php',
      JSON.stringify(
        {}
      ),
      { responseType: 'text' }
    );
  }

  user_pi_update_employee(user_name, form_edit_employee, id_person, date_now) {
    return this.http.post(
      './assets/php/user_pi_get_main_update_employee.php',
      JSON.stringify(
        {
          user_name: user_name,
          form_edit_employee: form_edit_employee,
          id_person: id_person,
          date_now: date_now
        }
      ),
      { responseType: 'text' }
    );
  }





}
