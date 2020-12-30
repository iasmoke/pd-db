import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TestsService {

  constructor(
    private http:HttpClient
  ) { }

  tests_add_new_test(newTest){
    return this.http.post(
      './assets/php/tests_add_new_test.php',
      JSON.stringify(
        {
          newTest:newTest
        }
      ),
      { responseType: 'text' }
    );
  }
  tests_get_list_position(){
    return this.http.post(
      './assets/php/tests_get_list_position.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }

  tests_save_changes_table(id_person,test_score,passing_date,name_test){
    return this.http.post(
      './assets/php/tests_save_changes_table.php',
      JSON.stringify(
        {
          id_person:id_person,
          test_score:test_score,
          passing_date:passing_date,
          name_test:name_test
        }
      ),
      { responseType: 'text' }
    );
  }

  tests_get_name_tests(){
    return this.http.post(
      './assets/php/tests_get_name_tests.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }

  tests_get_list_persons(){
    return this.http.post(
      './assets/php/tests_get_list_persons.php',
      JSON.stringify(
        {
        }
      ),
      { responseType: 'text' }
    );
  }

  tests_check_persons_for_match(list_person,name_test){
    return this.http.post(
      './assets/php/tests_check_persons_for_match.php',
      JSON.stringify(
        {
          list_person:list_person,
          name_test:name_test
        }
      ),
      { responseType: 'text' }
    );
  }

  tests_add_testing_for_person(list_person,name_test){
    return this.http.post(
      './assets/php/tests_add_testing_for_person.php',
      JSON.stringify(
        {
          list_person:list_person,
          name_test:name_test

        }
      ),
      { responseType: 'text' }
    );
  }
  tests_update_persons_data(editPerson,id_person){
    return this.http.post(
      './assets/php/tests_update_persons_data.php',
      JSON.stringify(
        {
          editPerson:editPerson,
          id_person:id_person
        }
      ),
      { responseType: 'text' }
    );
  }
}
